const modal = document.getElementById("modal");
const openModalBtn = document.getElementById("openModalBtn");
const closeModalBtn = document.getElementById("closeModalBtn");
const actividad = document.querySelectorAll(".contenido__actividad");

// Abrir la ventana emergente
openModalBtn.addEventListener("click", () => {
    modal.style.display = "flex";
});

// Cerrar la ventana emergente
closeModalBtn.addEventListener("click", () => {
    modal.style.display = "none";
});

// Cerrar la ventana emergente si se hace clic fuera de ella
window.addEventListener("click", (event) => {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});


function editarPrgm(id){
    const modalEditar = document.getElementById("modal-editar-" + id);
    const openEditar = document.getElementById("open-editar-" + id);
    const closeEditar = document.getElementById("close-editar-" + id);

    // Abrir la ventana emergente
    openEditar.addEventListener("click", () => {
        modalEditar.style.display = "flex";
    });

    // Cerrar la ventana emergente
    closeEditar.addEventListener("click", () => {
        modalEditar.style.display = "none";
    });

    // Cerrar la ventana emergente si se hace clic fuera de ella
    window.addEventListener("click", (event) => {
        if (event.target === modalEditar) {
            modalEditar.style.display = "none";
        }
    });
}


function eliminarPrgm(id){
    const modalEliminar = document.getElementById("modal-eliminar-" + id);
    const openModalEliminar = document.getElementById("open-eliminar-" + id);
    const closeModalEliminar = document.getElementById("close-eliminar-" + id);

    // Abrir la ventana emergente
    openModalEliminar.addEventListener("click", () => {
        modalEliminar.style.display = "flex";
    });

    // Cerrar la ventana emergente
    closeModalEliminar.addEventListener("click", () => {
        modalEliminar.style.display = "none";
    });

    // Cerrar la ventana emergente si se hace clic fuera de ella
    window.addEventListener("click", (event) => {
        if (event.target === modalEliminar) {
            modalEliminar.style.display = "none";
        }
    });
}

function crearAct(id){
    const modalAct = document.getElementById("modal-act-" + id);
    const openAct = document.getElementById("open-act-" + id);
    const closeAct = document.getElementById("close-act-" + id);

    // Abrir la ventana emergente
    openAct.addEventListener("click", () => {
        modalAct.style.display = "flex";
    });

    // Cerrar la ventana emergente
    closeAct.addEventListener("click", () => {
        modalAct.style.display = "none";
    });

    // Cerrar la ventana emergente si se hace clic fuera de ella
    window.addEventListener("click", (event) => {
        if (event.target === modalAct) {
            modalAct.style.display = "none";
        }
    });
}

function agregarVolun(idAct){
    const modalVolun = document.getElementById("modal-volun-" + idAct);
    const openVolun = document.getElementById("open-volun-" + idAct);
    const closeVolun = document.getElementById("close-volun-" + idAct);

    // Abrir la ventana emergente
    openVolun.addEventListener("click", () => {
        modalVolun.style.display = "flex";
    });

    // Cerrar la ventana emergente
    closeVolun.addEventListener("click", () => {
        modalVolun.style.display = "none";
    });

    // Cerrar la ventana emergente si se hace clic fuera de ella
    window.addEventListener("click", (event) => {
        if (event.target === modalVolun) {
            modalVolun.style.display = "none";
        }
    });
}