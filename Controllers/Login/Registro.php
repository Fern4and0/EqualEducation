<?php
// Controllers/Registro.php

// Incluimos la conexión a la base de datos
include '../../DB/DB.php';

// Iniciamos la sesión
session_start();

// Verificamos si el usuario ya está registrado (es decir, si ya tiene una sesión activa)
if (isset($_SESSION['user_id'])) {
    // Si el usuario ya tiene una sesión activa, redirigimos al dashboard o al perfil
    header('Location: ../../inicio.php'); // O puedes redirigir a la página de perfil
    exit();
}

// Verificamos si el método de la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $nombre = $_POST['nombre']; // Recoge el nombre del formulario
    $email = $_POST['email']; // Recoge el email del formulario
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hasheamos la contraseña usando BCRYPT

    // Asignar rol_id por defecto
    $id_rol = 5; // Por ejemplo, rol de usuario común (coordinador, según tus roles)

    // Verificamos si el correo ya está registrado en la base de datos
    $sqlCheckEmail = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sqlCheckEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si ya existe un usuario con ese correo, mostramos un mensaje de error
        $_SESSION['error_message'] = "El correo electrónico ya está registrado.";
        header('Location: ../../Resources/views/login.php'); // Redirigimos a la página de inicio de sesión
        exit();
    }

    // Si el correo no está registrado, procedemos a insertar el nuevo usuario
    $sql = "INSERT INTO users (nombre, email, direccion, password, id_rol, created_at, updated_at) 
            VALUES ('$nombre', '$email', 'Los patos', '$password', '$id_rol', NOW(), NOW())";

    // Ejecuta la consulta y verifica si fue exitosa
    if ($conn->query($sql) === TRUE) {
        // Iniciar sesión automáticamente
        $_SESSION['user_id'] = $conn->insert_id; // Guarda el ID del usuario en la sesión
        $_SESSION['user_name'] = $nombre; // Guarda el nombre del usuario en la sesión
        $_SESSION['user_email'] = $email; // Guarda el email del usuario en la sesión
        $_SESSION['user_role'] = $id_rol; // Guarda el rol del usuario en la sesión
        $_SESSION['registered_email'] = $email; // Guarda el email registrado en la sesión
        $_SESSION['registered_password'] = $_POST['password']; // Guarda la contraseña registrada en la sesión

        // Redirigir al dashboard
        header('Location: ../../inicio.php');
        exit();
    } else {
        // Muestra un mensaje de error si la consulta falló
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
