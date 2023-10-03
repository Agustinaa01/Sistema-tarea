<?php
include_once("../negocio/controlador.php");

$json = file_get_contents('php://input');
$data = json_decode($json);

$nombre = $data->nombre;
$usuario = $data->usuario;
$email = $data->email;
$password = $data->password;

$controlador = new Controlador();

$usuarioExistente = $controlador->verificarUsuarioExistente($usuario);

if ($usuarioExistente) {
  echo json_encode(['success' => false, 'message' => 'El nombre de usuario ya está en uso']);
} else {
  $registroExitoso = $controlador->registerUser($nombre, $email, $usuario, $password);

  if ($registroExitoso) {
    echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Error en el registro']);
  }
}
?>