var usuarios = [];
function cargarUsuariosResponsables() {
    $.ajax({
        url: '../assets/ajax/procesarObtenerResponsables.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var select = document.getElementById("responsable");

            for (var i = 0; i < response.length; i++) {
                var option = document.createElement("option");
                option.value = response[i].id;
                option.text = response[i].nombre;
                select.appendChild(option);
            }
        },
        error: function (xhr, status, error) {
            console.log("Error al cargar usuarios responsables:", error);
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    cargarUsuariosResponsables();
});
