<?php 
include '../../DB/db.php'; // Conexión a la base de datos
session_start(); // Inicia la sesión para acceder a la información de sesión

// Asegúrate de que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirige al login si no está autenticado
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Obtén el user_id de la sesión

// Consulta para obtener datos del usuario actual y su perfil de voluntario
$query = "
    SELECT 
        users.id AS id,
        users.nombre AS nombre_usuario,
        users.email,
        users.created_at,
        voluntarios.ocupacion,
        voluntarios.motivacion,
        voluntarios.localidad,
        voluntarios.habilidades_tecnicas,
        voluntarios.disponibilidad
    FROM users
    JOIN voluntarios ON users.id = voluntarios.user_id
    WHERE users.id = ?"; // Filtra por el ID del usuario en sesión

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // Vincula el parámetro de la consulta
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$row = $result->fetch_assoc(); // Solo se obtiene un registro, ya que es el usuario en sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voluntarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajustes generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        #container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        #card {
            width: 350px;
            border-radius: 25px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            color: #000;
            overflow: hidden;
        }

        h1 {
            text-align: center;
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            font-size: 20px;
            margin: 0;
        }

        .image-crop {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            width: 150px;
            height: 150px;
            margin: 20px auto;
            border-radius: 50%;
            overflow: hidden;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #bio {
            padding: 20px;
        }

        #bio p {
            margin: 5px 0;
            font-size: 14px;
        }

        #stats {
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            margin: 20px 0;
        }

        #buttons {
            display: flex;
            justify-content: space-between;
            padding: 10px 20px 20px;
        }

        button {
            padding: 10px 0;
            width: 48%;
            border-radius: 25px;
            border: none;
            font-size: 14px;
            font-weight: 500;
            background-color: #28a745;
            color: #fff;
            transition: transform 0.2s;
        }

        button:hover {
            transform: scale(1.03);
        }

        button.btn-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?> <!-- Barra de navegación -->
    <div id="container">
        <?php if ($row): ?>
        <div id="card">
            <h1><?= htmlspecialchars($row['nombre_usuario']); ?></h1>   
            <div class="image-crop">
                <img id="avatar" class="avatar-img" src="../../Public/Image/voluntario.png" alt="Avatar">
            </div>
            <div id="bio">
                <p><strong>Ocupacion:</strong> <?= htmlspecialchars($row['ocupacion']); ?></p>
                <p><strong>Motivacion :</strong> <?= htmlspecialchars($row['motivacion']); ?></p>
                <p><strong>Localidad:</strong> <?= htmlspecialchars($row['localidad']); ?></p>
                <p><strong>Habilidades Técnicas:</strong> <?= htmlspecialchars($row['habilidades_tecnicas']); ?></p>
                <p><strong>Disponibilidad:</strong> <?= htmlspecialchars($row['disponibilidad']); ?></p>
            </div>
            <div id="stats">
                <div>
                    <p><strong>Registrado:</strong></p>
                    <p><?= date('d/m/Y', strtotime($row['created_at'])); ?></p>
                </div>
                <div>
                    <p><strong>Email:</strong></p>
                    <p><?= htmlspecialchars($row['email']); ?></p>
                </div>
            </div>
            <div id="buttons">
                <button class="btn btn-warning" onclick="abrirModal(
                    <?= $row['id']; ?>, 
                    '<?= htmlspecialchars($row['ocupacion']); ?>',
                    '<?= htmlspecialchars($row['motivacion']); ?>',
                    '<?= htmlspecialchars($row['localidad']); ?>', 
                    '<?= htmlspecialchars($row['habilidades_tecnicas']); ?>', 
                    '<?= htmlspecialchars($row['disponibilidad']); ?>')">Editar</button>
            </div>
        </div>
        <?php else: ?>
            <p>No se encontró información del usuario.</p>
        <?php endif; ?>
    </div>

    <!-- Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateForm" action="mecanicas/actualizar.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ocupacion">Ocupacion</label>
                            <input type="text" class="form-control" id="ocupacion" name="ocupacion" required>
                        </div>
                        <div class="form-group">
                            <label for="motivacion">Motivación</label>
                            <textarea class="form-control" id="motivacion" name="motivacion" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="localidad">Localidad</label>
                            <input type="text" class="form-control" id="localidad" name="localidad" required>
                        </div>
                        <div class="form-group">
                            <label for="habilidades_tecnicas">Habilidades Técnicas</label>
                            <input type="text" class="form-control" id="habilidades_tecnicas" name="habilidades_tecnicas" required>
                        </div>
                        <div class="form-group">
                            <label for="disponibilidad">Disponibilidad</label>
                            <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function abrirModal(user_id, ocupacion, motivacion, localidad, habilidades_tecnicas, disponibilidad) {
            $('#editModal').modal('show');
            $('#ocupacion').val(ocupacion);
            $('#motivacion').val(motivacion);
            $('#localidad').val(localidad);
            $('#habilidades_tecnicas').val(habilidades_tecnicas);
            $('#disponibilidad').val(disponibilidad);
            $('#updateForm').append('<input type="hidden" name="user_id" value="' + user_id + '">');
        }
    </script>
</body>
</html>
