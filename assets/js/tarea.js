function tarea() {
    var titulo = document.getElementById("title").value;
    var descripcion = document.getElementById("description").value;
    var vencimiento = document.getElementById("date").value;
    var select = document.getElementById("responsable");
    var responsable = select.options[select.selectedIndex].value;

    var fechaActual = new Date().toISOString().split('T')[0];

    if (vencimiento < fechaActual) {
        mostrarNotificacion('La fecha de vencimiento debe ser a partir de hoy.');
        return;
    }

    if (titulo === "" || descripcion === "" || vencimiento === "" || responsable === "") {
        mostrarNotificacion('Por favor, ingresa los datos');
    } else {
        var formData = {
            titulo: titulo,
            descripcion: descripcion,
            vencimiento: vencimiento,
            responsable: responsable
        };

        $.ajax({
            url: '../assets/ajax/procesarTarea.php',
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function (response) {
                var jsonResponse = JSON.parse(response);

                if (jsonResponse.success) {
                    mostrarNotificacion('¡Tarea creada!');
                    
                    // Limpiar los campos de entrada
                    document.getElementById("title").value = "";
                    document.getElementById("description").value = "";
                    document.getElementById("date").value = "";
                    select.selectedIndex = 0;
                } else {
                    mostrarNotificacion('La tarea no se pudo crear');
                }
            }
        });
    }
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
