function mostrarFormularioEdicion() {
    var formularioEdicion = document.getElementById('formulario-edicion');
    formularioEdicion.style.display = 'block';
}
function editar_guardar() { 
    var newName = document.getElementById('newName').value;
    var newEmail = document.getElementById('newEmail').value;
    var newUser = document.getElementById('newUser').value;

    var formData = {
        nombre: newName,
        email: newEmail,
        usuario: newUser
    };    

    $.ajax({
        url: '../assets/ajax/procesarEditar.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log("bien");

            document.getElementById('name').textContent = newName;
            document.getElementById('email').textContent = newEmail;
            document.getElementById('user').textContent = newUser;
            
            var formularioEdicion = document.getElementById('formulario-edicion');
            formularioEdicion.style.display = 'none';
        },
        error: function (error) {
            console.error("Error:", error);
        }
    });
    
}
