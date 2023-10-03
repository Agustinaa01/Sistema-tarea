<?php
class Usuario_Tarea {
    private $id_usuario;
    private $id_tarea;

    public function __construct($id_tarea, $id_usuario)
    {
        $this->id_usuario = $id_usuario;
        $this -> id_tarea = $id_tarea;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario
    }
    public function getIdTarea()
    {
        return $this -> id_tarea
    }
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario
    }
    public function setIdTarea($id_tarea)
    {
        $this-> id_tarea = $id_tarea
    }
}
?>