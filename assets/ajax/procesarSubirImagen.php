<?php
session_start();
include_once("../negocio/controlador.php");

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $controlador = new Controlador();
        $usuario = $controlador->datosUsuario($id);
    
        if ($usuario) {
            // Ruta absoluta de destino (ajusta la ruta según tu configuración)
            $rutaDeDestino = __DIR__ . '/../assets/imgProfile/';
    
            if (!is_dir($rutaDeDestino)) {
                mkdir($rutaDeDestino, 0777, true);
            }
    
            // Nombre original de la imagen
            $nombreOriginal = $_FILES['imagen']['name'];
    
            $rutaDeDestinoCompleta = $rutaDeDestino . $nombreOriginal;
    
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDeDestinoCompleta)) {
                $controlador->subirImagen($id, $nombreOriginal);
    
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