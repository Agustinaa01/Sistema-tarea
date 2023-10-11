document.addEventListener("DOMContentLoaded", function () {
    cargarTarea();
});

function cargarTarea() {
    $.ajax({
        url: '../assets/ajax/procesarDatosTarea.php',
        type: 'GET',
        dataType: 'html',
        success: function (data) {
            document.getElementById("taskTableBody").innerHTML = data;
            agregarEventoAceptar();
        },
        error: function (error) {
            console.error("Error al cargar la tabla de tareas:", error);
        }
    });
}

function agregarEventoAceptar() {
    $(".btn-aceptar").click(function () {
        var selectedOption = $(this).closest("tr").find("select option:selected");
        var nuevoResponsable = selectedOption.text();

        var nuevoElemento = document.createElement('div');
        nuevoElemento.innerText = nuevoResponsable;

        // Agregar el nuevo responsable debajo de "Integrantes"
        var integrantes = $(this).closest("tr").find("td:nth-child(6)");
        integrantes.append(nuevoElemento);
    });
}