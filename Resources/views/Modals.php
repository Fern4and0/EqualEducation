<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inscripción</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,300i,400,500,600,700,800,900,900i%7CRoboto:400%7CRubik:100,400,700">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/styles_index.css">
    <link rel="stylesheet" href="../css/style_modal.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include('header.php');?>
    <div class="page">
      <section class="parallax-container" data-parallax-img="../../Public/image/img6.jpg">
        <div class="parallax-content breadcrumbs-custom context-dark">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-12 col-lg-9">
                <h2 class="breadcrumbs-custom-title">¡Únete a nuestro programa y transforma tu vida!</h2>
                
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="contenedor">
        <h3>Únete a Equal Education</h3>
        <div class="texto">
            <h4>Únete como beneficiario:</h4>
            <p>Únete como beneficiario en caso de que te encuentres en una situación económica dificil, y <br> 
                quieras ser parte de algunos de nuestros programas educativos, u obtener algun apoyo económico.</p>
        </div>
        </div>
        <div class="contenedor">
         <div class="texto">
            <h4>Únete como voluntario:</h4>
            <p>Únete como voluntario si deseas ayudar a que nuestra organización siga creciendo, y quieras ayudar <br>
            a llevar a cabo algunos de nuestros programas educativos, con el fin de apoyar a niños, niñas,
            y adolescentes. </p>
        </div>
      </div>
      <div class="contenedor">
         <div class="texto">
            <h4>Únete como coordinador:</h4>
            <p>Únete como coordinador si deseas unirte a nuestro equipo de trabajo, donde se llevará el control de los <br>
            programas educativos y se realizarán informes sobre el rendimiento y progreso de los programas educativos. </p>
        </div>
      </div>
      
        <div class="header-content">
            <button type="button" class="btn btn-beneficiario" data-bs-toggle="modal" data-bs-target="#formularioBeneficiarioModal">Quiero ser Beneficiario</button>
            <button type="button" class="btn btn-voluntario" data-bs-toggle="modal" data-bs-target="#formularioVoluntarioModal">Quiero ser Voluntario</button>
            <button type="button" class="btn btn-coordinador" data-bs-toggle="modal" data-bs-target="#formularioCoordinadorModal">Quiero ser Coordinador</button>
        </div>

 <!-- Modal Beneficiario -->
<div class="modal fade" id="formularioBeneficiarioModal" tabindex="-1" aria-labelledby="formularioBeneficiarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formularioBeneficiarioLabel">Formulario de Beneficiarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioBeneficiario" method="post" action="../../Controllers/registro_beneficiarios.php" novalidate>
                    <div class="form-group">
                        <label for="ocupacion">Ocupación:</label>
                        <select id="ocupacion" name="ocupacion" class="form-control" required>
                            <option value="">Seleccione una opción</option>
                            <option value="Estudiante">Estudiante</option>
                            <option value="Desempleado">Desempleado</option>
                            <option value="Trabajador">Trabajador</option>
                        </select>
                        
                    </div>

                    <div class="form-group">
                        <label for="razon">Razón:</label>
                        <textarea id="razon" name="razon" class="form-control" required></textarea>
                        
                    </div>

                    <div class="form-group">
                        <label for="localidad">Localidad:</label>
                        <input id="localidad" type="text" name="localidad" class="form-control" required>
                        
                    </div>
                    
                    <div class="form-group">
                        <label for="preferencias_educativas">Preferencias Educativas:</label>
                        <select id="preferencias_educativas" name="preferencias_educativas" class="form-control" required>
                            <option value="">Seleccione una opción</option>
                            <option value="Ciencias">Ciencias</option>
                            <option value="Matemáticas">Matemáticas</option>
                            <option value="Lengua">Lengua</option>
                            <option value="Historia">Historia</option>
                            <option value="Arte">Arte</option>
                            <option value="Tecnología">Tecnología</option>
                        </select>
                        
                    </div>

                    <button type="submit" class="btn btn-submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Modal Voluntario -->
