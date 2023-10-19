<?php

include("../datos/catalogo_usuario.php");
include("../datos/catalogo_tarea.php");
include("../datos/catalogo_usuarioTarea.php");
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
		function datosTarea(){
			$catUsu = new CatalogoTarea();
			$tareas = $catUsu->datosTarea();
			return $tareas;
		}
		function datosTareaComplete(){
			$catUsu = new CatalogoTarea();
			$tareas = $catUsu->datosTareaComplete();
			return $tareas;
		}
		function subirImagen($id, $imagen){
			$catUsu = new CatalogoUsuarios();
			$usuario = $catUsu->subirImagen($id, $imagen);
			return $usuario;
		}		
		function actualizarTareaResponsable($id_tarea, $id_usuario){
			$catUsu = new CatalogoUsuarioTarea();
			$tarea = $catUsu->actualizarTareaResponsable($id_tarea, $id_usuario);
			return $tarea;
		}
		function getUsuarioTarea(){
			$catUsu = new CatalogoUsuarioTarea();
			$tarea = $catUsu->getUsuarioTarea();
			return $tarea;
		}
		function obtenerNombreUsuario($id_usuario) {
			$catUsuario = new CatalogoUsuarioTarea(); 
			$usuario = $catUsuario->obtenerNombreUsuario($id_usuario);
			return $usuario;
		}
		function actualizarEstadoTarea($tarea_id) {
			$catTarea = new CatalogoTarea(); 
			$tarea = $catTarea-> actualizarEstadoTarea($tarea_id);
			return $tarea;
		}
		function bajaLogica($id_tarea) {
			$catTarea = new CatalogoTarea(); 
			$tarea = $catTarea-> bajaLogica($id_tarea);
			return $tarea;
		}
	}
?>