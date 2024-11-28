<?php
// Verifica si el usuario ya tiene una sesión activa
session_start();
$is_logged_in = isset($_SESSION['user_id']) ? true : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/styles_login.css">
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("termsModal");
            var termsLink = document.querySelectorAll(".forgot");
            var closeBtn = document.getElementsByClassName("close")[0];

            termsLink.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    modal.style.display = "block";
                });
            });

            closeBtn.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
</head>
<body>
<div class="container" id="container" data-logged-in="<?php echo $is_logged_in ? 'true' : 'false'; ?>">
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
                    <input type="password" id="password" name="password" required placeholder="Contraseña"/>
                    <label for="password"></label>   
                </div>
                <a href="#" class="forgot">Términos y condiciones</a>
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
                <a href="#" class="forgot">Términos y condiciones</a>
                <button type="submit">Iniciar sesión</button>
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

    <!-- Modal for Terms and Conditions -->
    <div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Términos y Condiciones</h2>
            <p>Bienvenido a EqualEducation. Al usar esta plataforma, aceptas cumplir con nuestras normas, incluyendo la gestión responsable de tu cuenta y el uso exclusivo con fines educativos y legales. Nos reservamos el derecho de gestionar o restringir el acceso si se detecta algún mal uso.</p>
            <p>Para más detalles, consulta nuestra <a href="política_privacidad.html" target="_blank">[Política de Privacidad]</a>.</p>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Verifica si el usuario está registrado
        const container = document.getElementById("container");
        const isLoggedIn = container.dataset.loggedIn === "true";

        if (isLoggedIn) {
            // Selecciona todos los inputs y botones del formulario de registro
            const formInputs = document.querySelectorAll("#formularioRegistro input, #formularioRegistro button");

            // Desactiva los inputs y botones
            formInputs.forEach(input => {
                input.disabled = true;

                // Añade un evento para mostrar el mensaje cuando se intente interactuar
                input.addEventListener("click", () => {
                    alert("Ya estás registrado. Por favor, inicia sesión.");
                });
            });

            // Opcional: Cambiar el estilo del formulario para indicar que está desactivado
            const form = document.getElementById("formularioRegistro");
            form.style.opacity = "0.5"; // Hace que el formulario se vea desactivado
            form.style.pointerEvents = "none"; // Evita cualquier interacción
        }
    });
    </script>
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
