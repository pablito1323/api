<?php
require_once "vendor/econea/nusoap/src/nusoap.php";

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$client = new nusoap_client("http://localhost/PERSONAL_WebServicePostman/InsertCategoria.php?wsdl", true);
$response = $client->call("EliminarUsuarioService", array("id" => $id));

echo json_encode(["success" => $response]);

?>