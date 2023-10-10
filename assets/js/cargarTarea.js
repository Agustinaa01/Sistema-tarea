function cargarTarea() {
    $.ajax({
        url: '../assets/ajax/procesarDatosTarea.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log("Respuesta del servidor:", data);
            if (data.success) {
                var tableBody = document.getElementById("taskTableBody");
                tableBody.innerHTML = '';

                data.tareas.forEach(function (tarea) {
                    var newRow = tableBody.insertRow(tableBody.rows.length);
                    newRow.insertCell(0).textContent = tarea.titulo; // Accede a 'titulo'
                    newRow.insertCell(1).textContent = tarea.descripcion; // Accede a 'descripcion'
                    newRow.insertCell(2).textContent = tarea.responsable; // Accede a 'responsable'
                    newRow.insertCell(3).textContent = tarea.fecha_venc; // Accede a 'fecha_venc'
                });
            } else {
                console.log("Error: " + data.message);
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    cargarTarea();
});