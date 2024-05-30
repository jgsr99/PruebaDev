<?php 

class loginController extends Controller {
  private $id = null;
  private $rol = null;

  function __construct()
  {
    if (Auth::validate()) {
      Flasher::new('Ya hay una sesión abierta.');
      Redirect::to('dashboard');
    }

    $this->id = get_user('id');
    $this->rol = get_user_role();    
  }

  function index()
  {
    $data =
    [
      'title'   => 'Ingresar a tu cuenta',
    ];

    View::render('index', $data);
  }

  function recuperacion()
  {
    $data =
    [
      'title' => 'Recuperación de contraseña',
    ];

    View::render('recuperacion', $data);
  }

  function post_recuperacion()
  {
    try {
      if (!check_posted_data(['email', 'csrf'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      // Data pasada del formulario
      $email = clean($_POST['email']);

      // Verificar que exista el usuario con ese email
      if (!$user = usuarioModel::by_email($email)) {
        throw new Exception('El correo electrónico no es válido.');
      }

      // Se envía el email de cambio de contraseña
      mail_recuperacion_contrasena($user['id']);

      Flasher::new(sprintf('Hemos enviado un correo electrónico a <b>%s</b> para actualizar tu contraseña.', $email), 'success');
      Redirect::back();
      
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }

  function post_login()
  {
       
    try {
      if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['email','csrf','password'], $_POST)) {
        Flasher::new('Acceso no autorizado.', 'danger');
        Redirect::back();
      }
  
      // Data pasada del formulario
      $email  = clean($_POST['email']);
      $password = clean($_POST['password']);
  
      //Verificar si el email es valido
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('EL correo electrónico no es válido.');        
      }

      //Verificar que exista el usuario con ese email
      if (!$user = usuarioModel::by_email($email)){
        throw new Exception('Las credenciales no son correctas.');
      }

      // Información del usuario loggeado, simplemente se puede reemplazar aquí con un query a la base de datos
      // para cargar la información del usuario si es existente      
      if (!password_verify($password.AUTH_SALT, $user['password'])) {
        throw new Exception('Las credenciales no son correctas.');
      }

      // Validar el status del usuario
      if ($user['status'] === 'pendiente') {
        mail_confirmar_cuenta($user['id']);
        throw new Exception('Confirma tu dirección de correo electronico.');
      }
      
      // Loggear al usuario
      Auth::login($user['id'], $user);
      Redirect::to('dashboard');

    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }

  function cuenta()
  {
    $data =
    [
      'title'   => 'Crea tu cuenta',
    ];

    View::render('cuenta', $data);
  }

  function post_agregar()
  {
    try {
      if (!check_posted_data(['csrf', 'nombres', 'apellidos', 'email', 'telefono', 'password', 'conf_password', 'sede'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      $nombres = clean($_POST["nombres"]);
      $apellidos = clean($_POST["apellidos"]);
      $email = clean($_POST["email"]);
      $telefono = clean($_POST["telefono"]);
      $password = clean($_POST["password"]);
      $conf_password = clean($_POST["conf_password"]);
      $sede = clean($_POST["sede"]);

      //Validar que el correo sea válido
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        throw new Exception('Ingresa un correo electrónico válido');
      }

      //Validar el nombre del usuario
      if (strlen($nombres) < 5){
        throw new Exception('Ingresa un nombre válido');
      }

      //Validar el apellido del usuario
      if (strlen($apellidos) < 5){
        throw new Exception('Ingresa un apellido válido');
      }

      //Validar el password del usuario
      if (strlen($password) < 5){
        throw new Exception('Ingresa una contraseña mayor a 5 caracteres');
      }

      //Validar ambas contraseñas 
      if ($password !== $conf_password){
        throw new Exception('Las contraseñas no son iguales.');
      }

      $data = 
      [
        'numero' => rand(111111, 999999),
        'perfil' => NULL,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'nombre_completo' => sprintf('%s %s', $nombres, $apellidos),
        'email' => $email,
        'telefono' => $telefono,
        'password' => password_hash($password.AUTH_SALT, PASSWORD_BCRYPT),
        'hash' => generate_token(),
        'rol' => 'cliente',
        'status' => 'pendiente',
        'sede' => $sede,
        'creado' => now()
      ];

      //Insertar a la base de datos
      if (!$id = usuarioModel::add(usuarioModel::$t1, $data)) {
        throw new Exception(get_notificaciones(2));
      }

      // Email de confirmación de correo
      mail_confirmar_cuenta($id);

      $usuario =  usuarioModel::by_id($id);

      Flasher::new(sprintf('Usuario <b>%s</b> agregado con éxito.', $usuario['nombre_completo']), 'success');
      Redirect::back();

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }

  function activate()
  {
    try {
      if (!check_get_data(['email', 'hash'], $_GET)) {
        throw new Exception('El enlace de activación no es válido.');
      }

      // Data pasada en la URL
      $email = clean($_GET["email"]);
      $hash = clean($_GET["hash"]);

      // Verificar que exista el usuario con ese email
      if (!$user = usuarioModel::by_email($email)) {
        throw new Exception('El enlace de activación no es válido.');
      }

      $id = $user['id'];
      $nombre = $user['nombres'];
      $status = $user['status'];
      $db_hash = $user['hash'];

      // Verificar el hash del usuario y el status
      if ($hash !== $db_hash) {
        throw new Exception('El enlace de activación no es válido.');
      }

      // Validar el status del usuario
      if ($status !== 'pendiente') {
        throw new Exception('El enlace de activación no es válido.');
      }

      // Activar cuenta
      if (usuarioModel::update(usuarioModel::$t1, ['id' => $id], ['status' => 'activo']) === false) {
        throw new Exception(get_notificaciones(3));
      }

      Flasher::new(sprintf('Tu correo electrónico ha sido activado con éxito <b>%s</b>, ya puedes iniciar sesión.', $nombre), 'success');
      Redirect::to('login');

    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::to('login');
    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::to('login');
    }
  }

  function password()
  {
    if (!check_get_data(['token', 'id'], $_GET)) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::to('login');
    }

    // Almacenar la información
    $id = clean($_GET["id"]);
    $token = clean($_GET["token"]);

    // Validar que exista dicho token en la bese de datos
    $sql = 'SELECT u.*
    FROM usuarios u
    JOIN posts p ON p.id_usuario =  u.id And p.tipo = \'token_recuperacion\'
    WHERE u.id = :id AND p.contenido = :token';
    if (!usuarioModel::query($sql, ['id' => $id, 'token' => $token])) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::to('login');
    }

    $data =
    [
      'title' => 'Actualiza tu contraseña',
      'token' => $token,
      'id' => $id
    ];

    View::render('password', $data);
  }

  function post_password()
  {
    try {
      if (!check_posted_data(['csrf', 'password', 'conf_password', 'id', 'token'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      // Data pasada del formulario
      $id = clean($_POST["id"]);
      $token = clean($_POST["token"]);
      $password = clean($_POST["password"]);
      $conf_password = clean($_POST["conf_password"]);

      // Validar que exista el token en la base de datos
      $sql = 'SELECT u.*,
      p.id AS id_post 
      FROM usuarios u 
      JOIN posts p ON p.id_usuario = u.id AND p.tipo = \'token_recuperacion\'
      WHERE u.id = :id AND p.contenido = :token';
      if (!$posts = usuarioModel::query($sql, ['id' => $id, 'token' => $token])) {
        throw new Exception(get_notificaciones());
      }

      $post = $posts[0];

      // Verificar las contraseñas
      if (strlen($password) < 5) {
        throw new Exception('La contraseña es deamasiado corta.');
      }

      if ($password !== $conf_password) {
        throw new Exception('Las contraseñas no coinciden.');
      }

      $data = 
      [
        'password' => password_hash($password.AUTH_SALT, PASSWORD_BCRYPT)
      ];

      // Se actualiza el registro
      if (!usuarioModel::update(usuarioModel::$t1, ['id' => $id], $data)) {
        throw new Exception(get_notificaciones(3));
      }

      // Se envía el email de cambio de contraseña
      $usuario = usuarioModel::by_id($id);
      $body = sprintf('Tu contraseña ha sido actualizada con éxito, si tú no realizaste esta acción, comunicate con la administración de %s', get_sitename());
      send_email(get_siteemail(), $usuario['email'], 'Tu contraseña ha sido actualizada', $body, 'Se han realizado cambios en tu contrasela');

      // Borramos el registro del token/ post
      postModel::remove(postModel::$t1, ['id' => $post['id_post']]);
      
      Flasher::new('Tu contraseña ha sido actualizada con éxito.', 'success');
      Redirect::to('login');

    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }
}