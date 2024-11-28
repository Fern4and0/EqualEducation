<?php 
include '../../../DB/db.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $ocupacion = $_POST['ocupacion'];
    $motivacion = $_POST['motivacion'];
    $localidad = $_POST['localidad'];
    $habilidades_tecnicas = $_POST['habilidades_tecnicas'];
    $disponibilidad = $_POST['disponibilidad'];

    $query = "UPDATE voluntarios 
              SET ocupacion = ?, motivacion = ?, localidad = ?, habilidades_tecnicas = ?, disponibilidad = ? 
              WHERE user_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $ocupacion, $motivacion, $localidad, $habilidades_tecnicas, $disponibilidad, $user_id);

    if ($stmt->execute()) {
        header("Location: ../Perfil.php"); // Redirige de nuevo a la página de perfil del voluntario
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
