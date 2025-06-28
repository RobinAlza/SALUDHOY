
<?php

require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/administradorDAO.php');
class Admin
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

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCedula()
    {
        return $this->cedula;
    }
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getApellido()
    {
        return $this->apellido;
    }
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }
    public function getClave()
    {
        return $this->clave;
    }
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    public function NombreCompleto()
    {
        return $this->nombre . " " . $this->apellido. "  ";
    }

    public function autenticar()
    {
        $conexion = new Conexion;
        $conexion->abrirConexion();
        $adminDAO = new AdminDAO(null, null, $this->nombre, null, $this->clave);
        $conexion->ejecutarConsulta($adminDAO->autenticar());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $registro = $conexion->siguienteRegistro();
        $this->id = $registro[0];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarPorId()
    {
        $conexion = new Conexion;
        $conexion->abrirConexion();
        $adminDAO = new AdminDAO($this->id);
        $conexion->ejecutarConsulta($adminDAO->consultarPorId());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $registro = $conexion->siguienteRegistro();
        $this->cedula = $registro[0];
        $this->nombre = $registro[1];
        $this->apellido = $registro[2];
        $this->clave = $registro[3];

        $conexion->cerrarConexion();
        return true;
    }
}
