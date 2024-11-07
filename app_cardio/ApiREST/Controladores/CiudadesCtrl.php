<?php
	/*
	* Cargamos la conexión unicamente se raliza en este archivo ya que sera el primero en cargar * el index
	*/
	
	class CiudadesCtrl
	{
		public $respuesta = null;
        private static $pdofull;

		function __construct($peticion){

            Self::$pdofull = ConexionDB::obtenerInstancia()->obtenerDB();

			switch ($peticion[0]) {
				case 'Listar':
					return self::Listar($this);
					break;
				case 'Registrar':
					return self::Registrar($this);
					break;
				case 'Actualizar':
					return self::Actualizar($this);
					break;
				default:
					$this->respuesta = array(
							'estado' => 2,
							'mensaje'=>'No se reconoce el metodo del recurso'
						);
			}
		}

		private static function Listar($obj){
			
			$comando = "SELECT
						ciudades.id_ciudad AS lis_id_ciudad,
					    ciudades.nombre AS lis_nombre
						FROM
						ciudades";
			$sentencia = Self::$pdofull->prepare($comando);
			if ($sentencia->execute()) {
				$resultado = $sentencia->fetchAll ( PDO::FETCH_ASSOC );
				if ($resultado) {
					$obj->respuesta = array(
							"estado" => 1,
							"lciudad" => $resultado
						);
				} else {
					$obj->respuesta = null;
				}
			} else
				$obj->respuesta = null; 
		}

		private static function Registrar($obj){
			$ciudad = $_POST['datos'];

			$validar = "SELECT ciudades.id_ciudad, ciudades.nombre FROM ciudades 
			WHERE ciudades.id_ciudad = '".$ciudad['id_ciudad']."'";

			$sentencia_validar = Self::$pdofull->prepare($validar);
            
			if ($sentencia_validar->execute ()) {
				$resultado_validar = $sentencia_validar->fetch(PDO::FETCH_OBJ);
				if ($resultado_validar) {
					$obj->respuesta = array(
							'estado' => 2,
							'mensaje'=>'La ciudad ya esta registrado'
						);
				} else {
					$insert = "INSERT INTO ciudades (ciudades.id_ciudad, ciudades.nombre) VALUES (?,?)";
					$sentencia = Self::$pdofull->prepare ( $insert );
					$sentencia->bindParam ( 1, $ciudad['id_ciudad']);
					$sentencia->bindParam ( 2, $ciudad['nombre']);
					$resultado = $sentencia->execute ();
					if($resultado){
						$obj->respuesta = array(
								"estado" =>1,
								"mensaje"=>"Ciudad Creado Con Exito"
						);
					}
				}
			} else
				$obj->respuesta = array(
						"estado" => 2,
						"mensaje"=>"Error Inesperado"
					);
		}


		private static function Actualizar($obj){
			$ciudad = $_POST['datos'];

			$comando = "UPDATE ciudades SET ciudades.id_ciudad = ?, ciudades.nombre = ? WHERE ciudades.id_ciudad = ?";
			$sentencia = Self::$pdofull->prepare ( $comando );
			$sentencia->bindParam ( 1, $ciudad['id_ciudad'] );
			$sentencia->bindParam ( 2, $ciudad['nombre'] );
			$sentencia->bindParam ( 3, $ciudad['id_ciudad'] );
		
			$resultado = $sentencia->execute ();
			if($resultado){
				$obj->respuesta = array(
						"estado" =>1,
						"mensaje"=>"Ciudad Actualizado Con Exito"
					);
			}
		}  
  }
 ?>