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
            $dato_usuario  = $_POST['datos'];

            if ($dato_usuario[0]['rol']  == 1) {
                $consulta = "SELECT 
                                u.usuario as lis_usuario, 
                                u.clave as lis_clave, 
                                u.rol as lis_rol, 
                                u.estado as lis_estado 
                            FROM usuarios as u";
           } else {
                $consulta = "SELECT 
                                u.usuario as lis_usuario, 
                                u.clave as lis_clave, 
                                u.rol as lis_rol, 
                                u.estado as lis_estado 
                            FROM usuarios as u WHERE u.usuario = '" . $dato_usuario[0]['usuario'] . "' AND u.rol = '" . $dato_usuario[0]['rol'] . "';";
            }

            $sentencia = self::$pdofull->prepare($consulta);

            if ($sentencia->execute()) {
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                if ($resultado) {
                    $obj->respuesta = array(
                        "estado"    => 1,
                        "lusuarios" => $resultado
                    );
                } else {
                    $obj->respuesta = null;
                }
            } else {
                $obj->respuesta = null;
            }
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
            $usuario = $_POST['datos'];
            $comando = "UPDATE usuarios 
                        SET 
                            usuarios.clave  = ?,
                            usuarios.estado = ?,
                            usuarios.rol    = ?
                        WHERE usuarios.usuario = ?";

            $sentencia = self::$pdofull->prepare($comando);
            $sentencia->bindParam ( 1, $usuario['clave'] );
            $sentencia->bindParam ( 2, $usuario['estado'] );
            $sentencia->bindParam ( 3, $usuario['rol'] );
            $sentencia->bindParam ( 4, $usuario['username'] );

            $resultado = $sentencia->execute();

            if ($resultado) {
                $obj->respuesta = array (
                    'estado'  => 1,
                    'mensaje' => "Usuario actualizado con exito..."
                );
            }
        }
        
        private static function Logear($obj)
        {
            $usuario = $_POST['datos'];
            $consultaSQL = "SELECT u.usuario, u.rol, u.estado FROM usuarios AS u where u.usuario = '" 
            . $usuario['username'] . "' AND u.clave = '" . $usuario['clave'] . "';";

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