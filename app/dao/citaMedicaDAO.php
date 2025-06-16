<?php
class CitaMedicaDAO
{
    private $codigoCita;
    private $fechaCita;
    private $idConsultorio;
    private $idMedico;
    private $idPaciente;
    private $idEstadoCita;
    private $idTipoCita;



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
        return "SELECT fecha_cita, id_consultorio, id_medico, id_paciente, id_estado_cita
                FROM cita_medica
                WHERE codigo_cita = $this->codigoCita";
    }

    public function consultaPendientes()
    {
        return "SELECT 
        c.codigo_cita,
        c.fecha_cita,
        c.id_consultorio,
        m.id_numero_identificacion,
        c.id_estado_cita,
        c.id_tipo_cita,
        per_m.nombre,
        per_m.apellido
    FROM cita_medica c
    JOIN paciente p ON c.id_paciente = p.id_paciente
    JOIN persona per_p ON p.id_numero_identificacion = per_p.numero_identificacion
    JOIN medico m ON c.id_medico = m.id_medico
    JOIN persona per_m ON m.id_numero_identificacion = per_m.numero_identificacion
    WHERE per_p.numero_identificacion = $this->idPaciente;";
    }
}
