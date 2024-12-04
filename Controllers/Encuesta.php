<?php
session_start(); // Inicia la sesión

// Incluye la conexión a la base de datos
include '../DB/DB.php';

// Verifica si el método de la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica si se ha enviado el ID del programa
    if (isset($_POST['programa_id'])) {
        $programa_id = intval($_POST['programa_id']); // Asegura que sea un entero

        // Si no se recibe un programa válido, muestra un mensaje de error
        if (!$programa_id) {
            $_SESSION['error_message'] = "No se especificó un programa válido.";
            echo "No encuentro programa.";
            exit();
        }

        // Aquí procesas las respuestas de la encuesta
        $preguntas = [
            'pregunta1', 'pregunta2', 'pregunta3', 'pregunta4', 
            'pregunta5', 'pregunta6', 'pregunta7', 'pregunta8', 'pregunta9'
        ];

        foreach ($preguntas as $pregunta) {
            if (isset($_POST[$pregunta])) {
                $respuesta = strtolower($_POST[$pregunta]); // Capturar y normalizar la respuesta
                $pregunta_id = intval(substr($pregunta, -1)); // ID de la pregunta basado en su nombre

                // Construir la consulta SQL
                $sql = "
                    INSERT INTO respuestas (id_programa, id_pregunta, $respuesta)
                    VALUES (?, ?, 1)
                    ON DUPLICATE KEY UPDATE $respuesta = $respuesta + 1;
                ";
                $stmt = $conn->prepare($sql);

                // Vincular parámetros
                $stmt->bind_param("ii", $programa_id, $pregunta_id);

                if (!$stmt->execute()) {
                    $_SESSION['error_message'] = "Error al procesar la pregunta $pregunta_id: " . $stmt->error;
                    echo "Error en la base de datos.";
                    exit();
                }
            }
        }

        // Redirige con mensaje de éxito
        $_SESSION['success_message'] = "Gracias por completar la encuesta.";
        header('Location: Beneficiario/programas.php');
        exit();
    } else {
        // Si no se recibe el programa_id, muestra un error
        $_SESSION['error_message'] = "No se ha enviado el ID del programa.";
        echo "No se ha recibido el ID del programa.";
        exit();
    }
}
?>