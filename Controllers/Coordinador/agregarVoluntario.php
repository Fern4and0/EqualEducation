<?php

session_start();

include '../../DB/DB.php';

$act_id = $_POST["idAct"];
$voluntario_id = $_POST["responsable"];

// Preparar la consulta SQL para insertar datos
$sql = "UPDATE actividades SET user_id = '$voluntario_id' WHERE id = '$act_id'";

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