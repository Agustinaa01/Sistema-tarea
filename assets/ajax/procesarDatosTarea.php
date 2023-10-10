<?php
session_start();
include_once("../negocio/controlador.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$controlador = new Controlador();
$tareas = $controlador->datosTarea();

if (!empty($tareas)) {
    $tareaPrimera = $tareas[0]; // Accede a la primera tarea en el arreglo
    $response = [
        'success' => true,
        'tareas' => $tareas, // $tareas es un arreglo de objetos Tarea
    ];
    
    echo json_encode($response);
} else {
    $response = [
        'success' => false,
        'message' => 'No se encontraron datos de las tareas.'
    ];
    echo json_encode($response);
}
?>