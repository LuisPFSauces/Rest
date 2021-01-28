<?php

/**
 * 
 */
require_once 'config/config.php';
require_once 'config/confDBPDO.php';
$auth_user = isset(getallheaders()["auth_user"]) ? getallheaders()["auth_user"] : null;
$auth_code = isset(getallheaders()["auth_password"]) ? getallheaders()[""] : null;

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if(isset($_REQUEST["ID"])){
            $aConsulta = UsuarioPDO::buscarPorId($_REQUEST["ID"]);
        } else {
            $aArgumentos = [];
            foreach ($_REQUEST as $llave => $valor){
                $aArgumentos[$llave] = $valor;
            }
            $aConsulta = UsuarioPDO::buscarPorArgumentos($aArgumentos);
        }
        echo json_encode($aConsulta);
        break;
    case "POST":
        echo "POST";
        var_dump($aArgumentos);
        $aArgumentos = json_decode(file_get_contents("php://input"), true);
        break;
    case "PUT":
        echo "PUT";
        if (isset($aArgumentos[0]) && is_array($aArgumentos[0])) {
            UsuarioPDO::actualizarVarios($aArgumentos);
        } else if (is_array($aArgumentos)) {
            UsuarioPDO::actualizar($aArgumentos);
        } else {
            http_response_code(422);
        }
        break;
    case "DELETE":
        echo "DELETE";
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