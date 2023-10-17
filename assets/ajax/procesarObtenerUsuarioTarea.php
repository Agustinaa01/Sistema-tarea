<?php
session_start();
include_once("../negocio/controlador.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];


    $controlador = new Controlador();
    $usuarioTareas = $controlador->getUsuarioTarea();

    if ($usuarioTareas) {
        $usuarios = [];

        foreach ($usuarioTareas as $usuarioTarea) {
            $usuarios[] = [
                'id_tarea' => $usuarioTarea->getIdTarea(),
                'id_usuario' => $usuarioTarea->getIdUsuario(),
            ];
        }

        echo json_encode($usuarios); 
        } else {
        $response = [
            'success' => false,
            'message' => 'No se encontraron datos de usuario.'
        ];
        echo json_encode($response);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'El usuario no ha iniciado sesión.']);
}
?>