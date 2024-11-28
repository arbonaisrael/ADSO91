<?php

	class Hipertension_ArterialCtrl
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

			$comando = "SELECT  hipertension_arterial.id_hiper_arterial as id_hiper_arterial, 
							    hipertension_arterial.id_cedula as id_cedula, 
							    hipertension_arterial.fec_realizacion_exa as fec_realizacion_exa, 
							    hipertension_arterial.cf_tensionales as cf_tensionales, 
								hipertension_arterial.tm_signos_vitales as tm_signos_vitales, 
								hipertension_arterial.cons_medico_general as cons_medico_general, 
								hipertension_arterial.cons_enfermeria as cons_enfermeria, 
								hipertension_arterial.cons_nutricion as cons_nutricion, 
								hipertension_arterial.glicemia_basal as glicemia_basal, 
								hipertension_arterial.hemoglobin as hemoglobin, 
								hipertension_arterial.hematocritos as hematocritos, 
								hipertension_arterial.colesterol_total as colesterol_total, 
								hipertension_arterial.colesterol_hdl as colesterol_hdl, 
								hipertension_arterial.trigliceridos as trigliceridos, 
								hipertension_arterial.potasio as potasio, 
								hipertension_arterial.creatinina as creatinina, 
								hipertension_arterial.uroanalisis as uroanalisis, 
								hipertension_arterial.ekg as ekg, 
								hipertension_arterial.id_medicamento as id_medicamento, 
								hipertension_arterial.edu_grupal as edu_grupal, 
								hipertension_arterial.observaciones as observaciones, 
								hipertension_arterial.acciones_realizar as acciones_realizar,  
								pacientes.nombres as nombrep, 
								pacientes.apellidos as apellidop,  
								medicamentos.nombre as nombrem
                                FROM ((hipertension_arterial inner join pacientes on hipertension_arterial.id_cedula = pacientes.id_cedula)
                                        inner join medicamentos on hipertension_arterial.id_medicamento = medicamentos.id_medicamento)";
			$sentencia = Self::$pdofull->prepare($comando);
			if ($sentencia->execute ()) {
				$resultado = $sentencia->fetchAll ( PDO::FETCH_ASSOC );
				if ($resultado) {
					$obj->respuesta = array(
							"estado" => 1,
							"Hipertension_Arterial" => $resultado
						);		
				} else {
					$obj->respuesta = null;
				}
			} else
				$obj->respuesta = null;
		}

		private static function Registrar($obj){
			$hipertension_arterial = $_POST['datos'];
			
			$insert = "INSERT INTO hipertension_arterial (
			                    hipertension_arterial.id_cedula , 
							    hipertension_arterial.fec_realizacion_exa, 
							    hipertension_arterial.cf_tensionales, 
								hipertension_arterial.tm_signos_vitales, 
								hipertension_arterial.cons_medico_general, 
								hipertension_arterial.cons_enfermeria, 
								hipertension_arterial.cons_nutricion, 
								hipertension_arterial.glicemia_basal, 
								hipertension_arterial.hemoglobin, 
								hipertension_arterial.hematocritos, 
								hipertension_arterial.colesterol_total, 
								hipertension_arterial.colesterol_hdl, 
								hipertension_arterial.trigliceridos, 
								hipertension_arterial.potasio, 
								hipertension_arterial.creatinina, 
								hipertension_arterial.uroanalisis, 
								hipertension_arterial.ekg, 
								hipertension_arterial.id_medicamento, 
								hipertension_arterial.edu_grupal, 
								hipertension_arterial.observaciones, 
								hipertension_arterial.acciones_realizar  
			           ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$sentencia = Self::$pdofull->prepare ( $insert );
			$sentencia->bindParam ( 1, $hipertension_arterial['id_cedula']);
            $sentencia->bindParam ( 2, $hipertension_arterial['fec_realizacion_exa']);
            $sentencia->bindParam ( 3, $hipertension_arterial['cf_tensionales']);
            $sentencia->bindParam ( 4, $hipertension_arterial['tm_signos_vitales']);
            $sentencia->bindParam ( 5, $hipertension_arterial['cons_medico_general']);
			$sentencia->bindParam ( 6, $hipertension_arterial['cons_enfermeria']);
            $sentencia->bindParam ( 7, $hipertension_arterial['cons_nutricion']);
            $sentencia->bindParam ( 8, $hipertension_arterial['glicemia_basal']);
            $sentencia->bindParam ( 9, $hipertension_arterial['hemoglobin']);
            $sentencia->bindParam ( 10, $hipertension_arterial['hematocritos']);
            $sentencia->bindParam ( 11, $hipertension_arterial['colesterol_total']);
            $sentencia->bindParam ( 12, $hipertension_arterial['colesterol_hdl']);
            $sentencia->bindParam ( 13, $hipertension_arterial['trigliceridos']);
            $sentencia->bindParam ( 14, $hipertension_arterial['potasio']);
            $sentencia->bindParam ( 15, $hipertension_arterial['creatinina']);
            $sentencia->bindParam ( 16, $hipertension_arterial['uroanalisis']);
			$sentencia->bindParam ( 17, $hipertension_arterial['ekg']);
            $sentencia->bindParam ( 18, $hipertension_arterial['id_medicamento']);
            $sentencia->bindParam ( 19, $hipertension_arterial['edu_grupal']);
            $sentencia->bindParam ( 20, $hipertension_arterial['observaciones']);
            $sentencia->bindParam ( 21, $hipertension_arterial['acciones_realizar']);

			$resultado = $sentencia->execute ();
			if($resultado){
			    $obj->respuesta = array(
				    "estado" =>1,
					"mensaje"=>"Hipertension Arterial Creado Con Exito"
				);
			} else 
		        $obj->respuesta = array(
				     "estado" => 2,
				     "mensaje"=>"Error Inesperado"
			);
		}

		private static function Actualizar($obj){
			$hipertension_arterial = $_POST['datos'];

			$comando = "UPDATE hipertension_arterial SET 
			            hipertension_arterial.id_cedula = ?, 
					    hipertension_arterial.fec_realizacion_exa = ?, 
					    hipertension_arterial.cf_tensionales = ?, 
						hipertension_arterial.tm_signos_vitales = ?, 
						hipertension_arterial.cons_medico_general = ?, 
						hipertension_arterial.cons_enfermeria = ?, 
						hipertension_arterial.cons_nutricion = ?, 
						hipertension_arterial.glicemia_basal = ?, 
						hipertension_arterial.hemoglobin = ?, 
						hipertension_arterial.hematocritos = ?, 
						hipertension_arterial.colesterol_total = ?, 
						hipertension_arterial.colesterol_hdl = ?, 
						hipertension_arterial.trigliceridos = ?, 
						hipertension_arterial.potasio = ?, 
						hipertension_arterial.creatinina = ?, 
						hipertension_arterial.uroanalisis = ?, 
						hipertension_arterial.ekg = ?, 
						hipertension_arterial.id_medicamento = ?, 
						hipertension_arterial.edu_grupal = ?, 
						hipertension_arterial.observaciones = ?, 
						hipertension_arterial.acciones_realizar = ?  
			            WHERE hipertension_arterial.id_hiper_arterial = ?";
			$sentencia = Self::$pdofull->prepare ( $comando );
			$sentencia->bindParam ( 1, $hipertension_arterial['id_cedula']);
            $sentencia->bindParam ( 2, $hipertension_arterial['fec_realizacion_exa']);
            $sentencia->bindParam ( 3, $hipertension_arterial['cf_tensionales']);
            $sentencia->bindParam ( 4, $hipertension_arterial['tm_signos_vitales']);
            $sentencia->bindParam ( 5, $hipertension_arterial['cons_medico_general']);
			$sentencia->bindParam ( 6, $hipertension_arterial['cons_enfermeria']);
            $sentencia->bindParam ( 7, $hipertension_arterial['cons_nutricion']);
            $sentencia->bindParam ( 8, $hipertension_arterial['glicemia_basal']);
            $sentencia->bindParam ( 9, $hipertension_arterial['hemoglobin']);
            $sentencia->bindParam ( 10, $hipertension_arterial['hematocritos']);
            $sentencia->bindParam ( 11, $hipertension_arterial['colesterol_total']);
            $sentencia->bindParam ( 12, $hipertension_arterial['colesterol_hdl']);
            $sentencia->bindParam ( 13, $hipertension_arterial['trigliceridos']);
            $sentencia->bindParam ( 14, $hipertension_arterial['potasio']);
            $sentencia->bindParam ( 15, $hipertension_arterial['creatinina']);
            $sentencia->bindParam ( 16, $hipertension_arterial['uroanalisis']);
			$sentencia->bindParam ( 17, $hipertension_arterial['ekg']);
            $sentencia->bindParam ( 18, $hipertension_arterial['id_medicamento']);
            $sentencia->bindParam ( 19, $hipertension_arterial['edu_grupal']);
            $sentencia->bindParam ( 20, $hipertension_arterial['observaciones']);
            $sentencia->bindParam ( 21, $hipertension_arterial['acciones_realizar']);
            $sentencia->bindParam ( 22, $hipertension_arterial['id_hiper_arterial']);
		
			$resultado = $sentencia->execute ();
			if($resultado){
				$obj->respuesta = array(
						"estado" =>1,
						"mensaje"=>"Hipertension Arterial Actualizado Con Exito"
					);
			}
		}
 }
 ?>