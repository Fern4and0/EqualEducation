<?php
session_start(); // Iniciamos la sesión

include '../../DB/DB.php'; // Incluimos la conexión a la base de datos

$error = ''; // Inicializamos la variable de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['resetEmail'])) {
        $email = $_POST['resetEmail'];

        // Preparación de la consulta para evitar inyecciones SQL
        $sql = "SELECT id, email FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Aquí puedes enviar un correo electrónico con el enlace de restablecimiento de contraseña
            // Por simplicidad, vamos a redirigir al usuario a la página de restablecimiento de contraseña
            $_SESSION['reset_email'] = $email;
            header("Location: ../../Controllers/Login/ResetPassword.php");
            exit();
        } else {
            $error = "El correo electrónico no está registrado.";
        }

        $stmt->close();
    } elseif (isset($_POST['newPassword'])) {
        $newPassword = $_POST['newPassword'];
        $email = $_SESSION['reset_email'];

        // Validar la nueva contraseña
        if (strlen($newPassword) >= 8 && preg_match('/[a-z]/', $newPassword) && preg_match('/[A-Z]/', $newPassword) && preg_match('/[0-9]/', $newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashedPassword, $email);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['password_reset_success'] = true;
                header("Location: ../../Resources/Views/login.php"); // Redirigir al login
                exit();
            } else {
                $error = "Error al restablecer la contraseña.";
            }

            $stmt->close();
        } else {
            $error = "La contraseña debe tener al menos 8 caracteres, incluyendo letras mayúsculas, minúsculas y números.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../../Resources/css/styles_login.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['reset_email'])): ?>
            <div class="form-container">
                <form method="post" action="">
                    <h1>Escriba la nueva contraseña</h1>
                    <div class="infield">
                        <input type="password" id="newPassword" name="newPassword" required placeholder="Nueva contraseña"/>
                        <label for="newPassword"></label>
                        <div id="passwordStrength"></div>
                    </div>
                    <button type="submit">Restablecer contraseña</button>
                </form>
            </div>
        <?php else: ?>
            <div class="form-container">
                <form method="post" action="">
                    <h1>Restablecer contraseña</h1>
                    <div class="infield">
                        <input type="email" id="resetEmail" name="resetEmail" required placeholder="Correo electrónico"/>
                        <label for="resetEmail"></label>
                    </div>
                    <button type="submit">Enviar enlace de restablecimiento</button>
                </form>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
    <script>
        var newPassword = document.getElementById('newPassword');
        var passwordStrength = document.getElementById('passwordStrength');

        newPassword.addEventListener('input', function() {
            var val = newPassword.value;
            var strength = 0;

            if (val.length >= 8) strength++;
            if (val.match(/[a-z]+/)) strength++;
            if (val.match(/[A-Z]+/)) strength++;
            if (val.match(/[0-9]+/)) strength++;

            switch (strength) {
                case 0:
                case 1:
                    passwordStrength.innerHTML = '<span style="color:red">Baja</span>';
                    break;
                case 2:
                    passwordStrength.innerHTML = '<span style="color:orange">Media</span>';
                    break;
                case 3:
                case 4:
                    passwordStrength.innerHTML = '<span style="color:green">Alta</span>';
                    break;
            }
        });
    </script>
</body>
</html>
