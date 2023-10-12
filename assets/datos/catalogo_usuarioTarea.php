<?php
include_once("../datos/conexion.php");
include_once ("../negocio/username.php");

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
	
	function getUsuarioTarea($id_usuario)
	{	
		$conexion = new Conexion();
		$conn = $conexion->conectar();
		
		$query = "SELECT * FROM usuario_tarea WHERE id_usuario=?;";   
		$stm = $conn->prepare($query);
		
		$stm->bind_result($id_tarea,$id_usuario);
        $stm->bind_param("i", $id_usuario);
		$stm->execute();
		$stm->fetch();
		$usuario_tarea = new Usuario_Tarea ($id_tarea,$id_usuario);	
		$conexion->desconectar($conn);
		return $usuario_tarea;
	}

	function actualizarTareaResponsable($id_tarea, $id_usuario) {
		$conexion = new Conexion();
		$conn = $conexion->conectar();
	
		$query = "INSERT INTO usuario_tarea (id_usuario, id_tarea) VALUES (?, ?)";
		$stm = $conn->prepare($query);
		$stm->bind_param("ii", $id_usuario, $id_tarea);
	
		$result = $stm->execute();
	
		$conexion->desconectar($conn);
	
		return $result;
	}

}
?>