<?php
session_start();
include_once("../negocio/controlador.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);
$json = file_get_contents('php://input');
$data = json_decode($json);

$tarea_id = $data->tarea_id;

$controlador = new Controlador();

$tarea = $controlador->actualizarEstadoTarea($tarea_id);

if ($tarea) {
    echo json_encode(array("success" => true, "message" => "Se actualizo eel estado"));
} else {
    echo json_encode(array("success" => false, "message" => "No sepuedo actualizar el estado"));
}
?>