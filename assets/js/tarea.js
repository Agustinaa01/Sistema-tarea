function tarea() {
    var titulo = document.getElementById("title").value;
    var descripcion = document.getElementById("description").value;
    var vencimiento = document.getElementById("date").value;
    var select = document.getElementById("responsable");
    var responsable = select.options[select.selectedIndex].value;
    
    var fechaActual = new Date().toISOString().split('T')[0];
    var tareaMensaje = document.getElementById('tarea-mensaje');

    if (vencimiento < fechaActual) {
        tareaMensaje.innerHTML = ("La fecha de vencimiento debe ser a partir de hoy.");
        tareaMensaje.classList.add('mostrar');
        ocultarMensaje(tareaMensaje);
        return;
    }

    if (titulo === "" || descripcion === "" || vencimiento === "" || responsable === "") {
        tareaMensaje.innerHTML = 'Por favor, ingresa los datos';
        tareaMensaje.classList.add('mostrar');
        ocultarMensaje(tareaMensaje);
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
            contentType: false,
            processData: false,
            success: function (response) {
                var jsonResponse = JSON.parse(response);

                if (jsonResponse.success) {
                    tareaMensaje.innerHTML = '¡Tarea creada!';
        
                    document.getElementById("title").value = "";
                    document.getElementById("description").value = "";
                    document.getElementById("date").value = "";
                    select.selectedIndex = 0;
                    
                    tareaMensaje.classList.add('mostrar');
                    ocultarMensaje(tareaMensaje);
                } else {
                    tareaMensaje.innerHTML = 'La tarea no se pudo crear';
                    tareaMensaje.classList.add('mostrar');
                    ocultarMensaje(tareaMensaje);
                }
            }
        });
    }
}

function ocultarMensaje(mensaje) {
    setTimeout(function() {
        mensaje.classList.remove('mostrar'); // Ocultar el mensaje después de 5 segundos (puedes ajustar el tiempo)
    }, 2500);
}
