<?php
include_once("../negocio/controlador.php");
$json = file_get_contents('php://input');
$data = json_decode($json);

$titulo = $data->titulo;
$descripcion = $data->descripcion;
$vencimiento = $data->vencimiento;
$responsable = $data->responsable;

$controlador = new Controlador();

$tarea = $controlador->crearTarea($titulo, $descripcion, $vencimiento, $responsable);

if ($tarea) {
    echo json_encode(['success' => true, 'message' => 'La tarea fue creada']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error en la creacion de la tarea']);
}
?>