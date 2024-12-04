<?php
// Iniciar sesión para verificar si el usuario está logueado
session_start();


?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">

<head>
  <title>Equal Education</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 
  <link rel="icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" type="text/css"
    href="//fonts.googleapis.com/css?family=Poppins:300,300i,400,500,600,700,800,900,900i%7CRoboto:400%7CRubik:100,400,700">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/fonts.css">
  <link rel="stylesheet" href="../css/styles_index.css">
</head>

<body>
  <div class="preloader">
    <div class="preloader-body">
      <div class="cssload-container">
        <div class="cssload-speeding-wheel"></div>
      </div>
      <p>Loading...</p>
    </div>
  </div>

   <!-- Page Header-->
   <header class="section page-header">
    <!-- RD Navbar-->
    <div class="rd-navbar-wrap">
      <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed"
         data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static"
         data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static"
         data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px"
         data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true"
         data-xxl-stick-up="true">
        <div class="rd-navbar-main-outer">
          <div class="rd-navbar-main">
            <!-- RD Navbar Panel-->
            <div class="rd-navbar-panel">
              <!-- RD Navbar Toggle-->
              <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
              <!-- RD Navbar Brand-->
              <div class="rd-navbar-brand">
                <a href="../views/index.php"><img class="brand-logo-light" src="../Images/logo.png" alt="" width="100" height=""/></a>
              </div>
            </div>
            <div class="rd-navbar-main-element">
              <div class="rd-navbar-nav-wrap">
                <!-- RD Navbar Nav-->
                <ul class="rd-navbar-nav">
                  <li class="rd-nav-item"><a class="rd-nav-link" href="../views/index.php">Inicio</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="../views/programas.php">Programas</a></li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="../views/nosotros.php">Sobre nosotros</a></li>
                  <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="rd-nav-item"><a class="rd-nav-link" href="../views/Modals.php">Únete</a></li>
                  <?php endif; ?>
                  <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="rd-nav-item"><a class="rd-nav-link" href="../views/login.php">Iniciar sesión</a></li>
                  <?php else: ?>
                    <!-- Mostrar "Cerrar Sesión" si el usuario está logueado -->
                    <li class="rd-nav-item">
                      <div class="dropdown">
                      <button class="button button-primary button-sm dropdown-toggle" type="button" id="profileDropdown"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="icon icon-md linearicons-user"></span> Perfil
                      </button>
                      <div class="dropdown-menu" aria-labelledby="profileDropdown">
                      <!-- Enlace para cerrar sesión -->
                      <?php
                      // Obtener el ID del rol del usuario desde la sesión
                      $role_id = $_SESSION['user_rol'];
                        echo $role_id;
                      // Redirigir al usuario a su Dashboard correspondiente
                      switch ($role_id) {
                        case 1:
                            $dashboard_url = "/EqualEducation/Controllers/Administrador/Layout/header.php";
                            break;
                        case 2:
                            $dashboard_url = "/EqualEducation/Controllers/Coordinador/Cordi-Dashboard.php";
                            break;
                        case 3:
                            $dashboard_url = "/EqualEducation/Controllers/Beneficiario/navbar.php";
                            break;
                        case 4:
                            $dashboard_url = "/EqualEducation/Controllers/Voluntario/navbar.php";
                            break;
                        case 5:
                            $dashboard_url = "/EqualEducation/Resources/views/Misdonaciones.php";
                            break;
                        default:
                            $dashboard_url = "../views/login.php"; // Redirige al login si no hay rol
                            break;
                        }
                      ?>
                      <a class="dropdown-item" href="<?php echo $dashboard_url; ?>">Mi Tablero</a>
                      <a class="dropdown-item" href="/EqualEducation/Controllers/Login/Logout.php">Cerrar Sesión</a>
                      </div>
                      </div>
                    </li>
                  <?php endif; ?>
                </ul>
                <a class="button button-primary button-sm" href="../views/donaciones.php">Donar</a>
              </div>
            </div>
            <a class="button button-primary button-sm" href="../views/donaciones.php">Donar</a>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>