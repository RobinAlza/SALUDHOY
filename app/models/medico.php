<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/medicoDAO.php');

class Medico extends Persona
{
    private $idEspecializacion;
    public function getIdEspecializacion()
    {
        return $this->idEspecializacion;
    }
    public function setIdEspecializacion($idEspecializacion)
    {
        $this->idEspecializacion = $idEspecializacion;
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
        $idEspecializacion = 0
    ) {
        parent::__construct(
            $numeroIdentificacion,
            $idTipoIdentificacion,
            $nombre,
            $apellido,
            $direccion,
            $idMunicipioResidencia,
            $fechaNacimiento,
            $clave
        );
        $this->idEspecializacion = $idEspecializacion;
    }

    public function autenticar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $medicoDAO = new medicoDAO(null, null, $this->nombre, null, null, null, null, $this->clave, null);
        $conexion->ejecutarConsulta($medicoDAO->autenticar());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $registro = $conexion->siguienteRegistro();
        $this->numeroIdentificacion = $registro[0];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new MedicoDAO($this->numeroIdentificacion);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->idTipoIdentificacion = $registro[0];
        $this->nombre = $registro[1];
        $this->apellido = $registro[2];
        $this->direccion = $registro[3];
        $this->idMunicipioResidencia = $registro[4];
        $this->fechaNacimiento = $registro[5];
        $this->clave = $registro[6];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new MedicoDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());

        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new Medico($registro[0], $registro[1]);
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }
}
