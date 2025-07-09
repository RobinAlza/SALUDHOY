<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/ingresoHospitalDAO.php');

class IngresoHospital
{
    private $idIngresoHospital;
    private $idConsultorio;
    private $idCitaMedica;
    private $fechaIngreso;

    public function getIdIngresoHospital()
    {
        return $this->idIngresoHospital;
    }
    public function setIdIngresoHospital($idIngresoHospital)
    {
        $this->idIngresoHospital = $idIngresoHospital;
    }

    public function getIdConsultorio()
    {
        return $this->idConsultorio;
    }
    public function setIdConsultorio($idConsultorio)
    {
        $this->idConsultorio = $idConsultorio;
    }

    public function getIdCitaMedica()
    {
        return $this->idCitaMedica;
    }
    public function setIdCitaMedica($idCitaMedica)
    {
        $this->idCitaMedica = $idCitaMedica;
    }

    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;
    }

    public function __construct($idIngresoHospital = 0, $idConsultorio = 0, $idCitaMedica = 0, $fechaIngreso = "")
    {
        $this->idIngresoHospital = $idIngresoHospital;
        $this->idConsultorio = $idConsultorio;
        $this->idCitaMedica = $idCitaMedica;
        $this->fechaIngreso = $fechaIngreso;
    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new IngresoHospitalDAO($this->idIngresoHospital);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->idConsultorio = $registro[0];
        $this->idCitaMedica = $registro[1];
        $this->fechaIngreso = $registro[2];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new IngresoHospitalDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());

        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new IngresoHospital($registro[0], $registro[1], $registro[2], $registro[3]);
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }

    public function confirmarAsistencia()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new IngresoHospitalDAO(
            null,
            $this->idConsultorio,
            $this->idCitaMedica,
            $this->fechaIngreso
        );

        $idCita = $conexion->ejecutarConsulta($dao->confirmarAsistencia());
        $conexion->cerrarConexion();
        return $idCita;
    }
}
