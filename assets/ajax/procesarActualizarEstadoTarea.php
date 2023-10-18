<?php
session_start();
include_once("../negocio/controlador.php");

$json = file_get_contents('php://input');
$data = json_decode($json);

if (isset($data->tarea_id)) {
    $tarea_id = $data->tarea_id;
    $controlador = new Controlador();
    $tarea = $controlador->actualizarEstadoTarea($tarea_id);

    if ($tarea) {
        echo json_encode(array("success" => true, "message" => "Estado actualizado correctamente"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al actualizar el estado"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Datos faltantes"));
}
?>