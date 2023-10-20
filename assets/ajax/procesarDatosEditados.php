<?php
session_start();
include_once("../negocio/controlador.php");
$json = file_get_contents('php://input');
$data = json_decode($json);

$idTarea = $data->idTarea;
$titulo = $data->titulo;
$descripcion = $data->descripcion;
$responsable = $data->responsable;
$fecha_venc = $data->fecha_venc;

$controlador = new Controlador();

$tarea = $controlador->datosEditados($idTarea, $titulo, $descripcion, $responsable, $fecha_venc);

if ($tarea) {
  echo json_encode(['success' => true, 'message' => 'Tarea editada']);
} else {
  echo json_encode(['success' => false, 'message' => 'Tarea no editada']);
}
?>
