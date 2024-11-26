<?php
require_once "vendor/econea/nusoap/src/nusoap.php";

// Configurar el cliente SOAP
$client = new nusoap_client("http://localhost/PERSONAL_WebServicePostman/InsertCategoria.php?wsdl", true);
$error = $client->getError();

if ($error) {
    die("Error en la conexión: $error");
}

// Llamar al servicio para obtener los usuarios
$response = $client->call("GetUsuariosService", array());

// Verificar si hay errores o si el servicio devolvió un resultado vacío
if ($client->fault) {
    echo "Error al consumir el servicio SOAP";
    print_r($response);
} elseif ($client->getError()) {
    echo "Error: " . $client->getError();
} else {
    $usuarios = $response;
}

function buscarUsuario($nombre) {
    global $client;
    return $client->call("BuscarUsuarioService", array("nombre" => $nombre));
}

?>
