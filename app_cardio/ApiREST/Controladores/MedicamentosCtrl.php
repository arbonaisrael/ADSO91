<?php
	/*
	* Cargamos la conexión unicamente se raliza en este archivo ya que sera el primero en cargar * el index
	*/
	
	class MedicamentosCtrl
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
						medicamentos.id_medicamento AS lis_id_medicamento,
					    medicamentos.nombre AS lis_nombre
						FROM
						medicamentos";
			$sentencia = Self::$pdofull->prepare($comando);
			if ($sentencia->execute()) {
				$resultado = $sentencia->fetchAll ( PDO::FETCH_ASSOC );
				if ($resultado) {
					$obj->respuesta = array(
							"estado" => 1,
							"lmedicamento" => $resultado
						);
				} else {
					$obj->respuesta = null;
				}
			} else
				$obj->respuesta = null; 
		}

		private static function Registrar($obj){
			$medicamento = $_POST['datos'];

			$validar = "SELECT medicamentos.id_medicamento, medicamentos.nombre FROM medicamentos 
			WHERE medicamentos.id_medicamento = '".$medicamento['id_medicamento']."'";
			$sentencia_validar = Self::$pdofull->prepare($validar);
			if ($sentencia_validar->execute ()) {
				$resultado_validar = $sentencia_validar->fetch(PDO::FETCH_OBJ);
				if ($resultado_validar) {
					$obj->respuesta = array(
							'estado' => 2,
							'mensaje'=>'El medicamento ya esta registrado'
						);
				} else {
					$insert = "INSERT INTO medicamentos (medicamentos.id_medicamento, medicamentos.nombre) VALUES (?,?)";
					$sentencia = Self::$pdofull->prepare ( $insert );
					$sentencia->bindParam ( 1, $medicamento['id_medicamento']);
					$sentencia->bindParam ( 2, $medicamento['nombre']);
					$resultado = $sentencia->execute ();
					if($resultado){
						$obj->respuesta = array(
								"estado" =>1,
								"mensaje"=>"Medicamento Creado Con Exito"
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
			$medicamento = $_POST['datos'];

			$comando = "UPDATE medicamentos SET medicamentos.id_medicamento = ?, medicamentos.nombre = ? WHERE medicamentos.id_medicamento = ?";
			$sentencia = Self::$pdofull->prepare ( $comando );
			$sentencia->bindParam ( 1, $medicamento['id_medicamento'] );
			$sentencia->bindParam ( 2, $medicamento['nombre'] );
			$sentencia->bindParam ( 3, $medicamento['id_medicamento'] );
		
			$resultado = $sentencia->execute ();
			if($resultado){
				$obj->respuesta = array(
						"estado" =>1,
						"mensaje"=>"Medicamento Actualizado Con Exito"
					);
			}
		}  

 }
 ?>