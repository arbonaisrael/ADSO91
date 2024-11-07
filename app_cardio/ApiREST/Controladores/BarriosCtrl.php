<?php
	/*
	* Cargamos la conexión unicamente se raliza en este archivo ya que sera el primero en cargar * el index
	*/

    class BarriosCtrl
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
						barrios.id_barrio AS lis_id_barrio,
					    barrios.nombre AS lis_nombre
						FROM
						barrios";
			$sentencia = Self::$pdofull->prepare($comando);
			if ($sentencia->execute()) {
				$resultado = $sentencia->fetchAll ( PDO::FETCH_ASSOC );
				if ($resultado) {
					$obj->respuesta = array(
							"estado" => 1,
							"lbarrios" => $resultado
						);
				} else {
					$obj->respuesta = null;
				}
			} else
				$obj->respuesta = null;
		}

        private static function Registrar($obj){
			$barrio = $_POST['datos'];

			$insert = "INSERT INTO barrios (barrios.nombre) VALUES (?)";
			$sentencia = Self::$pdofull->prepare ( $insert );
			$sentencia->bindParam ( 1, $barrio['nombre'] );
			$resultado = $sentencia->execute ();
			if($resultado){
			    $obj->respuesta = array(
				    "estado" =>1,
					"mensaje"=>"Barrio Creado Con Exito"
				);
			} else 
		        $obj->respuesta = array(
				     "estado" => 2,
				     "mensaje"=>"Error Inesperado"
			);
		}

        private static function Actualizar($obj){
			$barrio = $_POST['datos'];

			$comando = "UPDATE barrios SET barrios.nombre = ? WHERE barrios.id_barrio = ?";
			$sentencia = Self::$pdofull->prepare ( $comando );
			$sentencia->bindParam ( 1, $barrio['nombre'] );
			$sentencia->bindParam ( 2, $barrio['id_barrio'] );
		
			$resultado = $sentencia->execute ();
			if($resultado){
				$obj->respuesta = array(
						"estado" =>1,
						"mensaje"=>"Barrio Actualizado Con Exito"
					);
			}
		} 
    }

?>