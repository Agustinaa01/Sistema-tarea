<?php
class Usuario{
    private $id;
    private $nombre;
    private $email;
    private $usuario; 
    private $password;
    private $imagen;

    public function __construct($id, $nombre, $email, $usuario, $password, $imagen)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->usuario = $usuario;
        $this->password = $password;
        $this->imagen = $imagen;
    }
    
    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

}
?>