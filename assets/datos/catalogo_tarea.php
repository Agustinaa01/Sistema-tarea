<?php
include_once("conexion.php");
include_once "../negocio/tarea.php";

class CatalogoTarea {	
	function getTareas()
	{	
		$tareas = array();
		$conexion = new Conexion();
		$conn = $conexion->conectar();
		
		$query = "SELECT * FROM tareas WHERE eliminado=0;";   
		$stm = $conn->prepare($query);
		
		$stm->bind_result($id, $titulo, $descripcion, $fecha_venc, $responsable,$estado);
			
		$stm->execute();
		
		while($stm->fetch())
		{
			$tarea = new Tarea($id,$titulo, $descripcion, $fecha_venc, $responsable,$estado);
			$tareas[] = $tarea;
		}
		
		$conexion->desconectar($conn);
		
		return $tareas;
	}
	
	function getTarea($id)
	{	
		$conexion = new Conexion();
		$conn = $conexion->conectar();
		
		$query = "SELECT * FROM tareas WHERE id=?;";   
		$stm = $conn->prepare($query);
		
		$stm->bind_result($id,$titulo, $descripcion, $fecha_venc, $responsable,$estado);
		$stm->bind_param("i", $id);
		$stm->execute();
		$stm->fetch();
		$tarea = new Tarea ($id, $titulo, $descripcion, $fecha_venc, $responsable,$estado);	
		$conexion->desconectar($conn);
		return $tarea;
	}
    function crearTarea($titulo, $descripcion, $vencimiento, $responsable)
    {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
		$query = "INSERT INTO tareas (titulo, descripcion, fecha_venc, responsable) VALUES (?, ?, ?, ?)";
		$stm = $conn->prepare($query);
		$stm->bind_param("ssss", $titulo, $descripcion, $vencimiento, $responsable);
		$result = $stm->execute();
		
        $conexion->desconectar($conn);
        
        return $result;
    }	
	function datosTarea()
	{
		$conexion = new Conexion();
		$conn = $conexion->conectar();
		
		$query = "SELECT * FROM tareas";   
		$stm = $conn->prepare($query);
		
		$stm->execute();
		$result = $stm->get_result();
		
		$tareas = array();
		
		while ($row = $result->fetch_assoc()) {
			$tarea = array(
				'id' => $row['id'],
				'titulo' => $row['titulo'],
				'descripcion' => $row['descripcion'],
				'fecha_venc' => $row['fecha_venc'],
				'responsable' => $row['responsable'],
				'estado' => $row['estado']
			);        
			$tareas[] = $tarea;
		}
		
		$conexion->desconectar($conn);
		
		return $tareas;
	}
}
?>