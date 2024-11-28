<?php

	
	class DeabetesCtrl
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
					$this->respuestadeabetes = array(
							'estado' => 2,
							'mensaje'=>'No se reconoce el metodo del recurso'
						);
			}
		}

		private static function Listar($obj){

			$comando = "SELECT  deabetes.id_deabetes as id_deabetes, 
							    deabetes.id_cedula as id_cedula, 
							    deabetes.fec_realizacion_exa as fec_realizacion_exa,  
								deabetes.cons_medico_general as cons_medico_general, 
								deabetes.cons_enfermeria as cons_enfermeria, 
								deabetes.cons_nutricion as cons_nutricion,							 
								deabetes.colesterol_total as colesterol_total, 
								deabetes.colesterol_hdl as colesterol_hdl, 
								deabetes.trigliceridos as trigliceridos,
								deabetes.creatinina as creatinina,
								deabetes.hemoglobina as hemoglobina, 
								deabetes.uroanalisis as uroanalisis, 
								deabetes.ekg as ekg, 
								deabetes.id_medicamento1 as id_medicamento1,
								deabetes.id_medicamento2 as id_medicamento2, 
								deabetes.edu_grupal as edu_grupal, 
								deabetes.observaciones as observaciones, 
								deabetes.acciones_realizar as acciones_realizar,  
								pacientes.nombres as nombrep, 
								pacientes.apellidos as apellidop,  
								med1.nombre as nombrem1,
								med2.nombre as nombrem2
                                FROM (((deabetes inner join pacientes on deabetes.id_cedula = pacientes.id_cedula)
                                        inner join medicamentos as med1 on deabetes.id_medicamento1 = med1.id_medicamento) inner join medicamentos as med2 on deabetes.id_medicamento2 = med2.id_medicamento)";
			$sentencia = Self::$pdofull->prepare($comando);
			if ($sentencia->execute ()) {
				$resultado = $sentencia->fetchAll ( PDO::FETCH_ASSOC );
				if ($resultado) {
					$obj->respuesta = array(
							"estado" => 1,
							"Deabetes" => $resultado
						);		
				} else {
					$obj->respuesta = null;
				}
			} else
				$obj->respuesta = null;
		}

		private static function Registrar($obj){
			$deabetes = $_POST['datos'];
			
			$insert = "INSERT INTO deabetes (
			                    deabetes.id_cedula, 
							    deabetes.fec_realizacion_exa, 						     
								deabetes.cons_medico_general, 
								deabetes.cons_enfermeria, 
								deabetes.cons_nutricion, 
								deabetes.colesterol_total, 
								deabetes.colesterol_hdl, 
								deabetes.trigliceridos,  
								deabetes.creatinina,
								deabetes.hemoglobina, 
								deabetes.uroanalisis, 
								deabetes.ekg, 
								deabetes.id_medicamento1,
								deabetes.id_medicamento2,								 
								deabetes.edu_grupal, 
								deabetes.observaciones, 
								deabetes.acciones_realizar  
			           ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$sentencia = Self::$pdofull->prepare ( $insert );
			$sentencia->bindParam ( 1, $deabetes['id_cedula']);
            $sentencia->bindParam ( 2, $deabetes['fec_realizacion_exa']);
            $sentencia->bindParam ( 3, $deabetes['cons_medico_general']);
			$sentencia->bindParam ( 4, $deabetes['cons_enfermeria']);
            $sentencia->bindParam ( 5, $deabetes['cons_nutricion']);
            $sentencia->bindParam ( 6, $deabetes['colesterol_total']);
            $sentencia->bindParam ( 7, $deabetes['colesterol_hdl']);
            $sentencia->bindParam ( 8, $deabetes['trigliceridos']);            
            $sentencia->bindParam ( 9, $deabetes['creatinina']);
            $sentencia->bindParam ( 10, $deabetes['hemoglobina']);
            $sentencia->bindParam ( 11, $deabetes['uroanalisis']);
			$sentencia->bindParam ( 12, $deabetes['ekg']);
            $sentencia->bindParam ( 13, $deabetes['id_medicamento1']);
            $sentencia->bindParam ( 14, $deabetes['id_medicamento2']);            
            $sentencia->bindParam ( 15, $deabetes['edu_grupal']);
            $sentencia->bindParam ( 16, $deabetes['observaciones']);
            $sentencia->bindParam ( 17, $deabetes['acciones_realizar']);

			$resultado = $sentencia->execute ();
			if($resultado){
			    $obj->respuesta = array(
				    "estado" =>1,
					"mensaje"=>"Deabetes Creado Con Exito"
				);
			} else 
		        $obj->respuesta = array(
				     "estado" => 2,
				     "mensaje"=>"Error Inesperado"
			);
		}

		private static function Actualizar($obj){
			$deabetes = $_POST['datos'];


			$comando = "UPDATE deabetes SET 
			            deabetes.id_cedula = ?, 
					    deabetes.fec_realizacion_exa = ?, 
						deabetes.cons_medico_general = ?, 
						deabetes.cons_enfermeria = ?, 
						deabetes.cons_nutricion = ?, 
						deabetes.colesterol_total = ?, 
						deabetes.colesterol_hdl = ?, 
						deabetes.trigliceridos = ?, 
						deabetes.creatinina = ?, 
						deabetes.hemoglobina = ?,
						deabetes.uroanalisis = ?, 
						deabetes.ekg = ?, 
						deabetes.id_medicamento1 = ?,
						deabetes.id_medicamento2 = ?,						 
						deabetes.edu_grupal = ?, 
						deabetes.observaciones = ?, 
						deabetes.acciones_realizar = ?  
			            WHERE deabetes.id_deabetes = ?";
			$sentencia = Self::$pdofull->prepare ( $comando );
			$sentencia->bindParam ( 1, $deabetes['id_cedula']);
            $sentencia->bindParam ( 2, $deabetes['fec_realizacion_exa']);
            $sentencia->bindParam ( 3, $deabetes['cons_medico_general']);
			$sentencia->bindParam ( 4, $deabetes['cons_enfermeria']);
            $sentencia->bindParam ( 5, $deabetes['cons_nutricion']);
            $sentencia->bindParam ( 6, $deabetes['colesterol_total']);
            $sentencia->bindParam ( 7, $deabetes['colesterol_hdl']);
            $sentencia->bindParam ( 8, $deabetes['trigliceridos']);            
            $sentencia->bindParam ( 9, $deabetes['creatinina']);
            $sentencia->bindParam ( 10, $deabetes['hemoglobina']);
            $sentencia->bindParam ( 11, $deabetes['uroanalisis']);
			$sentencia->bindParam ( 12, $deabetes['ekg']);
            $sentencia->bindParam ( 13, $deabetes['id_medicamento1']);
            $sentencia->bindParam ( 14, $deabetes['id_medicamento2']);            
            $sentencia->bindParam ( 15, $deabetes['edu_grupal']);
            $sentencia->bindParam ( 16, $deabetes['observaciones']);
            $sentencia->bindParam ( 17, $deabetes['acciones_realizar']);
            $sentencia->bindParam ( 18, $deabetes['id_deabetes']);
            
		
			$resultado = $sentencia->execute ();
			if($resultado){
				$obj->respuesta = array(
						"estado" =>1,
						"mensaje"=>"Deabetes Actualizado Con Exito"
					);
			}
		}
 }
 ?>