<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.html"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Incluye la conexión a la base de datos

// Consulta para obtener el total de usuarios registrados
$sqlUsuarios = "SELECT COUNT(*) AS total_usuarios FROM users";
$resultUsuarios = $conn->query($sqlUsuarios); // Ejecuta la consulta
$totalUsuarios = $resultUsuarios->fetch_assoc()['total_usuarios']; // Obtiene el resultado de la consulta

// Consulta para obtener las donaciones totales
$sqlDonaciones = "SELECT COALESCE(SUM(monto), 0) AS total_donaciones FROM donaciones";
$resultDonaciones = $conn->query($sqlDonaciones); // Ejecuta la consulta
$totalDonaciones = $resultDonaciones->fetch_assoc()['total_donaciones']; // Obtiene el resultado de la consulta

// Consulta para obtener la cantidad de beneficiarios registrados
$sqlBeneficiarios = "SELECT COUNT(*) AS total_beneficiarios FROM beneficiarios";
$resultBeneficiarios = $conn->query($sqlBeneficiarios); // Ejecuta la consulta
$totalBeneficiarios = $resultBeneficiarios->fetch_assoc()['total_beneficiarios']; // Obtiene el resultado de la consulta

// Cerrar la conexión a la base de datos
$conn->close(); // Cierra la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
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
<?php include('layout/header.php') ?>

    <!-- Contenido de la página -->

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-dark bg-custom mb-3">
                    <div class="card-header">Total de Usuarios</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalUsuarios; ?></h5>
                        <p class="card-text">Usuarios registrados en el sistema.</p>
                    </div>
                </div>
            </div>   
            <div class="col-md-4">
                <div class="card text-dark bg-custom mb-3">
                    <div class="card-header">Total de Donaciones</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalDonaciones; ?></h5>
                        <p class="card-text">Monto total de donaciones recibidas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-dark bg-custom mb-3">
                    <div class="card-header">Total de Beneficiarios</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalBeneficiarios; ?></h5>
                        <p class="card-text">Beneficiarios registrados en el sistema.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


    


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'es',
            includedLanguages: 'en,es',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>

<div id="google_translate_element"></div>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>