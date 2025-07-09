<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

// Iniciar el buffer para evitar salidas tempranas
ob_start();

// Configuración para mostrar errores (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar sesión
if (!isset($_SESSION["role"]) || !isset($_SESSION["id"])) {
    ob_end_clean(); // Limpiar buffer
    header("Content-Type: application/json");
    echo json_encode(["error" => "No autenticado"]);
    exit();
}

// Establecer el tipo de contenido como JSON
header("Content-Type: application/json");

$conexion = new Conexion();
$conexion->abrirConexion();

// Nuevos parámetros para administrador
$tipoFiltro = $_GET['tipoFiltro'] ?? null;
$idFiltro = $_GET['idFiltro'] ?? null;
$role = $_SESSION["role"];
$userId = $_SESSION["id"];

// Obtener los últimos 6 meses
$meses = [];
$fechas = [];
for ($i = 5; $i >= 0; $i--) {
    $fecha = date('Y-m', strtotime("-$i months"));
    $meses[] = $fecha;
    $fechas[$fecha] = 0;  // Inicializar con valor 0
}

$response = [
    "paciente" => [],
    "medico" => [],
    "inasistencias" => []
];

try {
    // Consultas para paciente
    if (($role == "P") || ($role == "A" && $tipoFiltro == "P")) {
        // Determinar condición según el contexto
        if ($role == "A" && $tipoFiltro == "P") {
            $condicion = "pa.id_numero_identificacion = '$idFiltro'";
        } else if ($role == "P") {
            $condicion = "pa.id_numero_identificacion = '$userId'";
        } else {
            $condicion = "1=1";
        }

        $sqlPaciente = "SELECT 
                            DATE_FORMAT(cm.fecha_cita, '%Y-%m') AS mes,
                            COUNT(*) AS total
                         FROM cita_medica cm
                         JOIN paciente pa ON cm.id_paciente = pa.id_paciente
                         WHERE $condicion
                           AND cm.fecha_cita >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                         GROUP BY mes
                         ORDER BY mes";

        $res = $conexion->ejecutarConsulta($sqlPaciente);
        $citasPorMes = $fechas;
        
        while ($row = $res->fetch_assoc()) {
            $citasPorMes[$row['mes']] = (int)$row['total'];
        }

        foreach ($meses as $mes) {
            $response["paciente"][] = [
                "mes" => $mes,
                "total" => $citasPorMes[$mes]
            ];
        }

        // Inasistencias por mes
        $sqlInasistencias = "SELECT 
                                DATE_FORMAT(cm.fecha_cita, '%Y-%m') AS mes,
                                COUNT(*) AS total
                             FROM cita_medica cm
                             JOIN historial_cita hc ON cm.codigo_cita = hc.codigo_cita
                             JOIN paciente pa ON cm.id_paciente = pa.id_paciente
                             WHERE $condicion
                               AND hc.id_estado_cita = 1
                               AND hc.fecha_terminacion IS NULL
                               AND cm.fecha_cita < NOW()
                               AND cm.fecha_cita >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                             GROUP BY mes
                             ORDER BY mes";

        $res = $conexion->ejecutarConsulta($sqlInasistencias);
        $inasistenciasPorMes = $fechas;
        
        while ($row = $res->fetch_assoc()) {
            $inasistenciasPorMes[$row['mes']] = (int)$row['total'];
        }

        foreach ($meses as $mes) {
            $response["inasistencias"][] = [
                "mes" => $mes,
                "total" => $inasistenciasPorMes[$mes]
            ];
        }
    }

    // Consultas para médico: Citas atendidas por mes
    if (($role == "M") || ($role == "A" && $tipoFiltro == "M")) {
        // Determinar condición según el contexto
        if ($role == "A" && $tipoFiltro == "M") {
            $condicion = "m.id_numero_identificacion = '$idFiltro'";
        } else if ($role == "M") {
            $condicion = "m.id_numero_identificacion = '$userId'";
        } else {
            $condicion = "1=1";
        }

        $sqlMedico = "SELECT 
                         DATE_FORMAT(cm.fecha_cita, '%Y-%m') AS mes,
                         COUNT(*) AS total
                      FROM cita_medica cm
                      JOIN historial_cita hc ON cm.codigo_cita = hc.codigo_cita
                      JOIN medico m ON cm.id_medico = m.id_medico
                      WHERE $condicion
                        AND hc.fecha_terminacion IS NOT NULL
                        AND cm.fecha_cita >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                      GROUP BY mes
                      ORDER BY mes";

        $res = $conexion->ejecutarConsulta($sqlMedico);
        $citasAtendidasPorMes = $fechas;
        
        while ($row = $res->fetch_assoc()) {
            $citasAtendidasPorMes[$row['mes']] = (int)$row['total'];
        }

        foreach ($meses as $mes) {
            $response["medico"][] = [
                "mes" => $mes,
                "total" => $citasAtendidasPorMes[$mes]
            ];
        }
    }
} catch (Exception $e) {
    $response["error"] = $e->getMessage();
}

$conexion->cerrarConexion();

// Limpiar buffer y enviar JSON
ob_end_clean();
echo json_encode($response);
exit();
?>
