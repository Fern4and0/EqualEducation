<?php
session_start(); // Iniciamos la sesión

include '../../DB/DB.php'; // Incluimos la conexión a la base de datos

$error = ''; // Inicializamos la variable de error

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verificamos si la solicitud es de tipo POST
    $email = $_POST['email']; // Obtenemos el email del formulario
    $password = $_POST['password']; // Obtenemos el password del formulario

    // Preparación de la consulta para evitar inyecciones SQL
    $sql = "SELECT id, email, password, nombre, id_rol, estatus_cuenta FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { // Verificamos si la consulta devolvió algún resultado
        $user = $result->fetch_assoc(); // Obtenemos los datos del usuario

        // Verificamos si la cuenta está activa
        if ($user['estatus_cuenta'] === 'Activo') {
            // Verificamos si el password coincide
            if (password_verify($password, $user['password'])) { // Comparamos el password ingresado con el almacenado
                // Guardamos la información del usuario en la sesión
                $_SESSION['user_id'] = $user['id']; // Guardamos el ID del usuario en la sesión
                $_SESSION['user_name'] = $user['nombre']; // Guardamos el nombre del usuario en la sesión
                $_SESSION['user_email'] = $user['email']; // Guardamos el email del usuario en la sesión
                $_SESSION['user_rol'] = $user['id_rol']; // Guardamos el rol del usuario en la sesión

                header("Location: ../../Resources/views/index.php");
                exit(); // Terminamos la ejecución del script
            } else {
                $error = "Tus Credenciales son incorrectas, intenta de nuevo por favor."; // Mensaje de error si el password no coincide
            }
        } else {
            $error = "Cuenta suspendida"; // Mensaje de error si la cuenta está suspendida
        }
    } else {
        $error = "Tus Credenciales son incorrectas, intenta de nuevo por favor."; // Mensaje de error si el usuario no existe
    }

    $stmt->close(); // Cerramos el statement
    $conn->close(); // Cerramos la conexión a la base de datos
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../Resources/css/styles_login.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var errorElement = document.getElementById("error-message");
            if (errorElement) {
                setTimeout(function() {
                    errorElement.style.display = 'none';
                }, 3000); // 5000 milisegundos = 5 segundos
            }
        });
    </script>

</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
        <form method="post" action="../../Controllers/Login/Registro.php" id="formularioRegistro">
                <h1>Crear cuenta</h1>
                <div class="infield">
                    <input type="text" id="nombre" name="nombre" required placeholder="Nombre"/>
                    <label for="nombre"></label>
                </div>
                <div class="infield">
                    <input type="email" id="email" name="email" required placeholder="E-mail"/>
                    <label for="email"></label>
                </div>
                <div class="infield">
                    <input type="password" id="password" name="password" required placeholder="Constraseña"/>
                    <label for="password"></label>   
                </div>
                <a href="#" class="forgot">Términos y condiciones</a>
                <a href="#" class="forgot" id="forgotPasswordLink">Olvidé mi contraseña</a>
                <button type="submit">Registrarse</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
                <form method="post" action="../../Controllers/Login/Login.php">
                    <h1>Iniciar sesión</h1>
                    <div class="infield">
                        <input type="email" id="email" name="email" required placeholder="E-mail"/>
                        <label for="email"></label>
                    </div>
                    <div class="infield">
                        <input type="password" id="password" name="password" required placeholder="Contraseña"/>
                        <label for="password"></label>
                    </div>
                    <?php
        if (!empty($error)) {
            echo '<p id="error-message" style="color:red;">' . $error . '</p>';
        }
        ?>
                    <a href="#" class="forgot">Términos y condiciones</a>
                    <button type="submit">Inicar sesión</button>
         
            </form>
        </div>
        <div class="overlay-container" id="overlayCon">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Hola!</h1>
                    <p>Para mantenerse conectado con nosotros, inicia sesión.</p>
                    <button>Iniciar sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Bienvenido!</h1>
                    <p>Introduzca sus datos personales y comienza a ser parte de nosotros.</p>
                    <button>Registrarse</button>
                </div>
            </div>
            <button id="overlayBtn"></button>
        </div>
    </div>
    <script>
        const container = document.getElementById('container');
        const overlayCon = document.getElementById('overlayCon');
        const overlayBtn = document.getElementById('overlayBtn');

        overlayBtn.addEventListener('click', ()=> {
            container.classList.toggle('right-panel-active');

            overlayBtn.classList.remove('btnScaled');
            window.requestAnimationFrame( ()=> {
                overlayBtn.classList.add('btnScaled');
            })
        });
    </script>
</body>
</html>
<!-- Modal for Forgot Password -->
<div id="forgotPasswordModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Restablecer contraseña</h2>
        <form id="forgotPasswordForm" method="post" action="../../Controllers/Login/ForgotPassword.php">
            <div class="infield">
                <input type="email" id="resetEmail" name="resetEmail" required placeholder="Correo electrónico"/>
                <label for="resetEmail"></label>
            </div>
            <button type="submit">Enviar enlace de restablecimiento</button>
        </form>
    </div>
</div>

<!-- Modal for Reset Password -->
<div id="resetPasswordModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Escriba la nueva contraseña</h2>
        <form id="resetPasswordForm" method="post" action="../../Controllers/Login/ResetPassword.php">
            <div class="infield">
                <input type="password" id="newPassword" name="newPassword" required placeholder="Nueva contraseña"/>
                <label for="newPassword"></label>
                <div id="passwordStrength"></div>
            </div>
            <button type="submit">Restablecer contraseña</button>
        </form>
    </div>
</div>

<script>
    // Get the modal
    var forgotPasswordModal = document.getElementById("forgotPasswordModal");
    var resetPasswordModal = document.getElementById("resetPasswordModal");

    // Get the button that opens the modal
    var forgotPasswordBtn = document.querySelector(".forgot");

    // Get the <span> element that closes the modal
    var spans = document.getElementsByClassName("close");

    // When the user clicks the button, open the modal 
    forgotPasswordBtn.onclick = function() {
        forgotPasswordModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    for (var i = 0; i < spans.length; i++) {
        spans[i].onclick = function() {
            this.parentElement.parentElement.style.display = "none";
        }
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == forgotPasswordModal || event.target == resetPasswordModal) {
            event.target.style.display = "none";
        }
    }

    // Password strength meter
    var newPassword = document.getElementById('newPassword');
    var passwordStrength = document.getElementById('passwordStrength');

    newPassword.addEventListener('input', function() {
        var val = newPassword.value;
        var strength = 0;

        if (val.length >= 8) strength++;
        if (val.match(/[a-z]+/)) strength++;
        if (val.match(/[A-Z]+/)) strength++;
        if (val.match(/[0-9]+/)) strength++;
        if (val.match(/[$@#&!]+/)) strength++;

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