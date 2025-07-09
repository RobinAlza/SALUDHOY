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

    public function __construct($numeroIdentificacion = 0, $idTipoIdentificacion = 0, $nombre = "", $apellido = "", $direccion = "", $idMunicipioResidencia = 0, $fechaNacimiento = "", $clave = "", $idEspecializacion = 0)
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
    e.id_especializacion
FROM persona p
JOIN medico m ON p.numero_identificacion = m.id_numero_identificacion
JOIN especializacion e ON m.id_especializacion = e.id_especializacion
                WHERE numero_identificacion = $this->numeroIdentificacion";
    }


    public function consultarPorId()
    {
        return "SELECT id_tipo_identificacion, nombre, apellido, direccion, id_municipio_residencia, fecha_nacimiento, clave
                FROM persona
                WHERE numero_identificacion = $this->numeroIdentificacion";
    }
    public function listarMedicos()
    {
        return "SELECT m.id_medico, p.id_tipo_identificacion, p.nombre, p.apellido, p.direccion, p.id_municipio_residencia, p.fecha_nacimiento, m.id_especializacion
                FROM persona p
                JOIN medico m ON p.numero_identificacion = m.id_numero_identificacion;";
    }

    public function listarPorEspecialidad()
    {
        return "SELECT m.id_medico, p.nombre, p.apellido
                FROM persona p
                JOIN medico m ON p.numero_identificacion = m.id_numero_identificacion
                WHERE m.id_especializacion = $this->idEspecializacion";
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
    e.id_especializacion
FROM persona p
JOIN medico m ON p.numero_identificacion = m.id_numero_identificacion
JOIN especializacion e ON m.id_especializacion = e.id_especializacion
WHERE p.nombre LIKE '%" . $this->nombre . "%'";
    }
    public function guardarPersona()
    {
        return "INSERT INTO persona (numero_identificacion, id_tipo_identificacion, nombre, apellido, direccion, id_municipio_residencia, fecha_nacimiento, clave) 
                VALUES ($this->numeroIdentificacion, $this->idTipoIdentificacion,'$this->nombre' , '$this->apellido', '$this->direccion', $this->idMunicipioResidencia, '$this->fechaNacimiento', '$this->clave');";
    }

    public function guardarMedico()
    {
        return "INSERT INTO medico (id_numero_identificacion,id_especializacion) 
                VALUES ($this->numeroIdentificacion, $this->idEspecializacion);";
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

    public function ActualizarMedico()
    {
        return "UPDATE medico 
        SET 
            id_especializacion = $this->idEspecializacion 
        WHERE id_numero_identificacion = $this->numeroIdentificacion;";
    }
}
