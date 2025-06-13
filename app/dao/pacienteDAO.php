<?php
class PacienteDAO
{
    private $numeroIdentificacion;
    private $idTipoIdentificacion;
    private $nombre;
    private $apellido;
    private $direccion;
    private $idMunicipioResidencia;
    private $fechaNacimiento;
    private $clave;
    private $idTipoPaciente;

    public function __construct($numeroIdentificacion = 0, $idTipoIdentificacion = 0, $nombre = "", $apellido = "", $direccion = "", $idMunicipioResidencia = 0, $fechaNacimiento = "", $clave = "", $idTipoPaciente = 0)
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
        $this->idTipoIdentificacion = $idTipoIdentificacion;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->direccion = $direccion;
        $this->idMunicipioResidencia = $idMunicipioResidencia;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->clave = $clave;
        $this->idTipoPaciente = $idTipoPaciente;
    }
    public function autenticar()
    {
        return "SELECT p.numero_identificacion, p.nombre, p.clave
                FROM persona p
                JOIN paciente e ON p.numero_identificacion = e.id_numero_identificacion
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
    e.id_tipo_paciente 
FROM persona p
JOIN paciente e ON p.numero_identificacion = e.id_numero_identificacion
JOIN tipo_paciente t ON e.id_tipo_paciente  = t.id_tipo_paciente 
                WHERE numero_identificacion = $this->numeroIdentificacion";
    }
    public function consultarPorId()
    {
        return "SELECT id_tipo_identificacion, nombre, apellido, direccion, id_municipio_residencia, fecha_nacimiento, clave
                    FROM persona
                    WHERE numero_identificacion = $this->numeroIdentificacion";
    }

    public function consultarTodos()
    {
        return "SELECT numero_identificacion, id_tipo_identificacion, nombre, apellido, direccion, id_municipio_residencia, fecha_nacimiento, id_tipo_paciente, clave
                FROM persona";
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
            t.id_tipo_paciente
        FROM persona p
        JOIN paciente e ON p.numero_identificacion = e.id_numero_identificacion
        JOIN  tipo_paciente t ON e.id_tipo_paciente  = t.id_tipo_paciente
        WHERE p.nombre LIKE '%$this->nombre%'";
    }

    public function guardarPersona()
    {
        return "INSERT INTO persona (numero_identificacion, id_tipo_identificacion, nombre, apellido, direccion, id_municipio_residencia, fecha_nacimiento, clave) 
                VALUES ($this->numeroIdentificacion, $this->idTipoIdentificacion,'$this->nombre' , '$this->apellido', '$this->direccion', $this->idMunicipioResidencia, '$this->fechaNacimiento', '$this->clave');";
    }

    public function guardarPaciente()
    {
        return "INSERT INTO paciente (id_numero_identificacion, id_tipo_paciente) 
                VALUES ($this->numeroIdentificacion, $this->idTipoPaciente);";
    }
    public function ActualizarPersona()
    {
        return "UPDATE persona 
        SET 
            id_tipo_identificacion = $this->idTipoIdentificacion,
            nombre = '$this->nombre',
            apellido = '$this->apellido',
            direccion = '$this->direccion',
            id_municipio_residencia = $this->idMunicipioResidencia,
            fecha_nacimiento = '$this->fechaNacimiento',
            clave = '$this->clave'
        WHERE numero_identificacion = $this->numeroIdentificacion;";
    }

    public function actualizarPaciente()
    {
        return "UPDATE paciente SET id_tipo_paciente = $this->idTipoPaciente
        WHERE id_numero_identificacion = $this->numeroIdentificacion;";
    }
}
