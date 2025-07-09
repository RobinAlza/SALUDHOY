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
                     <!-- Botón Editar -->
                    <button
                      class='btn btn-success btn-editar-usuario'
                      data-bs-toggle='modal'
                      data-bs-target='#modalEditar'
                      data-id='{$fila['codigo_cita']}'
                      style='color: white;'> 
                      <span class='material-symbols-rounded'>edit</span>
                    </button>
                    <button
                      class='btn btn-danger btn-eliminar-usuario'
                      data-bs-toggle='modal'
                      data-bs-target='#modalEliminar'
                      data-id='{$fila['codigo_cita']}'
                      style='color: white;'>
                      <span class='material-symbols-rounded'>delete</span>
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

?>

<div class='modal fade' id='detalleModal' tabindex='-1' aria-labelledby='detalleModalLabel' aria-hidden='true'>
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

<div class='modal fade' id='modalEditar' tabindex='-1' aria-labelledby='editarLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <form id='procesarReagendamiento'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='editarLabel'>Reagendar Cita</h5>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
        </div>
        <div class='modal-body'>

          <!-- Campo oculto para el ID de la cita -->
          <input type='hidden' name='id_cita' id='idCitaEditar'>
          <div class='mb-3'>
            <label for='fecha_cita' class='form-label'> * Fecha Cita</label>
            <input type='date' class='form-control' name='fecha_cita' required>
          </div>
          <div class='mb-3'>
            <label for='hora_cita' class='form-label'>* Hora de Cita</label>
            <input type='time' class='form-control' name='hora_cita' id='hora_cita' required>
          </div>

        </div>
        <div class='modal-footer'>
          <button type='submit' class='btn btn-success'>Guardar cambios</button>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class='modal fade' id='modalEliminar' tabindex='-1' aria-labelledby='eliminarLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <form id='procesarEliminacion'>
      <div class='modal-content'>
        <div class='modal-header bg-danger text-white'>
          <h5 class='modal-title' id='eliminarLabel'>Confirmar Cancelacion</h5>
          <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Cerrar'></button>
        </div>
        <div class='modal-body'>
          <p>¿Estás seguro de que deseas cancelar esta cita?</p>

          <!-- Campo oculto para el ID de la cita -->
          <input type='hidden' name='id_cita' id='idCitaEliminar'>
          <!-- Campo textarea para el motivo -->
          <label for='motivo_cancelacion' class='form-label mt-2'>Motivo de la cancelación</label>
          <textarea name='motivo_cancelacion' class='form-control' rows='4' placeholder='Escribe el motivo de la cancelación...' required></textarea>
        </div>

        <div class='modal-footer'>
          <button type='submit' class='btn btn-danger'>Cancelar</button>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>

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