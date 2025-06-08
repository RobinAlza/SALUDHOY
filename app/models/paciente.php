<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/pacienteDAO.php');

class Paciente extends Persona
{
    private $idTipoPaciente;

    public function getIdTipoPaciente()
    {
        return $this->idTipoPaciente;
    }
    public function setIdTipoPaciente($idTipoPaciente)
    {
        $this->idTipoPaciente = $idTipoPaciente;
    }

    public function __construct($numeroIdentificacion = 0, $idTipoIdentificacion = 0, $nombre = "", $apellido = "", $direccion = "", $idMunicipioResidencia = 0, $fechaNacimiento = "", $clave = "", $idTipoPaciente = 0)
    {
        parent::__construct($numeroIdentificacion, $idTipoIdentificacion, $nombre, $apellido, $direccion, $idMunicipioResidencia, $fechaNacimiento, $clave);
        $this->idTipoPaciente = $idTipoPaciente;
    }

    public function autenticar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $pacienteDAO = new PacienteDAO(null, null, $this->nombre, null, null, null, null, $this->clave, null);
        $conexion->ejecutarConsulta($pacienteDAO->autenticar());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $registro = $conexion->siguienteRegistro();
        $this->numeroIdentificacion = $registro[0];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $pacienteDAO = new PacienteDAO($this->numeroIdentificacion);
        $conexion->ejecutarConsulta($pacienteDAO->consultar());

        $registro = $conexion->siguienteRegistro();

        if ($registro) {
            // tipo_identificacion
            $tipoIdentificacion = new TipoIdentificacion($registro[1]);
            $tipoIdentificacion->consultarPorId();

            // municipio_residencia
            $municipio = new MunicipioResidencia($registro[5]);
            $municipio->consultarPorId();

            // especializacion
            $TipoPacien = new TipoPaciente($registro[8]);
            $TipoPacien->consultarPorId();

            // teléfonos
            $telefonos = (new TelefonoPersona($registro[0], null))->consultarNumeros();

            // Asignar atributos al objeto actual
            $this->numeroIdentificacion = $registro[0];
            $this->idTipoIdentificacion = $tipoIdentificacion;
            $this->nombre = $registro[2];
            $this->apellido = $registro[3];
            $this->direccion = $registro[4];
            $this->idMunicipioResidencia = $municipio;
            $this->fechaNacimiento = $registro[6];
            $this->clave = $registro[7];
            $this->idTipoPaciente = $TipoPacien;
        }

        $conexion->cerrarConexion();
    }
    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new PacienteDAO($this->numeroIdentificacion);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->idTipoIdentificacion = $registro[0];
        $this->nombre = $registro[1];
        $this->apellido = $registro[2];
        $this->direccion = $registro[3];
        $this->idMunicipioResidencia = $registro[4];
        $this->fechaNacimiento = $registro[5];
        $this->clave = $registro[6];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new PacienteDAO();
        $conexion->ejecutarConsulta($dao->consultarTodos());

        $lista = array();
        while ($registro = $conexion->siguienteRegistro()) {
            $obj = new Paciente($registro[0], $registro[1]);
            array_push($lista, $obj);
        }
        $conexion->cerrarConexion();
        return $lista;
    }

    public function consultarPorNombre()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $pacienteDAO = new PacienteDAO(null, $this->nombre);
        $conexion->ejecutarConsulta($pacienteDAO->consultarPorNombre());

        $tiposIdentificacion = [];
        $municipios = [];
        $tiposPaciente = [];
        $pacientes = [];

        while ($registro = $conexion->siguienteRegistro()) {
            // tipo_identificacion
            $tipoIdentificacion = null;
            if (array_key_exists($registro[1], $tiposIdentificacion)) {
                $tipoIdentificacion = $tiposIdentificacion[$registro[1]];
            } else {
                $tipoIdentificacion = new TipoIdentificacion($registro[1]);
                $tipoIdentificacion->consultarPorId();
                $tiposIdentificacion[$registro[1]] = $tipoIdentificacion;
            }

            // municipio_residencia
            $municipio = null;
            if (array_key_exists($registro[5], $municipios)) {
                $municipio = $municipios[$registro[5]];
            } else {
                $municipio = new MunicipioResidencia($registro[5]);
                $municipio->consultarPorId();
                $municipios[$registro[5]] = $municipio;
            }

            // tipo_paciente
            $tipoPaciente = null;
            if (array_key_exists($registro[8], $tiposPaciente)) {
                $tipoPaciente = $tiposPaciente[$registro[8]];
            } else {
                $tipoPaciente = new TipoPaciente($registro[8]);
                $tipoPaciente->consultarPorId();
                $tiposPaciente[$registro[8]] = $tipoPaciente;
            }

            // teléfonos
            $telefonos = (new TelefonoPersona(null, $registro[0]))->consultarNumeros();

            // crear paciente
            $paciente = new Paciente(
                $registro[0], // numero_identificacion
                $tipoIdentificacion,
                $registro[2], // nombre
                $registro[3], // apellido
                $registro[4], // direccion
                $municipio,
                $registro[6], // fecha_nacimiento
                $registro[7], // clave
                $tipoPaciente

            );

            array_push($pacientes, $paciente);
        }

        $conexion->cerrarConexion();
        return $pacientes;
    }
    public function guardar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $pacienteDAO = new PacienteDAO(
            $this->numeroIdentificacion,
            $this->idTipoIdentificacion,
            $this->nombre,
            $this->apellido,
            $this->direccion,
            $this->idMunicipioResidencia,
            $this->fechaNacimiento,
            $this->clave,
            $this->idTipoPaciente
        );
        $conexion->ejecutarConsulta($pacienteDAO->guardarPersona());
        $conexion->ejecutarConsulta($pacienteDAO->guardarPaciente());
        $conexion->cerrarConexion();

        return $this->numeroIdentificacion;
    }

    public function actualizar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $pacienteDAO = new PacienteDAO(
            $this->numeroIdentificacion,
            $this->idTipoIdentificacion,
            $this->nombre,
            $this->apellido,
            $this->direccion,
            $this->idMunicipioResidencia,
            $this->fechaNacimiento,
            $this->clave,
            $this->idTipoPaciente
        );
        $conexion->ejecutarConsulta($pacienteDAO->actualizarPersona());
        $conexion->ejecutarConsulta($pacienteDAO->actualizarPaciente());
        $conexion->cerrarConexion();

        return $this->numeroIdentificacion;
    }
}
