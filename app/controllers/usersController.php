<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de users
 */
class usersController extends Controller {
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
    if (!is_admin($this->rol)) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }

    $data =
      [
        'title' => 'Todas los usuarios',
        'slug' => 'users',
        'button' => ['url' => 'users/agregar', 'text' => '<i class="fas fa-plus"></i> Agregar usuario'],
        'users' => usersModel::all_paginated()
      ];
    
    // Descomentar vista si requerida
    View::render('index', $data);
  }

  function ver($id)
  {
    if (!is_admin($this->rol)) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }

    if (!$user = usersModel::by_id($id)) {
      Flasher::new('No existe el usuario registrado en la base de datos.', 'danger');
      Redirect::back();
    }
    
    $data =
    [
      'title' => sprintf('Usuario %s', $user['nombre_completo']),
      'slug' => 'users',
      'button' => ['url' => 'users', 'text' => '<i class="fas fa-table"></i> Usuarios'],
      't' => $user
    ];

    View::render('ver', $data);
  }

  function agregar()
  {
    if (!is_admin($this->rol)) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }

    $data =
      [
        'title' => 'Agregar usuario',
        'slug' => 'users',
        'button' => ['url' => 'users', 'text' => '<i class="fas fa-table"></i> Usuarios ']
      ];

    View::render('agregar', $data);
  }

  function post_agregar()
  {
    try {
      if (!check_posted_data(['csrf', 'nombres', 'apellidos', 'email', 'telefono', 'password', 'conf_password'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      //Validar rol
      if (!is_admin($this->rol)) {
        throw new Exception(get_notificaciones(1));
      }

      $nombres = clean($_POST["nombres"]);
      $apellidos = clean($_POST["apellidos"]);
      $email = clean($_POST["email"]);
      $telefono = clean($_POST["telefono"]);
      $password = clean($_POST["password"]);
      $conf_password = clean($_POST["conf_password"]);

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
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'nombre_completo' => sprintf('%s %s', $nombres, $apellidos),
        'email' => $email,
        'telefono' => $telefono,
        'password' => password_hash($password.AUTH_SALT, PASSWORD_BCRYPT),
        'hash' => generate_token(),
        'rol' => 'admin',
        'status' => 'pendiente',
        'creado' => now()
      ];

      //Insertar a la base de datos
      if (!$id = usersModel::add(usersModel::$t1, $data)) {
        throw new Exception(get_notificaciones(2));
      }

      // Email de confirmación de correo
      mail_confirmar_cuenta($id);

      $usuario =  usersModel::by_id($id);

      Flasher::new(sprintf('Usuario <b>%s</b> agregado con éxito.', $usuario['nombre_completo']), 'success');
      Redirect::to('users');

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }

  function post_editar()
  {
    try {
      if (!check_posted_data(['csrf', 'id', 'nombres', 'apellidos', 'email', 'telefono', 'password', 'conf_password'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      //Validar rol
      if (!is_admin($this->rol)) {
        throw new Exception(get_notificaciones(1));
      }

      // Validar existencia del alumno
      $id = clean($_POST["id"]);
      if (!$users = usersModel::by_id($id)) {
        throw new Exception('No existe el usuario registrado en la base de datos.');
      }

      $db_email = $users['email'];
      $db_pw = $users['password'];
      $db_status = $users['status'];
      $db_id_g = $users['id_grupo'];

      $nombres = clean($_POST["nombres"]);
      $apellidos = clean($_POST["apellidos"]);
      $email = clean($_POST["email"]);
      $telefono = clean($_POST["telefono"]);
      $password = clean($_POST["password"]);
      $conf_password = clean($_POST["conf_password"]);
      $changed_email = $db_email === $email ? false : true;
      $changed_pw = false;

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
      if (strlen($nombres) < 5){
        throw new Exception('Ingresa un nombre válido');
      }

      //Validar el apellido del usuario
      if (strlen($apellidos) < 5){
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
        'status' => $changed_email ? 'pendiente' : $db_status
      ];

      //Actualización de contraseña
      if (!empty($password) && $pw_ok === false) {
        $data['password'] = password_hash($password.AUTH_SALT, PASSWORD_BCRYPT);
        $changed_pw = true;
      }

      // Actualizar base de datos
      if (!usersModel::update(usersModel::$t1, ['id' => $id], $data)) {
        throw new Exception(get_notificaciones(2));
      }

      $usuario =  usersModel::by_id($id);

      Flasher::new(sprintf('Usuario <b>%s</b> actualizado con éxito.', $usuario['nombre_completo']), 'success');

      if ($changed_email) {
        mail_confirmar_cuenta($id);
        Flasher::new('El correo electrónico del usuario ha sido actualizado, debe ser confirmado.');
      }

      if ($changed_pw) {
        Flasher::new('La contraseña del usuario ha sido actualizada.');
      }

      Redirect::to('users');

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
    try {
      if (!check_get_data(['_t'], $_GET) || !Csrf::validate($_GET['_t'])) {
        throw new Exception(get_notificaciones());
      }

      //Validar rol
      if (!is_admin($this->rol)) {
        throw new Exception(get_notificaciones(1));
      }

      // Exista el usuario
      if (!$users = usersModel::by_id($id)) {
        throw new Exception('No existe el profesor en la base de datos.');
      }
      
      // Borramos el registro y sus conexiones
      if (usersModel::eliminar($users['id']) === false) {
        throw new Exception(get_notificaciones(4));
      }

      Flasher::new(sprintf('Usuario <b>%s</b> borrado con éxito', $users['nombre_completo']), 'success');
      Redirect::to('users');

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }
}