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
    public function getIdTipoCita()
    {
        return $this->idTipoCita;
    }
    public function setIdTipoCita($idTipoCita)
    {
        $this->idTipoCita = $idTipoCita;
    }

    public function __construct($codigoCita = 0, $fechaCita = "", $idConsultorio = 0, $idMedico = 0, $idPaciente = 0, $idTipoCita = 0)
    {
        $this->codigoCita = $codigoCita;
        $this->fechaCita = $fechaCita;
        $this->idConsultorio = $idConsultorio;
        $this->idMedico = $idMedico;
        $this->idPaciente = $idPaciente;
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
        $conexion->cerrarConexion();
        return true;
    }


    public function consultaPendientes($numeroIdentificacion, $filtro)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        // Le pasamos el número de cédula al DAO
        $dao = new CitaMedicaDAO(null, null, null, null, $numeroIdentificacion);
        $conexion->ejecutarConsulta($dao->consultaPendientes($filtro));

        $consultorios = [];
        $medicos = [];
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
                $medico->setNombre($registro[5]); // nombre
                $medico->setApellido($registro[6]); // apellido
                $medicos[$registro[3]] = $medico;
            }

            // Especialidad
            $especialidad = $especialidades[$registro[4]] ?? new Especializacion($registro[4]);
            if (!isset($especialidades[$registro[4]])) {
                $especialidad->consultarPorId();
                $especialidades[$registro[4]] = $especialidad;
            }

            // Estado y motivo (del historial)
            $estado = $registro[8]; // descripcion_estado
            $motivo = $registro[7]; // motivo

            // Crear objeto Cita y asignar estado y motivo como propiedades adicionales (si no están en el modelo, puedes hacer esto como arreglo asociativo o extender la clase)
            $cita = new CitaMedica($registro[0], $registro[1], $consultorio, $medico, null, $especialidad);
            $cita->estadoHistorial = $estado;
            $cita->motivoHistorial = $motivo;

            array_push($citas, $cita);
        }

        $conexion->cerrarConexion();
        return $citas;
    }

    public function consultaHistorico($numeroIdentificacion, $filtro)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        // Le pasamos el número de cédula al DAO
        $dao = new CitaMedicaDAO(null, null, null, null, $numeroIdentificacion);
        $conexion->ejecutarConsulta($dao->consultaHistorico($filtro));

        $consultorios = [];
        $medicos = [];
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
                $medico->setNombre($registro[5]); // nombre
                $medico->setApellido($registro[6]); // apellido
                $medicos[$registro[3]] = $medico;
            }

            // Especialidad
            $especialidad = $especialidades[$registro[4]] ?? new Especializacion($registro[4]);
            if (!isset($especialidades[$registro[4]])) {
                $especialidad->consultarPorId();
                $especialidades[$registro[4]] = $especialidad;
            }

            // Estado y motivo (del historial)
            $estado = $registro[8]; // descripcion_estado
            $motivo = $registro[7]; // motivo

            // Crear objeto Cita y asignar estado y motivo como propiedades adicionales (si no están en el modelo, puedes hacer esto como arreglo asociativo o extender la clase)
            $cita = new CitaMedica($registro[0], $registro[1], $consultorio, $medico, null, $especialidad);
            $cita->estadoHistorial = $estado;
            $cita->motivoHistorial = $motivo;

            array_push($citas, $cita);
        }

        $conexion->cerrarConexion();
        return $citas;
    }

    public function consultaCitasP($filtro)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        // Le pasamos el número de cédula al DAO
        $dao = new CitaMedicaDAO();
        $conexion->ejecutarConsulta($dao->consultaCitasP($filtro));

        $consultorios = [];
        $medicos = [];
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
                $medico->setNombre($registro[5]); // nombre
                $medico->setApellido($registro[6]); // apellido
                $medicos[$registro[3]] = $medico;
            }

            // Especialidad
            $especialidad = $especialidades[$registro[4]] ?? new Especializacion($registro[4]);
            if (!isset($especialidades[$registro[4]])) {
                $especialidad->consultarPorId();
                $especialidades[$registro[4]] = $especialidad;
            }

            // Estado y motivo (del historial)
            $estado = $registro[8]; // descripcion_estado
            $motivo = $registro[7]; // motivo

            // Crear objeto Cita y asignar estado y motivo como propiedades adicionales (si no están en el modelo, puedes hacer esto como arreglo asociativo o extender la clase)
            $cita = new CitaMedica($registro[0], $registro[1], $consultorio, $medico, null, $especialidad);
            $cita->estadoHistorial = $estado;
            $cita->motivoHistorial = $motivo;

            array_push($citas, $cita);
        }

        $conexion->cerrarConexion();
        return $citas;
    }

    public function consultaCitasH($filtro)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        // Le pasamos el número de cédula al DAO
        $dao = new CitaMedicaDAO();
        $conexion->ejecutarConsulta($dao->consultaCitasH($filtro));

        $consultorios = [];
        $medicos = [];
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
                $medico->setNombre($registro[5]); // nombre
                $medico->setApellido($registro[6]); // apellido
                $medicos[$registro[3]] = $medico;
            }

            // Especialidad
            $especialidad = $especialidades[$registro[4]] ?? new Especializacion($registro[4]);
            if (!isset($especialidades[$registro[4]])) {
                $especialidad->consultarPorId();
                $especialidades[$registro[4]] = $especialidad;
            }

            // Estado y motivo (del historial)
            $estado = $registro[8]; // descripcion_estado
            $motivo = $registro[7]; // motivo

            // Crear objeto Cita y asignar estado y motivo como propiedades adicionales (si no están en el modelo, puedes hacer esto como arreglo asociativo o extender la clase)
            $cita = new CitaMedica($registro[0], $registro[1], $consultorio, $medico, null, $especialidad);
            $cita->estadoHistorial = $estado;
            $cita->motivoHistorial = $motivo;

            array_push($citas, $cita);
        }

        $conexion->cerrarConexion();
        return $citas;
    }

    public function guardarCita()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $citaDAO = new CitaMedicaDAO(
            null,
            $this->fechaCita,
            $this->idConsultorio,
            $this->idMedico,
            $this->idPaciente,
            $this->idTipoCita
        );

        $idCita = $conexion->ejecutarConsultaConId($citaDAO->guardarCita());
        $conexion->cerrarConexion();

        return $idCita; // Aquí devuelves el ID
    }

    public function reagendadaCita()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $pacienteDAO = new CitaMedicaDAO(
            $this->codigoCita,
            $this->fechaCita
        );
        $conexion->ejecutarConsulta($pacienteDAO->reagendadaCita());
        $conexion->cerrarConexion();
        return true;
    }

    public function restrincionCita($idPaciente, $idEspecialidad)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $citaDAO = new CitaMedicaDAO(null, null, null, null, $idPaciente, $idEspecialidad);


        $resultado = $conexion->ejecutarConsulta($citaDAO->restrincionCita());
        $fila = $resultado->fetch_assoc();

        $conexion->cerrarConexion();

        return intval($fila['total_citas']);
    }

    public function obtenerDetallesCita($idCita)
    {
        $citaDAO = new CitaMedicaDAO();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $conexion->ejecutarConsulta($citaDAO->detalleCita($idCita));

        if ($registro = $conexion->siguienteRegistro()) {
            // Construir el arreglo con los campos de la consulta
            $detalles = array(
                "codigo_cita" => $registro[0],
                "lugar_cita" => $registro[1],
                "nombre_medico" => $registro[2],
                "especializacion" => $registro[3],
                "nombre_paciente" => $registro[4],
                "numero_identificacion_paciente" => $registro[5],
                "tipo_paciente" => $registro[6],
                "fecha_inicio" => $registro[7],
                "fecha_terminacion" => $registro[8],
                "motivo" => $registro[9],
                "descripcion_estado" => $registro[10]
            );
            $conexion->cerrarConexion();
            return $detalles;
        } else {
            $conexion->cerrarConexion();
            return false;
        }
    }

}
