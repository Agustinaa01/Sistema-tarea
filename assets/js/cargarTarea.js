document.addEventListener("DOMContentLoaded", function () {
    cargarTarea();
    cargarTareaCompleta();
    cargarUsuariosTareas();
    bajaLogica();
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
            editarTarea();
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
                mostrarNotificacion("¡Integrantes agregados correctamente!")
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
                        mostrarNotificacion("¡Tarea terminada!");
                        setTimeout(function() {
                            // ocultarNotificacion();
                            $(`input[type="checkbox"][data-tarea-id="${tareaId}"]`).closest('tr').remove();
                        }, 1000);
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
                    console.log("Éxito en la eliminación");
                    filaTarea.remove();
                    mostrarNotificacion("¡Tarea eliminada correctamente!")
                },
                error: function (error) {
                    console.error("Error al eliminar la tarea:", error);
                    mostrarNotificacion("¡La tarea no se pudo eliminar!")
                }
            });
        }
    });
}


function editarTarea() {
    $(document).on("click", ".btn-editar", function () {
        var idTarea = $(this).data("tarea-id");
        console.log(idTarea);
        $.ajax({
            url: '../assets/ajax/procesarDatosTareaID.php?id=' + idTarea,
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#titulo").val(data.titulo);
                $("#descripcion").val(data.descripcion);
                $("#responsable").val(data.responsable);
                $("#fecha_venc").val(data.fecha_venc);

                // Mostrar el modal de edición
                $("#editarTareaModal").modal("show");

                // Agregar el idTarea al botón "Guardar Cambios"
                $("#guardarCambios").data("tarea-id", idTarea);
            },
            error: function (error) {
                console.error("Error al obtener los datos de la tarea:", error);
            }
        });
    });

    $("#guardarCambios").click(function () {
        var idTarea = $(this).data("tarea-id");
        datosEditados(idTarea);
    });
}

function datosEditados(idTarea) {
    var titulo = document.getElementById('titulo').value;
    var descripcion = document.getElementById('descripcion').value;
    var responsable = document.getElementById('responsable').value;
    var fecha_venc = document.getElementById('fecha_venc').value;

    var formData = {
        idTarea: idTarea,
        titulo: titulo,
        descripcion: descripcion,
        responsable: responsable,
        fecha_venc: fecha_venc
    };

    $.ajax({
        url: "../assets/ajax/procesarDatosEditados.php",
        type: "POST",
        data: JSON.stringify(formData),
        contentType: "application/json; charset=utf-8",
        success: function(data) {
            console.log(data);

            console.log("Cerrando el modal");
            $("#editarTareaModal").modal("hide");
            mostrarNotificacion("¡Tarea editada correctamente!");
            cargarTarea();
            cargarUsuariosTareas();
        },
        error: function(xhr, status, error) {
            console.error(error);
            mostrarNotificacion("¡La tarea no se pudo edita!")
        }
    });
}
function mostrarNotificacion(mensaje) {
    var miToast = new bootstrap.Toast(document.getElementById('miToast'));
    var toastBody = document.querySelector('.toast-body');
    toastBody.innerHTML = mensaje;
    miToast.show();

    setTimeout(function() {
        miToast.hide();
    }, 2700);
}


function ocultarMensaje(mensaje) {
    setTimeout(function() {
        mensaje.classList.remove('mostrar'); 
    }, 3000);
}
