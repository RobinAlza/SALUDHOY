<?php
session_start();
$anio = $_GET['year'];
$mes = $_GET['month'];
$dia = $_GET['day'];

require_once(__DIR__ . '/../dao/horarioDisponibleDAO.php');
require_once(__DIR__ . '/../models/horarioDisponible.php');
require_once(__DIR__ . '/../models/medico.php');


$medico = new Medico($_SESSION["id"]);
$medico->consultarPorId();
$id_medico = $medico->getIdMedico();
var_dump($id_medico);

$fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
$controller = new HorarioDisponible();
$horarios = $controller->comprobacionDisponibilidad($fecha, $id_medico);
?>

<div class="container">
    <h5 class="mb-3 text-center">Horarios - <?= htmlspecialchars("$anio-$mes-$dia") ?></h5>
    <div class="row">
        <?php
        foreach ($horarios as $hr) {
            $hora_inicio = $hr['hora'];
            $h = intval(substr($hora_inicio, 0, 2));
            $hora_fin = str_pad(($h + 1), 2, '0', STR_PAD_LEFT) . ':00:00';

            $estado = $hr['estado'];

            // Determinar clases y propiedades según estado
            switch ($estado) {
                case 1: // Ocupado (rojo, no modificable)
                    $clase = "bg-danger text-white";
                    $checked = "checked";
                    $disabled = "disabled";
                    break;
                case 2: // Disponible (verde)
                    $clase = "bg-success text-white";
                    $checked = "checked";
                    $disabled = "";
                    break;
                default: // No habilitado (gris)
                    $clase = "bg-secondary text-white";
                    $checked = "";
                    $disabled = "";
                    break;
            }
            ?>
            <div class="col-12 mb-2">
                <div class="form-check <?= $clase ?> p-2 rounded position-relative">
                    <input class="form-check-input horario-checkbox" type="checkbox" value="<?= $hora_inicio ?>" id="hora<?= $h ?>" <?= $checked ?> <?= $disabled ?>>
                    <label class="form-check-label" for="hora<?= $h ?>">
                        <?= $hora_inicio ?> - <?= $hora_fin ?>
                    </label>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
