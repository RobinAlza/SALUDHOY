<?php
require_once(__DIR__ . '/../models/medico.php');
require_once(__DIR__ . '/../models/citaMedica.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_especialidad'], $_POST['id_paciente'])) {
    $idEspecialidad = intval($_POST['id_especialidad']);
    $idPaciente = intval($_POST['id_paciente']);

    // Verificar si ya tiene 2 citas este mes para esta especialidad (excepto medicina general)
    $citaMedica = new CitaMedica();
    $cantidad = $citaMedica->restrincionCita($idPaciente, $idEspecialidad);

    if ($cantidad >= 2 && $idEspecialidad != 1) {
        echo json_encode(["permitido" => false]);
        exit;
    }


    $medico = new Medico();
    $medicos = $medico->listarPorEspecialidad($idEspecialidad);

    // Si se permite agendar, cargar médicos
    $medicosArray = [];

    foreach ($medicos as $medico) {
        $medicosArray[] = [
            'numero_identificacion' => $medico->getNumeroIdentificacion(),
            'nombre' => $medico->getNombre(),
            'apellido' => $medico->getApellido()
        ];
    }

    echo json_encode([
        "permitido" => true,
        "medicos" => $medicosArray
    ]);
}
