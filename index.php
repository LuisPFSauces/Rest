<?php

/**
 * 
 */
require_once 'config/config.php';
require_once 'config/confDBPDO.php';
header("pruebas: prue");
header('Content-Type: application/json');
$auth_user = isset(getallheaders()["auth_user"]) ? getallheaders()["auth_user"] : null;
$auth_password = isset(getallheaders()["auth_password"]) ? getallheaders()["auth_password"] : null;
$autenticado = UsuarioPDO::validadUsuario($auth_user, $auth_password);
function parametrosURL() {
    $parametros = [];
    foreach ($_REQUEST as $llave => $valor) {
        $parametros[$llave] = $valor;
    }
    return $parametros;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if (isset($_REQUEST["ID"])) {
            $aConsulta = UsuarioPDO::buscarPorId($_REQUEST["ID"]);
        } else if (count($_REQUEST) > 0) {
            $aArgumentos = parametrosURL();
            $aConsulta = UsuarioPDO::buscarPorArgumentos($aArgumentos);
        } else {
            $aConsulta = UsuarioPDO::buscar();
        }
        echo json_encode($aConsulta, JSON_PRETTY_PRINT);
        break;
    case "POST":
        if ($autenticado) {
            if (count($_REQUEST) >= 2 && isset($_REQUEST["ID"])) {
                $aArgumentos = parametrosURL();
                $retorno = UsuarioPDO::actualizar($aArgumentos);
            } else {
                $aArgumentos = json_decode(file_get_contents("php://input"), true);
                if (json_last_error() == JSON_ERROR_NONE && isset($aArgumentos[0]) && is_array($aArgumentos[0])) {
                    $retorno = UsuarioPDO::actualizarVarios($aArgumentos);
                } else if (json_last_error() == JSON_ERROR_NONE && is_array($aArgumentos)) {
                    $retorno = UsuarioPDO::actualizar($aArgumentos);
                } else {
                    http_response_code(422);
                    exit();
                }
            }
            if ($retorno) {
                echo json_encode($aArgumentos, JSON_PRETTY_PRINT);
            } else {
                http_response_code(422);
                exit();
            }
        } else {
            http_response_code(401);
        }
        break;
    case "PUT":
        if ($autenticado) {
            if (isset($_REQUEST["ID"])) {
                $aArgumentos = parametrosURL();
                $retorno = UsuarioPDO::crear($aArgumentos);
            } else {
                $aArgumentos = json_decode(file_get_contents("php://input"), true);
                if (json_last_error() == JSON_ERROR_NONE && isset($aArgumentos[0]) && is_array($aArgumentos[0])) {
                    $retorno = UsuarioPDO::crearVarios($aArgumentos);
                } else if (json_last_error() == JSON_ERROR_NONE && is_array($aArgumentos)) {
                    $retorno = UsuarioPDO::crear($aArgumentos);
                } else {
                    http_response_code(422);
                    exit();
                }
            }

            if ($retorno) {
                echo json_encode($aArgumentos, JSON_PRETTY_PRINT);
            } else {
                http_response_code(422);
                exit();
            }
        } else {
            http_response_code(401);
        }

        break;
    case "DELETE":
        if ($autenticado) {
            if (isset($_REQUEST["ID"])) {
                $retorno = UsuarioPDO::borrar($_REQUEST["ID"]);
                $aArgumentos["ID"] = $_REQUEST["ID"];
            } else {
                $aArgumentos = json_decode(file_get_contents("php://input"), true);
                if (json_last_error() == JSON_ERROR_NONE && isset($aArgumentos[0]) && is_array($aArgumentos[0])) {
                    $retorno = UsuarioPDO::borrarVarios($aArgumentos);
                } else if (json_last_error() == JSON_ERROR_NONE && isset($aArgumentos["ID"])) {
                    $retorno = UsuarioPDO::borrar($aArgumentos["ID"]);
                } else {
                    http_response_code(422);
                    exit();
                }
            }

            if ($retorno) {
                echo json_encode($aArgumentos, JSON_PRETTY_PRINT);
            } else {
                http_response_code(422);
                exit();
            }
        } else {
            http_response_code(401);
        }
        break;
}
/*
require_once 'config/config.php';
require_once 'config/confDBPDO.php';

$argumentos = [
    "limite" => 7,
    "Nombre" => "Pablo",
    "Descripcion" => "pruebas2"
];


echo "Hola: \n";
echo (count(UsuarioPDO::buscarPorArgumentos($argumentos)));
   

*/