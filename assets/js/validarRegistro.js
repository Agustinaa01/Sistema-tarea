function validarRegistro() {
    var nombre = document.getElementById('nombre').value; 
    var usuario = document.getElementById('usuario').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var passwordPattern = /^.{8,}$/;

    var mensajeRegistro = document.getElementById('registro-mensaje');

    if (nombre === "" || usuario === "" || email === "" || password === "") {
        mensajeRegistro.innerHTML = "Por favor, ingrese los datos";
    } else if (!emailPattern.test(email)) {
        mensajeRegistro.innerHTML = "Por favor, ingrese un email válido";
    } else if (!passwordPattern.test(password)) {
        mensajeRegistro.innerHTML = "Por favor, ingrese una contraseña de al menos 8 caracteres";
    } else {
        register();
    }
}