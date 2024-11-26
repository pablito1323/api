<?php
require_once "vendor/econea/nusoap/src/nusoap.php";

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$nombre = $data['nombre'];
$apellido = $data['apellido'];
$correo = $data['correo'];

$client = new nusoap_client("http://localhost/PERSONAL_WebServicePostman/InsertCategoria.php?wsdl", true);
$response = $client->call("EditarUsuarioService", array("id" => $id, "nombre" => $nombre, "apellido" => $apellido, "correo" => $correo));

echo json_encode(["success" => $response]);

?>