<?php
include_once("../datos/conexion.php");
include_once ("../negocio/username.php");
include_once ("../negocio/usuarioTarea.php");

class CatalogoUsuarioTarea {	
	function getUsuarioTareas()
	{	
		$usuario_tareas = array();
		$conexion = new Conexion();
		$conn = $conexion->conectar();
		
		$query = "SELECT * FROM usuario_tarea;";   
		$stm = $conn->prepare($query);
		
		$stm->bind_result($id_tarea,$id_usuario);
			
		$stm->execute();
		
		while($stm->fetch())
		{
			$usuario_tarea = new Usuario_Tarea($id_tarea,$id_usuario);
			$usuario_tareas[] = $usuario_tarea;
		}
		
		$conexion->desconectar($conn);
		
		return $usuario_tareas;
	}
	
	function getUsuarioTarea()
	{	
		$conexion = new Conexion();
		$conn = $conexion->conectar();
		
		$query = "SELECT * FROM usuario_tarea";   
		$stm = $conn->prepare($query);
		// $stm->bind_param("i", $id_tarea);
		$stm->execute();
		
		$result = $stm->get_result();

		
		while ($row = $result->fetch_assoc()) {
			$usuario_tareas[] = new Usuario_Tarea($row['id_tarea'], $row['id_usuario']);
		}
		
		$conexion->desconectar($conn);
		return $usuario_tareas;
	}	
	function obtenerNombreUsuario($id_usuario) {
		$conexion = new Conexion();
		$conn = $conexion->conectar();
		
		$query = "SELECT nombre FROM usuarios WHERE id IN (SELECT id_usuario FROM usuario_tarea WHERE id_usuario = ?)";
		$stm = $conn->prepare($query);
		$stm->bind_param("i", $id_usuario);
		$stm->execute();
		$result = $stm->get_result();
		
		$nombresUsuarios = array();
		
		while ($row = $result->fetch_assoc()) {
			$nombresUsuarios[] = $row['nombre'];
		}
		
		$conexion->desconectar($conn);
		
		return $nombresUsuarios;
	}	
	
	function actualizarTareaResponsable($id_tarea, $id_usuario) {
		$conexion = new Conexion();
		$conn = $conexion->conectar();
	
		$query = "INSERT INTO usuario_tarea (id_usuario, id_tarea) VALUES (?, ?)
		ON DUPLICATE KEY UPDATE id_usuario = VALUES(id_usuario), id_tarea = VALUES(id_tarea);
		";
		$stm = $conn->prepare($query);
		$stm->bind_param("ii", $id_usuario, $id_tarea);
	
		$result = $stm->execute();
	
		$conexion->desconectar($conn);
	
		return $result;
	}

}
?>