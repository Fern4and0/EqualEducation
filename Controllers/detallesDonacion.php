<?php

session_start();

include '../DB/DB.php';

// Recibir los datos JSON
$detalles = json_decode(file_get_contents('php://input'), true);

$cantidad = $detalles['amt'];

// Preparar la consulta SQL para insertar datos
$sql = "INSERT INTO donaciones (monto, donante_id)  
        VALUES ('$cantidad', '6')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Registro agregado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar conexión
$conn->close();

?>