<?php
session_start();
include_once("../negocio/controlador.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);
$json = file_get_contents('php://input');
$data = json_decode($json);

$usuario= $data->usuario;
$password = $data->password;

$controlador = new Controlador();

$usuarioLogin = $controlador->verificarUsuario($usuario, $password);

if ($usuarioLogin) {
    $_SESSION['id'] = $usuarioLogin->getId();
    echo json_encode(array("success" => true, "message" => "Inicio de sesión exitoso"));
} else {
    echo json_encode(array("success" => false, "message" => "Credenciales incorrectas"));
}
?>