<?php
class HistorialCitaDAO
{
    private $id_historial_cita;
    private $codigo_cita;
    private $fechaInicio;
    private $fechaTerminacion;
    private $motivo;
    private $estadoCita;


    public function __construct($id_historial_cita = 0, $codigo_cita = "", $fechaInicio = "", $fechaTerminacion = null, $motivo = null, $estadoCita = 0)
    {
        $this->id_historial_cita = $id_historial_cita;
        $this->codigo_cita = $codigo_cita;
        $this->fechaInicio = $fechaInicio;
        $this->fechaTerminacion = $fechaTerminacion;
        $this->motivo = $motivo;
        $this->estadoCita = $estadoCita;
    }

    public function cancelarCita()
    {
        return "UPDATE historial_cita SET fecha_terminacion = '$this->fechaTerminacion', motivo = '$this->motivo' , id_estado_cita = 2
                WHERE codigo_cita = $this->codigo_cita";
    }

    public function consultarTodos()
    {
        return "SELECT id_historial_cita, codigo_cita, fecha_inicio, fecha_terminacion, motivo, id_estado_cita 
                FROM historial_cita";
    }
     public function consultarPorId()
    {
        return "SELECT codigo_cita, fecha_inicio, fecha_terminacion, motivo, id_estado_cita 
                FROM historial_cita
                WHERE id_historial_cita = $this->id_historial_cita";
    }
    public  function guardarHistorial()
    {
        return "INSERT INTO historial_cita(codigo_cita, fecha_inicio, id_estado_cita) 
        VALUES ($this->codigo_cita,'$this->fechaInicio', 1)";
    }
}
