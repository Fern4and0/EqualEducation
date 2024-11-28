<?php
// Conexión a la base de datos (ajusta los datos de conexión)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ong";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: {$conn->connect_error}");
}

// Función para suspender una cuenta
function suspenderCuenta($id_usuario) {
    global $conn;
    $sql = "UPDATE users SET estatus_cuenta='Suspendido' WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: {$conn->error}");
    }
    $stmt->bind_param("i", $id_usuario);
    if (!$stmt->execute()) {
        die("Error executing statement: {$stmt->error}");
    }
    $stmt->close();
}
// Función para activar una cuenta
function activarCuenta($id_usuario) {
    global $conn;
    $sql = "UPDATE users SET estatus_cuenta='Activo' WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $id_usuario);
    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }
    $stmt->close();
}

// Función para obtener todos los usuarios
function obtenerUsuarios() {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    return $result;
}

// Obtener los usuarios
$usuarios = obtenerUsuarios();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Usuarios</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        button[name="suspender"] {
            background-color: #f44336;
        }
        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['suspender'])) {
            suspenderCuenta($_POST['id_usuario']);
        } elseif (isset($_POST['activar'])) {
            activarCuenta($_POST['id_usuario']);
        }
        // Refresh the page to reflect changes
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $usuarios->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['estatus_cuenta']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id_usuario" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="suspender">Suspender</button>
                            <button type="submit" name="activar">Activar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>