<?php

session_start();

include '../../DB/DB.php';

$programaid = $_POST["id"];
$user_id = $_POST["user_id"];

// Preparar la consulta SQL para insertar datos
$sql = "DELETE FROM programas WHERE id = $programaid AND users_id = $user_id";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    header("Location: /EqualEducation/Controllers/Coordinador/Cordi-Dashboard.php");
    die();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar conexión
$conn->close();

?>