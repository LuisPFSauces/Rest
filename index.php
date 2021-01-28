<?php

/**
 * 
 */
require_once 'config/config.php';
require_once 'config/confDBPDO.php';

$aArgumentos = json_decode(file_get_contents("php://input"), true);
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        echo "GET";
        var_dump($aArgumentos);
        break;
    case "POST":
        echo "POST";
        var_dump($aArgumentos);
        
        break;
    case "PUT":
        echo "PUT s";
        if (isset($aArgumentos[0]) && is_array($aArgumentos[0]) ){
              UsuarioPDO::actualizarVarios($aArgumentos);
        } else if(is_array($aArgumentos)) {
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