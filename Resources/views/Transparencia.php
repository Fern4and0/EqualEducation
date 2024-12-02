<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparencia financiera</title>
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
        
                <h1 class="h3 mb-3"><strong>Transparencia financiera</strong></h1>
        
                <div class="row">
                    <div class="col-xl-6 col-xxl-5 d-flex">
                        <div class="w-100">
                            <div class="row">
                                <!-- Donaciones -->
                                <div class="col-sm-6">
                                    <div class="card" style="box-shadow: 10px 20px 35px #5557; border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col mt-0">
                                                    <h5 class="card-title">Total de donaciones</h5>
                                                </div>
                                            </div>
                                            <h3 class="mt-1 mb-3" style="color: #5ED13C;">$110.00</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card" style="box-shadow: 10px 20px 35px #5557; border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col mt-0">
                                                    <h5 class="card-title">Num. Donaciones</h5>
                                                </div>
                                            </div>
                                            <h3 class="mt-1 mb-3" style="color: #5ED13C;">2</h3>
                                        </div>
                                    </div>
                                </div>
                                <!-- Num.Donaciones -->
                                <div class="col-sm-6">
                                    <div class="card" style="box-shadow: 10px 20px 35px #5557; border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col mt-0">
                                                    <h5 class="card-title">Total de gastos</h5>
                                                </div>
                                            </div>
                                            <h3 class="mt-1 mb-3" style="color: #FF6060">$-100</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card" style="box-shadow: 10px 20px 35px #5557; border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col mt-0">
                                                    <h5 class="card-title">Num. Gastos</h5>
                                                </div>
                                            </div>
                                            <h3 class="mt-1 mb-3" style="color: #ff6060;">2</h3>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Grafica Donaciones -->
                    <div class="col-sm-6" style="display: block;">
                        <div class="card" style="box-shadow: 10px 20px 35px #5557; border-radius: 10px; width: 100%; height: 300px; align-items:center">
                            <div class="card-body">
                                <canvas id="Donaciones"></canvas>
                            </div>
                        </div>
                    </div>
        
                </div>
        
                
                <div class="row">
                    <!-- Tabla mis donaciones -->
                    <div class="col-xl-6 col-xxl-7">
                        <div class="card w-100" style="box-shadow: 10px 20px 35px #5557; border-radius: 10px; top: -40px;">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Donaciones</h5>
                            </div>
                            <table class="table table-hover my-0">
                                <thead>
                                    <tr>
                                        <th class="d-none d-xl-table-cell">Monto</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-success">$20.00</span></td>
                                        <td class="d-none d-md-table-cell">25/11/2024</td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-success">$10.00</span></td>
                                        <td class="d-none d-md-table-cell">25/11/2024</td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-success">$100.00</span></td>
                                        <td class="d-none d-md-table-cell">24/11/2024</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-xl-6 col-xxl-7">
                        <div class="card w-100" style="box-shadow: 10px 20px 35px #5557; border-radius: 10px; top: -40px;">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Gastos</h5>
                            </div>
                            <table class="table table-hover my-0">
                                <thead>
                                    <tr>
                                        <th class="d-none d-xl-table-cell">Monto</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-danger">$20.00</span></td>
                                        <td class="d-none d-md-table-cell">25/11/2024</td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-danger">$10.00</span></td>
                                        <td class="d-none d-md-table-cell">25/11/2024</td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-danger">$100.00</span></td>
                                        <td class="d-none d-md-table-cell">24/11/2024</td>
                                    </tr>
                                </tbody>
                            </table>
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
                      <li><a href="../views/nosotros.html">Equipo</a></li>
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
    type: 'pie', // Cambiado a 'pie' para gráfica de pastel
    data: {
        labels: ['Donaciones ($+)', 'Gastos ($-)'], // Etiquetas para las secciones de la gráfica
        datasets: [
    {
        data: [110, 50], // Valores para las secciones de "Donaciones" y "Gastos"
        backgroundColor: [
            'rgba(0, 197, 18, 0.8)', // Color de "Donaciones" (verde fuerte)
            'rgba(197, 0, 0, 0.8)' // Color de "Gastos" (rojo fuerte)
        ],
        borderColor: [
            'rgba(4, 125, 0, 0.8)', // Borde de "Donaciones" (verde)
            'rgba(152, 0, 0, 0.8)' // Borde de "Gastos" (rojo)
        ],
        borderWidth: 1
    }
]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true // Muestra la leyenda
            },
            title: {
                display: true,
                text: 'Monto de Donaciones y Gastos'
            }
        }
    }
});

</script>
    <script src="../js/core.min.js"></script>
    <script src="../js/scriptt.js"></script>
</body>
</html>