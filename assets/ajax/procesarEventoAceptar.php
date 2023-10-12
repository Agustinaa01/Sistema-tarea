<?php
include_once '../negocio/controlador.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tarea = $_POST['id_tarea'];
    $id_usuario = $_POST['id_usuario'];

    $controlador = new Controlador();

    $actualizacion_exitosa = $controlador->actualizarTareaResponsable($id_tarea, $id_usuario);

    if ($actualizacion_exitosa) {
        echo json_encode(array('success' => true, 'message' => 'Tarea actualizada correctamente'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error al actualizar la tarea'));
    }
} else {
    http_response_code(405);
}

?>