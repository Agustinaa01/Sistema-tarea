<?php
class Conexion
{
    function conectar()
    {
        $server = "127.0.0.1"; 
        $base_datos = "r0000169_tareas"; 
        $user = "r0000169_tareas"; 
        $pass = "88ROlalado"; 
        $conn = new mysqli($server, $user, $pass, $base_datos);
        if ($conn->connect_errno) {
            echo ("Error al conectarse al servidor: " . $conn->connect_error);
        } else {
            $stm = $conn->prepare("SET time_zone = '-03:00';");
            $stm->execute();
        }

        return $conn;
    }

    function desconectar($conn)
    {
        $conn->close();
    }
}

?>