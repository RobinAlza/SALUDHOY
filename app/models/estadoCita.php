<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/estadoCitaDAO.php');

class EstadoCita
{
    private $id_estado_cita;
    private $descripcion_estado;

    public function getIdEstdoCita()
    {
        return $this->id_estado_cita;
    }
    public function setIdEstdoCita($id_estado_cita)
    {
        $this->id_estado_cita = $id_estado_cita;
    }

    public function getDescripcion()
    {
        return $this->descripcion_estado;
    }
    public function setDescripcion($descripcion_estado)
    {
        $this->descripcion_estado = $descripcion_estado;
    }

    public function __construct($id_estado_cita = 0, $descripcion_estado = "")
    {
        $this->id_estado_cita = $id_estado_cita;
        $this->descripcion_estado = $descripcion_estado;
    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new EstadoCitaDAO($this->id_estado_cita);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->id_estado_cita = $registro[0];
        $this->descripcion_estado = $registro[1];

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
            $obj = new EstadoCita($registro[0], $registro[1]);
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }
}
