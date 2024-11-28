<?php
include '../../DB/DB.php';

$sql = "SELECT id, nombre, descripcion ,fecha_ini, fecha_fin, foto FROM programas ORDER BY fecha_ini ASC";
$consulta = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Programas</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,300i,400,500,600,700,800,900,900i%7CRoboto:400%7CRubik:100,400,700">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/styles_index.css">
    <link rel="stylesheet" href="../css/styles_programs.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
    <style>
      
    </style>
</head>
<body>
    <div class="page">   
    <?php include('header.php');?>
      <section class="parallax-container" data-parallax-img="../../Public/image/img4.jpg">
        <div class="parallax-content breadcrumbs-custom context-dark">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-12 col-lg-9">
                <h2 class="breadcrumbs-custom-title">Programas educativos</h2>
              </div>
            </div>
          </div>
        </div>
      </section>

    <div class="container">
        <!-- Program header -->
        <h2 class="program-header text-center">Programas disponibles</h2>
        <p class="subheader text-center">Participa en nuestros programas educativos gratuitos y abre la puerta a nuevas oportunidades.
            Aprende nuevas habilidades, mejora tu futuro y conéctate con una comunidad de personas que, como tú, buscan superarse.
            ¡Es el momento de invertir en ti mismo, sin costo alguno!</p>
        
<?php
if ($consulta->num_rows > 0) {
    // Mostrar los productos en divs
    while ($row = $consulta->fetch_assoc()) {
        $id = $row['id'];
        echo "<div class='featured-program'>
            <div>
                <img src='../../Public/image/" . $row["id"] . ".png' alt='Featured image' class='featured-image'>
            </div>
            <div class='contenido'>
                <h6 class='program-date'><strong>" . $row["fecha_ini"] . ' // ' . $row["fecha_fin"] . "</strong></h6>
                <h4>" . $row["nombre"] . "</h4>
                <p id='featured-text-$id' class='featured-text'>
                    " . $row["descripcion"] . "
                </p>
                <div class='prgm-footer'>
                    <button 
                        class='show-more' 
                        id='show-more-btn-$id' 
                        onclick='showModal($id)' 
                        data-nombre='" . $row["nombre"] . "' 
                        data-descripcion='" . $row["descripcion"] . "' 
                        data-fecha-inicio='" . $row["fecha_ini"] . "' 
                        data-fecha-fin='" . $row["fecha_fin"] . "' 
                    >Ver más...</button>
                </div>
            </div>
        </div>";
    }
} else {
    echo "<p>No hay programas disponibles</p>";
}
?>
    </div>
    <!-- modal -->
    <div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <button id="join-button" class="join-button">Unirse</button>
        <h4 id="modal-nombre" class="modal-header"></h4>
        <div class="modal-body">
            <div class="modal-section">
                <strong>Descripción:</strong>
                <p id="modal-descripcion"></p>
            </div>
            <div class="modal-section">
                <strong>Fecha de inicio:</strong>
                <p id="modal-fecha-inicio"></p>
            </div>
            <div class="modal-section">
                <strong>Fecha de vencimiento:</strong>
                <p id="modal-fecha-fin"></p>
            </div>
            <div class="modal-section">
                <strong>Ubicación:</strong>
                <p id="modal-ubicacion">No especificada</p>
            </div>
            <div class="modal-section">
                <strong>Tipo de programa:</strong>
                <p id="modal-tipo">No especificado</p>
            </div>
            <div class="modal-section">
                <strong>Cupo máximo:</strong>
                <div class="progress-container">
                    <div id="modal-cupo-bar" class="progress-bar"></div>
                </div>
                <p id="modal-cupo-text"></p>
            </div>
        </div>
    </div>
</div>

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
    <script src="../js/core.min.js"></script>
    <script src="../js/scriptt.js"></script>
    <script>
// Mostrar el modal y actualizar los datos
// Mostrar el modal y desactivar el scroll del fondo
function showModal(id) {
    const modal = document.getElementById('modal');
    modal.style.display = 'block';

    // Desactivar el scroll del fondo
    document.body.classList.add('no-scroll');

    // Actualizar el contenido del modal (como antes)
    const nombre = "Programa de Capacitación";
    const descripcion = "Este es un programa educativo de formación profesional en distintas áreas.";
    const fechaInicio = "01 Enero 2024";
    const fechaFin = "30 Junio 2024";
    const ubicacion = "Ciudad A, Dirección B";
    const tipo = "Educativo";
    const cupoMaximo = 200;
    const cuposOcupados = 120;

    document.getElementById('modal-nombre').textContent = nombre;
    document.getElementById('modal-descripcion').textContent = descripcion;
    document.getElementById('modal-fecha-inicio').textContent = fechaInicio;
    document.getElementById('modal-fecha-fin').textContent = fechaFin;
    document.getElementById('modal-ubicacion').textContent = ubicacion;
    document.getElementById('modal-tipo').textContent = tipo;

    const progressBar = document.getElementById('modal-cupo-bar');
    const progressText = document.getElementById('modal-cupo-text');
    const porcentaje = Math.min((cuposOcupados / cupoMaximo) * 100, 100);

    progressBar.style.width = `${porcentaje}%`;
    progressText.textContent = `${cuposOcupados} de ${cupoMaximo} cupos ocupados`;
}

// Cerrar el modal y reactivar el scroll del fondo
function closeModal() {
    const modal = document.getElementById('modal');
    modal.style.display = 'none';

    // Reactivar el scroll del fondo
    document.body.classList.remove('no-scroll');
}

// Detectar clic fuera del modal para cerrarlo
window.onclick = function (event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
        closeModal();
    }
};
</script>

    <script>
    function toggleText(id) {
        const featuredText = document.getElementById('featured-text-' + id);
        const showMoreBtn = document.getElementById('show-more-btn-' + id);
        const unirse = document.getElementById('unirse-' + id);
        
        let isExpanded = featuredText.classList.contains('expanded');

        if (isExpanded) {
            featuredText.classList.remove('expanded');
            unirse.style.display = "none";
            showMoreBtn.textContent = "Mostrar más +";
        } else {
            featuredText.classList.add('expanded');
            unirse.style.display = "inline";
            showMoreBtn.textContent = "Mostrar menos -";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const featuredPrograms = document.querySelectorAll('.featured-program');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target); // Deja de observar el elemento una vez ha aparecido
                }
            });
        }, {
            threshold: 0.1 // El 10% del elemento debe ser visible para activarse
        });

        featuredPrograms.forEach(program => {
            observer.observe(program);
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
