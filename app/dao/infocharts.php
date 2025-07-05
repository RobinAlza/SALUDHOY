<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

header("Content-Type: application/json");

if (!isset($_SESSION["role"]) || !isset($_SESSION["id"])) {
    echo json_encode(["error" => "No autenticado"]);
    exit();
}

$role = $_SESSION["role"];
$userId = $_SESSION["id"];
$conexion = new Conexion();
$conexion->abrirConexion();

$response = [
    "paciente" => [],
    "medico" => [],
    "inasistencias" => []
];

// Obtener los últimos 6 meses
$meses = [];
$fechas = [];
for ($i = 5; $i >= 0; $i--) {
    $fecha = date('Y-m', strtotime("-$i months"));
    $meses[] = $fecha;
    $fechas[$fecha] = 0;  // Inicializar con valor 0
}

try {
    // Consultas para paciente: Total de citas por mes
    if ($role == "P") {
        $sqlPaciente = "SELECT 
                            DATE_FORMAT(cm.fecha_cita, '%Y-%m') AS mes,
                            COUNT(*) AS total
                        FROM cita_medica cm
                        JOIN paciente p ON cm.id_paciente = p.id_paciente
                        WHERE p.id_numero_identificacion = '$userId'
                          AND cm.fecha_cita >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                        GROUP BY mes
                        ORDER BY mes";

        $res = $conexion->ejecutarConsulta($sqlPaciente);
        $citasPorMes = $fechas; // Iniciar con ceros
        
        while ($row = $res->fetch_assoc()) {
            $citasPorMes[$row['mes']] = $row['total'];
        }

        // Construir respuesta con todos los meses
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
                             JOIN paciente p ON cm.id_paciente = p.id_paciente
                             WHERE p.id_numero_identificacion = '$userId'
                               AND hc.id_estado_cita = 1
                               AND hc.fecha_terminacion IS NULL
                               AND cm.fecha_cita < NOW()
                               AND cm.fecha_cita >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                             GROUP BY mes
                             ORDER BY mes";

        $res = $conexion->ejecutarConsulta($sqlInasistencias);
        $inasistenciasPorMes = $fechas; // Iniciar con ceros
        
        while ($row = $res->fetch_assoc()) {
            $inasistenciasPorMes[$row['mes']] = $row['total'];
        }

        foreach ($meses as $mes) {
            $response["inasistencias"][] = [
                "mes" => $mes,
                "total" => $inasistenciasPorMes[$mes]
            ];
        }
    }
    
    // Consultas para médico: Citas atendidas por mes
    if ($role == "M") {
        $sqlMedico = "SELECT 
                         DATE_FORMAT(cm.fecha_cita, '%Y-%m') AS mes,
                         COUNT(*) AS total
                      FROM cita_medica cm
                      JOIN historial_cita hc ON cm.codigo_cita = hc.codigo_cita
                      JOIN medico m ON cm.id_medico = m.id_medico
                      WHERE m.id_numero_identificacion = '$userId'
                        AND hc.fecha_terminacion IS NOT NULL
                        AND cm.fecha_cita >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                      GROUP BY mes
                      ORDER BY mes";

        $res = $conexion->ejecutarConsulta($sqlMedico);
        $citasAtendidasPorMes = $fechas; // Iniciar con ceros
        
        while ($row = $res->fetch_assoc()) {
            $citasAtendidasPorMes[$row['mes']] = $row['total'];
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
echo json_encode($response);
?>
