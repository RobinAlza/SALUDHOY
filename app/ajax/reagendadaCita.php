<?php
require_once(__DIR__ . '/../models/citaMedica.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_cita'], $_POST['fecha_cita'], $_POST['hora_cita'])) {
        $id_cita = $_POST['id_cita'];
        $fecha = $_POST['fecha_cita'];
        $hora = $_POST['hora_cita'];

        // Combinar ambos en formato DATETIME
        $fecha_cita = $fecha . ' ' . $hora . ':00';

        $cita = new CitaMedica($id_cita,  $fecha_cita);

        $resultado = $cita->reagendadaCita();

        echo json_encode(["success" => $resultado]);
    } else {
        echo json_encode(["success" => false, "message" => "Faltan datos"]);
    }
}
