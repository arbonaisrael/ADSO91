<?php

	class Cum_ProgramasCtrl
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

			$comando = "SELECT cum_programas.id_programa as id_programa,
			                   cum_programas.id_cedula as id_cedula, 
			                   cum_programas.fec_ingreso as fec_ingreso,
			                   cum_programas.fec_egreso as fec_egreso, 
			                   cum_programas.causa_egreso as causa_egreso, 
			                   cum_programas.fec_hospitalizacion as fec_hospitalizacion, 
			                   pacientes.nombres as nombres, 
			                   pacientes.apellidos as apellidos			 
			                   FROM (cum_programas INNER JOIN pacientes ON cum_programas.id_cedula = pacientes.id_cedula)";  
			$sentencia = Self::$pdofull->prepare($comando);
			if ($sentencia->execute ()) {
				$resultado = $sentencia->fetchAll ( PDO::FETCH_ASSOC );
				if ($resultado) {
					$obj->respuesta = array(
							"estado" => 1,
							"Cum_Programas" => $resultado
						);		
				} else {
					$obj->respuesta = null;
				}
			} else
				$obj->respuesta = null;
		}

        private static function Registrar($obj){
			$cum_programa = $_POST['datos'];
			
			$insert = "INSERT INTO cum_programas (
			           cum_programas.id_cedula,
			           cum_programas.fec_ingreso,
			           cum_programas.fec_egreso,
			           cum_programas.causa_egreso,
			           cum_programas.fec_hospitalizacion
			           ) VALUES (?,?,?,?,?)";
			$sentencia = Self::$pdofull->prepare ( $insert );
			$sentencia->bindParam ( 1, $cum_programa['id_cedula']);
            $sentencia->bindParam ( 2, $cum_programa['fec_ingreso']);
            $sentencia->bindParam ( 3, $cum_programa['fec_egreso']);
            $sentencia->bindParam ( 4, $cum_programa['causa_egreso']);
            $sentencia->bindParam ( 5, $cum_programa['fec_hospitalizacion']);
			$resultado = $sentencia->execute ();
			if($resultado){
			    $obj->respuesta = array(
				    "estado" =>1,
					"mensaje"=>"Cum Programa Creado Con Exito"
				);
			} else 
		        $obj->respuesta = array(
				     "estado" => 2,
				     "mensaje"=>"Error Inesperado"
			);
		}

		private static function Actualizar($obj){
			$cum_programa = $_POST['datos'];

			$comando = "UPDATE cum_programas SET 
			            cum_programas.id_cedula = ?,
			            cum_programas.fec_ingreso = ?,
			            cum_programas.fec_egreso = ?,
			            cum_programas.causa_egreso = ?,
			            cum_programas.fec_hospitalizacion = ? 
			            WHERE cum_programas.id_programa = ?";
			$sentencia = Self::$pdofull->prepare ( $comando );
			$sentencia->bindParam ( 1, $cum_programa['id_cedula']);
            $sentencia->bindParam ( 2, $cum_programa['fec_ingreso']);
            $sentencia->bindParam ( 3, $cum_programa['fec_egreso']);
            $sentencia->bindParam ( 4, $cum_programa['causa_egreso']);
            $sentencia->bindParam ( 5, $cum_programa['fec_hospitalizacion']);
            $sentencia->bindParam ( 6, $cum_programa['id_programa']);
		
			$resultado = $sentencia->execute ();
			if($resultado){
				$obj->respuesta = array(
						"estado" =>1,
						"mensaje"=>"Cum Programa Actualizado Con Exito"
					);
			}
		}
}
 ?>