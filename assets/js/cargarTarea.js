document.addEventListener("DOMContentLoaded", function () {
    cargarTarea();
    cargarUsuariosTareas();
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
        var id_tarea = selectedOption.closest("select").data("id");
        var id_usuario = selectedOption.val();

        $.ajax({
            url: '../assets/ajax/procesarEventoAceptar.php',
            type: 'POST',
            data: {
                id_tarea: id_tarea,
                id_usuario: id_usuario
            },
            success: function (response) {
                console.log("Tarea actualizada en la base de datos.");
            },
            error: function (error) {
                console.error("Error al actualizar la tarea:", error);
            }
        });

        var nuevoElemento = document.createElement('div');
        nuevoElemento.innerText = nuevoResponsable;

        var integrantes = $(this).closest("tr").find("td:nth-child(6)");
        integrantes.append(nuevoElemento);
    });
}

function cargarUsuariosTareas() {
    $.ajax({
        url: '../assets/ajax/procesarObtenerUsuarioTarea.php',
        type: 'GET',
        success: function (data) {
            var usuariosTareas = JSON.parse(data);

            usuariosTareas.forEach(function (usuarioTarea) {
                var idTarea = usuarioTarea.id_tarea;
                var idUsuario = usuarioTarea.id_usuario;

                var usuariosContainer = $("select[data-id='" + idTarea + "']").next(".usuarios-tarea");
                var nuevoElemento = document.createElement('div');
                nuevoElemento.innerText = idUsuario; 
                usuariosContainer.append(nuevoElemento);
            });
        },
        error: function (error) {
            console.error("Error al cargar la tabla de tareas:", error);
        }
    });
}

