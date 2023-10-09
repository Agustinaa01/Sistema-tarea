function cargarTarea() {
    
    $.ajax({
        url: '../assets/ajax/procesarDatosTarea.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log("Respuesta del servidor:", data);
            if (data.success) {
                document.getElementById('newTitle').textContent = data.title;
                document.getElementById('newDesc').textContent = data.desc;
                document.getElementById('newResp').textContent = data.responsable;
                document.getElementById('newFecha').textContent = data.fecha;
                document.getElementById('usuarios-select').textContent = data.usuario;
            } else {
                console.log("Error: " + data.message);
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    cargarTarea();
});

