<?php
// Controllers/Beneficiario-Dashboard.php

session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.php"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Incluye la conexión a la base de datos
// Cerrar la conexión a la base de datos
$conn->close(); // Cierra la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiarios Dashboard</title>
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
        .seccion {
            display: none;
        }
        .seccion.activa {
            display: block;
        }
    </style>
</head>
<body>
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Beneficiarios Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="mostrarSeccion('inicio')">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="mostrarSeccion('programas')">Programas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="mostrarSeccion('actividades')">Actividades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="mostrarSeccion('perfil')">Perfil</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenido Dinámico -->
    <div class="container mt-4">
        <!-- Inicio -->
        <div id="inicio" class="seccion activa">
            <h1>Bienvenido al Dashboard de Beneficiarios</h1>
            <p>Información general sobre los programas y actividades disponibles.</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Programas</h5>
                            <p>Accede a los programas disponibles.</p>
                            <a href="#" class="btn btn-primary" onclick="mostrarSeccion('programas')">Ver Programas</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Actividades</h5>
                            <p>Explora las actividades que puedes realizar.</p>
                            <a href="#" class="btn btn-primary" onclick="mostrarSeccion('actividades')">Ver Actividades</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programas -->
   <!-- Main Content -->
   <div class="container mt-5">
        <h1 class="text-center">Programas Disponibles</h1>
        <div class="row">
        </div>
      


    <!-- Scripts -->
    <script>
        function mostrarSeccion(id) {
            // Ocultar todas las secciones
            const secciones = document.querySelectorAll('.seccion');
            secciones.forEach(seccion => seccion.classList.remove('activa'));

            // Mostrar la sección seleccionada
            const seccionActiva = document.getElementById(id);
            if (seccionActiva) {
                seccionActiva.classList.add('activa');
            }
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
