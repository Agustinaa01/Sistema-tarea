<?php
include_once '../negocio/controlador.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tarea = $_POST['id_tarea'];

    $controlador = new Controlador();

    $tarea = $controlador->bajaLogica($id_tarea);

    if ($tarea) {
        echo json_encode(array('success' => true, 'message' => 'Tarea eliminada correctamente'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error al eliminar la tarea'));
    }
}
?>