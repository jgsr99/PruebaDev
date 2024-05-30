<?php

/**
 * Plantilla general de modelos
 * Versión 1.0.1
 *
 * Modelo de users
 */
class usersModel extends Model {
  public static $t1   = 'usuarios'; // Nombre de la tabla en la base de datos;
  
  // Nombre de tabla 2 que talvez tenga conexión con registros
  //public static $t2 = '__tabla 2___'; 
  //public static $t3 = '__tabla 3___'; 

  function __construct()
  {
    // Constructor general
  }
  
  static function all()
  {
    // Todos los registros
    $sql = 'SELECT * FROM usuarios ORDER BY id DESC';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function all_paginated()
  {
      // Todos los registros paginados
      $sql = 'SELECT * FROM usuarios WHERE rol = "admin" ORDER BY id DESC';
      return PaginationHandler::paginate($sql);
  }

  static function by_id($id)
  {
    // Un registro con $id
    $sql = 'SELECT * FROM usuarios WHERE id = :id AND rol = "admin" LIMIT 1';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : [];
  }

  static function suspender($id)
  {
    // Un registro con $id
    return (parent::update(self::$t1, ['id' => $id], ['status' => 'suspendido']) !== false) ? true : false;
  }

  static function remover_suspension($id)
  {
    // Un registro con $id
    return (parent::update(self::$t1, ['id' => $id], ['status' => 'activo']) !== false) ? true : false;
  }

  static function eliminar($id)
  {
    $sql = 'DELETE u FROM usuarios u WHERE u.id = :id AND u.rol = "admin"';
    return (parent::query($sql, ['id' => $id])) ? true : false;
  }
}