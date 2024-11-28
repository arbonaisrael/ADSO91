<?php
    /**
     * Cargamos todos los controladores...
     */
    
    require_once 'Controladores/UsuariosCtrl.php';
    require_once 'Controladores/BarriosCtrl.php';
    require_once 'Controladores/CiudadesCtrl.php';
    require_once 'Controladores/MedicamentosCtrl.php';
    require_once 'Controladores/PacientesCtrl.php';
    require_once 'Controladores/Cum_ProgramasCtrl.php';
    require_once 'Controladores/Hipertension_ArterialCtrl.php';
    require_once 'Controladores/HipercolesterolemiaCtrl.php'; 
    require_once 'Controladores/DeabetesCtrl.php';
	
	header ( 'content-type: application/json; charset=utf-8' );             // * Definimos que sera una aplicación de tipo JSON
	header ( 'Access-Control-Allow-Origin: *' );                            // * Permitimos el acceso a todos los clientes
	header ( 'Access-Control-Allow-Methods: POST' );                        // * Permitimos que los clientes usen POST

    $respuesta;
    $instancia;

    if ( isset($_GET['PATH_INFO']) ){
        $peticion = explode( '/', $_GET['PATH_INFO'] );
        $recurso  = array_shift( $peticion );                               // Obtenemos el recurso a solicitar

        $recursos_existentes = array(                                       // Definimos los recursos existentes y validamos que la solicitud exista
            'UsuariosCtrl',
            'BarriosCtrl',
            'CiudadesCtrl',
            'MedicamentosCtrl',
            'PacientesCtrl',
            'Cum_ProgramasCtrl',
            'Hipertension_ArterialCtrl',
            'HipercolesterolemiaCtrl',
            'DeabetesCtrl'
        );

        if ( in_array( $recurso, $recursos_existentes ) ) {
            $metodo = strtolower( $_SERVER['REQUEST_METHOD'] );             // Por seguridad validamos el método para que se post
            if ( $metodo === 'post' ) {
                switch ($recurso) {
                    case 'UsuariosCtrl':
                        $instancia = new UsuariosCtrl( $peticion );
                        break;
                    case 'BarriosCtrl':
                        $instancia = new BarriosCtrl( $peticion );
                        break;
                    case 'CiudadesCtrl':
                        $instancia = new CiudadesCtrl( $peticion );
                        break;
                    case 'MedicamentosCtrl':
                        $instancia = new MedicamentosCtrl( $peticion );
                        break;
                    case 'PacientesCtrl':
                        $instancia = new PacientesCtrl( $peticion );
                        break;
                    case 'Cum_ProgramasCtrl':
                        $instancia = new Cum_ProgramasCtrl($peticion);
                        break;
                    case 'Hipertension_ArterialCtrl':
                        $instancia = new Hipertension_ArterialCtrl($peticion);
                        break;
                    case 'HipercolesterolemiaCtrl':
                        $instancia = new HipercolesterolemiaCtrl($peticion);
                        break;
                    case 'DeabetesCtrl':
                        $instancia = new DeabetesCtrl($peticion);
                        break;
                }
                $respuesta = $instancia->respuesta;
            } else {
                $respuesta = array(
                    'estado' => 2,
                    'mensaje'=>'No se reconoce el metodo'
                );    
            }
        } else {
            $respuesta = array(
                'estado' => 2,
                'mensaje'=>'No se reconoce el recurso'
            );
        }

    } else {
        $respuesta = array(
            'estado' => 2,
            'mensaje'=>'No se reconoce la petición'
        );
    }


    echo json_encode($respuesta);

?>