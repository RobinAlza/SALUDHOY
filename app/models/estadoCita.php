<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/estadoCitaDAO.php');

class EstadoCita
{
    private $idEstadoCita;
    private $estadoCita;
    private $fechaInicio;
    private $fechaTerminacion;
    private $motivo;

    public function getIdEstadoCita()
    {
        return $this->idEstadoCita;
    }
    public function setIdEstadoCita($idEstadoCita)
    {
        $this->idEstadoCita = $idEstadoCita;
    }

    public function getEstadoCita()
    {
        return $this->estadoCita;
    }
    public function setEstadoCita($estadoCita)
    {
        $this->estadoCita = $estadoCita;
    }

    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    public function getFechaTerminacion()
    {
        return $this->fechaTerminacion;
    }
    public function setFechaTerminacion($fechaTerminacion)
    {
        $this->fechaTerminacion = $fechaTerminacion;
    }

    public function getMotivo()
    {
        return $this->motivo;
    }
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }

    public function __construct($idEstadoCita = 0, $estadoCita = "", $fechaInicio = "", $fechaTerminacion = null, $motivo = null)
    {
        $this->idEstadoCita = $idEstadoCita;
        $this->estadoCita = $estadoCita;
        $this->fechaInicio = $fechaInicio;
        $this->fechaTerminacion = $fechaTerminacion;
        $this->motivo = $motivo;
    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new EstadoCitaDAO($this->idEstadoCita);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->estadoCita = $registro[0];
        $this->fechaInicio = $registro[1];
        $this->fechaTerminacion = $registro[2];
        $this->motivo = $registro[3];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new EstadoCitaDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());

        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new EstadoCita($registro[0], $registro[1], $registro[2], $registro[3], $registro[4]);
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }
}
?>
