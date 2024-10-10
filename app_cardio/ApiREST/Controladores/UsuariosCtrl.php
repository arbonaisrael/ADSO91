<?php
    /**
     * Cargamos la conexion unicamente se realiza en este archivo ya que sera el primero en cargar * el index
     */
    require_once 'Datos/ConexionDB.php';

    class UsuariosCtrl
    {
        public $respuesta = null;
        private static $pdofull;

        function __construct($peticion)
        {
            self::$pdofull = ConexionDB::obtenerInstancia()->obtenerDB();

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
                case 'Logear':
                    return self::Logear($this);
                    break;
                default:
                    self::$respuesta = array(
                        'estado'  => 2,
                        'mensaje' => 'No se reconoce el metodo del recurso'
                    );
            }
        }

        private static function Listar($obj)
        {

        }

        private static function Registrar($obj)
        {
            $usuario           = $_POST['datos'];
            $validar_usu       = "SELECT u.usuario, u.clave, u.rol, u.estado FROM usuarios AS u where u.usuario = '" . $usuario['regusuario'] . "';";
            $sentencia_val_usu = Self::$pdofull->prepare($validar_usu);
            if ($sentencia_val_usu->execute()) {
                $resultado_val_usu = $sentencia_val_usu->fetch(PDO::FETCH_OBJ);
                if ($resultado_val_usu) {
                    $obj->respuesta = array (
                        'estado'  => 2,
                        'mensaje' => "Error el usuario ya se encuentra registrado..."
                    );
                } else {
                    $insertar  = "INSERT INTO usuarios (usuario, clave, rol, estado) VALUES (?,?,?,?)";
                    $sentencia = Self::$pdofull->prepare($insertar);
                    $sentencia->bindParam(1, $usuario['regusuario']);
                    $sentencia->bindParam(2, $usuario['regclave']);
                    $sentencia->bindParam(3, $usuario['regrol']);
                    $sentencia->bindParam(4, $usuario['regestado']);

                    $resultado = $sentencia->execute();
                    if($resultado) {
                        $obj->respuesta = array (
                            'estado'  => 1,
                            'mensaje' => "Usuario creado correctamente"
                        );
                    }
                }
            } else {
                $obj->respuesta = array (
                    'estado'  => 3,
                    'mensaje' => "Error inesperado..."
                );
            }        
        }
        
        private static function Actualizar($obj)
        {
            
        }
        
        private static function Logear($obj)
        {
            $usuario = $_POST['datos'];
            $consultaSQL = "SELECT u.usuario, u.estado FROM usuarios AS u WHERE u.usuario = '"
                            . $usuario['username'] . "' AND u.clave = '" . $usuario['clave'] . "' AND u.estado = 1;";

            $sentencia = self::$pdofull->prepare($consultaSQL);

            if ( $sentencia->execute() ) {
                $resultado = $sentencia->fetchAll( PDO::FETCH_ASSOC );
                if ($resultado) {
                    $obj->respuesta = array (
                        'estado'  => 1,
                        'mensaje' => 'Bienvenid@s',
                        'usuario' => $resultado
                    );
                } else {
                    $obj->respuesta = array (
                        'estado'  => 2,
                        'mensaje' => 'Error en la verificación de credenciales'
                    );
                }
            } else {
                $obj->respuesta = null;
            }
        }
        
    }
?>