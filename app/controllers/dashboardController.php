<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de dashboard
 */
class dashboardController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }
  }
  
  function index()
  {
    $rol = get_user_role();
    $data = 
    [
      'title' => 'Dashboard',
      'slug' => 'dashboard',
    ];

    if (is_admin($rol)) {

      $data['stats'] = adminModel::stats();
      View::render('dashboard_admin', $data);

    }
  }

  function ver($id)
  {
    View::render('ver');
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

  }

  function borrar($id)
  {
    // Proceso de borrado
  }
}