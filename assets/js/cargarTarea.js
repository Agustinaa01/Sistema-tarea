document.addEventListener("DOMContentLoaded", function () {
    cargarTarea();
    cargarTareaCompleta();
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
            cambiarEstadoTerminado();
            bajaLogica();
        },
        error: function (error) {
            console.error("Error al cargar la tabla de tareas:", error);
        }
    });
}

function cargarTareaCompleta() {
    $.ajax({
        url: '../assets/ajax/procesarDatosTareaCompleta.php',
        type: 'GET',
        dataType: 'html',
        success: function (data) {
            document.getElementById("taskTableBody-complete").innerHTML = data;
            bajaLogica();
        },
        error: function (error) {
            console.error("Error al cargar la tabla de tareas:", error);
        }
    });
}

function agregarEventoAceptar() {
    $(".btn-agregar").click(function () {
        //encuentran el menú desplegable y obtienen el texto de la opción que el usuario ha seleccionado.
        var selectedOption = $(this).closest("tr").find("select option:selected");
        var nuevoResponsable = selectedOption.text();
        //selecciona el id de tarea y usuario
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
        //muestra lo seleccionado abajo del dropdown
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
                                usuariosContainer.append("<br/>");
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

function cambiarEstadoTerminado() {
    $(document).on('change', 'input[type="checkbox"]', function() {
        var $checkbox = $(this);
        var tareaId = $checkbox.data('tarea-id');

        var estaSeguro = confirm("¿Estás seguro de que deseas marcar esta tarea como completada y eliminarla?");

        if (estaSeguro) {
            $.ajax({
                url: '../assets/ajax/procesarActualizarEstadoTarea.php', 
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify({ tarea_id: tareaId }),
                success: function(data) {
                    if (data.success) {
                        console.log('Estado actualizado correctamente.');
                        $(`input[type="checkbox"][data-tarea-id="${tareaId}"]`).closest('tr').remove();
                    } else {
                        console.error('Error al actualizar el estado:', data.message);
                    }
                },
                error: function(error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        }
    });
}

function bajaLogica() {
    $(".btn-eliminar").click(function () {      
        console.log("entro")
        var id_tarea = $(this).data("tarea-id");
        var filaTarea = $(this).closest("tr");

        var confirmar = confirm("¿Estás seguro de que deseas eliminar esta tarea?");

        if (confirmar) {
            $.ajax({
                url: '../assets/ajax/procesarBajaLogica.php',
                type: 'POST',
                data: {
                    id_tarea: id_tarea
                },
                success: function (response) {
                    console.log("Tarea eliminada correctamente.", response);
                    filaTarea.remove();
                },
                error: function (error) {
                    console.error("Error al eliminar la tarea:", error);
                }
            });
        }
    });
}
