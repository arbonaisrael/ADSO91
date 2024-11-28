<?php

	class HipercolesterolemiaCtrl
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

			$comando = "SELECT  hipercolesterolemia.id_hipercolesterolemia as id_hipercolesterolemia, 
							    hipercolesterolemia.id_cedula as id_cedula, 
							    hipercolesterolemia.fec_realizacion_exa as fec_realizacion_exa,  
								hipercolesterolemia.cons_medico_general as cons_medico_general, 
								hipercolesterolemia.cons_enfermeria as cons_enfermeria, 
								hipercolesterolemia.cons_nutricion as cons_nutricion, 
								hipercolesterolemia.glicemia_basal as glicemia_basal, 
								hipercolesterolemia.hemoglobin as hemoglobin, 
								hipercolesterolemia.hematocritos as hematocritos, 
								hipercolesterolemia.colesterol_total as colesterol_total, 
								hipercolesterolemia.colesterol_hdl as colesterol_hdl, 
								hipercolesterolemia.trigliceridos as trigliceridos,
								hipercolesterolemia.creatinina as creatinina, 
								hipercolesterolemia.uroanalisis as uroanalisis, 
								hipercolesterolemia.ekg as ekg, 
								hipercolesterolemia.id_medicamento1 as id_medicamento1,
								hipercolesterolemia.id_medicamento2 as id_medicamento2, 
								hipercolesterolemia.edu_grupal as edu_grupal, 
								hipercolesterolemia.observaciones as observaciones, 
								hipercolesterolemia.acciones_realizar as acciones_realizar,  
								pacientes.nombres as nombrep, 
								pacientes.apellidos as apellidop,  
								med1.nombre as nombrem1,
								med2.nombre as nombrem2
                                FROM (((hipercolesterolemia inner join pacientes on hipercolesterolemia.id_cedula = pacientes.id_cedula)
                                        inner join medicamentos as med1 on hipercolesterolemia.id_medicamento1 = med1.id_medicamento) inner join medicamentos as med2 on hipercolesterolemia.id_medicamento2 = med2.id_medicamento)";
			$sentencia = Self::$pdofull->prepare($comando);
			if ($sentencia->execute ()) {
				$resultado = $sentencia->fetchAll ( PDO::FETCH_ASSOC );
				if ($resultado) {
					$obj->respuesta = array(
							"estado" => 1,
							"Hipercolesterolemia" => $resultado
						);		
				} else {
					$obj->respuesta = null;
				}
			} else
				$obj->respuesta = null;
		}

		private static function Registrar($obj){
			$hipercolesterolemia = $_POST['datos'];

			
			$insert = "INSERT INTO hipercolesterolemia (
			                    hipercolesterolemia.id_cedula , 
							    hipercolesterolemia.fec_realizacion_exa, 							     
								hipercolesterolemia.cons_medico_general, 
								hipercolesterolemia.cons_enfermeria, 
								hipercolesterolemia.cons_nutricion, 
								hipercolesterolemia.glicemia_basal, 
								hipercolesterolemia.hemoglobin, 
								hipercolesterolemia.hematocritos, 
								hipercolesterolemia.colesterol_total, 
								hipercolesterolemia.colesterol_hdl, 
								hipercolesterolemia.trigliceridos,  
								hipercolesterolemia.creatinina, 
								hipercolesterolemia.uroanalisis, 
								hipercolesterolemia.ekg, 
								hipercolesterolemia.id_medicamento1,
								hipercolesterolemia.id_medicamento2,								 
								hipercolesterolemia.edu_grupal, 
								hipercolesterolemia.observaciones, 
								hipercolesterolemia.acciones_realizar  
			           ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$sentencia = Self::$pdofull->prepare ( $insert );
			$sentencia->bindParam ( 1, $hipercolesterolemia['id_cedula']);
            $sentencia->bindParam ( 2, $hipercolesterolemia['fec_realizacion_exa']);
            $sentencia->bindParam ( 3, $hipercolesterolemia['cons_medico_general']);
			$sentencia->bindParam ( 4, $hipercolesterolemia['cons_enfermeria']);
            $sentencia->bindParam ( 5, $hipercolesterolemia['cons_nutricion']);
            $sentencia->bindParam ( 6, $hipercolesterolemia['glicemia_basal']);
            $sentencia->bindParam ( 7, $hipercolesterolemia['hemoglobin']);
            $sentencia->bindParam ( 8, $hipercolesterolemia['hematocritos']);
            $sentencia->bindParam ( 9, $hipercolesterolemia['colesterol_total']);
            $sentencia->bindParam ( 10, $hipercolesterolemia['colesterol_hdl']);
            $sentencia->bindParam ( 11, $hipercolesterolemia['trigliceridos']);            
            $sentencia->bindParam ( 12, $hipercolesterolemia['creatinina']);
            $sentencia->bindParam ( 13, $hipercolesterolemia['uroanalisis']);
			$sentencia->bindParam ( 14, $hipercolesterolemia['ekg']);
            $sentencia->bindParam ( 15, $hipercolesterolemia['id_medicamento1']);
            $sentencia->bindParam ( 16, $hipercolesterolemia['id_medicamento2']);            
            $sentencia->bindParam ( 17, $hipercolesterolemia['edu_grupal']);
            $sentencia->bindParam ( 18, $hipercolesterolemia['observaciones']);
            $sentencia->bindParam ( 19, $hipercolesterolemia['acciones_realizar']);

			$resultado = $sentencia->execute ();
			if($resultado){
			    $obj->respuesta = array(
				    "estado" =>1,
					"mensaje"=>"Hipercolesterolemia Creado Con Exito"
				);
			} else 
		        $obj->respuesta = array(
				     "estado" => 2,
				     "mensaje"=>"Error Inesperado"
			);
		}

		private static function Actualizar($obj){
			$hipercolesterolemia = $_POST['datos'];


			$comando = "UPDATE hipercolesterolemia SET 
			            hipercolesterolemia.id_cedula = ?, 
					    hipercolesterolemia.fec_realizacion_exa = ?, 
						hipercolesterolemia.cons_medico_general = ?, 
						hipercolesterolemia.cons_enfermeria = ?, 
						hipercolesterolemia.cons_nutricion = ?, 
						hipercolesterolemia.glicemia_basal = ?, 
						hipercolesterolemia.hemoglobin = ?, 
						hipercolesterolemia.hematocritos = ?, 
						hipercolesterolemia.colesterol_total = ?, 
						hipercolesterolemia.colesterol_hdl = ?, 
						hipercolesterolemia.trigliceridos = ?, 
						hipercolesterolemia.creatinina = ?, 
						hipercolesterolemia.uroanalisis = ?, 
						hipercolesterolemia.ekg = ?, 
						hipercolesterolemia.id_medicamento1 = ?,
						hipercolesterolemia.id_medicamento2 = ?,						 
						hipercolesterolemia.edu_grupal = ?, 
						hipercolesterolemia.observaciones = ?, 
						hipercolesterolemia.acciones_realizar = ?  
			            WHERE hipercolesterolemia.id_hipercolesterolemia = ?";
			$sentencia = Self::$pdofull->prepare ( $comando );
			$sentencia->bindParam ( 1, $hipercolesterolemia['id_cedula']);
            $sentencia->bindParam ( 2, $hipercolesterolemia['fec_realizacion_exa']);
            $sentencia->bindParam ( 3, $hipercolesterolemia['cons_medico_general']);
			$sentencia->bindParam ( 4, $hipercolesterolemia['cons_enfermeria']);
            $sentencia->bindParam ( 5, $hipercolesterolemia['cons_nutricion']);
            $sentencia->bindParam ( 6, $hipercolesterolemia['glicemia_basal']);
            $sentencia->bindParam ( 7, $hipercolesterolemia['hemoglobin']);
            $sentencia->bindParam ( 8, $hipercolesterolemia['hematocritos']);
            $sentencia->bindParam ( 9, $hipercolesterolemia['colesterol_total']);
            $sentencia->bindParam ( 10, $hipercolesterolemia['colesterol_hdl']);
            $sentencia->bindParam ( 11, $hipercolesterolemia['trigliceridos']);
            $sentencia->bindParam ( 12, $hipercolesterolemia['creatinina']);
            $sentencia->bindParam ( 13, $hipercolesterolemia['uroanalisis']);
			$sentencia->bindParam ( 14, $hipercolesterolemia['ekg']);
            $sentencia->bindParam ( 15, $hipercolesterolemia['id_medicamento1']);
            $sentencia->bindParam ( 16, $hipercolesterolemia['id_medicamento2']);            
            $sentencia->bindParam ( 17, $hipercolesterolemia['edu_grupal']);
            $sentencia->bindParam ( 18, $hipercolesterolemia['observaciones']);
            $sentencia->bindParam ( 19, $hipercolesterolemia['acciones_realizar']);
            $sentencia->bindParam ( 20, $hipercolesterolemia['id_hipercolesterolemia']);
		
			$resultado = $sentencia->execute ();
			if($resultado){
				$obj->respuesta = array(
						"estado" =>1,
						"mensaje"=>"Hipercolesterolemia Arterial Actualizado Con Exito"
					);
			}
		}
 }
 ?>