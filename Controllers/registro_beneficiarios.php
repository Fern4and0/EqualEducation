<?php
// Iniciar sesión (asegurar que no se inicie varias veces)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión a la base de datos
include '../DB/DB.php';  // Asegúrate de que el archivo DB.php tenga la variable $conn correctamente configurada

// Verificar que la conexión a la base de datos sea exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario está registrado y tiene sesión activa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];  // Obtener el user_id de la sesión actual

    // Obtener los datos del formulario
    $ocupacion = $_POST['ocupacion'];
    $razon = $_POST['razon'];
    $localidad = $_POST['localidad'];
    $preferencias_educativas = $_POST['preferencias_educativas'];

    // 1. Actualizar el rol del usuario a 3 (Beneficiario)
    $rol_id = 3;  // Asignar el valor del rol a una variable
    $stmt_update_rol = $conn->prepare("UPDATE users SET id_rol = ? WHERE id = ?");
    $stmt_update_rol->bind_param("ii", $rol_id, $user_id);  // Ahora pasas la variable $rol_id

    if (!$stmt_update_rol->execute()) {
        echo "Error al actualizar el rol del usuario: " . $stmt_update_rol->error;
    }

    // 2. Insertar los datos del beneficiario en la tabla `beneficiarios`
    $stmt_beneficiarios = $conn->prepare("INSERT INTO beneficiarios (user_id, ocupacion, razon, localidad, preferencias_educativas) VALUES (?, ?, ?, ?, ?)");
    $stmt_beneficiarios->bind_param("issss", $user_id, $ocupacion, $razon, $localidad, $preferencias_educativas);

    if ($stmt_beneficiarios->execute()) {
        session_destroy(); // Cerrar la sesión
        header("Location: ../Resources/views/login.php");  // Redirigir al login
    } else {
        echo "Error al guardar los datos del beneficiario: " . $stmt_beneficiarios->error;
    }

    // Cerrar las consultas
    $stmt_update_rol->close();
    $stmt_beneficiarios->close();
} else {
    // Si no hay sesión activa, redirigir al login.php
    header("Location: ../Resources/views/login.php");  // Redirigir al login
    exit();  // Detener la ejecución
}

// Cerrar la conexión
$conn->close();
?>
