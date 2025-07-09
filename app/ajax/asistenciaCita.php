<?php
require_once(__DIR__ . '/../models/ingresoHospital.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_cita'], $_POST['consultorio'])) 
    {
        $id_cita = $_POST['id_cita'];
        $idConsultorio = $_POST['consultorio'];
        $fechaIngreso = date("Y-m-d H:i:s");  // formato compatible con DATETIME
        $estado = new IngresoHospital(null, $idConsultorio, $id_cita, $fechaIngreso);

        $resultado = $estado->confirmarAsistencia();

        echo json_encode(["success" => $resultado]);
    } else {
        echo json_encode(["success" => false, "message" => "Faltan datos"]);
    }
}
