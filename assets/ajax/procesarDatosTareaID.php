<?php
session_start();
include_once("../negocio/controlador.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);
$json = file_get_contents('php://input');
$data = json_decode($json);

$idTarea = $_GET['id'];

$controlador = new Controlador();

$tarea = $controlador->obtenerDatosTareaPorID($idTarea);

if ($tarea) {
    $data = [
        'success' => true,
        'titulo' => $tarea->getTitulo(),
        'descripcion' => $tarea->getDescripcion(),
        'fecha_venc' => $tarea->getFechaVencimiento(),
        'responsable' => $tarea->getResponsable(),
        'estado' => $tarea ->getEstado(),
        
    ];
    echo json_encode($data);
} else {
    $data = [
        'success' => false,
        'message' => 'No se encontraron datos de la tarea.'
    ];
    echo json_encode($data);
}
?>