<div class="modal fade" id="formularioVoluntarioModal" tabindex="-1" aria-labelledby="formularioVoluntarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formularioVoluntarioLabel">Formulario de Voluntarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario Voluntario -->
                <form method="POST" action="../../Controllers/registro_voluntario.php">
                    <div class="form-group">
                        <label for="ocupacion">Ocupación:</label>
                        <input type="text" class="form-control" name="ocupacion">
                    </div>

                    <div class="form-group">
                        <label for="motivacion">Motivación:</label>
                        <textarea class="form-control" name="motivacion" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="localidad">Localidad:</label>
                        <input type="text" class="form-control" name="localidad">
                    </div>

                    <div class="form-group">
                        <label for="habilidades_tecnicas">Habilidades Técnicas:</label>
                        <textarea class="form-control" name="habilidades_tecnicas" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="disponibilidad">Disponibilidad:</label>
                        <input type="text" class="form-control" name="disponibilidad">
                    </div>

                    <button type="submit" class="btn btn-submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Coordinadores -->
<div class="modal fade" id="formularioCoordinadorModal" tabindex="-1" aria-labelledby="formularioCoordinadorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formularioCoordinadorLabel">Formulario de Coordinadores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="../../Controllers/registro_coordinadores.php">
                    <div class="form-group">
                        <label for="experiencia">Experiencia:</label>
                        <textarea name="experiencia" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="habilidades">Habilidades:</label>
                        <textarea name="habilidades" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="motivacion">Motivación:</label>
                        <textarea name="motivacion" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <footer class="section footer-minimal context-dark">
        <div class="container wow-outer">
          <div class="wow fadeIn">
            <div class="row row-50 row-lg-60">
              <div class="col-12"><a href="../views/index.php"><img src="../Images/logo.png" alt="" width="207" height="51"/></a></div>
              <div class="col-12">
                <ul class="footer-minimal-nav">
                  <li><a href="../views/nosotros.html">Equipo</a></li>
                  <li><a href="../views/política_privacidad.html">Política de privacidad</a></li>
                  <li><a href="../views/contacto.html">Contacto</a></li>
                </ul>
              </div>
            </div>
            <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><span>Equal Education</span><span>.&nbsp;</span><span>All Rights Reserved.</span><span>&nbsp;</span>Design&nbsp;by Equal Education</p>
          </div>
        </div>
      </footer>
</div>
    <div class="snackbars" id="form-output-global"></div>
    <script src="../js/core.min.js"></script>
    <script src="../js/scriptt.js"></script>
    <script src="../../Resources/JS/Dashboard.js" defer></script>
    <!-- Formulario beneficiario script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Seleccionar el formulario y el modal
    const formBeneficiario = document.getElementById("formularioBeneficiario");
    const modalBeneficiario = document.getElementById("formularioBeneficiarioModal");

    if (formBeneficiario) {
        // Seleccionar campos
        const ocupacion = document.getElementById("ocupacion");
        const razon = document.getElementById("razon");
        const localidad = document.getElementById("localidad");
        const preferenciasEducativas = document.getElementById("preferencias_educativas");

        // Crear mensajes de error dinámicos
        const errors = {
            ocupacion: ocupacion.closest(".form-group").appendChild(createErrorElement()),
            razon: razon.closest(".form-group").appendChild(createErrorElement()),
            localidad: localidad.closest(".form-group").appendChild(createErrorElement()),
            preferencias_educativas: preferenciasEducativas.closest(".form-group").appendChild(createErrorElement()),
        };

        // Validación al enviar el formulario
        formBeneficiario.addEventListener("submit", function (event) {
            let valid = true;

            // Validar ocupación
            if (ocupacion.value.trim() === "") {
                valid = false;
                showError(errors.ocupacion, "Por favor seleccione una opción.");
            } else {
                hideError(errors.ocupacion);
            }

            // Validar razón
            if (!validateNoNumbers(razon.value)) {
                valid = false;
                showError(errors.razon, "No se permiten números en este campo.");
            } else if (razon.value.trim() === "") {
                valid = false;
                showError(errors.razon, "Este campo es obligatorio.");
            } else {
                hideError(errors.razon);
            }

            // Validar localidad
            if (!validateNoNumbers(localidad.value)) {
                valid = false;
                showError(errors.localidad, "No se permiten números en este campo.");
            } else if (localidad.value.trim() === "") {
                valid = false;
                showError(errors.localidad, "Este campo es obligatorio.");
            } else {
                hideError(errors.localidad);
            }

            // Validar preferencias educativas
            if (preferenciasEducativas.value.trim() === "") {
                valid = false;
                showError(errors.preferencias_educativas, "Por favor seleccione una opción.");
            } else {
                hideError(errors.preferencias_educativas);
            }

            // Prevenir envío si hay errores
            if (!valid) {
                event.preventDefault();
            }
        });

        // Limpiar errores y valores al cerrar el modal
        modalBeneficiario.addEventListener("hidden.bs.modal", function () {
            formBeneficiario.reset();
            Object.values(errors).forEach(hideError);
        });

        // Validación en tiempo real para evitar números en los campos
        [ocupacion, razon, localidad, preferenciasEducativas].forEach(field => {
            field.addEventListener("input", function () {
                if (!validateNoNumbers(field.value)) {
                    field.value = field.value.replace(/[0-9]/g, ""); // Eliminar números en tiempo real
                }
            });
        });
    }

    // Función para crear elementos de error
    function createErrorElement() {
        const errorElement = document.createElement("div");
        errorElement.className = "text-danger d-none";
        return errorElement;
    }

    // Mostrar mensaje de error
    function showError(errorElement, message) {
        errorElement.textContent = message;
        errorElement.classList.remove("d-none");
    }

    // Ocultar mensaje de error
    function hideError(errorElement) {
        errorElement.textContent = "";
        errorElement.classList.add("d-none");
    }

    // Validar que un campo no contenga números
    function validateNoNumbers(value) {
        return !/[0-9]/.test(value);
    }
});
    </script>

