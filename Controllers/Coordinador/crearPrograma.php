<?php

session_start();

include '../../DB/DB.php';

$user_id = $_POST["user_id"];
$nombre = $_POST["nombre"];
$ubicacion = $_POST["ubicacion"];
$cupo_maximo = $_POST["cupo_maximo"];
$tipo = $_POST["tipo"];
$fecha_ini = $_POST["fecha_ini"];
$fecha_fin = $_POST["fecha_fin"];
$descripcion = $_POST["descripcion"];

$nombreFoto = $_FILES["foto"]["name"];
$rutaTemporal = $_FILES["foto"]["tmp_name"];
$extensionImagen = strtolower(pathinfo($nombreFoto,PATHINFO_EXTENSION));
$directorio = "../../Public/image/";



// Preparar la consulta SQL para insertar datos
$sql = "INSERT INTO programas (nombre, descripcion, fecha_ini, fecha_fin, foto, ubicacion, cupo_maximo, tipo, users_id)
        VALUES ('$nombre','$descripcion', '$fecha_ini', '$fecha_fin', '$nombreFoto', '$ubicacion', '$cupo_maximo', '$tipo', '$user_id')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    $idimg = $conn->insert_id;
    $rutaFinal = $directorio.$idimg.".".$extensionImagen;
    if(move_uploaded_file($rutaTemporal,$rutaFinal)){
        header("Location: /EqualEducation/Controllers/Coordinador/Cordi-Dashboard.php");
        die();
    }else{
        echo "error al guardar";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar conexión
$conn->close();

?>