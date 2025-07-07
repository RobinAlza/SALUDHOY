<?php
class AdminDAO
{
    private $id;
    private $cedula;
    private $nombre;
    private $apellido;
    private $clave;

    public function __construct($id = null, $cedula = null, $nombre = null, $apellido = null, $clave = null)
    {
        $this->id = $id;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->clave = $clave;
    }

    public function autenticar()
    {
        return "SELECT id FROM administrador WHERE nombre = '$this->nombre' AND clave = '$this->clave'";
    }


    public function consultarPorId()
    {
        return "SELECT cedula, nombre, apellido, clave FROM administrador WHERE id = $this->id";
    }
}
