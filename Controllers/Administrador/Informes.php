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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<?php //include 'layout/header.php'; ?>
<div class="contenedor-programas">
    <?php
        if ($consulta->num_rows > 0) {
            while ($row = $consulta->fetch_assoc()) {
                $id = $row['id'];
                $consulta1 = "SELECT bueno, regular, malo FROM respuestas WHERE id_programa = $id AND id_pregunta = 1";
                $sql1 = $conn->query($consulta1);
                if ($sql1->num_rows > 0) {
                    $resultados = [];
                    while ($fila = $sql1->fetch_assoc()) {
                        $resultados[] = [
                            'bueno' => $fila['bueno'],
                            'regular' => $fila['regular'],
                            'malo' => $fila['malo']
                        ];
                    }
                    print_r($resultados); // Muestra el array con los resultados
                } else {
                    echo "No se encontraron resultados.";
                }

                $consulta2 = "SELECT si, no FROM respuestas WHERE id_programa = $id AND id_pregunta = 2";
                $sql2 = $conn->query($consulta2);
                if ($sql2->num_rows > 0) {
                    $resultados2 = [];
                    while ($fila2 = $sql2->fetch_assoc()) {
                        $resultados2[] = [
                            'bueno' => $fila2['bueno'],
                            'regular' => $fila2['regular'],
                            'malo' => $fila2['malo']
                        ];
                    }
                    
                } else {
                    echo "No se encontraron resultados.";
                }

                $consulta3 = "SELECT bueno, regular, malo FROM respuestas WHERE id_programa = $id AND id_pregunta = 3";
                $sql3 = $conn->query($consulta3);
                if ($sql3->num_rows > 0) {
                    $resultados3 = [];
                    while ($fila3 = $sql3->fetch_assoc()) {
                        $resultados3[] = [
                            'bueno' => $fila3['bueno'],
                            'regular' => $fila3['regular'],
                            'malo' => $fila3['malo']
                        ];
                    }
                    print_r($resultados); // Muestra el array con los resultados
                } else {
                    echo "No se encontraron resultados.";
                }

                $consulta4 = "SELECT bueno, regular, malo FROM respuestas WHERE id_programa = $id AND id_pregunta = 4";
                $sql4 = $conn->query($consulta4);
                if ($sql4->num_rows > 0) {
                    $resultados4 = [];
                    while ($fila4 = $sql4->fetch_assoc()) {
                        $resultados4[] = [
                            'bueno' => $fila4['bueno'],
                            'regular' => $fila4['regular'],
                            'malo' => $fila4['malo']
                        ];
                    }
                    print_r($resultados); // Muestra el array con los resultados
                } else {
                    echo "No se encontraron resultados.";
                }

                $consulta5 = "SELECT si, no FROM respuestas WHERE id_programa = $id AND id_pregunta = 5";
                $sql5 = $conn->query($consulta5);
                if ($sql5->num_rows > 0) {
                    $resultados5 = [];
                    while ($fila5 = $sql5->fetch_assoc()) {
                        $resultado5[] = [
                            'bueno' => $fil5['bueno'],
                            'regular' => $fila5['regular'],
                            'malo' => $fila5['malo']
                        ];
                    }
                    print_r($resultados); // Muestra el array con los resultados
                } else {
                    echo "No se encontraron resultados.";
                }

                $consulta6 = "SELECT si, no FROM respuestas WHERE id_programa = $id AND id_pregunta = 6";
                $sql6 = $conn->query($consulta6);
                if ($sql6->num_rows > 0) {
                    $resultados6 = [];
                    while ($fila6 = $sql6->fetch_assoc()) {
                        $resultados6[] = [
                            'bueno' => $fila6['bueno'],
                            'regular' => $fila6['regular'],
                            'malo' => $fila6['malo']
                        ];
                    }
                    print_r($resultados); // Muestra el array con los resultados
                } else {
                    echo "No se encontraron resultados.";
                }

                $consulta7 = "SELECT si, no FROM respuestas WHERE id_programa = $id AND id_pregunta = 7";
                $sql7 = $conn->query($consulta7);
                if ($sql7->num_rows > 0) {
                    $resultados7 = [];
                    while ($fila7 = $sql7->fetch_assoc()) {
                        $resultados7[] = [
                            'bueno' => $fila7['bueno'],
                            'regular' => $fila7['regular'],
                            'malo' => $fila7['malo']
                        ];
                    }
                    print_r($resultados); // Muestra el array con los resultados
                } else {
                    echo "No se encontraron resultados.";
                }

                $consulta8 = "SELECT si, no FROM respuestas WHERE id_programa = $id AND id_pregunta = 8";
                $sql8 = $conn->query($consulta8);
                if ($sql8->num_rows > 0) {
                    $resultados8 = [];
                    while ($fila8 = $sql8->fetch_assoc()) {
                        $resultados8[] = [
                            'bueno' => $fila8['bueno'],
                            'regular' => $fila8['regular'],
                            'malo' => $fila8['malo']
                        ];
                    }
                    print_r($resultados); // Muestra el array con los resultados
                } else {
                    echo "No se encontraron resultados.";
                }

                $consulta9 = "SELECT bueno, regular, malo FROM respuestas WHERE id_programa = $id AND id_pregunta = 9";
                $sql9 = $conn->query($consulta9);
                if ($sql9->num_rows > 0) {
                    $resultados0 = [];
                    while ($fila9 = $sql9->fetch_assoc()) {
                        $resultados9[] = [
                            'bueno' => $fila9['bueno'],
                            'regular' => $fila9['regular'],
                            'malo' => $fila9['malo']
                        ];
                    }
                    print_r($resultados); // Muestra el array con los resultados
                } else {
                    echo "No se encontraron resultados.";
                }
                echo '
                <div class="programa">
                    <img src="../../Public/image/' . $row["id"] . '.png" alt="Imagen del programa">
                    <div class="programa-contenido">
                        <h3>' . $row["nombre"] . '</h3>
                        <p>' . $row["descripcion"] . '</p>
                        <div class="acciones">  
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#informeModal" onClick="verInforme('.$id.')">
                            Ver informe
                        </button>  
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo "<p>No hay programas disponibles.</p>";
        }
        $conn->close();
    ?>
</div>



<!-- Modal -->
<div class="modal fade" id="informeModal" tabindex="-1" aria-labelledby="informeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="informeModalLabel">Informe de Rendimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Preguntas con espacios para gráficas -->
                <div class="pregunta">
                    <h6>1. ¿Qué tal te ha parecido el programa?</h6>
                    <canvas id="myPieChart" style="max-height: 300px;"></canvas>
                </div>
                <div class="pregunta">
                    <h6>2. ¿Le ha parecido relevante el programa?</h6>
                    <canvas id="myPieChart2" style="max-height: 300px;"></canvas>
                </div>
                <div class="pregunta">
                    <h6>3. ¿Cómo ha sido el trato del personal?</h6>
                    <canvas id="myPieChart3" style="max-height: 300px;"></canvas>
                </div>
                <div class="pregunta">
                    <h6>4. ¿Cómo ha sido la atención del personal?</h6>
                    <canvas id="myPieChart4" style="max-height: 300px;"></canvas>
                </div>
                <div class="pregunta">
                    <h6>5. ¿Considera que el programa cumplió con sus expectativas?</h6>
                    <canvas id="myPieChart5" style="max-height: 300px;"></canvas>
                </div>
                <div class="pregunta">
                    <h6>6. ¿Le gustaría participar en otro programa similar?</h6>
                    <canvas id="myPieChart6" style="max-height: 300px;"></canvas>
                </div>
                <div class="pregunta">
                    <h6>7. ¿Fue fácil inscribirse y asistir al programa?</h6>
                    <canvas id="myPieChart7" style="max-height: 300px;"></canvas>
                </div>
                <div class="pregunta">
                    <h6>8. ¿El horario fue adecuado para usted?</h6>
                    <canvas id="myPieChart8" style="max-height: 300px;"></canvas>
                </div>
                <div class="pregunta">
                    <h6>9. ¿El espacio físico era adecuado para la actividad?</h6>
                    <canvas id="myPieChart9" style="max-height: 300px;"></canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
const resultados = <?php echo json_encode($resultados); ?>;
const resultados2 = <?php echo json_encode($resultados2); ?>;
const resultados3 = <?php echo json_encode($resultados3); ?>;
const resultados4 = <?php echo json_encode($resultados4); ?>;
const resultados5 = <?php echo json_encode($resultados5); ?>;
const resultados6 = <?php echo json_encode($resultados6); ?>;
const resultados7 = <?php echo json_encode($resultados7); ?>;
const resultados8 = <?php echo json_encode($resultados8); ?>;
const resultados9 = <?php echo json_encode($resultados9); ?>;
const data = {
            labels: ['bueno', 'regular', 'malo'], // Etiquetas
            datasets: [{
                label: 'Opiniones',
                data: [
                resultados[0]?.bueno || 0, 
                resultados[0]?.regular || 0, 
                resultados[0]?.malo || 0
            ], // Valores
                backgroundColor: [
                    'rgba(0, 197, 18, 0.8)',  // Color para "Bueno"
                    'rgba(234, 158, 0, 1)',   // Color para "Regular"
                    'rgba(197, 0, 0, 0.8)'    // Color para "Malo"
                ],
                borderColor: [
                    'rgba(0, 197, 18, 1)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica
        const config = {
            type: 'pie', // Tipo de gráfica: pastel
            data: data,
            options: {
                responsive: true, // Escalable según tamaño de pantalla
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar información al pasar el mouse
                    }
                }
            }
        };

        // Inicializar la gráfica
        const myPieChart = new Chart(
            document.getElementById('myPieChart').getContext('2d'),
            config
        );


        const data2 = {
            labels: ['bueno', 'regular', 'malo'], // Etiquetas
            datasets: [{
                label: 'Opiniones',
                data: [
                resultados2[0]?.bueno || 0, 
                resultados2[0]?.regular || 0, 
                resultados2[0]?.malo || 0
            ], // Valores
                backgroundColor: [
                    'rgba(0, 197, 18, 0.8)',  // Color para "Bueno"
                    'rgba(234, 158, 0, 1)',   // Color para "Regular"
                    'rgba(197, 0, 0, 0.8)'    // Color para "Malo"
                ],
                borderColor: [
                    'rgba(0, 197, 18, 1)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica
        const config2 = {
            type: 'pie', // Tipo de gráfica: pastel
            data: data2,
            options: {
                responsive: true, // Escalable según tamaño de pantalla
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar información al pasar el mouse
                    }
                }
            }
        };

        // Inicializar la gráfica
        const myPieChart2 = new Chart(
            document.getElementById('myPieChart2').getContext('2d'),
            config
        );


        const data3 = {
            labels: ['bueno', 'regular', 'malo'], // Etiquetas
            datasets: [{
                label: 'Opiniones',
                data: [
                resultados3[0]?.bueno || 0, 
                resultados3[0]?.regular || 0, 
                resultados3[0]?.malo || 0
            ], // Valores
                backgroundColor: [
                    'rgba(0, 197, 18, 0.8)',  // Color para "Bueno"
                    'rgba(234, 158, 0, 1)',   // Color para "Regular"
                    'rgba(197, 0, 0, 0.8)'    // Color para "Malo"
                ],
                borderColor: [
                    'rgba(0, 197, 18, 1)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica
        const config3 = {
            type: 'pie', // Tipo de gráfica: pastel
            data: data3,
            options: {
                responsive: true, // Escalable según tamaño de pantalla
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar información al pasar el mouse
                    }
                }
            }
        };

        // Inicializar la gráfica
        const myPieChart3 = new Chart(
            document.getElementById('myPieChart3').getContext('2d'),
            config
        );


        const data4 = {
            labels: ['bueno', 'regular', 'malo'], // Etiquetas
            datasets: [{
                label: 'Opiniones',
                data: [
                resultados4[0]?.bueno || 0, 
                resultados4[0]?.regular || 0, 
                resultados4[0]?.malo || 0
            ], // Valores
                backgroundColor: [
                    'rgba(0, 197, 18, 0.8)',  // Color para "Bueno"
                    'rgba(234, 158, 0, 1)',   // Color para "Regular"
                    'rgba(197, 0, 0, 0.8)'    // Color para "Malo"
                ],
                borderColor: [
                    'rgba(0, 197, 18, 1)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica
        const config4 = {
            type: 'pie', // Tipo de gráfica: pastel
            data: data4,
            options: {
                responsive: true, // Escalable según tamaño de pantalla
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar información al pasar el mouse
                    }
                }
            }
        };

        // Inicializar la gráfica
        const myPieChart4 = new Chart(
            document.getElementById('myPieChart4').getContext('2d'),
            config
        );


        const data5 = {
            labels: ['bueno', 'regular', 'malo'], // Etiquetas
            datasets: [{
                label: 'Opiniones',
                data: [
                resultados5[0]?.bueno || 0, 
                resultados5[0]?.regular || 0, 
                resultados5[0]?.malo || 0
            ], // Valores
                backgroundColor: [
                    'rgba(0, 197, 18, 0.8)',  // Color para "Bueno"
                    'rgba(234, 158, 0, 1)',   // Color para "Regular"
                    'rgba(197, 0, 0, 0.8)'    // Color para "Malo"
                ],
                borderColor: [
                    'rgba(0, 197, 18, 1)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica
        const config5 = {
            type: 'pie', // Tipo de gráfica: pastel
            data: data5,
            options: {
                responsive: true, // Escalable según tamaño de pantalla
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar información al pasar el mouse
                    }
                }
            }
        };

        // Inicializar la gráfica
        const myPieChart5 = new Chart(
            document.getElementById('myPieChart5').getContext('2d'),
            config
        );


        const data6 = {
            labels: ['bueno', 'regular', 'malo'], // Etiquetas
            datasets: [{
                label: 'Opiniones',
                data: [
                resultados6[0]?.bueno || 0, 
                resultados6[0]?.regular || 0, 
                resultados6[0]?.malo || 0
            ], // Valores
                backgroundColor: [
                    'rgba(0, 197, 18, 0.8)',  // Color para "Bueno"
                    'rgba(234, 158, 0, 1)',   // Color para "Regular"
                    'rgba(197, 0, 0, 0.8)'    // Color para "Malo"
                ],
                borderColor: [
                    'rgba(0, 197, 18, 1)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica
        const config6 = {
            type: 'pie', // Tipo de gráfica: pastel
            data: data6,
            options: {
                responsive: true, // Escalable según tamaño de pantalla
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar información al pasar el mouse
                    }
                }
            }
        };

        // Inicializar la gráfica
        const myPieChart6 = new Chart(
            document.getElementById('myPieChart6').getContext('2d'),
            config
        );


        const data7 = {
            labels: ['bueno', 'regular', 'malo'], // Etiquetas
            datasets: [{
                label: 'Opiniones',
                data: [
                resultados7[0]?.bueno || 0, 
                resultados7[0]?.regular || 0, 
                resultados7[0]?.malo || 0
            ], // Valores
                backgroundColor: [
                    'rgba(0, 197, 18, 0.8)',  // Color para "Bueno"
                    'rgba(234, 158, 0, 1)',   // Color para "Regular"
                    'rgba(197, 0, 0, 0.8)'    // Color para "Malo"
                ],
                borderColor: [
                    'rgba(0, 197, 18, 1)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica
        const config7 = {
            type: 'pie', // Tipo de gráfica: pastel
            data: data7,
            options: {
                responsive: true, // Escalable según tamaño de pantalla
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar información al pasar el mouse
                    }
                }
            }
        };

        // Inicializar la gráfica
        const myPieChart7 = new Chart(
            document.getElementById('myPieChart7').getContext('2d'),
            config
        );


        const data8 = {
            labels: ['bueno', 'regular', 'malo'], // Etiquetas
            datasets: [{
                label: 'Opiniones',
                data: [
                resultados8[0]?.bueno || 0, 
                resultados8[0]?.regular || 0, 
                resultados8[0]?.malo || 0
            ], // Valores
                backgroundColor: [
                    'rgba(0, 197, 18, 0.8)',  // Color para "Bueno"
                    'rgba(234, 158, 0, 1)',   // Color para "Regular"
                    'rgba(197, 0, 0, 0.8)'    // Color para "Malo"
                ],
                borderColor: [
                    'rgba(0, 197, 18, 1)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica
        const config8 = {
            type: 'pie', // Tipo de gráfica: pastel
            data: data8,
            options: {
                responsive: true, // Escalable según tamaño de pantalla
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar información al pasar el mouse
                    }
                }
            }
        };

        // Inicializar la gráfica
        const myPieChart8 = new Chart(
            document.getElementById('myPieChart8').getContext('2d'),
            config
        );


        const data9 = {
            labels: ['bueno', 'regular', 'malo'], // Etiquetas
            datasets: [{
                label: 'Opiniones',
                data: [
                resultados9[0]?.bueno || 0, 
                resultados9[0]?.regular || 0, 
                resultados9[0]?.malo || 0
            ], // Valores
                backgroundColor: [
                    'rgba(0, 197, 18, 0.8)',  // Color para "Bueno"
                    'rgba(234, 158, 0, 1)',   // Color para "Regular"
                    'rgba(197, 0, 0, 0.8)'    // Color para "Malo"
                ],
                borderColor: [
                    'rgba(0, 197, 18, 1)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica
        const config9 = {
            type: 'pie', // Tipo de gráfica: pastel
            data: data9,
            options: {
                responsive: true, // Escalable según tamaño de pantalla
                plugins: {
                    legend: {
                        position: 'top', // Ubicación de la leyenda
                    },
                    tooltip: {
                        enabled: true, // Habilitar información al pasar el mouse
                    }
                }
            }
        };

        // Inicializar la gráfica
        const myPieChart9 = new Chart(
            document.getElementById('myPieChart9').getContext('2d'),
            config
        );
</script>

<!-- Librerías necesarias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
