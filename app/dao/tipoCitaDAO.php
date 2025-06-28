<?php
class TipoCitaDAO
{
    private $idTipoCita;
    private $especialidad;

    public function __construct($idTipoCita = 0, $especialidad = "")
    {
        $this->idTipoCita = $idTipoCita;
        $this->especialidad = $especialidad;
    }

    public function consultarPorId()
    {
        return "SELECT especialidad
                FROM tipo_cita
                WHERE id_tipo_cita = $this->idTipoCita";
    }

    public function consultarTodos()
    {
        return"SELECT id_tipo_cita, especialidad 
                    FROM tipo_cita";
    }
}
?>