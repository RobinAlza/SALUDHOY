<?php
session_start();
require_once(__DIR__ . '/../dao/horarioDisponibleDAO.php');
require_once(__DIR__ . '/../models/horarioDisponible.php');
require_once(__DIR__ . '/../models/medico.php');

if ($_SESSION["role"] != "M") {
    header("Location: ?pid=" . base64_encode("views/sinPermisos.php"));
    exit();
}

// POST = guardar horarios (retornar solo JSON)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if ($data && isset($data['horas'])) {
        $horas_recibidas = $data['horas'];
        $fecha = $data['fecha'];
        $id_medico = $data['id_medico'];

        $horas = [];
        foreach ($horas_recibidas as $info) {
            $hora = $info['hora'];
            $estado = $info['estado'];

            $horas[] = [
                "hora" => $hora,
                "estado" => $estado
            ];
        }

        $controller = new HorarioDisponible();
        $resultado = $controller->guardarFranjaHoraria($horas, $fecha, $id_medico);

        echo json_encode(["success" => $resultado]);
        exit(); // ⚠️ IMPORTANTE: Termina aquí para no devolver HTML
    } else {
        echo json_encode(["success" => false, "message" => "Datos inválidos"]);
        exit();
    }
}

// GET = renderizar vista de horarios

$anio = $_GET['year'];
$mes = $_GET['month'];
$dia = $_GET['day'];

$medico = new Medico($_SESSION["id"]);
$medico->consultarPorId();
$id_medico = $medico->getIdMedico();

$fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);

$controller = new HorarioDisponible();
$horarios = $controller->comprobacionDisponibilidad($fecha, $id_medico);
?>

<!-- TU HTML DE CHECKBOXES AQUÍ -->
<div class="container">
    <h5 class="mb-3 text-center">Horarios - <?= htmlspecialchars("$anio-$mes-$dia") ?></h5>
    <div class="row">
        <?php foreach ($horarios as $hr): ?>
            <?php
            $hora_inicio = $hr['hora'];
            $h = intval(substr($hora_inicio, 0, 2));
            $hora_fin = str_pad(($h + 1), 2, '0', STR_PAD_LEFT) . ':00:00';

            $estado = $hr['estado'];

            switch ($estado) {
                case 1:
                    $clase = "bg-danger text-white";
                    $checked = "checked";
                    $disabled = "disabled";
                    break;
                case 2:
                    $clase = "bg-success text-white";
                    $checked = "checked";
                    $disabled = "";
                    break;
                default:
                    $clase = "bg-secondary text-white";
                    $checked = "";
                    $disabled = "";
                    break;
            }
            ?>
            <div class="col-12 mb-2">
                <div class="form-check <?= $clase ?> p-2 rounded position-relative">
                    <input class="form-check-input horario-checkbox" type="checkbox" value="<?= $hora_inicio ?>" <?= $checked ?> <?= $disabled ?>>
                    <label class="form-check-label">
                        <?= $hora_inicio ?> - <?= $hora_fin ?>
                    </label>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <button id="guardarHorarios" class="btn btn-primary mt-3">Guardar</button>
</div>

<script>
document.getElementById("guardarHorarios").addEventListener("click", function() {
    let checkboxes = document.getElementsByClassName("horario-checkbox");
    let horas = [];

    for (let checkbox of checkboxes) {
        if (!checkbox.disabled) {
            horas.push({
                hora: checkbox.value,
                estado: checkbox.checked ? 1 : 0
            });
        }
    }

    let data = {
        horas: horas,
        fecha: "<?= $fecha ?>",
        id_medico: <?= $id_medico ?>
    };

    fetch("ajax/horarios.php", { // Usa la ruta real donde esté este archivo
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert("Horarios guardados correctamente");
            location.reload();
        } else {
            alert("Error al guardar horarios: " + (result.message || ''));
        }
    })
    .catch(error => console.error("Error:", error));
});
</script>
