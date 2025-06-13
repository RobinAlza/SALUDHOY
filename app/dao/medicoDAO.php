<?php
class MedicoDAO
{
    private $numeroIdentificacion;
    private $idTipoIdentificacion;
    private $nombre;
    private $apellido;
    private $direccion;
    private $idMunicipioResidencia;
    private $fechaNacimiento;
    private $clave;
    private $idEspecializacion;

    public function __construct($numeroIdentificacion = 0, 
    $idTipoIdentificacion = 0, 
    $nombre = "", $apellido = "", 
    $direccion = "", 
    $idMunicipioResidencia = 0, 
    $fechaNacimiento = "", 
    $clave = "", 
    $idEspecializacion = 0)
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
        $this->idTipoIdentificacion = $idTipoIdentificacion;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->direccion = $direccion;
        $this->idMunicipioResidencia = $idMunicipioResidencia;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->clave = $clave;
        $this->idEspecializacion = $idEspecializacion;
    }
    public function autenticar()
    {
        return "SELECT p.numero_identificacion, p.nombre, p.clave
                FROM persona p
                JOIN medico m ON p.numero_identificacion = m.id_numero_identificacion
                WHERE p.nombre = '$this->nombre' AND p.clave = '$this->clave'";
    }
    public function consultarPorId()

    {
        return "SELECT id_tipo_identificacion, nombre, apellido, direccion, id_municipio_residencia, fecha_nacimiento, clave
                FROM persona
                WHERE numero_identificacion = $this->numeroIdentificacion";
    }

    public function consultarTodos()
    {
        return "SELECT id_persona, id_especializacion
                FROM medico";
    }
    

    public function agenda($fechaCompleta){
        return "SELECT cm.codigo_cita, c.lugar_cita, cm.id_paciente, per.nombre, per.apellido, tp.nombre_tipo, cm.fecha_cita
                FROM cita_medica  AS cm
                    JOIN medico AS m ON (cm.id_medico = m.id_medico)
                    JOIN consultorio AS c ON (cm.id_consultorio = c.id_consultorio)
                    JOIN paciente AS p ON (cm.id_paciente = p.id_paciente)
                    JOIN tipo_paciente AS tp ON (p.id_tipo_paciente = tp.id_tipo_paciente)
                    JOIN persona AS per ON (p.id_numero_identificacion = per.numero_identificacion)
                WHERE m.id_numero_identificacion = $this->numeroIdentificacion AND DATE(cm.fecha_cita) = '$fechaCompleta'
                ORDER BY cm.fecha_cita;";
    }
}
