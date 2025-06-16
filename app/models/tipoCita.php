<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/tipoCitaDAO.php');

class TipoCita
{
    private $idTipoCita;
    private $especialidad;

    public function getIdTipoCita()
    {
        return $this->idTipoCita;
    }

    public function setIdTipoCita($idTipoCita)
    {
        $this->idTipoCita = $idTipoCita;
    }

    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;
    }

    public function __construct($idTipoCita = 0, $especialidad = "")
    {
        $this->idTipoCita = $idTipoCita;
        $this->especialidad = $especialidad;
    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new TipoCitaDAO($this->idTipoCita);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->especialidad = $registro[0];

        $conexion->cerrarConexion();
        return true;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new TipoCitaDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());
        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new TipoCita(
                $registro[0],
                $registro[1]
            );
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }
}
