<?php
// Controllers/Coordinador/Cordi-Dashboard.php

session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.html"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Incluye la conexión a la base de datos

$user_id = $_SESSION['user_id'];

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

$sql = "SELECT id, nombre, descripcion, fecha_ini, fecha_fin, foto FROM programas WHERE users_id = $user_id"; //cambiar el 2 por el id del coordinador
$consulta = $conn->query($sql);

$fecha_actual = date('Y-m-d');

// Cerrar la conexión a la base de datos

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Resources/css/styles_informes.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 0 !important;
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
<?php include 'layout/header.php'; ?>
    <div class="contenedor-programas">
    <?php
        if ($consulta->num_rows > 0) {
            while($row = $consulta->fetch_assoc()) {
                $id = $row['id'];
                echo '
                <div class="programa">
                    <img src="../../Public/image/' . $row["id"] .'.png" alt="Imagen del programa">
                    <div class="programa-contenido">
                        <h3>' . $row["nombre"] . '</h3>
                        <p>' . $row["descripcion"] . '</p>
                        <div class="acciones">  
                            <button id="open-informe-'.$id.'" class="btn-informe btn btn-primary" onClick="verInforme('.$id.')">Ver informe</button>  
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo "<p>No hay naaaah</p>";
        }
        $conn->close();
    ?>
    </div>
    <!-- Modal -->
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="informeModal" tabindex="-1" aria-labelledby="informeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="informeModalLabel">Informe de Rendimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="listaPreguntas"></div> <!-- Contenedor dinámico para preguntas y gráficas -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../Resources/js/informes.js"></script>
</body>
</html>
