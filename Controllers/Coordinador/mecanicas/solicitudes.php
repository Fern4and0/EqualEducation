<?php

header('Content-Type: application/json');

// Incluir el archivo de conexión a la base de datos
include '../../../DB/db.php'; // Incluye la conexión a la base de datos

$response = [];

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Tipo de solicitud no válido."]);
    exit;
}

// Debugging: Write the contents of $_POST to a file
file_put_contents('debug.txt', print_r($_POST, true));

// Obtener los datos del formulario
$id_users = $_POST['id_users'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$motivacion = $_POST['motivacion'] ?? '';
$fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$nivel_edu = $_POST['nivel_edu'] ?? '';
$situacion_eco = $_POST['situacion_eco'] ?? '';
$fecha_de_ingr = $_POST['fecha_de_ingr'] ?? '';

// Validar los datos
if (empty($_POST['nombre']) || empty($_POST['fecha_nacimiento']) || empty($_POST['direccion'])) {
    echo json_encode(["status" => "error", "message" => "Por favor completa todos los campos obligatorios."]);
    exit;
}

// Verificar el tipo de solicitud
if (isset($_POST['ingresos_mensuales']) && !isset($_POST['ocupacion'])) {
    // Solicitud de Beneficiario
    $ingresos_mensuales = $_POST['ingresos_mensuales'];
    $query = "INSERT INTO beneficiarios (id_users, nombre, ingresos_mensuales, motivacion, fecha_nacimiento, direccion, nivel_edu, situacion_eco, fecha_de_ingr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issdsssss", $id_users, $nombre, $ingresos_mensuales, $motivacion, $fecha_nacimiento, $direccion, $nivel_edu, $situacion_eco, $fecha_de_ingr);
} elseif (isset($_POST['ocupacion']) && !isset($_POST['ingresos_mensuales'])) {
    // Solicitud de Voluntario
    $ocupacion = $_POST['ocupacion'];
    $query = "INSERT INTO voluntarios (id_users, nombre, ocupacion, motivacion, fecha_nacimiento, direccion, nivel_edu, situacion_eco, fecha_de_ingr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issssssss", $id_users, $nombre, $ocupacion, $motivacion, $fecha_nacimiento, $direccion, $nivel_edu, $situacion_eco, $fecha_de_ingr);
} elseif (isset($_POST['ingresos_mensuales']) && isset($_POST['ocupacion'])) {
    $response['status'] = 'error';
    $response['message'] = 'No se puede enviar ambos tipos de solicitud a la vez.';
    echo json_encode($response);
    exit();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Tipo de solicitud no válido.';
    echo json_encode($response);
    exit();
}

// Ejecutar la consulta
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Solicitud enviada exitosamente.';
    echo json_encode($response);
    exit();
} else {
    $response['status'] = 'error';
    $response['message'] = "Error al enviar la solicitud: {$stmt->error}";
    echo json_encode($response);
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
