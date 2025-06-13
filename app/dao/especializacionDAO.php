<?php
class EspecializacionDAO
{
    private $idEspecializacion;
    private $especializacion;

    public function __construct($idEspecializacion = 0, $especializacion = "")
    {
        $this->idEspecializacion = $idEspecializacion;
        $this->especializacion = $especializacion;
    }
    public function consultarPorId()
    {
        return "SELECT especializacion 
            FROM especializacion 
            WHERE id_especializacion = $this->idEspecializacion";
    }


    public function consultarTodos()
    {
        return "SELECT id_especializacion, especializacion
                FROM especializacion";
    }
}
