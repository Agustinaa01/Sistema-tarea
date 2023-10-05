<?php
session_start();
include_once("../negocio/controlador.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $controlador = new Controlador();
    $usuario = $controlador->datosUsuario($id);

    if ($usuario) {
        $response = [
            'success' => true,
            'nombre' => $usuario->getNombre(),
            'email' => $usuario->getEmail(),
            'usuario' => $usuario->getUsuario(),
            'imagen' => $usuario->getImagen()
        ];
        echo json_encode($response);
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