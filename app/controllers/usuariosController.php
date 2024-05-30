<?php

use FFI\Exception;
use Verot\Upload\Upload;

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de usuarios
 */
class usuariosController extends Controller {
  private $id = null;
  private $rol = null;

  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    $this->id = get_user('id');
    $this->rol = get_user_role();    
  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Usuarios',
      'msg'   => 'Bienvenido al controlador de "usuarios", se ha creado con éxito si ves este mensaje.'
    ];
    
    // Descomentar vista si requerida
    View::render('index', $data);
  }

  function ver()
  {

    if (!$usuario = usuarioModel::by_id($this->id)) {
      Flasher::new('No existe el usuario en la base de datos.', 'danger');
      Redirect::back();
    }
    
    $data =
    [
      'title' => sprintf('Usuario %s', $usuario['nombre_completo']),
      'a' => $usuario
    ];

    View::render('ver', $data);
  }

  function agregar()
  {
    View::render('agregar');
  }

  function post_agregar()
  {

  }

  function editar($id)
  {
    View::render('editar');
  }

  function post_editar()
  {
    try {
      if (!check_posted_data(['csrf', 'id', 'nombres', 'apellidos', 'email', 'telefono', 'password', 'conf_password'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      // Validar existencia del alumno
      $id = clean($_POST["id"]);
      if (!$usuario = usuarioModel::by_id($id)) {
        throw new Exception('No existe el usuario en la base de datos.');
      }

      $db_email = $usuario['email'];
      $db_pw = $usuario['password'];
      $db_status = $usuario['status'];

      $nombres = clean($_POST["nombres"]);
      $apellidos = clean($_POST["apellidos"]);
      $email = clean($_POST["email"]);
      $telefono = clean($_POST["telefono"]);
      $password = clean($_POST["password"]);
      $conf_password = clean($_POST["conf_password"]);
      $changed_email = $db_email === $email ? false : true;
      $changed_pw = false;
      $perfil = $_FILES["perfil"];
      $n_perfil = false;

      //Validar existencia del correo electrónico
      $sql = 'SELECT * FROM usuarios WHERE email = :email AND id != :id LIMIT 1';
      if (usuarioModel::query($sql, ['email' => $email, 'id' => $id])) {
        throw new Exception('El correo electrónico ya existe en la base de datos.');
      }

      // Validar que el correo sea válido
      if ($changed_email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Ingresa un correo electrónico válido.');
      }

      //Validar el nombre del usuario
      if (strlen($nombres) < 2){
        throw new Exception('Ingresa un nombre válido');
      }

      //Validar el apellido del usuario
      if (strlen($apellidos) < 2){
        throw new Exception('Ingresa un apellido válido');
      }

      //Validar el password del usuario
      $pw_ok = password_verify($db_pw, $password.AUTH_SALT);
      if (!empty($password) && $pw_ok === false && strlen($password) < 5){
        throw new Exception('Ingresa una contraseña mayor a 5 caracteres.');
      }

      //Validar ambas contraseñas 
      if (!empty($password) && $pw_ok === false && $password !== $conf_password){
        throw new Exception('Las contraseñas no son iguales.');
      }

      $data = 
      [
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'nombre_completo' => sprintf('%s %s', $nombres, $apellidos),
        'email' => $email,
        'telefono' => $telefono,
        'status' => $changed_email ? 'activo' : $db_status
      ];

      $db_perfil = $usuario['perfil'];

      // Validar si se está subiendo una imagen
      if ($perfil['error'] !== 4){
        $tmp = $perfil['tmp_name'];
        $name = $perfil['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        
        //Validar extensión del archivo
        if (!in_array($ext, ['jpg', 'png', 'jpeg', 'bmp'])){
          throw new Exception('Selecciona un formato de imagen válido.');
        }
        
        $foo = new upload($perfil);
        if (!$foo->uploaded) {
          throw new Exception('Hubo un problema al subir el archivo.');
        }

        //nuevo nombre y nuevas medidas de la imagen
        $filename = generate_filename();
        $foo->file_new_name_body = $filename;
        $foo->image_resize = true;
        $foo->image_x = 800;
        $foo->image_ratio_y = true;

        $foo->process(UPLOADS);
        if (!$foo->processed) {
          throw new Exception('Hubo un problema al guardar la imagen en el servidor.');
        }
        
        $data['perfil'] = sprintf('%s.%s', $filename, $ext);
        $n_perfil = true;
      }

      //Actualización de contraseña
      if (!empty($password) && $pw_ok === false) {
        $data['password'] = password_hash($password.AUTH_SALT, PASSWORD_BCRYPT);
        $changed_pw = true;
      }

      // Borrado del perfil anterior en caso de actualización
      if ($db_perfil !== null && $n_perfil === true && is_file(UPLOADS.$db_perfil)){
        unlink(UPLOADS.$perfil);
      }

      // Actualizar base de datos
      if (!usuarioModel::update(usuarioModel::$t1, ['id' => $id], $data)) {
        throw new Exception(get_notificaciones(2));
      }

      $usuario =  usuarioModel::by_id($id);

      Flasher::new(sprintf('Usuario <b>%s</b> actualizado con éxito.', $usuario['nombre_completo']), 'success');

      if ($changed_email) {
        mail_confirmar_cuenta($id);
        Flasher::new('El correo electrónico del usuario ha sido actualizado, debe ser confirmado.');
      }

      if ($changed_pw) {
        Flasher::new('La contraseña del usuario ha sido actualizada.');
      }

      if($usuario['rol'] === 'admin'){
        Redirect::to('dashboard');
      }
    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }

  function borrar($id)
  {
    // Proceso de borrado
  }
}