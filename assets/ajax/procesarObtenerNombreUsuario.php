<?php
include_once '../negocio/controlador.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    $controlador = new Controlador();

    $nombreUsuario = $controlador->obtenerNombreUsuario($id_usuario);

    if ($nombreUsuario) {
        echo json_encode($nombreUsuario);
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
    }
} else {
    http_response_code(400);
}
?>