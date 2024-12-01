<?php

session_start();

include '../DB/DB.php';

$programa_id = $_POST["programa_id"];
$user_id = $_POST["user_id"];
$fecha = $_POST["fecha_incripcion"];

// Preparar la consulta SQL para insertar datos
$sql = "INSERT INTO users_programa (beneficiario_id, programa_id, fecha_inscripcion)
        VALUES ('$user_id', '$programa_id', '$fecha')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    header("Location: /EqualEducation/Resources/views/index.php");
    die();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar conexión
$conn->close();

?>