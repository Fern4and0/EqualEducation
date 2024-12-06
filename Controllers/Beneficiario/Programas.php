<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.php"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Conexión a la base de datos

// Consulta para obtener los programas en los que participa el beneficiario logueado
$queryProgramas = "
    SELECT 
        p.id, p.nombre, p.descripcion, p.fecha_ini, p.fecha_fin, p.foto, p.ubicacion, 
        p.cupo_maximo, p.tipo, p.estatus
    FROM users_programa up
    JOIN programas p ON up.programa_id = p.id
    WHERE up.beneficiario_id = ?
";

$stmt = $conn->prepare($queryProgramas);
$stmt->bind_param("i", $_SESSION['user_id']); // Filtra los datos para el beneficiario logueado
$stmt->execute();
$resultProgramas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Programas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .programa-card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
        }
        .programa-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
        }
        .programa-info {
            padding: 15px;
            flex: 1;
        }
        .programa-date {
            font-size: 14px;
            color: #888;
        }
        .programa-info h4 {
            margin-top: 10px;
            font-size: 18px;
        }
        .program-description {
            font-size: 14px;
            margin-top: 10px;
            color: #555;
        }
        .program-footer {
            margin-top: 15px;
        }
        .modal-section {
            margin-bottom: 15px;
        }
        .progress-container {
            background-color: #f2f2f2;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-bar {
            height: 20px;
            background-color: #28a745;
        }
        .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-footer form button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">Mis Programas</h1>

        <?php if ($resultProgramas->num_rows > 0): ?>
            <?php while ($programa = $resultProgramas->fetch_assoc()): ?>
                <div class="programa-container">
                    <div class="programa-card">
                        <!-- Imagen del programa -->
                        <div class="programa-image">
                            <img src="../../Public/image/<?php echo $programa['id']; ?>.png" alt="Imagen destacada" class="featured-image">
                        </div>
                        <div class="programa-info">
                            <!-- Información básica del programa -->
                            <h6 class="programa-date"><strong><?php echo $programa['fecha_ini'] . ' // ' . $programa['fecha_fin']; ?></strong></h6>
                            <h4><?php echo $programa['nombre']; ?></h4>
                            <p class="program-description"><?php echo $programa['descripcion']; ?></p>
                            <div class="program-footer">
                                <!-- Botón para abrir modal -->
                                <button class="btn btn-info" data-toggle="modal" data-target="#modal-<?php echo $programa['id']; ?>">Ver más...</button>
                                <?php if ($programa['estatus'] == 'Activo'): ?>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#encuestaModal">Realizar Encuesta</button>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modal-<?php echo $programa['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel-<?php echo $programa['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel-<?php echo $programa['id']; ?>"><?php echo $programa['nombre']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Descripción y detalles del programa en el modal -->
                                    <div class="modal-section">
                                        <strong>Descripción:</strong>
                                        <p><?php echo $programa['descripcion']; ?></p>
                                    </div>
                                    <div class="modal-section">
                                        <strong>Fecha de inicio:</strong>
                                        <p><?php echo $programa['fecha_ini']; ?></p>
                                    </div>
                                    <div class="modal-section">
                                        <strong>Fecha de vencimiento:</strong>
                                        <p><?php echo $programa['fecha_fin']; ?></p>
                                    </div>
                                    <div class="modal-section">
                                        <strong>Ubicación:</strong>
                                        <p><?php echo $programa['ubicacion']; ?></p>
                                    </div>
                                    <div class="modal-section">
                                        <strong>Tipo de programa:</strong>
                                        <p><?php echo $programa['tipo']; ?></p>
                                    </div>
                                    <div class="modal-section">
                                        <strong>Cupo máximo:</strong>
                                        <div class="progress-container">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>
                                        <p>50% de cupo lleno</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Fin del contenedor del programa -->
                <div class="modal fade" id="encuestaModal" tabindex="-1" role="dialog" aria-labelledby="encuestaModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="encuestaModalLabel">Encuesta del Programa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form action="../Encuesta.php" method="POST">
                                <input type="hidden" name="programa_id" value="<?php echo $programa['id'];?>">
                                    <div class="mb-3">
                                        <label>1. ¿Qué tal te ha parecido el programa?</label><br>
                                        <input type="radio" name="pregunta1" value="bueno" required> Bueno<br>
                                        <input type="radio" name="pregunta1" value="regular"> Regular<br>
                                        <input type="radio" name="pregunta1" value="malo"> Malo<br>
                                    </div>

                                    <div class="mb-3">
                                        <label>2. ¿Le ha parecido relevante el programa?</label><br>
                                        <input type="radio" name="pregunta2" value="si" required> Sí<br>
                                        <input type="radio" name="pregunta2" value="no"> No<br>
                                    </div>

                                    <div class="mb-3">
                                        <label>3. ¿Cómo ha sido el trato del personal?</label><br>
                                        <input type="radio" name="pregunta3" value="bueno" required> Bueno<br>
                                        <input type="radio" name="pregunta3" value="regular"> Regular<br>
                                        <input type="radio" name="pregunta3" value="malo"> Malo<br>
                                    </div>

                                    <div class="mb-3">
                                        <label>4. ¿Cómo ha sido la atención del personal?</label><br>
                                        <input type="radio" name="pregunta4" value="bueno" required> Bueno<br>
                                        <input type="radio" name="pregunta4" value="regular"> Regular<br>
                                        <input type="radio" name="pregunta4" value="malo"> Malo<br>
                                    </div>

                                    <div class="mb-3">
                                        <label>5. ¿Considera que el programa cumplió con sus expectativas?</label><br>
                                        <input type="radio" name="pregunta5" value="si" required> Sí<br>
                                        <input type="radio" name="pregunta5" value="no"> No<br>
                                    </div>

                                    <div class="mb-3">
                                        <label>6. ¿Le gustaría participar en otro programa similar?</label><br>
                                        <input type="radio" name="pregunta6" value="si" required> Sí<br>
                                        <input type="radio" name="pregunta6" value="no"> No<br>
                                    </div>

                                    <div class="mb-3">
                                        <label>7. ¿Fue fácil inscribirse y asistir al programa?</label><br>
                                        <input type="radio" name="pregunta7" value="si" required> Sí<br>
                                        <input type="radio" name="pregunta7" value="no"> No<br>
                                    </div>

                                    <div class="mb-3">
                                        <label>8. ¿El horario fue adecuado para usted?</label><br>
                                        <input type="radio" name="pregunta8" value="si" required> Sí<br>
                                        <input type="radio" name="pregunta8" value="no"> No<br>
                                    </div>

                                    <div class="mb-3">
                                        <label>9. ¿El espacio físico era adecuado para la actividad?</label><br>
                                        <input type="radio" name="pregunta9" value="bueno" required> Bueno<br>
                                        <input type="radio" name="pregunta9" value="regular"> Regular<br>
                                        <input type="radio" name="pregunta9" value="malo"> Malo<br>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">Enviar Encuesta</button>
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No tienes programas disponibles.</p>
        <?php endif; ?>
    </div>
    

<!-- Modal De encuestas -->

  <!-- Scripts de Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js?v=1"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
