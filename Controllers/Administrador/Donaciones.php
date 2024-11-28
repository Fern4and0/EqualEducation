<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.html"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Incluye la conexión a la base de datos

// Consulta para obtener las donaciones totales
$sqlIngresos = "SELECT COALESCE(SUM(monto), 0) AS total_ingresos FROM donaciones";
$resultIngresos = $conn->query($sqlIngresos); // Ejecuta la consulta
$totalIngresos = $resultIngresos->fetch_assoc()['total_ingresos']; // Obtiene el resultado de la consulta
$sqlIngresosSemana = "SELECT COALESCE(SUM(monto), 0) AS total_ingresossem FROM donaciones WHERE created_at >= '2024-11-20' and created_at <= '2024-11-27'";
$resultIngresosSemana = $conn->query($sqlIngresosSemana); // Ejecuta la consulta
$totalIngresosSemana = $resultIngresosSemana->fetch_assoc()['total_ingresossem']; // Obtiene el resultado de la consulta


$sqlDonantes = "SELECT COUNT(DISTINCT donante_id) as nuevos_donantes FROM donaciones";
$resultDonantes = $conn->query($sqlDonantes); // Ejecuta la consulta
$nuevosDonantes = $resultDonantes->fetch_assoc()['nuevos_donantes'];
$sqlDonantesSemana = "SELECT COUNT(DISTINCT donante_id) as nuevos_donantessem FROM donaciones WHERE created_at >= '2024-11-20' and created_at <= '2024-11-27'";
$resultDonantesSemana = $conn->query($sqlDonantesSemana); // Ejecuta la consulta
$nuevosDonantesSemana = $resultDonantesSemana->fetch_assoc()['nuevos_donantessem'];

$sqlDonaciones = "SELECT COUNT(monto) as nuevas_donaciones FROM donaciones";
$resultDonaciones = $conn->query($sqlDonaciones); // Ejecuta la consulta
$nuevasDonaciones = $resultDonaciones->fetch_assoc()['nuevas_donaciones'];
$sqlDonacionesSemana = "SELECT COUNT(monto) as nuevas_donacionessem FROM donaciones WHERE created_at >= '2024-11-20' and created_at <= '2024-11-27'";
$resultDonacionesSemana = $conn->query($sqlDonacionesSemana); // Ejecuta la consulta
$nuevasDonacionesSemana = $resultDonacionesSemana->fetch_assoc()['nuevas_donacionessem'];


$sqlTabla = "SELECT nombre_usuario, monto_donacion, fecha_donacion FROM vista_donaciones_usuarios";
$consultaTabla = $conn->query($sqlTabla);



// Cerrar la conexión a la base de datos
$conn->close(); // Cierra la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
	<link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../../Resources/css/styles_donacionesDB.css">
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
    
    <main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Registro de donaciones y gastos</strong></h1>

        <div class="row">
            <!-- Mitad izquierda -->
            <div class="col-md-6">
                <!-- Tarjetas -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Gastos</h5>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">$0.00</h1>
                                <div class="mb-0">
                                    <span class="text-success">0%</span>
                                    <span class="text-muted">Durante la última semana</span>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Donadores</h5>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3"><?php echo $nuevosDonantes; ?></h1>
                                <div class="mb-0">
                                    <span class="text-success">+<?php echo $nuevosDonantesSemana; ?></span>
                                    <span class="text-muted">Durante la última semana</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Donaciones</h5>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">$<?php echo $totalIngresos; ?></h1>
                                <div class="mb-0">
                                    <span class="text-success">+$<?php echo $totalIngresosSemana; ?></span>
                                    <span class="text-muted">Durante la última semana</span>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Num. Donaciones</h5>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3"><?php echo $nuevasDonaciones; ?></h1>
                                <div class="mb-0">
                                    <span class="text-success">+<?php echo $nuevasDonacionesSemana; ?></span>
                                    <span class="text-muted">Durante la última semana</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="card flex-fill w-100 mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Donaciones</h5>
                    </div>
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th class="d-none d-xl-table-cell">Monto</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                if ($consultaTabla->num_rows > 0) {
                                    while ($row = $consultaTabla->fetch_assoc()) {
                                        echo '
                                        <td>' . $row["nombre_usuario"] . '</td>
                                        <td><span class="badge bg-success">$' . $row["monto_donacion"] . '</span></td>
                                        <td class="d-none d-md-table-cell">' . $row["fecha_donacion"] . '</td>';
                                    }
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mitad derecha -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ingresos en los ultimos meses</h5>
                                <canvas id="lineChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Nuevos donantes en los ultimos meses</h5>
                                <canvas id="barChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


    <script>
        // Obtener el contexto del lienzo donde se dibujará la gráfica
        const ctx = document.getElementById('lineChart').getContext('2d');
        // Crear la gráfica
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre'], // Etiquetas
                datasets: [{
                    label: 'Ingresos',
                    data: [500,300,800,100,0,<?php echo $totalIngresos;?>], // Datos aleatorios
                    backgroundColor: 'rgba(50, 245, 40, 0.1)',
                    borderColor: 'rgba(50, 245, 40, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(50, 245, 40, 1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Obtener el contexto del lienzo donde se dibujará la gráfica
        const ctx2 = document.getElementById('barChart').getContext('2d');
        // Crear la gráfica
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre'], // Etiquetas
                datasets: [{
                    label: 'Nuevos donantes',
                    data: [100,50,60,80,20,<?php echo $nuevosDonantes;?>], // Datos aleatorios
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>