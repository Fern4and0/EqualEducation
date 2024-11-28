    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Estilo para la barra de navegación */
        .navbar-custom {
            background-color: #2b2b2b; /* Gris oscuro */
            border-bottom: 1px solid #444; /* Línea sutil */
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #f1f1f1; /* Texto gris claro */
        }
        .navbar-custom .nav-link:hover {
            color: #dcdcdc; /* Color más claro al pasar el cursor */
        }
        .dropdown-menu {
            background-color: #333; /* Gris más oscuro */
            border: none;
        }
        .dropdown-item {
            color: #f1f1f1;
        }
        .dropdown-item:hover {
            background-color: #444; /* Fondo gris medio */
        }

        /* Ajustes generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #1f1f1f; /* Gris oscuro para fondo */
            color: #fff;
            margin: 0;
            padding: 0;
        }
        
        /* Ajustes visuales */
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .nav-link {
            font-size: 1rem;
            padding: 0.5rem 1rem;
        }
        .dropdown-toggle::after {
            margin-left: 0.5rem;
            color: #fff;
        }
        .navbar-toggler {
            border: 1px solid #444;
        }
        .navbar-toggler-icon {
            background-image: none;
        }
        .navbar-toggler-icon::before {
            content: "\f0c9"; /* Icono de menú (FontAwesome) */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: #fff;
        }

        /* Sección central */
        .container {
            margin-top: 50px;
        }
        .container h1 {
            font-size: 2rem;
            font-weight: bold;
        }
        .container p {
            font-size: 1.2rem;
            color: #dcdcdc;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="#">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="inicio.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="programas.php">Programas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="actividades.php">Actividades</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="perfil.php">Perfil</a>
            </li>
            <!-- Menú desplegable corregido -->
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


<!-- Scripts necesarios -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