<!-- Formulario voluntario script -->
<script>
     document.addEventListener("DOMContentLoaded", function () {
    // Seleccionar el formulario y el modal
    const formVoluntario = document.querySelector("form[action='../../Controllers/registro_voluntario.php']");
    const modalVoluntario = document.getElementById("formularioVoluntarioModal");

    if (formVoluntario) {
        // Seleccionar los campos
        const voluntarioOcupacion = formVoluntario.querySelector("input[name='ocupacion']");
        const motivacion = formVoluntario.querySelector("textarea[name='motivacion']");
        const voluntarioLocalidad = formVoluntario.querySelector("input[name='localidad']");
        const habilidadesTecnicas = formVoluntario.querySelector("textarea[name='habilidades_tecnicas']");
        const disponibilidad = formVoluntario.querySelector("input[name='disponibilidad']");

        // Crear los mensajes de error si no existen ya
        const errors = {
            ocupacion: ensureErrorElement(voluntarioOcupacion),
            motivacion: ensureErrorElement(motivacion),
            localidad: ensureErrorElement(voluntarioLocalidad),
            habilidades_tecnicas: ensureErrorElement(habilidadesTecnicas),
            disponibilidad: ensureErrorElement(disponibilidad),
        };

        // Validación al enviar el formulario
        formVoluntario.addEventListener("submit", function (event) {
            let valid = true;

            // Validar Ocupación
            if (!validateNoNumbers(voluntarioOcupacion.value)) {
                valid = false;
                showError(errors.ocupacion, "No se permiten números en este campo.");
            } else if (voluntarioOcupacion.value.trim() === "") {
                valid = false;
                showError(errors.ocupacion, "Este campo es obligatorio.");
            } else {
                hideError(errors.ocupacion);
            }

            // Validar Motivación
            if (motivacion.value.trim() === "") {
                valid = false;
                showError(errors.motivacion, "Este campo es obligatorio.");
            } else {
                hideError(errors.motivacion);
            }

            // Validar Localidad
            if (!validateNoNumbers(voluntarioLocalidad.value)) {
                valid = false;
                showError(errors.localidad, "No se permiten números en este campo.");
            } else if (voluntarioLocalidad.value.trim() === "") {
                valid = false;
                showError(errors.localidad, "Este campo es obligatorio.");
            } else {
                hideError(errors.localidad);
            }

            // Validar Habilidades Técnicas
            if (habilidadesTecnicas.value.trim() === "") {
                valid = false;
                showError(errors.habilidades_tecnicas, "Este campo es obligatorio.");
            } else {
                hideError(errors.habilidades_tecnicas);
            }

            // Validar Disponibilidad
            if (disponibilidad.value.trim() === "") {
                valid = false;
                showError(errors.disponibilidad, "Este campo es obligatorio.");
            } else {
                hideError(errors.disponibilidad);
            }

            // Evitar el envío si no es válido
            if (!valid) {
                event.preventDefault();
            }
        });

        // Limpiar errores y campos al cerrar el modal
        modalVoluntario.addEventListener("hidden.bs.modal", function () {
            formVoluntario.reset();
            Object.values(errors).forEach(hideError);
        });

        // Validación en tiempo real para eliminar números
        [voluntarioOcupacion, voluntarioLocalidad, motivacion, habilidadesTecnicas, disponibilidad].forEach(field => {
            field.addEventListener("input", function () {
                if (!validateNoNumbers(field.value)) {
                    field.value = field.value.replace(/[0-9]/g, ""); // Eliminar números en tiempo real
                }
            });
        });
    }

    // Asegura que el mensaje de error exista
    function ensureErrorElement(field) {
        let errorElement = field.closest(".form-group").querySelector(".text-danger");
        if (!errorElement) {
            errorElement = createErrorElement();
            field.closest(".form-group").appendChild(errorElement);
        }
        return errorElement;
    }

    // Crear elementos de error
    function createErrorElement() {
        const errorElement = document.createElement("div");
        errorElement.className = "text-danger d-none";
        return errorElement;
    }

    // Mostrar error
    function showError(errorElement, message) {
        errorElement.textContent = message;
        errorElement.classList.remove("d-none");
    }

    // Ocultar error
    function hideError(errorElement) {
        errorElement.textContent = "";
        errorElement.classList.add("d-none");
    }

    // Validar que no haya números
    function validateNoNumbers(value) {
        return !/[0-9]/.test(value);
    }
});
</script>

