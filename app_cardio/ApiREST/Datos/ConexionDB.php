<?php

/**
 * Clase que envuelve una instancia de la clase PDO
 * para el manejo de la base de datos
 */

 require_once 'loginMYSQL.php';

 class ConexionDB 
 {
    /**
     * Única instancia de la clase
     */

     private static $db = null;

     /**
      * Instancia de PDO
      */
    private static $pdo;

    final private function __construct() 
    {
        try {
            // Crear nueva conexion
            self::obtenerDB();
        } catch (PDOException $e) {
            // Manejo de errores
        }
    }

    /**
     * Retorna en la única instancia de la clase
     * @return Conexion|null
     */
    public static function obtenerInstancia() 
    {
        if (self::$db == null) {
            self::$db = new self();
        }
        return self::$db;
    }

    /**
     * Crear una nueva conexion PDO basada
     * en las constantes de conexion
     * @return PDO objeto
     */

     public function obtenerDB()
     {
        if (self::$pdo == null) {
            self::$pdo = new PDO(
                'mysql:dbname=' . BASE_DE_DATOS .
                ';  host=' . NOMBRE_HOST . ';',
                USUARIO,
                CONTRASENA,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );

            // HABILITAR LAS EXCEPCIONES
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
     }

     /**
      * Evitar la clonación del objeto
      */

      final protected function __clone() 
      {
      }

      function _destructor()
      {
        self::$pdo = null;
      }

 }


?>