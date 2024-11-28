<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.html"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Incluye la conexión a la base de datos
require_once __DIR__ . '/../../vendor/autoload.php'; // Incluye la librería de Dompdf

$error_message = '';

// Verifica si se envió el formulario para crear un nuevo informe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programa_id = $_POST['programa_id']; // ID del programa asociado
    $tipo = $_POST['tipo']; // Tipo de informe (Impacto o Educativo)
    $contenido = $_POST['contenido']; // Contenido del informe

    // Verifica si el programa_id existe en la tabla programas
    $sqlCheckPrograma = "SELECT id FROM programas WHERE id = '$programa_id'";
    $resultCheckPrograma = $conn->query($sqlCheckPrograma);

    if ($resultCheckPrograma->num_rows > 0) {
        // Inserta el informe en la base de datos
        $sqlInsertInforme = "INSERT INTO informes (programa_id, tipo, contenido, created_at, updated_at)
                             VALUES ('$programa_id', '$tipo', '$contenido', NOW(), NOW())";

        if ($conn->query($sqlInsertInforme) === TRUE) {
            echo "Informe creado exitosamente.";
        } else {
            echo "Error al crear el informe: {$conn->error}";
        }
    } else {
        $error_message = "Error: El programa no existe.";
    }
}

// Consulta para obtener los informes
$sqlInformes = "SELECT * FROM informes";
$resultInformes = $conn->query($sqlInformes);

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
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
            border-radius: 10px;
            box-shadow: 10px 20px 35px #5557;
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-body {
            background-color: #eae9e9;
        }
        .btn-primary {
            background-color: #fff;
            border: none;
            color: black;
        }
        .btn-primary:hover {
            background-color: #cdcdcd;
        }
        table {
            border-radius: 10px;
        }
        tbody {
            background-color: #f3f3f3;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#" style="padding: 10;">
            <img src="../../Resources/Images/logo.png" width="50" height="50" class="d-inline-block align-top" alt="Equal Education Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Administrador-Dashboard.php' ? 'active' : ''; ?>" href="Administrador-Dashboard.php"><i class="fas fa-home"></i> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Donaciones.php' ? 'active' : ''; ?>" href="Donaciones.php"><i class="fas fa-donate"></i> Registro de Donaciones y Gastos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Monitoreo.php' ? 'active' : ''; ?>" href="Monitoreo.php"><i class="fas fa-chart-line"></i> Monitoreo de Indicadores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Informes.php' ? 'active' : ''; ?>" href="Informes.php"><i class="fas fa-file-alt"></i> Generación de Informes</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUsuarios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users-cog"></i> Gestión de Usuarios
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUsuarios">
                        <a class="dropdown-item" href="Tabla/Administradores.php">Administradores</a>
                        <a class="dropdown-item" href="Tabla/Coordinador.php">Coordinadores</a>
                        <a class="dropdown-item" href="Tabla/Beneficiarios.php">Beneficiarios</a>
                        <a class="dropdown-item" href="Tabla/Voluntarios.php">Voluntarios</a>
                        <a class="dropdown-item" href="Tabla/Donadores.php">Donadores</a>

                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../Login/Logout.php">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container mt-5">
        <!-- Modal para crear un nuevo informe -->
        <div class="modal fade" id="crearInformeModal" tabindex="-1" role="dialog" aria-labelledby="crearInformeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearInformeModalLabel">Crear Nuevo Informe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="Informes.php" method="POST">
                            <div class="form-group">
                                <label for="programa_id">ID del Programa</label>
                                <input type="number" class="form-control" id="programa_id" name="programa_id" required>
                            </div>
                            <div class="form-group">
                                <label for="tipo">Tipo de Informe</label>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option value="Impacto">Impacto</option>
                                    <option value="Educativo">Educativo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="contenido">Contenido del Informe</label>
                                <textarea class="form-control" id="contenido" name="contenido" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Informe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de error -->
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo $error_message; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla para visualizar los informes -->
        <div class="card">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Informes Registrados</h5>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#crearInformeModal" title="Nuevo Informe">
                    <i class="fas fa-file-medical"></i>
                </button>
            </div>
            <table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Programa</th>
                    <th>Tipo</th>
                    <th>Fecha de Creación</th>
                    <th>Ver Informe</th>
                    <th>Exportar PDF</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($resultInformes->num_rows > 0): ?>
                    <?php while($row = $resultInformes->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['programa_id']; ?></td>
                        <td><?php echo $row['tipo']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><a href="ver_informe.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Ver</a></td>
                        <td><a href="exportar_pdf.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Exportar PDF</a></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                    <td colspan="6">No hay informes registrados.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
        </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        <?php if (!empty($error_message)): ?>
            $(document).ready(function() {
                $('#errorModal').modal('show');
            });
        <?php endif; ?>
    </script>
</body>
</html>
