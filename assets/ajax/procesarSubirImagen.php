<?php
session_start();
include_once("../negocio/controlador.php");

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $controlador = new Controlador();
    $usuario = $controlador->datosUsuario($id);

    if ($usuario) {
        $nombreOriginal = $_FILES['imagen']['name'];

        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

        $nombreUsuario = $usuario->getUsuario();

        $rutaDeDestino = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'imgProfile' . DIRECTORY_SEPARATOR;

        if (!is_dir($rutaDeDestino)) {
            mkdir($rutaDeDestino, 0777, true);
        }

        $nombrePersonalizado = $nombreUsuario . '.' . $extension;

        $rutaDeDestinoCompleta = $rutaDeDestino . $nombrePersonalizado;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDeDestinoCompleta)) {
            $controlador->subirImagen($id, $nombrePersonalizado);

            echo json_encode(['success' => true, 'message' => 'Imagen subida y nombre guardado en la base de datos']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al mover el archivo']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontraron datos de usuario.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'El usuario no ha iniciado sesión.']);
}
?>