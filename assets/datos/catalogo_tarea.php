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
    
    $query = "SELECT t.id, t.titulo, t.descripcion, t.fecha_venc, t.responsable, u.nombre AS nombre_responsable
    FROM tareas t
    LEFT JOIN usuarios u ON t.responsable = u.id
    WHERE t.estado IS NULL";
 
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
            'responsable' => $row['nombre_responsable']
        );        
        $tareas[] = $tarea;
    }
    
    $conexion->desconectar($conn);
    
    return $tareas;
}
function datosTareaComplete()
{
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    $query = "SELECT t.id, t.titulo, t.descripcion, t.fecha_venc, u.nombre AS nombre_responsable, 
    (SELECT GROUP_CONCAT(iu.nombre) FROM usuario_tarea ut
     LEFT JOIN usuarios iu ON ut.id_usuario = iu.id
     WHERE ut.id_tarea = t.id) AS integrantes
    FROM tareas t
    LEFT JOIN usuarios u ON t.responsable = u.id
    WHERE t.estado IS NOT NULL";

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
            'responsable' => $row['nombre_responsable'],
            'integrantes' => $row['integrantes']
        );        
        $tareas[] = $tarea;
    }
    
    $conexion->desconectar($conn);
    
    return $tareas;
}


function actualizarEstadoTarea($tarea_id)
{
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    $query = "UPDATE tareas
	SET estado = 'Completado'
	WHERE id = ?;";
    $stm = $conn->prepare($query);

    $stm->bind_param("i",$tarea_id);

    $tarea = $stm->execute();

    $stm->close();
    $conexion->desconectar($conn);

    return $tarea;
}

}

?>