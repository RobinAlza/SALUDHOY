<?php
require_once(__DIR__ . '/../config/conexion.php');

class Persona
{
    protected $numeroIdentificacion;
    protected $idTipoIdentificacion;
    protected $nombre;
    protected $apellido;
    protected $direccion;
    protected $idMunicipioResidencia;
    protected $fechaNacimiento;
    protected $clave;


    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }
    public function setNumeroIdentificacion($numeroIdentificacion)
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
    }

    public function getIdTipoIdentificacion()
    {
        return $this->idTipoIdentificacion;
    }
    public function setIdTipoIdentificacion($idTipoIdentificacion)
    {
        $this->idTipoIdentificacion = $idTipoIdentificacion;
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

    public function getDireccion()
    {
        return $this->direccion;
    }
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function getIdMunicipioResidencia()
    {
        return $this->idMunicipioResidencia;
    }
    public function setIdMunicipioResidencia($idMunicipioResidencia)
    {
        $this->idMunicipioResidencia = $idMunicipioResidencia;
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function getClave()
    {
        return $this->clave;
    }
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    public function __construct(
        $numeroIdentificacion = 0,
        $idTipoIdentificacion = 0,
        $nombre = "",
        $apellido = "",
        $direccion = "",
        $idMunicipioResidencia = 0,
        $fechaNacimiento = "",
        $clave = "",
    ) {
        $this->numeroIdentificacion = $numeroIdentificacion;
        $this->idTipoIdentificacion = $idTipoIdentificacion;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->direccion = $direccion;
        $this->idMunicipioResidencia = $idMunicipioResidencia;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->clave = $clave;
    }
        public function nombreCompleto()
    {
        return $this->getNombre() . " " . $this->getApellido() . "   ";
    }
}
?>