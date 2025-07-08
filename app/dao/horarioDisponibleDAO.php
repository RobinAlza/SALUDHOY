<?php
class HorarioDisponibleDAO
{
    private $idPersona;
    private $fechaHorario;

    public function __construct( $idPersona = 0, $fechaHorario = "")
    {
        $this->idPersona = $idPersona;
        $this->fechaHorario = $fechaHorario;
    }

    public function consultarPorId()
    {
        return "SELECT id_medico, fecha_horario
                FROM horario_disponible";
    }

    public function consultarTodos()
    {
        return "SELECT id_horario_disponible, id_persona, fecha_horario
                FROM horario_disponible";
    }

    public function consultarPorFecha($fecha, $id_medico)
    {
            return "SELECT id_medico, fecha_horario
            FROM horario_disponible
            WHERE id_medico=$id_medico AND fecha_horario BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
    }
    public function consultarYa($fecha, $id_medico){
        return "SELECT id_medico, fecha_cita
                FROM cita_medica
                WHERE id_medico=$id_medico AND fecha_cita BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
    }
    public function franjaHorariaEspecifica($fecha, $hora, $id_medico){
        return "SELECT hora, estado
                FROM horario_disponible
                WHERE id_medico=$id_medico AND fecha_horario = '$fecha $hora'";
    }
    public function insertar($fecha, $hora, $id_medico){
        return "INSERT INTO horario_disponible (fecha_horario, id_medico)
                VALUES ('$fecha $hora', $id_medico)";
    }
        
    public function eliminar($fecha, $hora, $id_medico){
        return "DELETE FROM horario_disponible
                WHERE fecha_horario = '$fecha $hora' AND id_medico = $id_medico";
    }
}
