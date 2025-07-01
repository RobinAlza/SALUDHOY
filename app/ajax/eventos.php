<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/medicoDAO.php');
require_once(__DIR__ . '/../models/medico.php');


session_start();



if (isset($_GET['year'], $_GET['month'], $_GET['day']) && 
    isset($_SESSION["role"], $_SESSION["id"]) && 
    $_SESSION["role"] === "M") {
    
    $medico = new Medico($_SESSION["id"]);
    $medico->consultarPorId();

    $year = intval($_GET['year']);
    $month  = intval($_GET['month']);
    $day  = intval($_GET['day']);

    // Formato YYYY-MM-DD
    $fechaCompleta = sprintf('%04d-%02d-%02d', $year, $month, $day);
    var_dump($fechaCompleta);

    $id_medico = $medico->getIdMedico();
    var_dump($id_medico);

    var_dump($_SESSION["id"]);


    // Instanciar conexión
    $conexion = new Conexion();
    $conexion->abrirConexion();
    
    $medico = new Medico($_SESSION["id"]);
    $medico->consultarPorId(); // Para obtener numeroIdentificacion
    $medicoDAO = new MedicoDAO($medico->getNumeroIdentificacion());


    // Ejecutar consulta
    $resultados = $conexion->ejecutarConsulta($medicoDAO->agenda($fechaCompleta, $id_medico));

    // Mostrar tabla
    if (!empty($resultados)) {
        echo "<h5>Citas para el día $fechaCompleta</h5>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='table-light'>
                <tr>
                    <th>Código</th>
                    <th>Consultorio</th>
                    <th>ID Paciente</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Tipo Paciente</th>
                </tr>
              </thead><tbody>";

        foreach ($resultados as $fila) {
            echo "<tr>
                    <td>{$fila['codigo_cita']}</td>
                    <td>{$fila['lugar_cita']}</td>
                    <td>{$fila['id_paciente']}</td>
                    <td>{$fila['nombre']}</td>
                    <td>{$fila['apellido']}</td>
                    <td>{$fila['nombre_tipo']}</td>
                  </tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-muted'>No hay citas agendadas para el $fechaCompleta.</p>";
    }
} else {
    echo "<div class='alert alert-warning'>Faltan datos o permisos para mostrar las citas.</div>";
}
