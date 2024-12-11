<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.html"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Incluye la conexión a la base de datos

// Consulta para obtener el total de usuarios registrados
$sqlUsuarios = "SELECT COUNT(*) AS total_usuarios FROM users";
$resultUsuarios = $conn->query($sqlUsuarios); // Ejecuta la consulta
$totalUsuarios = $resultUsuarios->fetch_assoc()['total_usuarios']; // Obtiene el resultado de la consulta

// Consulta para obtener las donaciones totales
$sqlDonaciones = "SELECT COALESCE(SUM(monto), 0) AS total_donaciones FROM donaciones";
$resultDonaciones = $conn->query($sqlDonaciones); // Ejecuta la consulta
$totalDonaciones = $resultDonaciones->fetch_assoc()['total_donaciones']; // Obtiene el resultado de la consulta

// Consulta para obtener la cantidad de beneficiarios registrados
$sqlBeneficiarios = "SELECT COUNT(*) AS total_beneficiarios FROM beneficiarios";
$resultBeneficiarios = $conn->query($sqlBeneficiarios); // Ejecuta la consulta
$totalBeneficiarios = $resultBeneficiarios->fetch_assoc()['total_beneficiarios']; // Obtiene el resultado de la consulta

$sql = "SELECT id, nombre, descripcion, fecha_ini, fecha_fin, foto, ubicacion, cupo_maximo, tipo, estatus, created_at FROM programas ORDER BY id";
$consulta = $conn->query($sql);
// Cerrar la conexión a la base de datos
$conn->close(); // Cierra la conexión a la base de datos

// Verifica si la traducción está activada desde administradores.php
$translationEnabled = true; // Cambia esto según tu lógica para verificar si la traducción está activada

if ($translationEnabled) {
    // URL de la API de Google Translate
    $url = "https://translation.googleapis.com/language/translate/v2";
    $apiKey = "YOUR_GOOGLE_API_KEY"; // Reemplaza con tu clave de API de Google

    // Texto a traducir (contenido de la página)
    ob_start();
    include('layout/header.php');
    $pageContent = ob_get_clean();

    // Datos para la solicitud POST
    $data = [
        'q' => $pageContent,
        'target' => 'en',
        'format' => 'html',
        'source' => 'es',
        'key' => $apiKey
    ];

    // Configuración de la solicitud cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecuta la solicitud y obtiene la respuesta
    $response = curl_exec($ch);
    curl_close($ch);

    // Decodifica la respuesta JSON
    $responseDecoded = json_decode($response, true);

    // Verifica si la traducción fue exitosa
    if (isset($responseDecoded['data']['translations'][0]['translatedText'])) {
        $translatedContent = $responseDecoded['data']['translations'][0]['translatedText'];
        echo $translatedContent;
    } else {
        echo "Error en la traducción.";
    }
} else {
    include('layout/header.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinador Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Resources/css/styles_coordinadores.css">
    <link rel="stylesheet" href="../../Resources/css/styles_modal.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 0 !important;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include('layout/header.php') ?>

<div class="contenedor-programas">
    <?php
    if ($consulta->num_rows > 0) {
        // Mostrar los productos en divs
        while($row = $consulta->fetch_assoc()) {
            $id = $row['id'];
            echo '
            <div class="programa">
                <img src="../../Public/image/img2.jpeg" alt="Imagen del programa">
                <div class="programa-contenido">
                    <h3>' . $row["nombre"] . '</h3>
                    <p>' . $row["descripcion"] . '</p>
                    <select name="status" id="status" required>
                        <option value="inac">Inactivo</option>
                        <option value="Enprog">En progreso</option>
                        <option value="Fin">Finalizado</option>
                    </select>
                    <div class="acciones">  
                        <button class="btn-ver">Ver cronograma</button>
                        <button id="open-editar-'.$id.'" class="btn-editar" onClick="editarPrgm('.$id.')">Editar</button>
                        <button id="open-eliminar-'.$id.'" class="btn-eliminar" onClick="eliminarPrgm('.$id.')">Eliminar</button>
                    </div>
                </div>
            </div>

            <dialog id="modal-eliminar-'.$id.'" class="modalEliminar">
                <div class="eliminarContent">
                    <form action="eliminarPrograma.php" method="POST">
                        <input type="hidden" name="id" value="'.$id.'">
                        <input type="hidden" name="user_id" value="2"> <!-- Cambiar el user_id -->
                        <span>¿Estas seguro que quieres eliminar este programa?</span>
                        <div class="eliminar-footer">
                            <button id="eliminar" type="submit">Eliminar</button>
                            <button type="button" id="close-eliminar-'.$id.'">Cancelar</button>
                        </div>
                    </form>
                </div>
            </dialog>
            <dialog id="modal-editar-'.$id.'" class="modalEditar">
                <div class="editarContent">
                    <h2>Editar programa</h2>
                    <form action="editarPrograma.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="hidden" name="id" value="'.$id.'">
                            <input type="hidden" name="user_id" value="2"> <!-- Cambiar el user_id -->
                            <input class="form-control" id="floatingInput" name="nombre" placeholder="name@example.com">
                            <label for="floatingInput">Titulo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="floatingInput" name="fecha_ini" placeholder="name@example.com">
                            <label for="floatingInput">Fecha de inicio</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="floatingInput" name="fecha_fin" placeholder="name@example.com">
                            <label for="floatingInput">Fecha de conclusion</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" name="descripcion" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Descripción</label>
                        </div>
                        <!-- Botones para crear o cancelar -->
                        <div class="modal-footer">
                            <button id="crear" type="submit">Editar</button>
                            <button type="button" id="close-editar-'.$id.'">Cancelar</button>
                        </div>
                    </form>
                </div>
            </dialog>';
        }
    } else {
        // Si no hay resultados
        echo "<p>No hay programas disponibles</p>";
    }
    ?>
</div>
<div class="boton-crear">
    <button class="crear-act" id="openModalBtn">
        Crear programa<br>
        <i style="font-weight: bold; font-size: 30px;" class="bi bi-plus-lg"></i>
    </button>
</div>
<dialog id="modal" class="modal">
    <div class="modal-content">
        <h2>Crear programa</h2>
        <form action="crearPrograma.php" method="POST">
            <div class="form-floating mb-3">
                <input type="hidden" name="user_id" value="2"> <!-- Cambiar el user_id -->
                <input class="form-control" id="floatingInput" name="nombre" placeholder="name@example.com">
                <label for="floatingInput">Titulo</label>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="floatingInput" name="fecha_ini" placeholder="name@example.com">
                <label for="floatingInput">Fecha de inicio</label>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="floatingInput" name="fecha_fin" placeholder="name@example.com">
                <label for="floatingInput">Fecha de conclusion</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" name="descripcion" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                <label for="floatingTextarea">Descripción</label>
            </div>
            <!-- Botones para crear o cancelar -->
            <div class="modal-footer">
                <button id="crear" type="submit">Crear</button>
                <button type="button" id="closeModalBtn">Cancelar</button>
            </div>
        </form>
    </div>
</dialog>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../../Resources/js/programas.js"></script>
</body>
</html>
