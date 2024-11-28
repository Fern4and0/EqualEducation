<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Donaciones</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,300i,400,500,600,700,800,900,900i%7CRoboto:400%7CRubik:100,400,700">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/styles_index.css">
    <link rel="stylesheet" href="../css/styles_donaciones.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
  </head>
  <body>
    <div class="page">
    <?php include('header.php');?>
      <section class="parallax-container" data-parallax-img="../../Public/image/imgDonation.jpg">
        <div class="parallax-content breadcrumbs-custom context-dark">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-12 col-lg-9">
                <h2 class="breadcrumbs-custom-title">Cambia vidas para siempre</h2>
                <ul class="breadcrumbs-custom-path">
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
        <!-- Contenedor donaciones -->
            <div class="contenedor">
              <h3>¿Por qué contribuir?</h3>
             
              <div>
              <p>Tu donación no solo apoya a estudiantes con recursos escolares, becas o acceso a la tecnología, 
                sino que construye un futuro más justo, lleno de oportunidades, ademas de ayudarnos a sostener nuestro trabajo. 
                Al donar, te conviertes en parte de un movimiento que cambia vidas a través de la educación.</p>
                </div>
                <ul>
                    <li><strong>-100% Seguro</strong></li>
                    <li><strong>-Eficaz. </strong>Nuestros informes de impacto avalan la eficacia de nuestro trabajo.</li>
                    <li><strong>-Efectivo. </strong>90% de las donaciones estan dirigidas a aquellos que mas lo necesitan.</li>
                </ul>
                <div>
                <p>No importa el monto, cada contribución cuenta y puede cambiar el destino de una comunidad. 
                Ayúdanos a darles a más niños la oportunidad de aprender, crecer y prosperar.</p>
                </div>
            <style>
                #donate-button {
                  margin-top: 10px;
                }
                #donate-button img {
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }
                #donate-button img:hover {
                    transform: scale(1.1); /* Aumenta el tamaño ligeramente */
                }
            </style>
            <div id="donate-button-container" class="text-center mt-auto">
                <div id="donate-button"></div>
                <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
                <script>
                PayPal.Donation.Button({
                env:'sandbox',
                hosted_button_id:'FHAFN9D6MVUBC',
                image: {
                src:'https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif',
                alt:'Donate with PayPal button',
                title:'Donar a Equal Education!',
                },
                onComplete: function(detalles){
                    console.log(detalles);
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "../../Controllers/detallesDonacion.php", true);
                    xhr.setRequestHeader("Content-Type", "application/json");

                    // Enviar los datos en formato JSON
                    xhr.send(JSON.stringify(detalles));

                    // Manejar la respuesta
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log(xhr.responseText);  // Respuesta del servidor
                        }
                    };
                }
                }).render('#donate-button');
                //convertir los detalles de la donacion a json
                </script>
            </div>
          </div>
      <!-- Footer -->
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
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/core.min.js"></script>
    <script src="../js/scriptt.js"></script>
  </body>
</html>