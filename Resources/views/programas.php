
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
</head>
<body>
<div class="page">
        <?php   include('header.php'); 
        include '../../DB/DB.php';

        $user_id = $_SESSION['user_id'];
        $user_rol = $_SESSION['user_rol'];
        $fecha_actual = date('Y-m-d');


        $sql = "SELECT id, nombre, descripcion ,fecha_ini, fecha_fin, foto, ubicacion, cupo_maximo, tipo FROM programas ORDER BY fecha_ini ASC";
        $consulta = $conn->query($sql);
        ?>

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
    </div>
        
<?php
if ($consulta->num_rows > 0) {
    // Mostrar los productos en divs
    while ($row = $consulta->fetch_assoc()) {
        $id = $row['id'];
        $checkInscripcionSQL = "SELECT * FROM users_programa WHERE programa_id = $id AND beneficiario_id = $user_id";
        $inscripcionResult = $conn->query($checkInscripcionSQL);

        $isInscrito = $inscripcionResult->num_rows > 0;
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
                    >Ver más...</button>
                </div>
            </div>
        </div>
        
        <div id='modal-$id' class='modal'>
            <div class='modal-content'>
                <span class='close' onclick='closeModal($id)'>&times;</span>";
                if ($isInscrito || $user_rol != 3){
                echo "<p class='already-joined'></p>
                ";
                } else {
                    echo "
                    <form action='../../Controllers/unirse.php' method='POST'>
                <input type='hidden' name='programa_id' value=".$id.">
                <input type='hidden' name='user_id' value=".$user_id.">
                <button id='join-button-$id' class='join-button' type='submit'>Unirse</button>
                </form>";
                }
                echo "
                <h4 id='modal-nombre-$id' class='modal-header'>" . $row['nombre'] . "</h4>
                <div class='modal-body'>
                    <div class='modal-section'>
                        <strong>Descripción:</strong>
                        <p id='modal-descripcion-$id'>" . $row['descripcion'] . "</p>
                    </div>
                    <div class='modal-section'>
                        <strong>Fecha de inicio:</strong>
                        <p id='modal-fecha-inicio-$id'>" . $row['fecha_ini'] . "</p>
                    </div>
                    <div class='modal-section'>
                        <strong>Fecha de vencimiento:</strong>
                        <p id='modal-fecha-fin-$id'>" . $row['fecha_fin'] . "</p>
                    </div>
                    <div class='modal-section'>
                        <strong>Ubicación:</strong>
                        <p id='modal-ubicacion-$id'>" . $row['ubicacion'] . "</p>
                    </div>
                    <div class='modal-section'>
                        <strong>Tipo de programa:</strong>
                        <p id='modal-tipo-$id'>" . $row['tipo'] . "</p>
                    </div>
                    <div class='modal-section'>
                        <strong>Cupo máximo:</strong>
                        <div class='progress-container'>
                            <div id='modal-cupo-bar-$id' class='progress-bar'></div>
                        </div>
                        <p id='modal-cupo-text-$id'></p>
                    </div>
                </div>
            </div>
        </div>";
    }
} else {
    echo "<p>No hay programas disponibles</p>";
}
$conn->close();
?>

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
    <script src="../js/core.min.js"></script>
    <script src="../js/scriptt.js"></script>
    <script>
// Mostrar el modal y actualizar los datos
// Mostrar el modal y desactivar el scroll del fondo
function showModal(id) {
    const modal = document.getElementById('modal-' + id);
    modal.style.display = 'block';
    // Desactivar el scroll del fondo
    document.body.classList.add('no-scroll');

    const progressBar = document.getElementById('modal-cupo-bar');
    const progressText = document.getElementById('modal-cupo-text');
    const porcentaje = Math.min((cuposOcupados / cupoMaximo) * 100, 100);

    progressBar.style.width = `${porcentaje}%`;
    progressText.textContent = `${cuposOcupados} de ${cupoMaximo} cupos ocupados`;
}

// Cerrar el modal y reactivar el scroll del fondo
function closeModal(id) {
    const modal = document.getElementById('modal-' + id);
    modal.style.display = 'none';

    // Reactivar el scroll del fondo
    document.body.classList.remove('no-scroll');
}

window.onclick = function (event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach((modal) => {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.body.classList.remove('no-scroll');
        }
    });
};

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
