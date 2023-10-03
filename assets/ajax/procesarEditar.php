<?php
session_start();
include_once("../negocio/controlador.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$json = file_get_contents('php://input');
$data = json_decode($json);

$nombre = $data->nombre;
$usuario = $data->usuario;
$email = $data->email;

$id = $_SESSION['id']; 

$controlador = new Controlador();

$usuario = $controlador->editarUsuario($id, $usuario, $email, $nombre);

if ($usuario) {
  echo json_encode(['success' => true, 'message' => 'Usuario editado']);
} else {
  echo json_encode(['success' => false, 'message' => 'Usuario no editado']);
}
?>