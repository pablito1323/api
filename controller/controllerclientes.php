<?php

require_once("../config/conexion.php");
require_once("../models/modelsclientes.php");


header("Content-Type: application/json");

$clientes = new clientes();

$body = json_decode(file_get_contents("php://input"), true);

if (isset($_GET["op"])) {
    $op = trim($_GET["op"]);

    switch ($op) {
        case "GetALL":
            $datos = $clientes->get_cliente();
            echo json_encode($datos);
            break;

        case "GetId":
            $datos = $clientes->get_cliente_x_id($body["id_cliente"]);
            echo json_encode($datos);
            break;

        case "Post":
           $datos = $clientes->insert_cliente($body["nombre_cliente"], $body["correo"], $body["telefono"], $body["direccion"]);
           echo json_encode("Insert correcto"); 
           break;

        case "Put":
            $datos = $clientes->update_cliente($body["id_cliente"], $body["nombre_cliente"], $body["correo"], $body["telefono"], $body["direccion"]);
            echo json_encode("Update correcto"); 
           break;

        case "Delete":     
                $datos = $clientes->delete_cliente($body["id_cliente"]);
                echo json_encode($datos ? ["mensaje" => "Eliminación exitosa"] : ["error" => "No se pudo eliminar la categoría."]);
            break;

        default:
            echo json_encode(["error" => "Operación no válida."]);
            break;
    }
} else {
    // Si no se envió el parámetro 'op' en la URL, se devuelve un mensaje de error
    echo json_encode(["error" => "Parámetro 'op' no encontrado."]);
}
?>