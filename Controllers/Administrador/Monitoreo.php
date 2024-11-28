<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.html"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Incluye la conexión a la base de datos

// Consulta para obtener el número de usuarios
$sqlUsers = "SELECT COUNT(*) AS total_usuarios FROM users"; // Changed 'usuarios' to 'users'
$resultUsers = $conn->query($sqlUsers);
$totalUsuarios = ($resultUsers->num_rows > 0) ? $resultUsers->fetch_assoc()['total_usuarios'] : 0;

// Consulta para obtener el total de donaciones
$sqlDonaciones = "SELECT SUM(monto) AS total_donaciones FROM donaciones";
$resultDonaciones = $conn->query($sqlDonaciones);
$totalDonaciones = ($resultDonaciones->num_rows > 0) ? $resultDonaciones->fetch_assoc()['total_donaciones'] : 0;

// Consulta para obtener el número de beneficiarios
$sqlBeneficiarios = "SELECT COUNT(*) AS total_beneficiarios FROM beneficiarios";
$resultBeneficiarios = $conn->query($sqlBeneficiarios);
$totalBeneficiarios = ($resultBeneficiarios->num_rows > 0) ? $resultBeneficiarios->fetch_assoc()['total_beneficiarios'] : 0;

// Consulta para obtener el número de informes generados
$sqlInformes = "SELECT COUNT(*) AS total_informes FROM informes";
$resultInformes = $conn->query($sqlInformes);
$totalInformes = ($resultInformes->num_rows > 0) ? $resultInformes->fetch_assoc()['total_informes'] : 0;

// Consulta para obtener el número de programas generados
$sqlProgramas = "SELECT COUNT(*) AS total_programas FROM programas";
$resultProgramas = $conn->query($sqlProgramas);
$totalProgramas = ($resultProgramas->num_rows > 0) ? $resultProgramas->fetch_assoc()['total_programas'] : 0;

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
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 10px 20px 35px #5557;
            border-radius: 10px;
        }
        .dashboard-stat {
            text-align: center;
        }
        .chart-container {
            position: relative;
            height: 25vh; /* Altura ajustada */
            width: 40vw;  /* Ancho ajustado */
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
        <h1 class="mb-4">Panel de Control</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card dashboard-stat">
                    <div class="card-body">
                        <h5 class="card-title">Total Usuarios</h5>
                        <div class="chart-container">
                            <canvas id="usuariosChart" style="width: 32vw; height: 25vh;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card dashboard-stat">
                    <div class="card-body">
                        <h5 class="card-title">Total Donaciones</h5>
                        <div class="chart-container">
                            <canvas id="donacionesChart" style="width: 32vw; height: 25vh;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card dashboard-stat">
                    <div class="card-body">
                        <h5 class="card-title">Total Beneficiarios</h5>
                        <div class="chart-container">
                            <canvas id="beneficiariosChart" style="width: 32vw; height: 25vh;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card dashboard-stat">
                    <div class="card-body">
                        <h5 class="card-title">Total Informes Generados</h5>
                        <div class="chart-container">
                            <canvas id="informesChart" style="width: 32vw; height: 25vh;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card dashboard-stat">
                    <div class="card-body">
                        <h5 class="card-title">Total Programas Generados</h5>
                        <div class="chart-container">
                            <canvas id="programasChart" style="width: 32vw; height: 25vh;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const usuariosChart = new Chart(document.getElementById('usuariosChart'), {
            type: 'bar',
            data: {
                labels: ['Usuarios'],
                datasets: [{
                    label: 'Total Usuarios',
                    data: [<?php echo $totalUsuarios; ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const donacionesChart = new Chart(document.getElementById('donacionesChart'), {
            type: 'bar',
            data: {
                labels: ['Donaciones'],
                datasets: [{
                    label: 'Total Donaciones',
                    data: [<?php echo $totalDonaciones; ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const beneficiariosChart = new Chart(document.getElementById('beneficiariosChart'), {
            type: 'bar',
            data: {
                labels: ['Beneficiarios'],
                datasets: [{
                    label: 'Total Beneficiarios',
                    data: [<?php echo $totalBeneficiarios; ?>],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const informesChart = new Chart(document.getElementById('informesChart'), {
            type: 'bar',
            data: {
                labels: ['Informes'],
                datasets: [{
                    label: 'Total Informes',
                    data: [<?php echo $totalInformes; ?>],
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const programasChart = new Chart(document.getElementById('programasChart'), {
            type: 'bar',
            data: {
                labels: ['Programas'],
                datasets: [{
                    label: 'Total Programas',
                    data: [<?php echo $totalProgramas; ?>],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
