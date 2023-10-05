<?php

include("../datos/catalogo_usuario.php");
include("../datos/catalogo_tarea.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Controlador {	
		function getUsuarios()
		{
			$catUsu = new CatalogoUsuarios();
			$usuarios = $catUsu->getUsuarios();
			return $usuarios;
			
		}
		
		function getUsuario($id)
		{
			$catUsu = new CatalogoUsuarios();
			$usuario = $catUsu->getUsuario($id);
			return $usuario;
		}

		function registerUser($nombre, $email, $usuario, $password)
		{
			$catUsu = new CatalogoUsuarios();
			$registroExitoso = $catUsu->register($nombre, $email, $usuario, $password);
			return $registroExitoso;
		}
		
		function verificarUsuarioExistente($usuario) {
			$catUsu = new CatalogoUsuarios();
			$usuarioExistente = $catUsu->usuarioExistente($usuario);
			return $usuarioExistente;
		}
		function verificarUsuario($usuario, $password) {
			$catUsu = new CatalogoUsuarios();
			$usuarioLogin = $catUsu->verificarUsuario($usuario, $password);
			return $usuarioLogin;
		}
		function crearTarea($titulo, $descripcion, $vencimiento, $responsable){
			$catUsu = new CatalogoTarea();
			$tarea = $catUsu->crearTarea($titulo, $descripcion, $vencimiento, $responsable);
			return $tarea;
		}

		function getUsuariosResponsables(){
			$catUsu = new CatalogoUsuarios();
			$usuarios = $catUsu->getUsuariosResponsables();
			return $usuarios;
		}
		function editarUsuario($id, $usuario, $email, $nombre, $password){
			$catUsu = new CatalogoUsuarios();
			$usuario = $catUsu->editarUsuario($id, $usuario, $email, $nombre, $password);
			return $usuario;
		}
		function datosUsuario($id){
			$catUsu = new CatalogoUsuarios();
			$usuario = $catUsu->datosUsuario($id);
			return $usuario;
		}
		function subirImagen($id, $imagen){
			$catUsu = new CatalogoUsuarios();
			$usuario = $catUsu->subirImagen($id, $imagen);
			return $usuario;
		}


	}
?>