<?php
    /**
     * Cargamos todos los controladores...
     */
    require_once 'Controladores/UsuariosCtrl.php';
	
	header ( 'content-type: application/json; charset=utf-8' );             // * Definimos que sera una aplicación de tipo JSON
	header ( 'Access-Control-Allow-Origin: *' );                            // * Permitimos el acceso a todos los clientes
	header ( 'Access-Control-Allow-Methods: POST' );                        // * Permitimos que los clientes usen POST

    $respuesta;
    $instancia;

    if ( isset($_GET['PATH_INFO']) ){
        $peticion = explode( '/', $_GET['PATH_INFO'] );
        $recurso  = array_shift( $peticion );                               // Obtenemos el recurso a solicitar

        $recursos_existentes = array(                                       // Definimos los recursos existentes y validamos que la solicitud exista
            'UsuariosCtrl'
        );

        if ( in_array( $recurso, $recursos_existentes ) ) {
            $metodo = strtolower( $_SERVER['REQUEST_METHOD'] );             // Por seguridad validamos el método para que se post
            if ( $metodo === 'post' ) {
                switch ($recurso) {
                    case 'UsuariosCtrl':
                        $instancia = new UsuariosCtrl( $peticion );
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