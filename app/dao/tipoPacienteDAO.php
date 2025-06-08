<?php
class TipoPacienteDAO
{
    private $idTipoPaciente;
    private $nombreTipo;

    public function __construct($idTipoPaciente = 0, $nombreTipo = "")
    {
        $this->idTipoPaciente = $idTipoPaciente;
        $this->nombreTipo = $nombreTipo;
    }

    public function consultarPorId()
    {
        return "SELECT nombre_tipo 
                FROM tipo_paciente 
                WHERE id_tipo_paciente = $this->idTipoPaciente";
    }

    public function consultarTodos()
    {
        return "SELECT id_tipo_paciente, nombre_tipo
                FROM tipo_paciente";
    }
}
