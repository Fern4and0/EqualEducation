
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis donaciones</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
	<link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/styles_index.css">
    <link rel="stylesheet" href="../css/styles_donacionesDB.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
</head>
<body>
    <?php include('./layout/header_donador.php'); ?>
    <?php include '../../DB/DB.php';

    $user_id = $_SESSION['user_id'];
    
    $sql = "SELECT COALESCE(SUM(monto), 0) AS total_donaciones FROM donaciones WHERE donante_id = $user_id";
    $sqlResult = $conn->query($sql);
    $totalDonaciones = $sqlResult->fetch_assoc()['total_donaciones'];
    
    $sql2 = "SELECT COUNT(id) AS num_donaciones FROM donaciones WHERE donante_id = $user_id";
    $sqlResult2 = $conn->query($sql2);
    $numDonaciones = $sqlResult2->fetch_assoc()['num_donaciones'];
    
    $sql3 = "SELECT monto, created_at FROM donaciones WHERE donante_id = $user_id";
    $tabla = $conn->query($sql3);
    $conn->close();
    ?>
        <div class="page">
        <section class="parallax-container" data-parallax-img="../../Public/image/Donations.jpg">
            <div class="parallax-content breadcrumbs-custom context-dark">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12 col-lg-9">
                    <h2 class="breadcrumbs-custom-title">Donaciones</h2>
                    <ul class="breadcrumbs-custom-path">
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <main class="content">
          <div class="container-fluid p-0">
            <h1 class="h3 mb-3"><strong>Mis donaciones</strong></h1>

            <div class="row">
                <!-- Parte izquierda -->
                <div class="col-lg-6">
                    <!-- Tarjetas -->
                    <div class="row mb-3">
                        <!-- Total de Donaciones -->
                        <div class="col-6">
                            <div class="card" style="box-shadow: 10px 20px 35px #5557;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total de donaciones</h5>
                                        </div>
                                    </div>
                                    <span style="font-size: 25px;" class="mt-1 mb-3">$<?php echo $totalDonaciones; ?></span>
                                </div>
                            </div>
                        </div>
                        <!-- Num. Donaciones -->
                        <div class="col-6">
                            <div class="card" style="box-shadow: 10px 20px 35px #5557;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Num. Donaciones</h5>
                                        </div>
                                    </div>
                                    <span style="font-size: 25px;" class="mt-1 mb-3"><?php echo $numDonaciones; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tabla Mis Donaciones -->
                    <div class="card w-100" style="box-shadow: 10px 20px 35px #5557;">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Mis donaciones</h5>
                        </div>
                        <table class="table table-hover my-0">
                            <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell">Monto</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($tabla->num_rows > 0) {
                                    while ($row = $tabla->fetch_assoc()) {
                                        echo '
                                        <tr>
                                            <td><span class="badge bg-success">$' . $row["monto"] . '</span></td>
                                            <td class="d-none d-md-table-cell">' . $row["created_at"] . '</td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="2">No hay datos disponibles.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Parte derecha -->
                <div class="col-lg-6">
                    <!-- Gráfica Num. Donaciones -->
                    <div class="card mb-3" style="box-shadow: 10px 20px 35px #5557;">
                        <div class="card-body">
                            <canvas id="NumDonaciones"></canvas>
                        </div>
                    </div>
                    <!-- Gráfica Donaciones -->
                    <div class="card" style="box-shadow: 10px 20px 35px #5557;">
                        <div class="card-body">
                            <canvas id="Donaciones"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Barra donaciones
    const donationAmountCtx = document.getElementById('Donaciones').getContext('2d');
    new Chart(donationAmountCtx, {
        type: 'bar',
        data: {
            labels: ['Donaciones'],
            datasets: [{
                label: 'Monto ($)',
                data: [<?php echo $totalDonaciones; ?>],
                backgroundColor: ['rgba(153, 102, 255, 0.2)',],
                borderColor: ['rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                title: {
                    display: true,
                    text: 'Monto de Donaciones'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Barra Num. Donaciones
    const donationCountCtx = document.getElementById('NumDonaciones').getContext('2d');
    new Chart(donationCountCtx, {
        type: 'bar',
        data: {
            labels: ['Num. Donaciones'],
            datasets: [{
                label: 'Número de Donaciones',
                data: [<?php echo $numDonaciones; ?>],
                backgroundColor: ['rgba(255, 159, 64, 0.2)'],
                borderColor: ['rgba(255, 159, 64, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                title: {
                    display: true,
                    text: 'Número de Donaciones'
                }
            }
        }
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../js/core.min.js"></script>
    <script src="../js/scriptt.js"></script>
</body>
</html>