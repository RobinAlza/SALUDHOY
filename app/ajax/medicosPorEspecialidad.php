<?php
require_once(__DIR__ . '/../models/medico.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_especialidad'])) {
    $idEspecialidad = intval($_POST['id_especialidad']);

    $medico = new Medico();
    $medicos = $medico->listarPorEspecialidad($idEspecialidad);

    $medicosArray = [];

    foreach ($medicos as $medico) {
        $medicosArray[] = [
            'numero_identificacion' => $medico->getNumeroIdentificacion(),
            'nombre' => $medico->getNombre(),
            'apellido' => $medico->getApellido()
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($medicosArray);
}
