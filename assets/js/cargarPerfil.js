function cargarPerfil() {
    $.ajax({
        url: '../assets/ajax/procesarDatosUsuario.php',
        type: 'GET',
        dataType: false, 
        success: function (data) {
            console.log("Respuesta del servidor:", data);
            data = JSON.parse(data);
            if (data.success) {
                document.getElementById('name').textContent = data.nombre;
                document.getElementById('email').textContent = data.email;
                document.getElementById('user').textContent = data.usuario;
            } else {
                console.log("Error: " + data.message);
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    cargarPerfil();
});
