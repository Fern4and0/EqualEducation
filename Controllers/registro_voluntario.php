<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión a la base de datos
include '../DB/DB.php'; // Asegúrate de configurar correctamente la conexión en este archivo

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario tiene sesión activa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // ID del usuario desde la sesión

    // Obtener datos del formulario
    $ocupacion = $_POST['ocupacion'] ?? '';
    $motivacion = $_POST['motivacion'] ?? '';
    $localidad = $_POST['localidad'] ?? '';
    $habilidades_tecnicas = $_POST['habilidades_tecnicas'] ?? '';
    $disponibilidad = $_POST['disponibilidad'] ?? '';

    // Validar campos obligatorios
    if (empty($ocupacion) || empty($motivacion) || empty($localidad) || empty($habilidades_tecnicas) || empty($disponibilidad)) {
        die("Error: Todos los campos son obligatorios.");
    }

    $rol_id = 4;  // Asignar el valor del rol a una variable
    $stmt_update_rol = $conn->prepare("UPDATE users SET id_rol = ? WHERE id = ?");
    $stmt_update_rol->bind_param("ii", $rol_id, $user_id);  // Ahora pasas la variable $rol_id

    if (!$stmt_update_rol->execute()) {
        die("Error al actualizar el rol del usuario: " . $stmt_update_rol->error);
    }

    // Insertar datos del voluntario en la tabla `voluntarios`
    $stmt_voluntarios = $conn->prepare("INSERT INTO voluntarios (user_id, ocupacion, motivacion, localidad, habilidades_tecnicas, disponibilidad) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_voluntarios->bind_param("isssss", $user_id, $ocupacion, $motivacion, $localidad, $habilidades_tecnicas, $disponibilidad);

    if ($stmt_voluntarios->execute()) {
        echo "Registro de voluntario exitoso.";
    } else {
        die("Error al guardar los datos del voluntario: " . $stmt_voluntarios->error);
    }

    // Cerrar consultas
    $stmt_update_rol->close();
    $stmt_voluntarios->close();
} else {
    echo "No hay sesión activa. El usuario no está registrado.";
}

// Cerrar conexión
$conn->close();
?>
