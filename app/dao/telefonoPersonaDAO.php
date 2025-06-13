<?php
class TelefonoPersonaDAO
{
    private $idPersona;
    private $telefono;

    public function __construct($idPersona = 0, $telefono = "")
    {
        $this->idPersona = $idPersona;
        $this->telefono = $telefono;
    }

    public function consultarPorId()
    {
        return "SELECT id_persona, telefono 
                FROM telefono_persona 
                WHERE id_persona = $this->idPersona AND telefono = '$this->telefono'";
    }

    public function consultarTodos()
    {
        return "SELECT id_persona, telefono 
                FROM telefono_persona";
    }
    public function consultarNumeros()
    {
        return "SELECT telefono
        FROM telefono_persona 
        WHERE id_persona = '$this->idPersona'";
    }

    public function guardarNumeros()
    {
        return "INSERT INTO telefono_persona (id_persona, telefono)
                VALUES ($this->idPersona, '$this->telefono')
        ";
    }

        public function actualizarNumeros()
    {
        return "UPDATE telefono_persona  SET  telefono = '$this->telefono'
                WHERE id_persona = $this->idPersona;";
    }
}
