<?php
require_once "vendor/econea/nusoap/src/nusoap.php";

// Nombre del servicio
$namespace = "InsertCategoriaSOAP";
$server = new soap_server();
$server->configureWSDL("InsertCategoria", $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

// Estructura del servicio para insertar usuario
$server->wsdl->addComplexType(
    'InsertCategoria',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'usu_nom' => array('name' => 'usu_nom', 'type' => 'xsd:string'),
        'usu_ape' => array('name' => 'usu_ape', 'type' => 'xsd:string'),
        'usu_correo' => array('name' => 'usu_correo', 'type' => 'xsd:string'),
    )
);

// Estructura de la respuesta (booleano)
$server->wsdl->addComplexType(
    'response',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'Resultado' => array('name' => 'Resultado', 'type' => 'xsd:boolean')
    )
);

// Estructura para devolver todos los usuarios
$server->wsdl->addComplexType(
    'Usuario',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'usu_id' => array('name' => 'usu_id', 'type' => 'xsd:int'),
        'usu_nom' => array('name' => 'usu_nom', 'type' => 'xsd:string'),
        'usu_ape' => array('name' => 'usu_ape', 'type' => 'xsd:string'),
        'usu_correo' => array('name' => 'usu_correo', 'type' => 'xsd:string'),
    )
);

$server->wsdl->addComplexType(
    'UsuariosList',
    'complexType',
    'array',
    '',
    '',
    array(
        'Usuario' => array('name' => 'Usuario', 'type' => 'tns:Usuario')
    )
);

// Registra las funciones del servicio
$server->register(
    "InsertCategoriaService",
    array("InsertCategoria" => "tns:InsertCategoria"),
    array("response" => "tns:response"),
    $namespace,
    false,
    "rpc",
    "encoded",
    "Inserta una categoria"
);

$server->register(
    "GetUsuariosService",
    array(),
    array("UsuariosList" => "tns:UsuariosList"),
    $namespace,
    false,
    "rpc",
    "encoded",
    "Devuelve todos los usuarios activos"
);

// Función para insertar un usuario
function InsertCategoriaService($request){
    require_once('config/conexion.php');
    require_once('models/UsuarioSOAP.php');

    $usuario = new Usuario();
    $usuario->insert_usuario($request["usu_nom"],$request["usu_ape"],$request["usu_correo"]);
    return array(
        "Resultado" => true
    );
}

// Función para obtener todos los usuarios
function GetUsuariosService() {
    require_once('config/conexion.php');
    require_once('models/UsuarioSOAP.php');

    $usuario = new Usuario();
    $usuarios = $usuario->get_usuarios();
    return $usuarios;
}

///
// Registrar servicio de edición
$server->register(
    "EditarUsuarioService",
    array("id" => "xsd:int", "nombre" => "xsd:string", "apellido" => "xsd:string", "correo" => "xsd:string"),
    array("response" => "xsd:boolean"),
    $namespace,
    false,
    "rpc",
    "encoded",
    "Editar un usuario"
);

function EditarUsuarioService($id, $nombre, $apellido, $correo) {
    require_once('config/conexion.php');
    require_once('models/UsuarioSOAP.php');
    $usuario = new Usuario();
    $usuario->update_usuario($id, $nombre, $apellido, $correo);
    return true;
}

// Registrar servicio de eliminación
$server->register(
    "EliminarUsuarioService",
    array("id" => "xsd:int"),
    array("response" => "xsd:boolean"),
    $namespace,
    false,
    "rpc",
    "encoded",
    "Eliminar un usuario"
);

function EliminarUsuarioService($id) {
    require_once('config/conexion.php');
    require_once('models/UsuarioSOAP.php');
    $usuario = new Usuario();
    $usuario->delete_usuario($id);
    return true;
}

// Registrar servicio de búsqueda
$server->register(
    "BuscarUsuarioService",
    array("nombre" => "xsd:string"),
    array("Usuario" => "tns:Usuario"),
    $namespace,
    false,
    "rpc",
    "encoded",
    "Buscar un usuario por nombre"
);

function BuscarUsuarioService($nombre) {
    require_once('config/conexion.php');
    require_once('models/UsuarioSOAP.php');
    $usuario = new Usuario();
    $resultado = $usuario->buscar_usuario($nombre);
    return $resultado ? $resultado : [];
}



// Procesar la solicitud SOAP
$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();
?>
