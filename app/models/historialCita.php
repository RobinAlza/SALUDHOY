<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/historialCitaDAO.php');

class HistorialCita
{
    private $id_historial_cita;
    private $codigo_cita;
    private $fechaInicio;
    private $fechaTerminacion;
    private $motivo;
    private $estadoCita;

    public function getCodigoCita()
    {
        return $this->codigo_cita;
    }
    public function setCodigoCita($codigo_cita)
    {
        $this->codigo_cita = $codigo_cita;
    }
    
    public function getEstadoCita()
    {
        return $this->estadoCita;
    }
    public function setEstadoCita($estadoCita)
    {
        $this->estadoCita = $estadoCita;
    }

    public function getIdHistorialCita()
    {
        return $this->id_historial_cita;
    }
    public function setIdHistorialCita($id_historial_cita)
    {
        $this->id_historial_cita = $id_historial_cita;
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

    public function __construct($id_historial_cita = 0, $codigo_cita = 0,  $fechaInicio = "", $fechaTerminacion = null, $motivo = null, $estadoCita = 0)
    {
        $this->id_historial_cita = $id_historial_cita;
        $this->codigo_cita = $codigo_cita;
        $this->fechaInicio = $fechaInicio;
        $this->fechaTerminacion = $fechaTerminacion;
        $this->motivo = $motivo;
        $this->estadoCita = $estadoCita;
    }

    public function consultarPorId()
    {

        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new HistorialCitaDAO($this->id_historial_cita);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->codigo_cita = $registro[0];
        $this->fechaInicio = $registro[1];
        $this->fechaTerminacion = $registro[2];
        $this->motivo = $registro[3];
        $this->estadoCita = $registro[4];

        $conexion->cerrarConexion();
        return true;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new HistorialCitaDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());

        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new HistorialCita($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5]);
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }

    public function updateCita()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        // Asegúrate de que el DAO esté correcto:
        $dao = new HistorialCitaDAO(
            0,                      // id_historial_cita
            $this->codigo_cita,     // codigo_cita
            $this->fechaInicio,     // fechaInicio
            $this->fechaTerminacion,// fechaTerminacion
            $this->motivo,          // motivo
            $this->estadoCita       // estadoCita
        );


        $sql = $dao->modificar();  // tu método modificar() en el DAO
        $resultado = $conexion->ejecutarConsulta($sql);

        $conexion->cerrarConexion();
        return $resultado;
    }

    public function guardarHistorial()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $pacienteDAO = new HistorialCitaDAO(
            null,
            $this->codigo_cita,
            $this->fechaInicio
        );
        $conexion->ejecutarConsulta($pacienteDAO->guardarHistorial());
        $conexion->cerrarConexion();

        return true;
    }

    
}
