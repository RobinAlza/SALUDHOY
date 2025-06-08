<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/especializacionDAO.php');

class Especializacion
{
    private $idEspecializacion;
    private $especializacion;

    public function getIdEspecializacion()
    {
        return $this->idEspecializacion;
    }
    public function setIdEspecializacion($idEspecializacion)
    {
        $this->idEspecializacion = $idEspecializacion;
    }

    public function getEspecializacion()
    {
        return $this->especializacion;
    }
    public function setEspecializacion($especializacion)
    {
        $this->especializacion = $especializacion;
    }

    public function __construct($idEspecializacion = 0, $especializacion = "")
    {
        $this->idEspecializacion = $idEspecializacion;
        $this->especializacion = $especializacion;
    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $dao = new EspecializacionDAO($this->idEspecializacion);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->especializacion = $registro[0];

        $conexion->cerrarConexion();
        return true;
    }


    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new EspecializacionDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());

        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new Especializacion($registro[0], $registro[1]);
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }
}
