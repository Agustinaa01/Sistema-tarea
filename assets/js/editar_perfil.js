function mostrarFormularioEdicion() {
    var formularioEdicion = document.getElementById('formulario-edicion');
    formularioEdicion.style.display = 'block';
}
function editar_guardar() { 
    var newName = document.getElementById('newName').value;
    var newEmail = document.getElementById('newEmail').value;
    var newUser = document.getElementById('newUser').value;
    var newPassword = document.getElementById('newPassword').value;

    var formData = {
        nombre: newName,
        email: newEmail,
        usuario: newUser,
        password: newPassword
    };    

    $.ajax({
        url: '../assets/ajax/procesarEditar.php',
        type: 'POST',
        data: JSON.stringify(formData), // Convert to JSON
        contentType: 'application/json', // Set content type
        success: function (response) {
            var data = JSON.parse(response);
            
            document.getElementById('name').textContent = data.nombre;
            document.getElementById('email').textContent = data.email;
            document.getElementById('user').textContent = data.usuario;

            var formularioEdicion = document.getElementById('formulario-edicion');
            formularioEdicion.style.display = 'none';

            cargarPerfil();
        },
        error: function (error) {
            console.error("Error:", error);
        }
    });
}
function subir_imagen() {
    var formData = new FormData();
    var input = document.getElementById('img');

    if (input.files.length > 0) {
        formData.append('imagen', input.files[0]);

        $.ajax({
            url: '../assets/ajax/procesarSubirImagen.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                var data = JSON.parse(response);
                if (data.success) {
                    console.log(data.message);
                    cargarPerfil();
                } else {
                    console.error(data.message);
                }
            },
            error: function (error) {
                console.error("Error:", error);
            }
        });
    } else {
        console.error("Debes seleccionar una imagen.");
    }
}
