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

$sql = "SELECT id, nombre, descripcion, fecha_ini, fecha_fin, foto FROM programas"; //cambiar el 2 por el id del coordinador
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

<script>
    // Datos de preguntas y gráficas
// Datos de preguntas y gráficas
const preguntasGraficas = [
    //Pregunta 1
    {
        pregunta: "¿Qué tal te ha parecido el programa?",
        labels: ['Bueno', 'Regular', 'Malo'],
        data: [50, 30, 20]
    },
    //Pregunta 2
    {
        pregunta: "¿Le ha parecido relevante el programa?",
        labels: ['Sí', 'No'],
        data: [10, 25]
    },
    //Pregunta 3
    {
        pregunta: "¿Cómo ha sido el trato del personal?",
        labels: ['Bueno', 'Regular', 'Malo'],
        data: [70, 20, 10]
    },
    //Pregunta 4
    {
        pregunta: "¿Cómo ha sido la atención del personal?",
        labels: ['Bueno', 'Regular', 'Malo'],
        data: [70, 20, 10]
    },
    //Pregunta 5
    {
        pregunta: "¿Considera que el programa cumplió con sus expectativas?",
        labels: ['Sí', 'No'],
        data: [10, 25]
    },
    //Pregunta 6
    {
        pregunta: "¿Le gustaría participar en otro programa similar?",
        labels: ['Sí', 'No'],
        data: [10, 50]
    },
    //Pregunta 7
    {
        pregunta: "¿Fue fácil inscribirse y asistir al programa?",
        labels: ['Sí', 'No'],
        data: [10, 27]
    },
    //Pregunta 8
    {
        pregunta: "¿El horario fue adecuado para usted?",
        labels: ['Sí', 'No'],
        data: [38, 13]
    },
    //Pregunta 9
    {
        pregunta: "¿El espacio físico era adecuado para la actividad?",
        labels: ['Bueno', 'Regular', 'Malo'],
        data: [70, 20, 10]
    }
];

// Función para mostrar el modal con las gráficas
function verInforme(programaId) {
    const contenedorPreguntas = document.getElementById("listaPreguntas");
    contenedorPreguntas.innerHTML = ""; // Limpiar contenido previo

    // Generar dinámicamente las preguntas y gráficas
    preguntasGraficas.forEach((item, index) => {
        // Crear contenedor para cada pregunta y su gráfica
        const divPregunta = document.createElement("div");
        divPregunta.className = "mb-4"; // Añadir margen inferior

        // Título de la pregunta
        const preguntaTitulo = document.createElement("h6");
        preguntaTitulo.textContent = `${index + 1}. ${item.pregunta}`;
        divPregunta.appendChild(preguntaTitulo);

        // Lienzo para la gráfica
        const canvas = document.createElement("canvas");
        canvas.id = `chart-${index}`; // ID único para cada gráfica
        canvas.style.maxHeight = "300px"; // Ajustar altura máxima
        divPregunta.appendChild(canvas);

        // Añadir contenedor al modal
        contenedorPreguntas.appendChild(divPregunta);

        // Asignar colores para la gráfica de tipo Sí/No
        let backgroundColors = [];
        let borderColors = [];

        // Si las opciones son Sí/No, asignar colores específicos
        if (item.labels.includes("Sí") && item.labels.includes("No")) {
            backgroundColors = ['rgba(0, 197, 18, 0.8)', 'rgba(197, 0, 0, 0.8)'];
            borderColors = ['rgba(4, 125, 0, 0.8)', 'rgba(152, 0, 0, 0.8)'];
        } else {
            backgroundColors = [
                    'rgba(0, 197, 18, 0.8)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 0.8)'
            ];
            borderColors = [
                    'rgba(4, 125, 0, 0.8)',
                    'rgba(208, 225, 40, 1)',
                    'rgba(152, 0, 0, 0.8)'
            ];
        }

        // Crear la gráfica con los colores ajustados
        const ctx = canvas.getContext("2d");
        new Chart(ctx, {
            type: "pie", 
            data: {
                labels: item.labels,
                datasets: [{
                    data: item.data,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    });

    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('informeModal'));
    modal.show();
}
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--<script src="../../Resources/js/informes.js"></script>-->
</body>
</html>
