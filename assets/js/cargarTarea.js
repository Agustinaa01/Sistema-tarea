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

                $.ajax({
                    url: '../assets/ajax/procesarObtenerNombreUsuario.php',
                    type: 'GET',
                    data: { id_usuario: idUsuario },
                    success: function (nombreUsuario) {
                        var usuariosContainer = $("select[data-id='" + idTarea + "']").next(".usuarios-tarea");

                        nombreUsuario = nombreUsuario.replace(/["\[\]]/g, '');
                        
                        if (!usuariosContainer.text().includes(nombreUsuario)) {
                            if (usuariosContainer.text() !== "") {
                                usuariosContainer.append("<br/> ");
                            }

                            usuariosContainer.append(nombreUsuario);
                        }
                    },
                    error: function (error) {
                        console.error("Error al cargar los nombres de usuarios:", error);
                    }
                });
            });
        },
        error: function (error) {
            console.error("Error al cargar la tabla de tareas:", error);
        }
    });
}
