<?php 
include '../../../DB/db.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $nombre = $_POST['nombre'];
    $localidad = $_POST['localidad'];
    $ocupacion = $_POST['ocupacion'];
    $preferencias_educativas = $_POST['preferencias_educativas'];
    $razon = $_POST['razon'];

    $query = "UPDATE beneficiarios 
              SET localidad = ?, ocupacion = ?, preferencias_educativas = ?, razon = ? 
              WHERE user_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $localidad, $ocupacion, $preferencias_educativas, $razon, $user_id);

    if ($stmt->execute()) {
        header("Location: ../Perfil.php"); // Redirige de nuevo a la página de beneficiarios
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>