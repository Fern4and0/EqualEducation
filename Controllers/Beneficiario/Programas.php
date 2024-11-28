<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.html"); // Redirige al login si no está autenticado
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
        }
        .programa-header {
            background-color: #f5f5f5;
            padding: 10px;
            font-weight: bold;
            font-size: 18px;
        }
        .programa-body {
            padding: 15px;
        }
        .programa-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<?php include 'navbar.php';?>   
<div class="container mt-4">
    <h1 class="mb-4">Mis Programas</h1>

    <?php if ($resultProgramas->num_rows > 0): ?>
        <?php while ($programa = $resultProgramas->fetch_assoc()): ?>
            <div class="programa-card">
                <div class="programa-header">
                    <?= htmlspecialchars($programa['nombre']); ?>
                    <span class="badge badge-secondary float-right"><?= $programa['tipo']; ?></span>
                </div>
                <?php if (!empty($programa['foto'])): ?>
                    <img src="<?= htmlspecialchars($programa['foto']); ?>" alt="Foto del programa" class="programa-img">
                <?php endif; ?>
                <div class="programa-body">
                    <p><strong>Descripción:</strong> <?= htmlspecialchars($programa['descripcion']); ?></p>
                    <p><strong>Ubicación:</strong> <?= htmlspecialchars($programa['ubicacion']); ?></p>
                    <p><strong>Fechas:</strong> <?= htmlspecialchars($programa['fecha_ini']); ?> - <?= htmlspecialchars($programa['fecha_fin']); ?></p>
                    <p><strong>Cupo Máximo:</strong> <?= htmlspecialchars($programa['cupo_maximo']); ?></p>
                    <p><strong>Estatus:</strong> <?= htmlspecialchars($programa['estatus']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No estás inscrito en ningún programa actualmente.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
