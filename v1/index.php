<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Content-type: application/json;chartset=UTF-8");
header("Access-Control-Allow-Headers: *");

require_once dirname(__DIR__) . '/func/operaciones.php';

$headers = getallheaders();
$respuesta = array();
if (isset($headers['token'])) {
    $token = $headers['token'];
    require_once dirname(__DIR__) . '/func/constantes.php';
    if ($token == API_KEY) {
        $operaciones = new Operaciones();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['accion'])) {
                $accion = $_GET['accion'];
                switch ($accion) {
                    case 'niveles':
                        $data = $operaciones->getNiveles();
                        if (count($data) > 0) {
                            $respuesta['error'] = false;
                            $respuesta['mensaje'] = 'Niveles encontrados';
                            $respuesta['niveles'] = $data;
                        } else {
                            $respuesta['error'] = true;
                            $respuesta['mensaje'] = 'Niveles no encontrados';
                        }
                        break;
                    case 'subniveles':
                        if (isset($_GET['idNivel'])) {
                            $data = $operaciones->getSubNiveles($_GET['idNivel']);
                            if (count($data) > 0) {
                                $respuesta['error'] = false;
                                $respuesta['mensaje'] = 'Niveles encontrados';
                                $respuesta['subniveles'] = $data;
                            } else {
                                $respuesta['error'] = true;
                                $respuesta['mensaje'] = 'Subniveles no encontrados';
                            }
                        } else {
                            $respuesta['error'] = true;
                            $respuesta['mensaje'] = 'Falta el idNivel';
                        }
                        break;
                    default:
                        $respuesta['error'] = true;
                        $respuesta['mensaje'] = 'Accion no encontrada';
                        break;
                }
            } else {
                $respuesta['error'] = true;
                $respuesta['mensaje'] = 'Accion no definida';
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];
                switch ($accion) {
                    case 'loginApoderado':
                        if (isset($_POST['correo']) && isset($_POST['password'])) {
                            $data = $operaciones->loginApoderado($_POST['correo'], $_POST['password']);
                            if (count($data) > 0) {
                                $respuesta['error'] = false;
                                $respuesta['mensaje'] = 'Login exitoso';
                                $respuesta['loginApoderado'] = $data;
                            } else {
                                $respuesta['error'] = true;
                                $respuesta['mensaje'] = 'Correo y/o contraseña incorrecta';
                            }
                        } else {
                            $respuesta['error'] = true;
                            $respuesta['mensaje'] = 'Falta algun dato del login';
                        }
                        break;
                    case 'loginEstudiante':
                        if (isset($_POST['correo']) && isset($_POST['password'])) {
                            $data = $operaciones->loginEstudiante($_POST['correo'], $_POST['password']);
                            if (count($data) > 0) {
                                $respuesta['error'] = false;
                                $respuesta['mensaje'] = 'Login exitoso';
                                $respuesta['loginEstudiante'] = $data;
                            } else {
                                $respuesta['error'] = true;
                                $respuesta['mensaje'] = 'Correo y/o contraseña incorrecta';
                            }
                        } else {
                            $respuesta['error'] = true;
                            $respuesta['mensaje'] = 'Falta algun dato del login';
                        }
                        break;
                    case 'crearNotificacion':
                        if (isset($_POST['idApoderado']) && isset($_POST['idEstudiante']) &&
                            isset($_POST['titulo']) && isset($_POST['mensaje'])) {
                            if ($operaciones->crearNotificacion($_POST['idApoderado'], $_POST['idEstudiante'],
                                $_POST['titulo'], $_POST['mensaje'])) {
                                $respuesta['error'] = false;
                                $respuesta['mensaje'] = 'Notificación guardada';
                            } else {
                                $respuesta['error'] = true;
                                $respuesta['mensaje'] = 'Notificación no guardada';
                            }
                        } else {
                            $respuesta['error'] = true;
                            $respuesta['mensaje'] = 'Faltan parametros';
                        }
                        break;
                    default:
                        $respuesta['error'] = true;
                        $respuesta['mensaje'] = 'Accion no definida';
                        break;
                }
            } else {
                $respuesta['error'] = true;
                $respuesta['mensaje'] = 'Accion no definida';
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str(file_get_contents('php://input'), $put_vars);
        } else
            if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                parse_str(file_get_contents('php://input'), $delete_vars);
            }
    } else {
        $respuesta['error'] = true;
        $respuesta['mensaje'] = 'Token invalido';
    }
} else {
    $respuesta['error'] = true;
    $respuesta['mensaje'] = 'Falta el token';
}
echo json_encode($respuesta, JSON_NUMERIC_CHECK);