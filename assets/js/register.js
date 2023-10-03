function register() {
    var nombre = document.getElementById('nombre').value; 
    var usuario = document.getElementById('usuario').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var registroMensaje = document.getElementById('registro-mensaje'); // Obtén el elemento de mensaje

    var formData = {
        nombre: nombre, 
        usuario: usuario,
        email: email,
        password: password
    };

    $.ajax({
        url: '../assets/ajax/procesarRegistro.php',
        type: 'POST',
        data: JSON.stringify(formData),
        contentType: false,
        processData: false,
        success: function (response) {
            var jsonResponse = JSON.parse(response);

            if (jsonResponse.success) {
                registroMensaje.innerHTML = '¡Registro exitoso! Puede iniciar sesión ahora.';

                setTimeout(function () {
                window.location.href = "http://localhost/material-dashboard-master/pages/sign-in.html";
                }, 2000);
            } else {
                registroMensaje.innerHTML = 'Error en el registro: ' + jsonResponse.message;
            }
        },
        error: function (error) {
            console.error('Error en el registro: ' + error);
        }
    });
}
