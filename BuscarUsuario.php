<?php
require_once "vendor/econea/nusoap/src/nusoap.php";

$data = json_decode(file_get_contents("php://input"), true);
$nombre = $data['nombre'];

$client = new nusoap_client("http://localhost/PERSONAL_WebServicePostman/InsertCategoria.php?wsdl", true);
$response = $client->call("BuscarUsuarioService", array("nombre" => $nombre));

echo json_encode($response);
?>