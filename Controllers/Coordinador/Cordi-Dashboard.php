<?php
// Controllers/Coordinador/Cordi-Dashboard.php

session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Resources/Views/Login.html"); // Redirige al login si no está autenticado
    exit(); // Detiene la ejecución
}

include '../../DB/db.php'; // Incluye la conexión a la base de datos

$user_id = $_SESSION['user_id'];

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

$sql = "SELECT id, nombre, descripcion, fecha_ini, fecha_fin, foto FROM programas WHERE users_id = $user_id"; //cambiar el 2 por el id del coordinador
$consulta = $conn->query($sql);

$fecha_actual = date('Y-m-d');

// Cerrar la conexión a la base de datos

?>

<!DOCTYPE html>
<html lang="en"></html>
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
<?php include 'layout/header.php'; ?>
    <div class="contenedor-programas">
    <?php
        if ($consulta->num_rows > 0) {
            // Mostrar los productos en divs
            while($row = $consulta->fetch_assoc()) {
                $id = $row['id'];
                $sql2 = "SELECT id, nombre, descripcion, fecha, hora, user_id FROM actividades WHERE programa_id = $id"; //cambiar el 2 por el id del coordinador
                $sqlActividades = $conn->query($sql2);
                echo '
                <div class="programa">
                    <img src="../../Public/image/' . $row["id"] .'.png" alt="Imagen del programa">
                <div class="programa-contenido">
                <h3>' . $row["nombre"] . '</h3>
                <p>' . $row["descripcion"] . '</p>
                <div class="acciones">  
                    <button id="open-eliminar-'.$id.'" class="btn-eliminar" onClick="eliminarPrgm('.$id.')">Eliminar</button>
                    <button id="open-editar-'.$id.'" class="btn-editar" onClick="editarPrgm('.$id.')">Editar</button>
                    <button class="btn-actividades" style="margin-right: auto;">Actividades</button>
                </div>
                <div class="extra-contenido">
                    <button id="open-act-'.$id.'" class="crearAct" onClick="crearAct('.$id.')">Crear Actividad<i class="bi bi-clipboard-plus" style="font-size: 20px; margin-left: 10px"></i></button>';
                    while($row2 = $sqlActividades->fetch_assoc()){
                        $idAct = $row2['id'];
                        $sql3 = "SELECT * FROM vista_voluntarios"; 
                        $sqlVoluntarios = $conn->query($sql3);
                    echo '
                    <div class="accordion mt-3" id="accordionExample-'.$idAct.'">
                        <div class="accordion-item border-0 rounded">
                            <h2 class="accordion-header" id="heading-'.$idAct.'">
                                <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-'.$idAct.'" aria-expanded="false" aria-controls="collapse-'.$idAct.'">
                                    ' . $row2["nombre"] . '
                                </button>
                            </h2>
                            <div id="collapse-'.$idAct.'" class="accordion-collapse collapse" aria-labelledby="heading-'.$idAct.'" data-bs-parent="#accordionExample-'.$idAct.'">
                                <div class="accordion-body position-relative">
                                    <button class="btn position-absolute top-0 end-0 m-2" style="background-color: #75f156; padding: 2px 4px; font-size: 15px;" id="open-volun-'.$idAct.'" onClick="agregarVolun('.$idAct.')"><i class="bi bi-person-add" style="margin-right: 10px; font-size: 20px;"></i>Agregar voluntario</button>
                                    <div style="display: flex; gap: 10px;">
                                        <span style="font-weight: bold;"><i style="margin-right: 5px;" class="bi bi-calendar"></i>Fecha:</span>
                                        <span>' . $row2["fecha"] . '</span>
                                        <span style="font-weight: bold;"><i style="margin-right: 5px;" class="bi bi-clock"></i>Hora:</span>
                                        <span>' . $row2["hora"] . '</span>
                                    </div>
                                    <span style="margin-top: 10px;">' . $row2["descripcion"] . '</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <dialog id="modal-volun-'.$idAct.'" class="modalVolun">
                        <div class="volunContent">
                        <h2>Agregar voluntario</h2>
                            <form action="agregarVoluntario.php" method="POST">';
                            while($row3 = $sqlVoluntarios->fetch_assoc()){
                                $idVolun = $row3['id'];
                            echo '
                                <div class="accordion" id="accordionExample-'.$idVolun.'">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header d-flex align-items-center" id="heading-'.$idVolun.'">
                                            <div class="form-check me-3">
                                                <input type="hidden" name="idAct" value="'.$idAct.'">
                                                <input class="form-check-input" type="radio" id="radio-'.$idVolun.'" name="responsable" value="'.$idVolun.'" required style="margin-left: 2px">
                                                <label class="form-check-label visually-hidden" for="radio-'.$idVolun.'">
                                                    Seleccionar voluntario 1
                                                </label>
                                            </div>
                                            <button class="accordion-button collapsed flex-grow-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-'.$idVolun.'" aria-expanded="false" aria-controls="collapse-'.$idVolun.'">
                                                ' . $row3["nombre"] . '
                                            </button>
                                        </h2>
                                        <div id="collapse-'.$idVolun.'" class="accordion-collapse collapse" aria-labelledby="heading-'.$idVolun.'" data-bs-parent="#accordionExample-'.$idVolun.'">
                                            <div class="accordion-body">
                                                <div style="display: flex; gap: 10px;">
                                                    <span style="font-weight: bold;"><i style="margin-right: 5px;" class="bi bi-person-vcard"></i>Ocupacion:</span>
                                                    <span>' . $row3["ocupacion"] . '</span>
                                                    <span style="font-weight: bold;"><i style="margin-right: 5px;" class="bi bi-geo-alt"></i>Localidad:</span>
                                                    <span>' . $row3["localidad"] . '</span>
                                                    <span style="font-weight: bold;">Disponibilidad:</span>
                                                    <span>' . $row3["disponibilidad"] . '</span>
                                                </div>
                                                <span style="font-weight: bold; margin-top: 20px;">Habilidades:</span>
                                                <span>' . $row3["habilidades"] . '</span>
                                                <span style="font-weight: bold;">Motivacion:</span>
                                                <span>' . $row3["motivacion"] . '</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';}
                            echo'
                            <div class="eliminar-footer">
                                <button id="volun" type="submit">Eliminar</button>
                                <button type="button" id="close-volun-'.$idAct.'">Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </dialog>
                    ';}
                echo '</div>
            </div>
        </div>
                    
                
        <dialog id="modal-eliminar-'.$id.'" class="modalEliminar">
            <div class="eliminarContent">
                <form action="eliminarPrograma.php" method="POST">
                <input type="hidden" name="id" value="'.$id.'">
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
                <form action="editarPrograma.php" method="POST" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <input type="hidden" name="id_programa" value="'.$id.'">
                        <input type="hidden" name="user_id" value="'.$user_id.'"> <!-- Cambiar el user_id -->
                        <input class="form-control" id="floatingInput" name="nombre" placeholder="name@example.com" required>
                        <label for="floatingInput">Titulo</label>
                    </div>
                    <div class="mb-3">
                    <label for="formFile" class="form-label">Imagen</label>
                    <input class="form-control" type="file" id="formFile" name="foto" accept="image/png" required>
                </div>
                <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="numericInput" name="cupo_maximo" placeholder="0" min="1" max="200" required>
                        <label for="numericInput">Cupo maximo</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="selectInput1" name="tipo" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Curso</option>
                            <option value="2">Taller</option>
                            <option value="3">Seminario</option>
                            <option value="4">Conferencia</option>
                        </select>
                        <label for="selectInput1">Tipo de programa</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="floatingInput" name="ubicacion" placeholder="" required>
                        <label for="floatingInput">Ubicación</label>
                    </div>
                </div>
                </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="floatingInput" name="fecha_ini" placeholder="name@example.com" min="'.$fecha_actual.'" required>
                        <label for="floatingInput">Fecha de inicio</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="floatingInput" name="fecha_fin" placeholder="name@example.com" min="'.$fecha_actual.'" requires>
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
        </dialog>
        
        <dialog id="modal-act-'.$id.'" class="modalAct"> 
            <div class="actContent">
                <h2>Crear actividad</h2>
                <form action="crearAct.php" method="POST" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <input type="hidden" name="programa_id" value="'.$id.'">
                        <input class="form-control" id="floatingInput" name="nombreAct" placeholder="name@example.com" required>
                        <label for="floatingInput">Titulo</label>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <!-- Input de fecha -->
                        <div class="form-floating me-2 flex-grow-1">
                            <input type="date" class="form-control" id="floatingDate" name="fechaAct" placeholder="Fecha de inicio" min="'.$fecha_actual.'" required>
                            <label for="floatingDate">Fecha</label>
                        </div>
                        <!-- Input de hora -->
                        <div class="form-floating">
                            <input 
                                type="time" 
                                class="form-control" 
                                id="floatingTime" 
                                name="hora" 
                                placeholder="Hora de inicio" 
                                required
                                min="08:00" 
                                max="15:00">
                            <label for="floatingTime">Hora de inicio</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="descripcionAct" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Descripción</label>
                    </div>
                    <!-- Botones para crear o cancelar -->
                    <div class="modal-footer">
                        <button id="crear" type="submit">Crear</button>
                        <button type="button" id="close-act-'.$id.'">Cancelar</button>
                    </div>
                </form>
            </div>
        </dialog>';
            }
        } else {
            // Si no hay resultados
            echo "<p>No hay programas disponibles</p>";
        }
        $conn->close(); // Cierra la conexión a la base de datos
        ?>
    </div>
    <div class="boton-crear">
    <button class="crear-act" id="openModalBtn">
        Crear programa<br>
        <i style="font-weight: bold; font-size: 30px;" class="bi bi-plus-lg"></i>
    </button></div>
    <dialog id="modal" class="modal">
        <div class="modal-content">
            <h2>Crear programa</h2>
            <form action="crearPrograma.php" method="POST" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>"> <!-- Cambiar el user_id -->
                    <input class="form-control" id="floatingInput" name="nombre" placeholder="" required>
                    <label for="floatingInput">Titulo</label>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Imagen</label>
                    <input class="form-control" type="file" id="formFile" name="foto" accept="image/png" required>
                </div>
                <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="numericInput" name="cupo_maximo" placeholder="0" min="1" max="200" required>
                        <label for="numericInput">Cupo maximo</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="selectInput1" name="tipo" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Curso</option>
                            <option value="2">Taller</option>
                            <option value="3">Seminario</option>
                            <option value="4">Conferencia</option>
                        </select>
                        <label for="selectInput1">Tipo de programa</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="floatingInput" name="ubicacion" placeholder="" required>
                        <label for="floatingInput">Ubicación</label>
                    </div>
                </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="floatingInput" name="fecha_ini" placeholder="" min="<?php echo $fecha_actual; ?>" required>
                    <label for="floatingInput">Fecha de inicio</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="floatingInput" name="fecha_fin" placeholder="" min="<?php echo $fecha_actual; ?>" required>
                    <label for="floatingInput">Fecha de conclusion</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" name="descripcion" placeholder="" id="floatingTextarea" style="height: 100px;"></textarea>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const botonesActividades = document.querySelectorAll('.btn-actividades');

        botonesActividades.forEach(boton => {
            boton.addEventListener('click', () => {
                const programa = boton.closest('.programa');
                programa.classList.toggle('expandido');
            });
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../Resources/js/programas.js"></script>
</body>
</html>
