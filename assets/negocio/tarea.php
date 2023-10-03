<?php
class Tarea {
    private $id;
    private $titulo;
    private $descripcion;
    private $fecha_venc;
    private $responsable;
    private $estado; 

    public function __contructor($nombre, $email, $usuario)
    {
        $this -> id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this ->fecha_venc = $fecha_venc;
        $this -> responsable = $responsable;
        $this -> estado = $estado; 
    }
    public function getId()
    {
        return $this->id;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getFechaVencimiento()
    {
        return $this->fecha_venc;
    }
    public function getResponsable()
    {
        return $this-> responsable;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setFechaVencimiento($fecha_venc)
    {
        $this->fecha_venc = $fecha_venc;
    }
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    
}
?>