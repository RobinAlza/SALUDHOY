<?php
class CitaMedicaDAO
{
    private $codigoCita;
    private $fechaCita;
    private $idConsultorio;
    private $idMedico;
    private $idPaciente;
    private $idTipoCita;



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
        return "SELECT fecha_cita, id_consultorio, id_medico, id_paciente
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
        c.id_tipo_cita,
        per_m.nombre,
        per_m.apellido
    FROM cita_medica c
    JOIN paciente p ON c.id_paciente = p.id_paciente
    JOIN persona per_p ON p.id_numero_identificacion = per_p.numero_identificacion
    JOIN medico m ON c.id_medico = m.id_medico
    JOIN persona per_m ON m.id_numero_identificacion = per_m.numero_identificacion
    WHERE per_p.numero_identificacion = $this->idPaciente";
    }


    public function consultaHistorico()
    {
        return "SELECT 
        c.codigo_cita,
        c.fecha_cita,
        c.id_consultorio,
        m.id_numero_identificacion,
        c.id_tipo_cita,
        per_m.nombre,
        per_m.apellido
    FROM cita_medica c
    JOIN paciente p ON c.id_paciente = p.id_paciente
    JOIN persona per_p ON p.id_numero_identificacion = per_p.numero_identificacion
    JOIN medico m ON c.id_medico = m.id_medico
    JOIN persona per_m ON m.id_numero_identificacion = per_m.numero_identificacion
    WHERE per_p.numero_identificacion = $this->idPaciente";
    }

    public  function guardarCita()
    {
        return "INSERT INTO cita_medica(fecha_cita, id_consultorio, id_medico, id_paciente, id_tipo_cita) 
        VALUES ('$this->fechaCita',$this->idConsultorio,$this->idMedico, $this->idPaciente , $this->idTipoCita)";
    }

    public  function reagendadaCita()
    {
        return "UPDATE  cita_medica SET fecha_cita='$this->fechaCita'
                    WHERE codigo_cita = $this->codigoCita";
    }

    public function restrincionCita()
    {
        $fechaHoy = date('Y-m-d');

        return "SELECT COUNT(*) AS total_citas
            FROM cita_medica cm
            JOIN especializacion e ON cm.id_tipo_cita = e.id_especializacion
            WHERE cm.id_paciente = $this->idPaciente
              AND cm.id_tipo_cita = $this->idTipoCita
              AND MONTH(cm.fecha_cita) = MONTH('$fechaHoy')   
              AND YEAR(cm.fecha_cita) = YEAR('$fechaHoy')";
    }

    public function detalleCita($codigoCita){
        return "SELECT cm.codigo_cita, con.lugar_cita, per_m.nombre, es.especializacion, per_p.nombre, per_p.numero_identificacion, tp.nombre_tipo, hc.fecha_inicio, hc.fecha_terminacion, hc.motivo, ec.descripcion_estado
                FROM cita_medica AS cm
                    JOIN consultorio AS con ON (cm.id_consultorio=con.id_consultorio)
                    JOIN medico AS m ON (m.id_medico=cm.id_medico)
                    JOIN persona AS per_m ON (per_m.numero_identificacion=m.id_numero_identificacion)
                    JOIN paciente AS  pac ON (pac.id_paciente=cm.id_paciente)
                    JOIN persona AS per_p ON (per_p.numero_identificacion=pac.id_numero_identificacion)
                    JOIN tipo_paciente AS tp ON (pac.id_tipo_paciente=tp.id_tipo_paciente)
                    JOIN especializacion AS es ON (es.id_especializacion = cm.id_tipo_cita)
                    JOIN historial_cita AS hc ON (cm.codigo_cita=hc.codigo_cita)
                    JOIN estado_cita AS ec ON (hc.id_estado_cita=ec.id_estado_cita)
                WHERE cm.codigo_cita= $codigoCita ";
    }


}