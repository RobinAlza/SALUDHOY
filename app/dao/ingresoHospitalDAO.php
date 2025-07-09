<?php
class IngresoHospitalDAO
{
    private $idIngresoHospital;
    private $idConsultorio;
    private $idCitaMedica;
    private $fechaIngreso;

    public function __construct($idIngresoHospital = 0, $idConsultorio = 0, $idCitaMedica = 0, $fechaIngreso = "")
    {
        $this->idIngresoHospital = $idIngresoHospital;
        $this->idConsultorio = $idConsultorio;
        $this->idCitaMedica = $idCitaMedica;
        $this->fechaIngreso = $fechaIngreso;
    }
    public function consultarPorId()
    {
        return "SELECT id_consultorio, id_cita_medica, fecha_ingreso
                FROM ingreso_hospital
                WHERE id_ingreso_hospital = $this->idIngresoHospital";
    }
    public function consultarTodos()
    {
        return "SELECT id_ingreso_hospital, id_consultorio, id_cita_medica, fecha_ingreso
                FROM ingreso_hospital";
    }
    public  function confirmarAsistencia()
    {
        return "INSERT INTO ingreso_hospital(id_consultorio, id_cita_medica, fecha_ingreso) 
        VALUES ($this->idConsultorio,$this->idCitaMedica,'$this->fechaIngreso')";
    }
}
