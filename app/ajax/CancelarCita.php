<?php
require_once(__DIR__ . '/../models/historialCita.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_cita'], $_POST['motivo_cancelacion'])) 
    {
        $id_cita = $_POST['id_cita'];
        $motivo = $_POST['motivo_cancelacion'];
        $fechaFin = date("Y-m-d H:i:s");  // formato compatible con DATETIME
        $estado = new HistorialCita(null, $id_cita, null, $fechaFin, $motivo);

        $resultado = $estado->cancelarCita();

        echo json_encode(["success" => $resultado]);
    } else {
        echo json_encode(["success" => false, "message" => "Faltan datos"]);
    }
}
