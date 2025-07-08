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
                    <th>Fecha Cita</th>
                    <th>Ver Detalles</th>
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
                <td>{$fila['fecha_cita']}</td>
                <td>
                    <button type='button' class='btn btn-outline-primary ver-detalle-btn' 
                        data-id='{$fila['codigo_cita']}' 
                        data-fecha='{$fila['fecha_cita']}' 
                        data-bs-toggle='modal' 
                        data-bs-target='#detalleModal'>
                        <span class='material-symbols-rounded'>visibility</span>
                    </button>
                </td>
            </tr>";

        }

        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-muted'>No hay citas agendadas para el $fechaCompleta.</p>";
    }
} else {
    echo "<div class='alert alert-warning'>Faltan datos o permisos para mostrar las citas.</div>";
}
echo "<div class='modal fade' id='detalleModal' tabindex='-1' aria-labelledby='detalleModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-lg'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='detalleModalLabel'>Detalles de la Cita</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
      </div>
      <div class='modal-body' id='detalleContenido'>
        <!-- Aquí se cargará detalles.php vía AJAX -->
        <p>Cargando detalles...</p>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
      </div>
    </div>
  </div>
</div>
"
?>
<script>
  //  detalles en el modal
  $(document).on('click', '.ver-detalle-btn', function() {
      var idCita = $(this).data('id');

      $('#detalleContenido').html('<p>Cargando detalles...</p>');

      $.ajax({
          url: 'ajax/detalles.php',
          type: 'GET',
          data: { 
            id: idCita
           },
          success: function(response) {
              $('#detalleContenido').html(response);
          },
          error: function(xhr) {
              $('#detalleContenido').html('<p class="text-danger">Error al cargar detalles.</p>');
              console.log(xhr.responseText);
          }
      });
  });

</script>