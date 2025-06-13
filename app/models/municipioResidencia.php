<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/municipioResidenciaDAO.php');

class MunicipioResidencia
{
    private $idMunicipioResidencia;
    private $municipio;

    public function getIdMunicipioResidencia()
    {
        return $this->idMunicipioResidencia;
    }
    public function setIdMunicipioResidencia($idMunicipioResidencia)
    {
        $this->idMunicipioResidencia = $idMunicipioResidencia;
    }

    public function getMunicipio()
    {
        return $this->municipio;
    }
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;
    }

    public function __construct($idMunicipioResidencia = 0, $municipio = "")
    {
        $this->idMunicipioResidencia = $idMunicipioResidencia;
        $this->municipio = $municipio;
    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new MunicipioResidenciaDAO($this->idMunicipioResidencia);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->municipio = $registro[0];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new MunicipioResidenciaDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());

        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new MunicipioResidencia($registro[0], $registro[1]);
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }
}
?>