<!-- Formulario coordi script-->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Seleccionar formulario de coordinadores y modal
    const formCoordinador = document.querySelector("form[action='../../Controllers/registro_coordinadores.php']");
    const modalCoordinador = document.getElementById("formularioCoordinadorModal");

    if (formCoordinador) {
        // Seleccionar campos
        const experiencia = formCoordinador.querySelector("textarea[name='experiencia']");
        const habilidades = formCoordinador.querySelector("textarea[name='habilidades']");
        const motivacion = formCoordinador.querySelector("textarea[name='motivacion']");

        // Crear mensajes de error
        const errors = {
            experiencia: experiencia.closest(".form-group").appendChild(createErrorElement()),
            habilidades: habilidades.closest(".form-group").appendChild(createErrorElement()),
            motivacion: motivacion.closest(".form-group").appendChild(createErrorElement()),
        };

        // Validación al enviar el formulario
        formCoordinador.addEventListener("submit", function (event) {
            let valid = true;

            // Validar experiencia
            if (!validateNoNumbers(experiencia.value)) {
                valid = false;
                showError(errors.experiencia, "No se permiten números en este campo.");
            } else if (experiencia.value.trim() === "") {
                valid = false;
                showError(errors.experiencia, "Este campo es obligatorio.");
            } else {
                hideError(errors.experiencia);
            }

            // Validar habilidades
            if (!validateNoNumbers(habilidades.value)) {
                valid = false;
                showError(errors.habilidades, "No se permiten números en este campo.");
            } else if (habilidades.value.trim() === "") {
                valid = false;
                showError(errors.habilidades, "Este campo es obligatorio.");
            } else {
                hideError(errors.habilidades);
            }

            // Validar motivación
            if (!validateNoNumbers(motivacion.value)) {
                valid = false;
                showError(errors.motivacion, "No se permiten números en este campo.");
            } else if (motivacion.value.trim() === "") {
                valid = false;
                showError(errors.motivacion, "Este campo es obligatorio.");
            } else {
                hideError(errors.motivacion);
            }

            // Prevenir envío si hay errores
            if (!valid) {
                event.preventDefault();
            }
        });

        // Limpiar errores al cerrar el modal
        modalCoordinador.addEventListener("hidden.bs.modal", function () {
            formCoordinador.reset();
            Object.values(errors).forEach(hideError);
        });

        // Validación en tiempo real para evitar números en los campos
        [experiencia, habilidades, motivacion].forEach(field => {
            field.addEventListener("input", function () {
                if (!validateNoNumbers(field.value)) {
                    field.value = field.value.replace(/[0-9]/g, ""); // Eliminar números en tiempo real
                }
            });
        });
    }

    // Función para crear elementos de error
    function createErrorElement() {
        const errorElement = document.createElement("div");
        errorElement.className = "text-danger d-none";
        return errorElement;
    }

    // Mostrar mensaje de error
    function showError(errorElement, message) {
        errorElement.textContent = message;
        errorElement.classList.remove("d-none");
    }

    // Ocultar mensaje de error
    function hideError(errorElement) {
        errorElement.textContent = "";
        errorElement.classList.add("d-none");
    }

    // Validar que un campo no contenga números
    function validateNoNumbers(value) {
        return !/[0-9]/.test(value);
    }
});
</script>
</body>
</html>