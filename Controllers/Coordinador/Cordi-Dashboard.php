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

$sql = "SELECT id, nombre, descripcion, fecha_ini, fecha_fin, foto FROM programas"; //cambiar el 2 por el id del coordinador
$consulta = $conn->query($sql);

$fecha_actual = date('Y-m-d');

// Cerrar la conexión a la base de datos
$conn->close(); // Cierra la conexión a la base de datos
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Coordinador Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Index.php' ? 'active' : ''; ?>" href="../../Resources/views/index.html"><i class="fas fa-home"></i> Inicio</a></a>
                </li>
                <li class="nav-item">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRoles" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gestion de Usuarios
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownRoles">
                            <a class="dropdown-item" href="Tabla/Beneficiarios.php">Beneficiarios</a>
                            <a class="dropdown-item" href="Tabla/Voluntarios.php">Voluntarios</a>
                        </div>
                    </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Informes.php">Informes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Donadores.php">Donaciones</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../Login/Logout.php">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="contenedor-programas">
    <?php
        if ($consulta->num_rows > 0) {
            // Mostrar los productos en divs
            while($row = $consulta->fetch_assoc()) {
                $id = $row['id'];
                echo '
                <div class="programa">
                    <img src="../../Public/image/' . $row["id"] .'.png" alt="Imagen del programa">
                <div class="programa-contenido">
                <h3>' . $row["nombre"] . '</h3>
                <p>' . $row["descripcion"] . '</p>
                <div class="acciones">  
                    <button id="open-eliminar-'.$id.'" class="btn-eliminar" onClick="eliminarPrgm('.$id.')">Eliminar</button>
                    <button id="open-editar-'.$id.'" class="btn-editar" onClick="editarPrgm('.$id.')">Editar</button>
                    <div class="dropdown">
                                <button id="dropdown-btn-'.$id.'" class="btn-actividades" onClick="toggleDropdown('.$id.')">Actividades</button>
                                <div id="dropdown-menu-'.$id.'" class="dropdown-menu">
                                    <button class="dropdown-item" onClick="crearActividad('.$id.')">Crear Actividad</button>
                                    <button class="dropdown-item" onClick="mostrarActividades('.$id.')">Mostrar Actividades</button>
                                </div>
                            </div>
                </div>
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
                        <input type="hidden" name="user_id" value="2"> <!-- Cambiar el user_id -->
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
                        <input type="hidden" name="user_id" value="2"> <!-- Cambiar el user_id -->
                        <input class="form-control" id="floatingInput" name="nombre" placeholder="name@example.com" required>
                        <label for="floatingInput">Titulo</label>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <!-- Input de fecha -->
                        <div class="form-floating me-2 flex-grow-1">
                            <input type="date" class="form-control" id="floatingDate" name="fecha" placeholder="Fecha de inicio" min="'.$fecha_actual.'" required>
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
                        <textarea class="form-control" name="descripcion" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Descripción</label>
                    </div>
                    <!-- Botones para crear o cancelar -->
                    <div class="modal-footer">
                        <button id="crear" type="submit">Editar</button>
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
    <!-- Modal para Crear Actividad -->
<div id="crearActividadModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCrearActividadModal()">&times;</span>
        <h3>Crear Actividad</h3>
        <form id="crearActividadForm">
            <label for="actividad-nombre">Nombre:</label>
            <input type="text" id="actividad-nombre" name="nombre" required>

            <label for="actividad-descripcion">Descripción:</label>
            <textarea id="actividad-descripcion" name="descripcion" required></textarea>

            <label for="actividad-fecha">Fecha:</label>
            <input type="date" id="actividad-fecha" name="fecha" required>

            <label for="actividad-hora">Hora:</label>
            <input type="time" id="actividad-hora" name="hora" required>

            <label for="actividad-estado">Estado:</label>
            <select id="actividad-estado" name="estado" required>
                <option value="pendiente">Pendiente</option>
                <option value="en progreso">En Progreso</option>
                <option value="completado">Completado</option>
            </select>

            <button type="submit" class="btn-submit">Guardar</button>
        </form>
    </div>
</div>
<!-- Modal para Mostrar Actividades -->
<div id="modalMostrarActividades" class="modal-tab">
    <div class="modal-content-tab">
        <span class="close" onclick="cerrarModalMostrarActividades()">&times;</span>
        <h3>Actividades</h3>
        <table id="actividades-table" border="2">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <!-- Las actividades se agregarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>
</div>
    <script>
        // Función para abrir el modal y cargar actividades
// Función para abrir el modal y cargar las actividades
function mostrarActividades(id) {
    console.log("Mostrando actividades para el id: " + id); // Agrega este log para verificar si la función es llamada

    // Aquí es donde recuperamos las actividades relacionadas con el id
    // Usamos datos de ejemplo por ahora
    const actividades = [
        { nombre: 'Actividad 1', descripcion: 'Descripción de Actividad 1', fecha: '12/12/2024', hora: '10:00 AM', estado: 'Pendiente' },
        { nombre: 'Actividad 2', descripcion: 'Descripción de Actividad 2', fecha: '13/12/2024', hora: '11:00 AM', estado: 'En progreso' },
        { nombre: 'Actividad 3', descripcion: 'Descripción de Actividad 3', fecha: '14/12/2024', hora: '12:00 PM', estado: 'Finalizada' }
    ];

    // Mostrar el modal
    const modal = document.getElementById('modalMostrarActividades');
    modal.style.display = "block"; // Aseguramos que el modal sea visible

    // Llenar la tabla con las actividades
    const tableBody = document.getElementById('actividades-table').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = ''; // Limpiar las filas anteriores

    actividades.forEach(actividad => {
        const row = tableBody.insertRow();
        row.insertCell(0).textContent = actividad.nombre;
        row.insertCell(1).textContent = actividad.descripcion;
        row.insertCell(2).textContent = actividad.fecha;
        row.insertCell(3).textContent = actividad.hora;
        row.insertCell(4).textContent = actividad.estado;
    });
    function mostrarActividades(id) {
    console.log("Clic en Mostrar Actividades. ID:", id); // Verifica que esta línea se ejecute al hacer clic
    // Resto del código...
}
}

// Función para cerrar el modal
function cerrarModalMostrarActividades() {
    const modal = document.getElementById('modalMostrarActividades');
    modal.style.display = "none"; // Ocultamos el modal
}

// Cerrar el modal si se hace clic fuera de él
window.onclick = function(event) {
    const modal = document.getElementById('modalMostrarActividades');
    if (event.target == modal) {
        modal.style.display = "none"; // Cierra el modal si se hace clic fuera de él
    }
};
    </script>
    <script>
     // Función para abrir el modal de Crear Actividad
function crearActividad(id) {
    const modal = document.getElementById('crearActividadModal');
    modal.style.display = 'block';

    // Si necesitas asociar el ID del programa a la actividad
    document.getElementById('crearActividadForm').dataset.programId = id;
}

// Función para cerrar el modal
function closeCrearActividadModal() {
    const modal = document.getElementById('crearActividadModal');
    modal.style.display = 'none';
}

// Cerrar el modal si se hace clic fuera del contenido
window.onclick = function(event) {
    const modal = document.getElementById('crearActividadModal');
    if (event.target === modal) {
        closeCrearActividadModal();
    }
};

// Manejo del formulario de creación de actividades
document.getElementById('crearActividadForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const programId = e.target.dataset.programId; // ID del programa asociado
    const nombre = document.getElementById('actividad-nombre').value;
    const descripcion = document.getElementById('actividad-descripcion').value;
    const fecha = document.getElementById('actividad-fecha').value;
    const hora = document.getElementById('actividad-hora').value;
    const estado = document.getElementById('actividad-estado').value;

    // Aquí puedes agregar la lógica para enviar los datos al servidor
    console.log({
        programId,
        nombre,
        descripcion,
        fecha,
        hora,
        estado,
    });

    // Cerrar el modal después de guardar
    closeCrearActividadModal();
});
    </script>
    <script>
        function toggleDropdown(id) {
    const dropdownMenu = document.getElementById(`dropdown-menu-${id}`);
    const isVisible = dropdownMenu.classList.contains('show');

    // Cierra todos los dropdowns abiertos
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.remove('show');
    });

    // Si no estaba visible, lo muestra
    if (!isVisible) {
        dropdownMenu.classList.add('show');
    }
}

// Cerrar dropdowns si se hace clic fuera de ellos
window.onclick = function(event) {
    if (!event.target.matches('.btn-actividades')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    }
};
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../Resources/js/programas.js"></script>
</body>
</html>
