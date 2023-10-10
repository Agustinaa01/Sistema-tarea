// cargarTarea.js

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
                    newRow.insertCell(0).textContent = tarea.titulo;
                    newRow.insertCell(1).textContent = tarea.descripcion;
                    newRow.insertCell(2).textContent = tarea.responsable;

                    // Agregar el "Vencimiento" en la columna de "Vencimiento"
                    newRow.insertCell(3).textContent = tarea.fecha_venc;

                    // Agregar un checkbox en la columna de "Terminado"
                    var terminadoCell = newRow.insertCell(4);
                    var terminadoCheckbox = document.createElement("input");
                    terminadoCheckbox.type = "checkbox";
                    terminadoCell.appendChild(terminadoCheckbox);

                    // Agregar un dropdown para "Integrantes" en la columna de "Integrantes"
                    var integrantesCell = newRow.insertCell(5);
                    var selectIntegrantes = document.createElement("select");
                    selectIntegrantes.id = "integrantes_" + tarea.id;

                    // Agregar una opción por defecto
                    var defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Seleccionar Integrante";
                    selectIntegrantes.appendChild(defaultOption);

                    integrantesCell.appendChild(selectIntegrantes);

                    // Agregar un enlace "Editar" en la columna de "Editar"
                    var editarCell = newRow.insertCell(6);
                    var editarText = document.createElement("a");
                    editarText.href = "#"; // Puedes configurar el enlace de edición aquí
                    editarText.textContent = "Editar";
                    editarCell.appendChild(editarText);
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