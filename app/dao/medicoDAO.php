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
    private $id_medico;

    public function __construct($numeroIdentificacion = 0, 
    $idTipoIdentificacion = 0, 
    $nombre = "", $apellido = "", 
    $direccion = "", 
    $idMunicipioResidencia = 0, 
    $fechaNacimiento = "", 
    $clave = "", 
    $idEspecializacion = 0, 
    $id_medico = 0)
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
        $this->id_medico = $id_medico;
    }
    public function autenticar()
    {
        return "SELECT p.numero_identificacion, p.nombre, p.clave
                FROM persona p
                JOIN medico m ON p.numero_identificacion = m.id_numero_identificacion
                WHERE p.nombre = '$this->nombre' AND p.clave = '$this->clave'";
    }


    public function consultar()
    {
        return "SELECT 
                p.numero_identificacion,
                p.id_tipo_identificacion,
                p.nombre,
                p.apellido,
                p.direccion,
                p.id_municipio_residencia,
                p.fecha_nacimiento,
                p.clave,
                e.id_especializacion,
                m.id_medico
            FROM persona p
            JOIN medico m ON p.numero_identificacion = m.id_numero_identificacion
            JOIN especializacion e ON m.id_especializacion = e.id_especializacion
            WHERE numero_identificacion = $this->numeroIdentificacion";
    }
    
    public function consultarPorNombre()
    {
        return "SELECT 
                p.numero_identificacion,
                p.id_tipo_identificacion,
                p.nombre,
                p.apellido,
                p.direccion,
                p.id_municipio_residencia,
                p.fecha_nacimiento,
                p.clave,
                e.id_especializacion,
                m.id_medico
            FROM persona p
            JOIN medico m ON p.numero_identificacion = m.id_numero_identificacion
            JOIN especializacion e ON m.id_especializacion = e.id_especializacion
            WHERE nombre = $this->nombre";
    }


    public function consultarPorId()

    {
        return "SELECT id_tipo_identificacion, nombre, apellido, direccion, id_municipio_residencia, fecha_nacimiento, clave
                FROM persona
                WHERE numero_identificacion = $this->numeroIdentificacion";
    }



    public function actualizar()
    {
        return "UPDATE persona SET 
                id_tipo_identificacion = $this->idTipoIdentificacion,
                nombre = '$this->nombre',
                apellido = '$this->apellido',
                direccion = '$this->direccion',
                id_municipio_residencia = $this->idMunicipioResidencia,
                fecha_nacimiento = '$this->fechaNacimiento',
                clave = '$this->clave'
            WHERE numero_identificacion = $this->numeroIdentificacion";
    }

    public function consultarTodos()
    {
        return "SELECT id_persona, id_especializacion
                FROM medico";
    }

    public function agenda($fecha, $id_medico)
    {
        return "SELECT cm.codigo_cita, c.lugar_cita, cm.id_paciente, per.nombre, per.apellido, tp.nombre_tipo
                FROM cita_medica  AS cm
                    JOIN medico AS m ON (cm.id_medico = m.id_medico)
                    JOIN consultorio AS c ON (cm.id_consultorio = c.id_consultorio)
                    JOIN paciente AS p ON (cm.id_paciente = p.id_paciente)
                    JOIN tipo_paciente AS tp ON (p.id_tipo_paciente = tp.id_tipo_paciente)
                    JOIN persona AS per ON (p.id_paciente = per.numero_identificacion)
                WHERE m.id_medico = $id_medico AND DATE(cm.fecha_cita) = $fecha
                ORDER BY cm.fecha_cita";
    }
}
