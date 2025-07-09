<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

// Solo administradores pueden acceder
if ($_SESSION["role"] != "A") {
    header("Content-Type: application/json");
    echo json_encode(["error" => "Acceso no autorizado"]);
    exit();
}

$tipo = $_GET['tipo'] ?? '';
if (!in_array($tipo, ['P', 'M'])) {
    header("Content-Type: application/json");
    echo json_encode(["error" => "Tipo de usuario no válido"]);
    exit();
}

$conexion = new Conexion();
$conexion->abrirConexion();

$usuarios = [];
$sql = "";

if ($tipo === 'P') {
    // Obtener pacientes
    $sql = "SELECT 
                p.numero_identificacion AS id, 
                CONCAT(p.nombre, ' ', p.apellido) AS nombre 
            FROM paciente pa
            JOIN persona p ON pa.id_numero_identificacion = p.numero_identificacion
            ORDER BY p.nombre ASC";
} elseif ($tipo === 'M') {
    // Obtener médicos
    $sql = "SELECT 
                p.numero_identificacion AS id, 
                CONCAT(p.nombre, ' ', p.apellido) AS nombre
            FROM medico m
            JOIN persona p ON m.id_numero_identificacion = p.numero_identificacion
            ORDER BY p.nombre ASC";
}

$result = $conexion->ejecutarConsulta($sql);
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

$conexion->cerrarConexion();

header("Content-Type: application/json");
echo json_encode($usuarios);
exit();
?>
