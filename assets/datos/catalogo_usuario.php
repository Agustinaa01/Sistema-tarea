<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("conexion.php");
include_once "../negocio/username.php";

class CatalogoUsuarios {	
    function getUsuarios()
    {	
        $usuarios = array();
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $query = "SELECT * FROM usuarios WHERE eliminado=0;";   
        $stm = $conn->prepare($query);
        
        $stm->bind_result($id, $nombre, $email, $usuario, $imagen, $password);
            
        $stm->execute();
        
        while($stm->fetch())
        {
            $usuario = new Usuario($id, $nombre, $email, $usuario, $imagen, $password);
            $usuarios[] = $usuario;
        }
        
        $conexion->desconectar($conn);
        
        return $usuarios;
    }
    
    function getUsuario($id)
    {	
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $query = "SELECT * FROM usuarios WHERE id=?;";   
        $stm = $conn->prepare($query);
        
        $stm->bind_param("i", $id);
        $stm->bind_result($id, $nombre, $email, $usuario, $imagen, $password);
            
        $stm->execute();
        $stm->fetch();
        $usuario = new Usuario($id, $nombre, $email, $usuario, $imagen, $password);	
        $conexion->desconectar($conn);
        return $usuario;
    }

    function register($nombre, $email, $usuario, $password)
    {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $hashedPassword = md5($password);
        $query = "INSERT INTO usuarios (nombre, email, usuario, password) VALUES (?, ?, ?, ?);";   
        $stm = $conn->prepare($query);
        
        $stm->bind_param("ssss", $nombre, $email, $usuario, $hashedPassword);
    
        $result = $stm->execute();
        
        $conexion->desconectar($conn);
        
        return $result;
    }

    function usuarioExistente($usuario) {
        $conexion = new Conexion();
        $conn = $conexion->conectar();

        $query = "SELECT COUNT(*) FROM usuarios WHERE usuario = ? and eliminado=0;";
        $stm = $conn->prepare($query);

        $stm->bind_param("s", $usuario);
        $stm->execute();

        $result = $stm->get_result();
        $row = $result->fetch_assoc();

        $conexion->desconectar($conn);

        return $row['COUNT(*)'] > 0;
    }

    function verificarUsuario($usuario, $password) {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
    
        $query = "SELECT * FROM usuarios WHERE usuario=?";   
        $stm = $conn->prepare($query);
    
        $stm->bind_param("s", $usuario);
        $stm->execute();
        $result = $stm->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
            $hashedPasswordInput = md5($password);
            echo($hashedPasswordInput); // Check the hashed input password
            echo($hashedPassword);        

            if ($hashedPasswordInput == $hashedPassword) {
                $usuario = new Usuario($row['id'], $row['nombre'], $row['email'], $row['usuario'], $row['imagen'], $row['password']);
                $stm->close();
                $conexion->desconectar($conn);
    
                echo "Inicio de sesión exitoso"; 
                return $usuario;
            } else {
                echo "Contraseñas no coinciden"; 
                return NULL;
            }
        } else {
            echo "Usuario no encontrado"; 
            return NULL;
        }
    }

    function getUsuariosResponsables()
    {
        $usuarios = array();
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $query = "SELECT id, nombre FROM usuarios";
        $stm = $conn->prepare($query);
        
        if ($stm === false) {
            return false;
        }
        
        $stm->execute();
        $stm->bind_result($id, $nombre);
        
        while ($stm->fetch()) {
            $usuarios[] = ['id' => $id, 'nombre' => $nombre];
        }
        
        $conexion->desconectar($conn);
        
        return $usuarios;
    }
    
    function editarUsuario($id, $usuario, $email, $nombre, $password)
    {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
    
        $hashedPassword = md5($password);
    
        $query = "UPDATE usuarios SET nombre = ?, usuario = ?, email = ?, password = ? WHERE id = ?";
        $stm = $conn->prepare($query);
        
        $stm->bind_param("ssssi", $nombre, $usuario, $email, $hashedPassword, $id);
        
        $stm->execute();
    
        $stm->close();
        $conexion->desconectar($conn);
        return $usuario;
    }    
    
    function datosUsuario($id)
    {	
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $query = "SELECT * FROM usuarios WHERE id = ?;";   
        $stm = $conn->prepare($query);
        
        $stm->bind_param("i", $id);
         
        $stm->execute();
        $result = $stm->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $usuario = new Usuario($row['id'], $row['nombre'], $row['email'], $row['usuario'], $row['password'], $row['imagen']);
            return $usuario;
        } else {
            echo "No funca";
        }
        $conexion->desconectar($conn);
    }
  
function subirImagen($id, $imagen)
{
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    $query = "UPDATE usuarios SET imagen = ? WHERE id = ?";
    $stm = $conn->prepare($query);
    
    $stm->bind_param("si", $imagen, $id);
    
    $stm->execute();

    $stm->close();
    $conexion->desconectar($conn);
    return $imagen;
}     
}
?>