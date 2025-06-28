<?php
class EstadoCitaDAO
{
    private $id_estado_cita ;
    private $descripcion_estado;



    public function __construct($id_estado_cita = 0, $descripcion_estado = "")
    {
        $this->id_estado_cita = $id_estado_cita;
        $this->descripcion_estado = $descripcion_estado;

    }

    public function consultarPorId()
    {
        return "SELECT descripcion_estado
                FROM  estado_cita
                WHERE id_estado_cita = $this->id_estado_cita";
    }

    public function consultarTodos()
    {
        return "SELECT id_estado_cita, descripcion_estado
                FROM  estado_cita";
    }
}
