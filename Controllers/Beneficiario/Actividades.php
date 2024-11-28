<?php

session_start(); // Inicia la sesión

include '../../DB/db.php'; // Conexión a la base de datos

// Obtener el ID del beneficiario (esto debería ser a través de sesión o algún mecanismo de autenticación)
$beneficiario_id = $_SESSION['user_id']; // Asegúrate de obtener el ID correctamente

// Consulta para obtener todas las actividades en las que el beneficiario está involucrado
$query = "
    SELECT a.id, a.nombre, a.descripcion, a.fecha, a.hora, a.estado, a.user_id
    FROM actividades a
    JOIN users_actividad ua ON a.id = ua.actividad_id
    WHERE ua.beneficiario_id = ?;
";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $beneficiario_id); // Vincular el ID del beneficiario
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
        /* Estilo personalizado para la tabla */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .estado {
            font-weight: bold;
        }
        .estado.Programada {
            color: #007bff;
        }
        .estado.Proceso {
            color: #ff9800;
        }
        .estado.Finalizada {
            color: #4caf50;
        }
        .estado.Cancelada {
            color: #f44336;
        }
    </style>
</head>
<body>
<?php include 'navbar.php';?>  
    <div class="container">
        <h2 class="text-center mt-5">Mis Actividades</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']); ?></td>
                            <td><?= htmlspecialchars($row['descripcion']); ?></td>
                            <td><?= date('d/m/Y', strtotime($row['fecha'])); ?></td>
                            <td><?= date('H:i', strtotime($row['hora'])); ?></td>
                            <td class="estado <?= $row['estado']; ?>"><?= htmlspecialchars($row['estado']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center mt-3">No estás inscrito en ninguna actividad.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

 
