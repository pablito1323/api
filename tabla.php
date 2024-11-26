<?php include('Consumir.php'); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        /* Estilos para el menú vertical */
        .menu {
            height: 100vh;
            width: 250px;
            background-color: #343a40;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 15px;
            display: block;
            font-size: 18px;
        }

        .menu a:hover {
            background-color: #007bff;
        }
        /* Contenido principal */
        .content {
            margin-left: 220px;
            padding: 20px;
        }

    </style>
</head>

<body>
    <!-- Menú vertical -->
    <div class="menu">
        <a href="inicio.html">Inicio</a> <!-- Cambié el enlace de inicio a home.html -->
        <a href="clientes.html">Clientes</a>
        <a href="tabla.php">Usuarios</a>
        <a href="reportes.html">Reportes</a>
        <!-- Puedes agregar más enlaces aquí -->
    </div>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Lista de Usuarios</h1>
        <div class="d-flex justify-content-between mb-4">
            <div>
                <input type="text" id="buscarNombre" class="form-control" placeholder="Buscar por nombre" oninput="buscarUsuario()">
            </div>
            <div>
                <button class="btn btn-primary" id="mostrarTodos">Mostrar Todos</button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar Usuario</button>
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaUsuarios">
                <?php if (!empty($usuarios)) : ?>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?php echo $usuario['usu_id']; ?></td>
                            <td><?php echo $usuario['usu_nom']; ?></td>
                            <td><?php echo $usuario['usu_ape']; ?></td>
                            <td><?php echo $usuario['usu_correo']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="abrirModalEditar(<?php echo $usuario['usu_id']; ?>, '<?php echo $usuario['usu_nom']; ?>', '<?php echo $usuario['usu_ape']; ?>', '<?php echo $usuario['usu_correo']; ?>')">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(<?php echo $usuario['usu_id']; ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay usuarios disponibles.</td>
                    </tr>
                <?php endif; ?>
                <script>
        document.querySelector('#mostrarTodos').addEventListener('click', function() {
            // Lógica para mostrar todos los usuarios
            window.location.href = 'tabla.php';  // Redirige a la página tabla.php
        });
    </script>
            </tbody>

        </table>
    </div>

    <!-- Modal para agregar usuario -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregar">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" id="correo" name="correo" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="agregarUsuario()">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditar">
                        <input type="hidden" id="editarId">
                        <div class="mb-3">
                            <label for="editarNombre" class="form-label">Nombre:</label>
                            <input type="text" id="editarNombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarApellido" class="form-label">Apellido:</label>
                            <input type="text" id="editarApellido" name="apellido" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarCorreo" class="form-label">Correo:</label>
                            <input type="email" id="editarCorreo" name="correo" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-warning" onclick="guardarEdicion()">Guardar Cambios</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Agregar usuario
        function agregarUsuario() {
            const nombre = document.getElementById("nombre").value;
            const apellido = document.getElementById("apellido").value;
            const correo = document.getElementById("correo").value;

            if (nombre && apellido && correo) {
                fetch('http://localhost/PERSONAL_WEBSERVICEPOSTMAN/AgregarUsuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        nombre: nombre,
                        apellido: apellido,
                        correo: correo
                    })
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Usuario agregado con éxito.");
                            location.reload(); // Recargar la página
                        } else {
                            alert("Error al agregar el usuario.");
                        }
                    });
            } else {
                alert("Por favor, complete todos los campos.");
            }
        }

        // Función para abrir el modal de edición y llenar los campos
        function abrirModalEditar(id, nombre, apellido, correo) {
            document.getElementById("editarId").value = id;
            document.getElementById("editarNombre").value = nombre;
            document.getElementById("editarApellido").value = apellido;
            document.getElementById("editarCorreo").value = correo;

            // Mostrar el modal de edición
            const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
            modal.show();
        }

        // Guardar cambios después de editar
        function guardarEdicion() {
            const id = document.getElementById("editarId").value;
            const nombre = document.getElementById("editarNombre").value;
            const apellido = document.getElementById("editarApellido").value;
            const correo = document.getElementById("editarCorreo").value;

            if (nombre && apellido && correo) {
                fetch('http://localhost/PERSONAL_WEBSERVICEPOSTMAN/EditarUsuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: id,
                        nombre: nombre,
                        apellido: apellido,
                        correo: correo
                    })
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Usuario editado con éxito.");
                            location.reload(); // Recargar la página
                        } else {
                            alert("Error al editar el usuario.");
                        }
                    });
            } else {
                alert("Por favor, complete todos los campos.");
            }
        }

        // Función para eliminar un usuario
        function eliminarUsuario(id) {
            console.log("Intentando eliminar usuario con ID:", id);
            if (confirm("¿Está seguro de eliminar este usuario?")) {
                fetch('http://localhost/PERSONAL_WEBSERVICEPOSTMAN/EliminarUsuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Usuario eliminado con éxito.");
                            location.reload(); // Recargar la página
                        } else {
                            alert("Error al eliminar el usuario.");
                        }
                    });
            }
        }

        // Función de búsqueda de usuario
        function buscarUsuario() {
            const nombre = document.getElementById("buscarNombre").value;

            if (nombre) {
                fetch('http://localhost/PERSONAL_WebServicePostman/BuscarUsuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nombre: nombre })
                })
                .then(response => response.json())
                .then(data => {
                    const tabla = document.getElementById("tablaUsuarios");
                    tabla.innerHTML = ""; // Limpiar la tabla

                    if (data && data.usu_id) {
                        const fila = `
                            <tr>
                                <td>${data.usu_id}</td>
                                <td>${data.usu_nom}</td>
                                <td>${data.usu_ape}</td>
                                <td>${data.usu_correo}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="abrirModalEditar(${data.usu_id}, '${data.usu_nom}', '${data.usu_ape}', '${data.usu_correo}')">Editar</button>
                                    <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${data.usu_id})">Eliminar</button>
                                </td>
                            </tr>
                        `;
                        tabla.innerHTML = fila;
                    } else {
                        tabla.innerHTML = `<tr><td colspan="5">No se encontraron resultados.</td></tr>`;
                    }
                })
                .catch(error => {
                    console.error("Error en la búsqueda:", error);
                    alert("Hubo un error al realizar la búsqueda.");
                });
            } else {
                // Si el campo de búsqueda está vacío, recargar todos los usuarios
                mostrarTodos();
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>



