<?php
session_start();
include_once("../negocio/controlador.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// if (isset($_SESSION['id'])) {
//     $id = $_SESSION['id'];

    $controlador = new Controlador();
    $usuario = $controlador->datosTarea();

    if ($usuario) {
        $response = [
            'success' => true,
            'title' => $usuario->getTitulo(),
            'desc' => $usuario->getDescripcion(),
            'fecha' => $usuario->getFechaVencimiento(),
            'responsable' => $usuario->getResponsable()
        ];        
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'message' => 'No se encontraron datos de las tareas.'
        ];
        echo json_encode($response);
    }
    
// } else {
//     echo json_encode(['success' => false, 'message' => 'No se encontro la tarea.']);
// }
?>