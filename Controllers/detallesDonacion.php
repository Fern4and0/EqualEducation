<?php

session_start();

include '../DB/DB.php';

// Recibir el ID del donante y los detalles de la donación
$detalles = json_decode(file_get_contents('php://input'), true);
$donante_id = $detalles['donante_id'] ?? null;

// Verificar si se recibieron los detalles correctamente
if ($detalles) {
    // Obtener la cantidad de la donación
    $cantidad = $detalles['amt'];

    // Preparar la consulta SQL para insertar datos
    $sql = "INSERT INTO donaciones (monto, donante_id)  
            VALUES ('$cantidad', '$donante_id')"; // Usar el ID del donante que viene del formulario

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Registro agregado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No se recibieron detalles de la donación.";
}

// Cerrar conexión
$conn->close();

?>
