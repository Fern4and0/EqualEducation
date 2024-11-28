<?php

session_start();

include '../../DB/DB.php';

$id_programa = $_POST["id_programa"]; // Se requiere el ID del programa a actualizar
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
$extensionImagen = strtolower(pathinfo($nombreFoto, PATHINFO_EXTENSION));
$directorio = "../../Public/image/";

try {
    // Verificar si se subió una nueva imagen
    if (!empty($nombreFoto)) {
        // Obtener la imagen actual del programa
        $sql = "SELECT foto FROM programas WHERE id = '$id_programa'";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $fotoAnterior = $row["foto"];

            // Eliminar la imagen anterior si existe
            if (!empty($fotoAnterior)) {
                $rutaAnterior = $directorio . $fotoAnterior;
                if (file_exists($rutaAnterior)) {
                    unlink($rutaAnterior);
                }
            }
        }

        // Asignar nuevo nombre único a la imagen
        $nuevoNombreFoto = $id_programa . "." . $extensionImagen;
        $rutaFinal = $directorio . $nuevoNombreFoto;

        // Mover la nueva imagen al directorio
        if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
            $fotoActualizada = $nuevoNombreFoto;
        } else {
            throw new Exception("Error al guardar la nueva imagen.");
        }
    } else {
        // Si no se sube una nueva imagen, mantener la actual
        $fotoActualizada = null;
    }

    // Preparar la consulta de actualización
    $sql = "UPDATE programas 
            SET 
                nombre = '$nombre', 
                descripcion = '$descripcion', 
                fecha_ini = '$fecha_ini', 
                fecha_fin = '$fecha_fin', 
                ubicacion = '$ubicacion', 
                cupo_maximo = '$cupo_maximo', 
                tipo = '$tipo'";

    // Agregar foto solo si hay una nueva
    if ($fotoActualizada !== null) {
        $sql .= ", foto = '$fotoActualizada'";
    }

    $sql .= " WHERE id = '$id_programa' and users_id = '$user_id'";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        header("Location: /EqualEducation/Controllers/Coordinador/Cordi-Dashboard.php");
        die();
    } else {
        throw new Exception("Error al actualizar el programa: " . $conn->error);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Cerrar conexión
    $conn->close();
}

?>
