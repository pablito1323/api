<?php
require_once "vendor/econea/nusoap/src/nusoap.php";

$data = json_decode(file_get_contents("php://input"), true);
$nombre = $data['nombre'];
$apellido = $data['apellido'];
$correo = $data['correo'];

$client = new nusoap_client("http://localhost/PERSONAL_WebServicePostman/InsertCategoria.php?wsdl", true);
$response = $client->call("InsertCategoriaService", array("InsertCategoria" => array(
    "usu_nom" => $nombre,
    "usu_ape" => $apellido,
    "usu_correo" => $correo
)));

echo json_encode(["success" => $response['Resultado']]);
?>
