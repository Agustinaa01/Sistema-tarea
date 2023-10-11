<?php
include_once("../negocio/controlador.php");

$controlador = new Controlador();

$usuariosResponsables = $controlador->getUsuariosResponsables();

if ($usuariosResponsables) {
    echo json_encode($usuariosResponsables);
} else {
    echo json_encode(['success' => false, 'message' => 'No hay responsables']);
}
?>