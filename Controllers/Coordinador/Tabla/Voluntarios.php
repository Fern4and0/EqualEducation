<?php
session_start(); // Inicia la sesión

// Verifica si hay una sesión activa (es decir, si el usuario ha iniciado sesión)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Resources/Views/Login.html"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución del script
}

include '../../../DB/db.php'; // Incluye la conexión a la base de datos

// Obtener lista de usuarios
$sql = "SELECT * FROM users"; // Se define la consulta SQL para obtener todos los usuarios
$result = $conn->query($sql); // Ejecuta la consulta y guarda el resultado

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC); // Si hay filas, se almacenan los datos en un arreglo asociativo
} else {
    $users = []; // Si no hay resultados, se inicializa un arreglo vacío
}

$conn->close();  // Cierra la conexión a la base de datos

// Función para obtener el nombre del rol a partir del id_rol
function getRoleName($id_rol) {
    switch ($id_rol) {
        case 1:
            return 'Administrador';
        case 2:
            return 'Coordinador';
        case 3:
            return 'Beneficiario';
        case 4:
            return 'Voluntario';
        case 5:
            return 'Donador';
        default:
            return 'Desconocido';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voluntarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../Cordi-Dashboard.php">    Coordinador Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../Cordi-Dashboard.php">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRoles" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Gestión de Usuarios
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownRoles">
                        <li><a class="dropdown-item" href="Beneficiarios.php">Beneficiarios</a></li>
                        <li><a class="dropdown-item" href="Voluntarios.php">Voluntarios</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../Programas.php">Programas</a>
                <li class="nav-item">
                    <a class="nav-link" href="../Informes.php">Informes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../Donadores.php">Donaciones</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../Login/Logout.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
                <h2>Voluntarios Registrados</h2>

                <!-- Tabla para Voluntarios -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Voluntarios</span>
                        <!-- Botón de Solicitudes -->
                        <button id="btnSolicitudesVoluntarios" class="btn btn-warning btn-sm position-relative">
                            <i class="fas fa-bell"></i> <!-- Icono de campana para solicitudes -->
                            <span id="contadorSolicitudesVoluntarios" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                0 <!-- Valor inicial del contador -->
                            </span>
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Barra de búsqueda -->
                        <div class="form-group">
                            <input type="text" id="searchInputVoluntarios" class="form-control" placeholder="Buscar usuarios...">
                        </div>
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="userTableVoluntarios">
                                <?php foreach ($users as $user): ?>
                                    <?php if ($user['id_rol'] == 4): ?>
                                        <tr>
                                            <td><?php echo $user['id']; ?></td>
                                            <td><?php echo !empty($user['nombre']) ? htmlspecialchars($user['nombre'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
                                            <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo getRoleName($user['id_rol']); ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm edit-btn" 
                                                    data-id="<?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                    data-name="<?php echo htmlspecialchars($user['nombre'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                    data-email="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                    data-role="<?php echo htmlspecialchars($user['id_rol'], ENT_QUOTES, 'UTF-8'); ?>">Editar</button>
                                                <button class="btn btn-danger btn-sm delete-btn" 
                                                    data-id="<?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?>">Eliminar</button>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="mecanicas/edit_user.php" method="POST">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="form-group">
                            <label for="edit-name">Nombre</label>
                            <input type="text" class="form-control" id="edit-name" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="edit-role">Rol</label>
                            <select class="form-control" id="edit-role" name="id_rol">
                                <option value="2">Coordinador</option>
                                <option value="3">Beneficiario</option>
                                <option value="4">Voluntario</option>
                                <option value="5">Donador</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este usuario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Script para pasar los datos al modal de edición
        $('.edit-btn').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var role = $(this).data('role');

            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-email').val(email);
            $('#edit-role').val(role);

            $('#editModal').modal('show'); // Muestra el modal
        });

        // Script para pasar el ID al modal de confirmación de eliminación
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            $('#confirmDeleteBtn').attr('href', 'mecanicas/delete_user.php?id=' + id);
            $('#deleteModal').modal('show'); // Muestra el modal
        });

        // Simulación del número de solicitudes (esto puede venir de una consulta a la base de datos)
        const solicitudesPendientesVoluntarios = 3; // Ejemplo: número de solicitudes

        // Actualiza el contador de solicitudes en el botón
        document.getElementById('contadorSolicitudesVoluntarios').textContent = solicitudesPendientesVoluntarios;

        // Script para filtrar usuarios en la tabla de Voluntarios
        document.getElementById('searchInputVoluntarios').addEventListener('keyup', function() {
            var input = this.value.toLowerCase();
            var rows = document.querySelectorAll('#userTableVoluntarios tr');
            rows.forEach(function(row) {
                var name = row.cells[1].textContent.toLowerCase();
                var email = row.cells[2].textContent.toLowerCase();
                row.style.display = (name.includes(input) || email.includes(input)) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
