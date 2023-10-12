<?php
include_once '../negocio/controlador.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    $controlador = new Controlador();

    // Llama a la función para obtener el nombre del usuario
    $nombreUsuario = $controlador->obtenerNombreUsuario($id_usuario);

    if ($nombreUsuario) {
        // Devuelve el nombre del usuario en formato JSON
        echo json_encode($nombreUsuario);
    } else {
        // En caso de error o si no se encuentra el usuario
        echo json_encode(['error' => 'Usuario no encontrado']);
    }
} else {
    http_response_code(400); // Respuesta de error si la solicitud no es válida
}
?>