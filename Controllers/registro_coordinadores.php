<?php
// Iniciar sesión (asegurar que no se inicie varias veces)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión a la base de datos
include '../DB/DB.php';  // Asegúrate de que el archivo DB.php tenga la variable $conn correctamente configurada

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario tiene sesión activa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // ID del usuario desde la sesión

    // Obtener datos del formulario
    $experiencia = $_POST['experiencia'] ?? '';
    $habilidades = $_POST['habilidades'] ?? '';
    $motivacion = $_POST['motivacion'] ?? '';

    // Validar campos obligatorios
    if (empty($experiencia) || empty($habilidades) || empty($motivacion)) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Actualizar el rol del usuario a 2 (Coordinador)
    $rol_id = 2;  // Asignar el valor del rol a una variable
    $stmt_update_rol = $conn->prepare("UPDATE users SET id_rol = ? WHERE id = ?");
    $stmt_update_rol->bind_param("ii", $rol_id, $user_id);

    if (!$stmt_update_rol->execute()) {
        die("Error al actualizar el rol del usuario: " . $stmt_update_rol->error);
    }

    // Insertar los datos del coordinador en la tabla `coordinadores`
    $stmt_coordinadores = $conn->prepare("INSERT INTO coordinadores (user_id, experiencia, habilidades, motivacion) VALUES (?, ?, ?, ?)");
    $stmt_coordinadores->bind_param("isss", $user_id, $experiencia, $habilidades, $motivacion);

    if ($stmt_coordinadores->execute()) {
        // Registro exitoso: cerrar sesión y redirigir al login
        session_destroy(); // Cerrar la sesión
        header("Location: ../Resources/views/login.php");  // Redirigir al login
        exit(); // Asegurarse de que no se ejecute más código
    } else {
        die("Error al guardar los datos del coordinador: " . $stmt_coordinadores->error);
    }

    // Cerrar consultas
    $stmt_update_rol->close();
    $stmt_coordinadores->close();
} else {
    // Si no hay sesión activa, redirigir al login.php
    header("Location: ../views/login.php");  // Redirigir al login
    exit();  // Detener la ejecución
}

// Cerrar conexión
$conn->close();
?>
