// Datos de preguntas y gráficas
// Datos de preguntas y gráficas
const preguntasGraficas = [
    //Pregunta 1
    {
        pregunta: "¿Qué tal te ha parecido el programa?",
        labels: ['Bueno', 'Regular', 'Malo'],
        data: [50, 30, 20]
    },
    //Pregunta 2
    {
        pregunta: "¿Le ha parecido relevante el programa?",
        labels: ['Sí', 'No'],
        data: [10, 25]
    },
    //Pregunta 3
    {
        pregunta: "¿Cómo ha sido el trato del personal?",
        labels: ['Bueno', 'Regular', 'Malo'],
        data: [70, 20, 10]
    },
    //Pregunta 4
    {
        pregunta: "¿Cómo ha sido la atención del personal?",
        labels: ['Bueno', 'Regular', 'Malo'],
        data: [70, 20, 10]
    },
    //Pregunta 5
    {
        pregunta: "¿Considera que el programa cumplió con sus expectativas?",
        labels: ['Sí', 'No'],
        data: [10, 25]
    },
    //Pregunta 6
    {
        pregunta: "¿Le gustaría participar en otro programa similar?",
        labels: ['Sí', 'No'],
        data: [10, 50]
    },
    //Pregunta 7
    {
        pregunta: "¿Fue fácil inscribirse y asistir al programa?",
        labels: ['Sí', 'No'],
        data: [10, 27]
    },
    //Pregunta 8
    {
        pregunta: "¿El horario fue adecuado para usted?",
        labels: ['Sí', 'No'],
        data: [38, 13]
    },
    //Pregunta 9
    {
        pregunta: "¿El espacio físico era adecuado para la actividad?",
        labels: ['Bueno', 'Regular', 'Malo'],
        data: [70, 20, 10]
    }
];

// Función para mostrar el modal con las gráficas
function verInforme(programaId) {
    const contenedorPreguntas = document.getElementById("listaPreguntas");
    contenedorPreguntas.innerHTML = ""; // Limpiar contenido previo

    // Generar dinámicamente las preguntas y gráficas
    preguntasGraficas.forEach((item, index) => {
        // Crear contenedor para cada pregunta y su gráfica
        const divPregunta = document.createElement("div");
        divPregunta.className = "mb-4"; // Añadir margen inferior

        // Título de la pregunta
        const preguntaTitulo = document.createElement("h6");
        preguntaTitulo.textContent = `${index + 1}. ${item.pregunta}`;
        divPregunta.appendChild(preguntaTitulo);

        // Lienzo para la gráfica
        const canvas = document.createElement("canvas");
        canvas.id = `chart-${index}`; // ID único para cada gráfica
        canvas.style.maxHeight = "300px"; // Ajustar altura máxima
        divPregunta.appendChild(canvas);

        // Añadir contenedor al modal
        contenedorPreguntas.appendChild(divPregunta);

        // Asignar colores para la gráfica de tipo Sí/No
        let backgroundColors = [];
        let borderColors = [];

        // Si las opciones son Sí/No, asignar colores específicos
        if (item.labels.includes("Sí") && item.labels.includes("No")) {
            backgroundColors = ['rgba(0, 197, 18, 0.8)', 'rgba(197, 0, 0, 0.8)'];
            borderColors = ['rgba(4, 125, 0, 0.8)', 'rgba(152, 0, 0, 0.8)'];
        } else {
            backgroundColors = [
                    'rgba(0, 197, 18, 0.8)',
                    'rgba(234, 158, 0, 1)',
                    'rgba(197, 0, 0, 0.8)'
            ];
            borderColors = [
                    'rgba(4, 125, 0, 0.8)',
                    'rgba(208, 225, 40, 1)',
                    'rgba(152, 0, 0, 0.8)'
            ];
        }

        // Crear la gráfica con los colores ajustados
        const ctx = canvas.getContext("2d");
        new Chart(ctx, {
            type: "pie", 
            data: {
                labels: item.labels,
                datasets: [{
                    data: item.data,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    });

    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('informeModal'));
    modal.show();
}