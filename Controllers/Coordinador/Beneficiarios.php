<?php
// Controllers/Coordinador/Beneficiarios.php

session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.html"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Incluye la conexión a la base de datos

// Verifica si la conexión a la base de datos se ha establecido correctamente
if ($conn->connect_error) {
    die("Connection failed: {$conn->connect_error}");
}

// Consulta para obtener la cantidad de beneficiarios registrados
$sqlBeneficiarios = "SELECT COUNT(*) AS total_beneficiarios FROM beneficiarios";
$resultBeneficiarios = $conn->query($sqlBeneficiarios); // Ejecuta la consulta
$totalBeneficiarios = $resultBeneficiarios->fetch_assoc()['total_beneficiarios']; // Obtiene el resultado de la consulta

// Consulta para obtener la lista de beneficiarios
$sqlListaBeneficiarios = "SELECT id, first_name AS nombre, last_name AS apellido, email FROM beneficiarios";
$resultListaBeneficiarios = $conn->query($sqlListaBeneficiarios); // Ejecuta la consulta

// Cerrar la conexión a la base de datos
$conn->close(); // Cierra la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
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
        <a class="navbar-brand" href="#">Coordinador Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="Cordi-Dashboard.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="usuarios.php">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Informes.php">Informes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Beneficiarios.php">Beneficiarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Donaciones.php">Donaciones</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../../Login/Logout.php">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Beneficiarios Registrados</h5>
                        <p class="card-text">Total de beneficiarios registrados: <span class="number"><?= $totalBeneficiarios; ?></span></p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $resultListaBeneficiarios->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['nombre']; ?></td>
                                        <td><?= $row['apellido']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
