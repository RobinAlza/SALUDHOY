<?php
session_start();
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/citaMedicaDAO.php');
require_once(__DIR__ . '/../models/citaMedica.php');

// Verificar si los parámetros están set
if (isset($_GET['id']) && isset($_SESSION["id"])) {
    $idCita = $_GET['id'];


    // Crear el objeto CitaMedica y llamar al método
    $cita = new CitaMedica();
    $detalleCita = $cita->obtenerDetallesCita($idCita);

    if ($detalleCita != null) {
        echo "<h5>Detalles de la Cita</h5>";
        echo "<p><strong>Código:</strong> " . $detalleCita['codigo_cita'] . "</p>";
        echo "<p><strong>Lugar:</strong> " . $detalleCita['lugar_cita'] . "</p>";
        echo "<p><strong>Médico:</strong> " . $detalleCita['nombre_medico'] . " (" . $detalleCita['especializacion'] . ")</p>";
        echo "<p><strong>Paciente:</strong> " . $detalleCita['nombre_paciente'] . " (" . $detalleCita['numero_identificacion_paciente'] . ")</p>";
        echo "<p><strong>Tipo Paciente:</strong> " . $detalleCita['tipo_paciente'] . "</p>";
        echo "<p><strong>Fecha Inicio:</strong> " . $detalleCita['fecha_inicio'] . "</p>";
        echo "<p><strong>Fecha Terminación:</strong> " . $detalleCita['fecha_terminacion'] . "</p>";
        echo "<p><strong>Motivo:</strong> " . $detalleCita['motivo'] . "</p>";
        echo "<p><strong>Estado:</strong> " . $detalleCita['descripcion_estado'] . "</p>";

    } else {
        echo '<div class="alert alert-danger">';
        echo '<h5>Error</h5>';
        
        // Información de depuración (solo en entorno de desarrollo)
        echo '<div class="mt-3 text-muted small">';
        echo '<p>Parámetros recibidos:</p>';
        echo '<ul>';
        echo '<li>ID Cita: ' . ($idCita) . '</li>';
        echo '</ul>';
        echo '</div>';
        echo '</div>';
      }
} else {
    echo "<p class='text-danger'>Datos incompletos o sin permisos.</p>";
}
?>