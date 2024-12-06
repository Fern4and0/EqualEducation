<?php
//session_start(); // Inicia la sesión


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
    <title>Transparencia financiera</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
	<link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles_index.css">
    <link rel="stylesheet" href="../css/styles_donacionesDB.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
</head>
<body>
    <div class="page">
    <?php include('./layout/header_donador.php');?>
        <section class="parallax-container" data-parallax-img="../../Public/image/Donations.jpg">
            <div class="parallax-content breadcrumbs-custom context-dark">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12 col-lg-9">
                    <h2 class="breadcrumbs-custom-title">Transparencia Financiera</h2>
                    <ul class="breadcrumbs-custom-path">
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <main class="content">
            <div class="container-fluid p-0">
                <h1 class="h3 mb-3"><strong>Registro de donaciones y gastos</strong></h1>

                <div class="row">
                    <!-- Mitad izquierda -->
                    <div class="col-md-6">
                        <!-- Tarjetas -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card" style="box-shadow: 10px 20px 35px #5557;">
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

                                <div class="card" style="box-shadow: 10px 20px 35px #5557;">
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
                                <div class="card" style="box-shadow: 10px 20px 35px #5557;">
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

                                <div class="card" style="box-shadow: 10px 20px 35px #5557;">
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
                        <div class="card flex-fill w-100 mt-3" style="box-shadow: 10px 20px 35px #5557;">
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
                                    <?php
                                    if ($consultaTabla->num_rows > 0) {
                                        while ($row = $consultaTabla->fetch_assoc()) {
                                            echo '
                                            <tr>
                                                <td>' . $row["nombre_usuario"] . '</td>
                                                <td><span class="badge bg-success">$' . $row["monto_donacion"] . '</span></td>
                                                <td class="d-none d-md-table-cell">' . $row["fecha_donacion"] . '</td>
                                            </tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mitad derecha -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="box-shadow: 10px 20px 35px #5557;">
                                    <div class="card-body">
                                        <h5 class="card-title">Ingresos en los ultimos meses</h5>
                                        <canvas id="lineChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="card" style="box-shadow: 10px 20px 35px #5557;">
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

        <footer class="section footer-minimal context-dark">
            <div class="container wow-outer">
              <div class="wow fadeIn">
                <div class="row row-50 row-lg-60">
                  <div class="col-12"><a href="../views/index.php"><img src="../Images/logo.png" alt="" width="207" height="51"/></a></div>
                  <div class="col-12">
                    <ul class="footer-minimal-nav">
                      <li><a href="../views/nosotros.php">Equipo</a></li>
                      <li><a href="../views/política_privacidad.html">Política de privacidad</a></li>
                      <li><a href="../views/contacto.html">Contacto</a></li>
                    </ul>
                  </div>
                </div>
                <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><span>Equal Education</span><span>.&nbsp;</span><span>All Rights Reserved.</span><span>&nbsp;</span>Design&nbsp;by Equal Education</p>
              </div>
            </div>
          </footer>
</div>
    <div class="snackbars" id="form-output-global"></div>


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
    <script src="../js/core.min.js"></script>
    <script src="../js/scriptt.js"></script>
</body>
</html>