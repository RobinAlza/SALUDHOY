<?php
require_once '../models/citaMedica.php';
require_once '../models/historialCita.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_paciente'], $_POST['tipoCita'], $_POST['especialista'], $_POST['fecha_cita'], $_POST['hora_cita'], $_POST['consultorio'])) {
        $idPaciente = $_POST['id_paciente'];
        $tipoCita = $_POST['tipoCita'];
        $especialista = $_POST['especialista'];
        $fecha = $_POST['fecha_cita'];
        $hora = $_POST['hora_cita'];
        $consultorio = $_POST['consultorio'];
        // Combinar ambos en formato DATETIME
        $fecha_cita = $fecha . ' ' . $hora . ':00';

        $fechaIni = date("Y-m-d H:i:s");  // formato compatible con DATETIME

        $cita = new CitaMedica(null, $fecha_cita, $consultorio, $especialista, $idPaciente, $tipoCita);
        $idCitaInsertada = $cita->guardarCita();

        if ($idCitaInsertada) {
            $histo = new HistorialCita(null, $idCitaInsertada, $fechaIni);
            $resultado = $histo->guardarHistorial();
            echo json_encode(["success" => $resultado]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Faltan datos"]);
    }
}