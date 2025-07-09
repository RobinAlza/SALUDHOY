<?php
require_once(__DIR__ . '/../config/conexion.php');
require_once(__DIR__ . '/../dao/medicoDAO.php');
require_once(__DIR__ . '/../models/medico.php');
require_once(__DIR__ . '/../models/historialCita.php'); // Asegúrate de tener este require

session_start();

// Procesar POST para editar estado de cita
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['codigo_cita'], $_POST['motivo_edicion'], $_POST['nuevo_estado'])) {
        $id_cita = $_POST['codigo_cita'];
        $motivo = $_POST['motivo_edicion'];
        $nuevoEstado = $_POST['nuevo_estado'];
        $fechaFin = date("Y-m-d H:i:s");


        // Crear objeto HistorialCita con el estado nuevo y motivo
        $estado = new HistorialCita(0, $id_cita, null, $fechaFin, $motivo, $nuevoEstado);

        $resultado = $estado->updateCita(); 

        echo json_encode(["success" => $resultado]);
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Faltan datos"]);
        exit();
    }
}

// Validar GET y sesión para mostrar la agenda
if (isset($_GET['year'], $_GET['month'], $_GET['day']) &&
    isset($_SESSION["role"], $_SESSION["id"]) &&
    $_SESSION["role"] === "M") {

    $medico = new Medico($_SESSION["id"]);
    $medico->consultarPorId();

    $year = intval($_GET['year']);
    $month = intval($_GET['month']);
    $day = intval($_GET['day']);
    $fechaCompleta = sprintf('%04d-%02d-%02d', $year, $month, $day);

    $id_medico = $medico->getIdMedico();

    $conexion = new Conexion();
    $conexion->abrirConexion();
    $medicoDAO = new MedicoDAO($medico->getNumeroIdentificacion());

    $resultados = $conexion->ejecutarConsulta($medicoDAO->agenda($fechaCompleta, $id_medico));

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
                    <th>Acciones</th>
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
                    <button
                      class='btn btn-success btn-editar-usuario'
                      data-bs-toggle='modal'
                      data-bs-target='#modalEditar'
                      data-id='{$fila['codigo_cita']}'
                      style='color: white;'> 
                      <span class='material-symbols-rounded'>edit</span>
                    </button>
                </td>
            </tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-muted'>No hay citas agendadas para el $fechaCompleta.</p>";
    }

    $conexion->cerrarConexion();
} else {
    echo "<div class='alert alert-warning'>Faltan datos o permisos para mostrar las citas.</div>";
}

?>

<!-- Modal Detalles -->
<div class='modal fade' id='detalleModal' tabindex='-1' aria-labelledby='detalleModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-lg'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='detalleModalLabel'>Detalles de la Cita</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
      </div>
      <div class='modal-body' id='detalleContenido'>
        <p>Cargando detalles...</p>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div class='modal fade' id='modalEditar' tabindex='-1' aria-labelledby='editarLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <form id='procesarEdicion'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='editarLabel'>Cambiar Estado de la Cita</h5>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
        </div>
        <div class='modal-body'>
          <input type='hidden' id='idCitaEditar' name='codigo_cita' value=''>
          <div class='mb-3'>
            <label for='nuevo_estado' class='form-label'>Nuevo Estado</label>
            <select id='nuevo_estado' name='nuevo_estado' class='form-select' required>
              <option disabled selected>Seleccione estado</option>
              <option value='3'>Finalizada</option>
              <option value='4'>Inasistida</option>
            </select>
          </div>
          <div class='mb-3'>
            <label for='motivo_edicion' class='form-label mt-2'>Motivo</label>
            <textarea name='motivo_edicion' class='form-control' rows='4' placeholder='Escribe el motivo...' required></textarea>
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

<script>
  // Cargar detalles en el modal
  $(document).on('click', '.ver-detalle-btn', function() {
    
      var idCita = $(this).data('id');
      $('#detalleContenido').html('<p>Cargando detalles...</p>');
      $.ajax({
          url: 'ajax/detalles.php',
          type: 'GET',
          data: { id: idCita },
          success: function(response) {
              $('#detalleContenido').html(response);
          },
          error: function(xhr) {
              $('#detalleContenido').html('<p class="text-danger">Error al cargar detalles.</p>');
              console.log(xhr.responseText);
          }
      });
  });

  // Preparar modal editar con ID de cita
  $('#modalEditar').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var idCita = button.data('id');
    $('#idCitaEditar').val(idCita);
  });

  // Procesar edición de estado
  $('#procesarEdicion').on('submit', function(e) {
    e.preventDefault();
    const datosFormulario = $(this).serialize();
    $.ajax({
      url: 'ajax/eventos.php', // Ajusta si tu archivo de procesamiento es diferente
      type: 'POST',
      data: datosFormulario,
      dataType: 'json',
      success: function(respuesta) {
        if (respuesta.success) {
          alert("Cita actualizada correctamente.");
          $('#procesarEdicion')[0].reset();
          $('#modalEditar').modal('hide');
          location.reload(); // recarga para actualizar la tabla
        } else {
          alert("Error: " + respuesta.message);
        }
      },
      error: function(xhr) {
        alert("Error al enviar la solicitud.");
        console.log(xhr.responseText);
      }
    });
  });
</script>
