<?php 
include '../../DB/db.php'; // Conexión a la base de datos

// Consulta para obtener datos de ambas tablas
$query = "
    SELECT 
        users.id AS user_id,
        users.nombre AS nombre_usuario,
        users.email,
        users.created_at,
        beneficiarios.localidad,
        beneficiarios.ocupacion,
        beneficiarios.preferencias_educativas,
        beneficiarios.razon
    FROM users
    JOIN beneficiarios ON users.id = beneficiarios.user_id;
";

$result = $conn->query($query);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajustes al modal para asegurar que el texto sea visible */
        .modal-content {
            color: #000000; /* Texto en negro */
        }

        .modal-header {
            background-color: #23272b; /* Fondo más oscuro para la cabecera */
            color: #f1f1f1; /* Blanco para el texto en la cabecera */
        }

        .modal-footer {
            background-color: #23272b; /* Fondo oscuro para la parte inferior */
            color: #f1f1f1; /* Blanco para el texto en el pie */
        }

        /* Estilo para los inputs y selects dentro del modal */
        .modal-body .form-control {
            color: #000000; /* Texto negro en los campos */
        }

        .modal-body .form-control:focus {
            background-color: #6c757d; /* Fondo cuando el input está en foco */
            border-color: #007bff; /* Borde azul al hacer foco */
            color: #000000; /* Texto negro cuando está en foco */
        }

        .modal-body label {
            color: #000000; /* Etiquetas negras para mayor visibilidad */
        }

        /* Ajustes generales */
        html, body {
            font-family: tahoma, sans-serif;
            margin: 0;
            padding: 0;
        }

        #container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        #card {
            width: 350px;
            border-radius: 25px;
            box-shadow: 2px 2px 5px #4069E2;
            padding-bottom: 1px;
            background-color: #4A4E59; /* Más claro para mejor contraste */
            color: #FFFFFF; /* Texto blanco */
        }

        h1 {
            color: white;
            text-align: center;
            background-color: #E6EBEE;
            border-radius: 25px 25px 0 0;
            color: #393B45;
            padding: 20px 0;
            font-weight: bold;
        }

        .image-crop {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #E6EBEE;
            width: 150px;
            height: 150px;
            margin: 30px auto 20px;
            border-radius: 50%;
            box-shadow: 1px 1px 5px #4069E2;
            overflow: hidden; /* Oculta cualquier parte de la imagen que sobresalga */
        }
        .avatar-img {
            width: 100%; /* Imagen llena el contenedor */
            height: 100%;
            object-fit: cover; /* Ajusta la imagen para cubrir todo el círculo */
        }
        #bio p, #stats .col p {
            color: #E6EBEE; /* Gris claro para texto */
        }   
        #bio {
            padding: 0 20px;
        }

        #bio p {
            margin-bottom: 10px;
            font-size: 15px;
        }

        #stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }

        .col p {
            margin: 0;
            font-weight: 600;
        }

        #buttons {
            display: flex;
            justify-content: space-between;
            padding: 0 20px 20px;
        }

        button {
            padding: 10px 0;
            width: 48%;
            border-radius: 25px;
            border: none;
            font-size: 16px;
            font-weight: 500;
            background-color: #FFA726; /* Naranja */
            color: #FFFFFF; /* Blanco */
            transition: transform 0.2s;
        }

        button:hover {
            transform: scale(1.03);
        }
    </style>
</head>
<body>
<?php include 'navbar.php';?>   
    <div id="container">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div id="card">
            <h1><?= htmlspecialchars($row['nombre_usuario']); ?></h1>   
            <div class="image-crop">
                <img id="avatar" class="avatar-img" src="../../Public/Image/op.png" alt="Avatar">
            </div>
            <div id="bio">
                <p><strong>Localidad:</strong> <?= htmlspecialchars($row['localidad']); ?></p>
                <p><strong>Ocupación:</strong> <?= htmlspecialchars($row['ocupacion']); ?></p>
                <p><strong>Preferencias Educativas:</strong> <?= htmlspecialchars($row['preferencias_educativas']); ?></p>
                <p><strong>Razón:</strong> <?= htmlspecialchars($row['razon']); ?></p>
            </div>
            <div id="stats">
                <div class="col">
                    <p><strong>Registrado:</strong></p>
                    <p><?= date('d/m/Y', strtotime($row['created_at'])); ?></p>
                </div>
                <div class="col">
                    <p><strong>Email:</strong></p>
                    <p><?= htmlspecialchars($row['email']); ?></p>
                </div>
            </div>
            <div id="buttons">
                <button class="btn btn-warning" onclick="abrirModal(<?= $row['user_id']; ?>, '<?= htmlspecialchars($row['nombre_usuario']); ?>', '<?= htmlspecialchars($row['localidad']); ?>', '<?= htmlspecialchars($row['ocupacion']); ?>', '<?= htmlspecialchars($row['preferencias_educativas']); ?>', '<?= htmlspecialchars($row['razon']); ?>')">Editar</button>
            
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Beneficiario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateForm" action="mecanicas/actualizar.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="localidad">Localidad</label>
                            <input type="text" class="form-control" id="localidad" name="localidad" required>
                        </div>
                        <div class="form-group">
                            <label for="ocupacion">Ocupación</label>
                            <select class="form-control" id="ocupacion" name="ocupacion" required>
                                <option value="Estudiante">Estudiante</option>
                                <option value="Desempleado">Desempleado</option>
                                <option value="Trabajador">Trabajador</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="preferencias_educativas">Preferencias Educativas</label>
                            <select class="form-control" id="preferencias_educativas" name="preferencias_educativas" required>
                                <option value="Ciencias">Ciencias</option>
                                <option value="Matemáticas">Matemáticas</option>
                                <option value="Lengua">Lengua</option>
                                <option value="Historia">Historia</option>
                                <option value="Arte">Arte</option>
                                <option value="Tecnología">Tecnología</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="razon">Razón</label>
                            <textarea class="form-control" id="razon" name="razon" rows="3" required></textarea>
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
        function abrirModal(user_id, nombre, localidad, ocupacion, preferencias_educativas, razon) {
            $('#editModal').modal('show');
            $('#nombre').val(nombre);
            $('#localidad').val(localidad);
            $('#ocupacion').val(ocupacion);
            $('#preferencias_educativas').val(preferencias_educativas);
            $('#razon').val(razon);
            $('#updateForm').append('<input type="hidden" name="user_id" value="' + user_id + '">');
        }
    </script>
</body>
</html>
