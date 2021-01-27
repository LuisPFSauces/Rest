<?php

/**
 * 
 */
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        echo "GET";
        echo json_decode(file_get_contents("php://input"));
        break;
    case "POST":
        echo "POST";
        var_dump(json_decode(file_get_contents("php://input"), true));
        break;
    case "PUT":
        echo "PUT";
        echo json_decode(file_get_contents("php://input"));
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