function login() {
    var usuario = document.getElementById('usuario').value;
    var password = document.getElementById('password').value;

    var loginMensaje = document.getElementById('login-mensaje');

    var formData = {
        usuario: usuario,
        password: password
    };

    $.ajax({
        url: '../assets/ajax/procesarLogin.php',
        type: 'POST',
        data: JSON.stringify(formData),
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            loginMensaje.innerHTML = '¡Bienvenido!';
            setTimeout(function () {
                window.location.href = 'profile.html';
            }, 2000);
        }        
        
    });
}