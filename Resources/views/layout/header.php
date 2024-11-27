<?php
session_start(); // Iniciamos la sesión
?>

<!-- header-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-uppercase" href="#">Equal Edu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/EqualEducation/inicio.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Programas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre nosotros</a>
                </li>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <!-- Mostrar "Inicia Sesión" si no hay sesión activa -->
                    <li class="nav-item">
                        <a class="nav-link" href="/EqualEducation/Resources/views/login.html">Inicia Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Resources/views/Modals.php">Únete</a>
                    </li>
                <?php else: ?>
                    <!-- Mostrar "Cerrar Sesión" si el usuario está logueado -->
                    <li class="nav-item">
                        <a class="nav-link" href="/EqualEducation/Controllers/Login/Logout.php">Cerrar Sesión</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="btn btn-primary" href="Resources/views/donaciones.php">Donar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
