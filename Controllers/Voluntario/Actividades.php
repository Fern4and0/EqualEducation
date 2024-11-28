<?php
include '../../DB/db.php'; // Incluye conexión a la base de datos

session_start();
$voluntario_id = $_SESSION['user_id']; // Asume que el ID del usuario está almacenado en sesión

// Consulta para obtener las actividades donde el voluntario está registrado
$query = "
    SELECT 
        a.id AS actividad_id,
        a.programa_id,
        a.nombre,
        a.descripcion,
        a.fecha,
        a.hora,
        a.estado,
        a.user_id,
        ua.rol,
        ua.fecha_inscripcion,
        ua.estatus_participacion,
        ua.feedback
    FROM actividades a
    JOIN users_actividad ua ON a.id = ua.actividad_id
    WHERE ua.voluntario_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $voluntario_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Actividades</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .table-container {
            margin: 50px auto;
            width: 90%;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #343a40;
            color: #ffffff;
        }

        .status-programada {
            color: #007bff;
        }

        .status-proceso {
            color: #ffc107;
        }

        .status-finalizada {
            color: #28a745;
        }

        .status-cancelada {
            color: #dc3545;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }

        .btn-ver {
            background-color: #007bff;
        }

        .btn-ver:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Si tienes una barra de navegación -->
    <div class="table-container">
        <h1>Mis Actividades</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Programa</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['actividad_id']); ?></td>
                        <td><?= htmlspecialchars($row['programa_id']); ?></td>
                        <td><?= htmlspecialchars($row['nombre']); ?></td>
                        <td><?= htmlspecialchars($row['descripcion']); ?></td>
                        <td><?= date('d/m/Y', strtotime($row['fecha'])); ?></td>
                        <td><?= date('H:i', strtotime($row['hora'])); ?></td>
                        <td>
                            <span class="
                                <?= $row['estado'] === 'Programada' ? 'status-programada' : '' ?>
                                <?= $row['estado'] === 'En Proceso' ? 'status-proceso' : '' ?>
                                <?= $row['estado'] === 'Finalizada' ? 'status-finalizada' : '' ?>
                                <?= $row['estado'] === 'Cancelada' ? 'status-cancelada' : '' ?>
                            ">
                                <?= htmlspecialchars($row['estado']); ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['rol']); ?></td>
                        <td>
                            <a href="detalle_actividad.php?id=<?= $row['actividad_id']; ?>" class="btn btn-ver">Ver</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
