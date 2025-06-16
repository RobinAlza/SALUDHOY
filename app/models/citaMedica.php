<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/citaMedicaDAO.php');

class CitaMedica
{
    private $codigoCita;
    private $fechaCita;
    private $idConsultorio;
    private $idMedico;
    private $idPaciente;
    private $idEstadoCita;
    private $idTipoCita;


    public function getCodigoCita()
    {
        return $this->codigoCita;
    }
    public function setCodigoCita($codigoCita)
    {
        $this->codigoCita = $codigoCita;
    }

    public function getFechaCita()
    {
        return $this->fechaCita;
    }
    public function setFechaCita($fechaCita)
    {
        $this->fechaCita = $fechaCita;
    }

    public function getIdConsultorio()
    {
        return $this->idConsultorio;
    }
    public function setIdConsultorio($idConsultorio)
    {
        $this->idConsultorio = $idConsultorio;
    }

    public function getIdMedico()
    {
        return $this->idMedico;
    }
    public function setIdMedico($idMedico)
    {
        $this->idMedico = $idMedico;
    }

    public function getIdPaciente()
    {
        return $this->idPaciente;
    }
    public function setIdPaciente($idPaciente)
    {
        $this->idPaciente = $idPaciente;
    }

    public function getIdEstadoCita()
    {
        return $this->idEstadoCita;
    }
    public function setIdEstadoCita($idEstadoCita)
    {
        $this->idEstadoCita = $idEstadoCita;
    }
        public function getIdTipoCita()
    {
        return $this->idTipoCita;
    }
    public function setIdTipoCita($idTipoCita)
    {
        $this->idTipoCita = $idTipoCita;
    }

    public function __construct($codigoCita = 0, $fechaCita = "", $idConsultorio = 0, $idMedico = 0, $idPaciente = 0, $idEstadoCita = 0, $idTipoCita = 0)
    {
        $this->codigoCita = $codigoCita;
        $this->fechaCita = $fechaCita;
        $this->idConsultorio = $idConsultorio;
        $this->idMedico = $idMedico;
        $this->idPaciente = $idPaciente;
        $this->idEstadoCita = $idEstadoCita;
        $this->idTipoCita = $idTipoCita;

    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $dao = new CitaMedicaDAO($this->codigoCita);
        $conexion->ejecutarConsulta($dao->consultarPorId());

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }

        $registro = $conexion->siguienteRegistro();
        $this->fechaCita = $registro[0];
        $this->idConsultorio = $registro[1];
        $this->idMedico = $registro[2];
        $this->idPaciente = $registro[3];
        $this->idEstadoCita = $registro[4];
        $conexion->cerrarConexion();
        return true;
    }
    public function consultaPendientes($numeroIdentificacion)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        // Le pasamos el número de cédula al DAO
        $dao = new CitaMedicaDAO(null, null, null, null, $numeroIdentificacion);
        $conexion->ejecutarConsulta($dao->consultaPendientes());

        $consultorios = [];
        $medicos = [];
        $estados = [];
        $citas = [];
        $especialidades = [];



        while ($registro = $conexion->siguienteRegistro()) {

            // Consultorio
            $consultorio = $consultorios[$registro[2]] ?? new Consultorio($registro[2]);
            if (!isset($consultorios[$registro[2]])) {
                $consultorio->consultarPorId();
                $consultorios[$registro[2]] = $consultorio;
            }

            // Médico
            $medico = $medicos[$registro[3]] ?? new Medico($registro[3]);
            if (!isset($medicos[$registro[3]])) {
                $medico->setNombre($registro[5]);    // nombre
                $medico->setApellido($registro[6]);  // apellido
                $medicos[$registro[3]] = $medico;
            }


            // Estado
            $estado = $estados[$registro[4]] ?? new EstadoCita($registro[4]);
            if (!isset($estados[$registro[4]])) {
                $estado->consultarPorId();
                $estados[$registro[4]] = $estado;
            }
            
            // especialidad
            $especialidad = $especialidades[$registro[5]] ?? new TipoCita($registro[5]);
            if (!isset($especialidades[$registro[5]])) {
                $especialidad->consultarPorId();
                $especialidades[$registro[5]] = $especialidad;
            }

            // Crear la cita
            $cita = new CitaMedica($registro[0], $registro[1], $consultorio, $medico, null, $estado,$especialidad );
            array_push($citas, $cita);
        }

        $conexion->cerrarConexion();
        return $citas;
    }
}
