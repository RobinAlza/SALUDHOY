<?php
session_start();
$items = [];
if (isset($_GET['tipo'])) {
  $tipo = $_GET['tipo'];
  $filtro = $_GET['filtro'] ?? '';
  $idPaciente = $_GET['id'];

  $cita = new CitaMedica();
  if ($_SESSION["role"] == 'P') {
    //Es paciente
    if ($tipo === "historico") {
      $items = $cita->consultaHistorico($idPaciente, $filtro);
    } elseif ($tipo === "pendientes") {
      $items = $cita->consultaPendientes($idPaciente, $filtro);
    }
  } else {
    //Es medico y admin
    if ($tipo === "historico") {
      $items = $cita->consultaCitasH($filtro);
    } elseif ($tipo === "pendientes") {
      $items = $cita->consultaCitasP($filtro);
    }
  }
}


// Definir cantidad de items por página
$itemsPorPagina = 9;
$totalItems   = count($items);
$paginas      = ($totalItems > 0) ? ceil($totalItems / $itemsPorPagina) : 1;

// Obtener la página actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$paginaActual = max(1, min($paginaActual, $paginas));

// Obtener items de la página actual
$inicio       = ($paginaActual - 1) * $itemsPorPagina;
$itemsPagina  = array_slice($items, $inicio, $itemsPorPagina);
?>

<br>
<?php
if ($_SESSION["role"] == 'M') {
?>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>codigo_cita</th>
          <th>fecha_cita</th>
          <th>Cita</th>
          <th>Consultorio </th>
          <th>Paciente</th>
          <th>Estado</th>
          <th>Observavion</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($itemsPagina as $item): ?>
          <tr>
            <td><?= $item->getCodigoCita() ?></td>
            <td><?= $item->getFechaCita() ?></td>
            <td><?= $item->getIdTipoCita()->getEspecializacion() ?></td>
            <td><?= $item->getIdConsultorio()->getLugarCita() ?></td>
            <td><?= $item->getIdMedico()->nombreCompleto() ?></td>
            <td><?= $item->estadoHistorial ?></td>
            <td><?= $item->motivoHistorial ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php
} else {
?>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>codigo_cita</th>
          <th>fecha_cita</th>
          <th>Cita</th>
          <th>Consultorio </th>
          <th>Especialista</th>
          <th>Estado</th>
          <?php if ($tipo === "historico"): ?>
            <th>Observavion</th>
          <?php endif; ?>
          <?php if ($tipo === "pendientes"): ?>
            <?php if ($_SESSION["role"] == 'A'): ?>
              <th>Asistencia</th>
            <?php endif; ?>

            <th>Reagendar</th>
            <th>Cancelar</th>
          <?php endif; ?>

        </tr>
      </thead>
      <tbody>
        <?php foreach ($itemsPagina as $item): ?>
          <tr>
            <td><?= $item->getCodigoCita() ?></td>
            <td><?= $item->getFechaCita() ?></td>
            <td><?= $item->getIdTipoCita()->getEspecializacion() ?></td>
            <td><?= $item->getIdConsultorio()->getLugarCita() ?></td>
            <td><?= $item->getIdMedico()->nombreCompleto() ?></td>
            <td><?= $item->estadoHistorial ?></td>
            <?php if ($tipo === "historico"): ?>
              <td><?= $item->motivoHistorial ?></td>
            <?php endif; ?>
            <?php if ($tipo === "pendientes"): ?>
              <?php if ($_SESSION["role"] == 'A'): ?>

                <!-- Botón Aistencia -->
                <td>
                  <button
                    class="btn btn-primary btn-editar-usuario"
                    data-bs-toggle="modal"
                    data-bs-target="#modalAsistencia"
                    data-id="<?= $item->getCodigoCita() ?>"
                    data-consultorio="<?= $item->getIdConsultorio()->getIdConsultorio() ?>"
                    style="color: white;">
                    <span class='material-symbols-rounded'>check</span>
                  </button>
                </td>
              <?php endif; ?>

              <!-- Botón Editar -->
              <td>
                <button
                  class="btn btn-success btn-editar-usuario"
                  data-bs-toggle="modal"
                  data-bs-target="#modalEditar"
                  data-id="<?= $item->getCodigoCita() ?>"
                  style="color: white;">
                  <span class='material-symbols-rounded'>edit</span>
                </button>
              </td>
              <!-- Botón Eliminar -->
              <td>
                <button
                  class="btn btn-danger btn-eliminar-usuario"
                  data-bs-toggle="modal"
                  data-bs-target="#modalEliminar"
                  data-id="<?= $item->getCodigoCita() ?>"
                  style="color: white;">
                  <span class="material-symbols-rounded">delete</span>
                </button>
              </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php

}
?>

<div id="data-component"></div>

<nav aria-label="Page navigation">
  <ul class="pagination justify-content-end">
    <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : ''; ?>">
      <a
        class="page-link"
        href="#"
        data-pagina="<?= $paginaActual - 1; ?>">&laquo;</a>
    </li>

    <?php for ($i = 1; $i <= $paginas; $i++): ?>
      <li class="page-item <?= ($paginaActual == $i) ? 'active' : ''; ?>">
        <a
          class="page-link"
          href="#"
          data-pagina="<?= $i; ?>"><?= $i; ?></a>
      </li>
    <?php endfor; ?>

    <li class="page-item <?= ($paginaActual >= $paginas) ? 'disabled' : ''; ?>">
      <a
        class="page-link"
        href="#"
        data-pagina="<?= $paginaActual + 1; ?>">&raquo;</a>
    </li>
  </ul>
</nav>

<div class="modal fade" id="modalAsistencia" tabindex="-1" aria-labelledby="asistenciaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="procesarAsistencia">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="asistenciaLabel">Confirmar Asistencia</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>¿Estás seguro de que quieres Confirmar la asistencia a la cita?</p>
          <!-- Campo oculto para el ID de la cita -->
          <input type="hidden" name="id_cita" id="idCitaAsistida">

          <!-- Campo oculto para el consultorio -->
          <input type="hidden" name="consultorio" id="consultorioAsistido">
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Confirmar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="editarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="procesarReagendamiento">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarLabel">Reagendar Cita</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

          <!-- Campo oculto para el ID de la cita -->
          <input type="hidden" name="id_cita" id="idCitaEditar">
          <div class="mb-3">
            <label for="fecha_cita" class="form-label"> * Fecha Cita</label>
            <input type="date" class="form-control" name="fecha_cita" required>
          </div>
          <div class="mb-3">
            <label for="hora_cita" class="form-label">* Hora de Cita</label>
            <input type="time" class="form-control" name="hora_cita" id="hora_cita" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="eliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="procesarEliminacion">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="eliminarLabel">Confirmar Cancelacion</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>¿Estás seguro de que deseas cancelar esta cita?</p>

          <!-- Campo oculto para el ID de la cita -->
          <input type="hidden" name="id_cita" id="idCitaEliminar">
          <!-- Campo textarea para el motivo -->
          <label for="motivo_cancelacion" class="form-label mt-2">Motivo de la cancelación</label>
          <textarea name="motivo_cancelacion" class="form-control" rows="4" placeholder="Escribe el motivo de la cancelación..." required></textarea>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Cancelar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Al abrir el modal, asignar el id_cita al input oculto
    $('#modalAsistencia').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget); // Botón que activó el modal

      var idCita = button.data('id'); // data-id
      var consultorio = button.data('consultorio'); // data-consultorio

      // Asignar a los inputs ocultos
      $('#idCitaAsistida').val(idCita);
      $('#consultorioAsistido').val(consultorio); // <-- aquí agregas esto
    });


    // Manejo del formulario
    $('#procesarAsistencia').on('submit', function(e) {
      e.preventDefault();

      const datosFormulario = $(this).serialize();

      $.ajax({
        url: 'ajax/asistenciaCita.php',
        type: 'POST',
        data: datosFormulario,
        dataType: 'json',
        success: function(respuesta) {
          if (respuesta.success) {
            alert("Confirmar Asistencia correctamente.");
            $('#procesarAsistencia')[0].reset();
            $('#modalAsistencia').modal('hide');
            // Aquí puedes actualizar la tabla si quieres con JS
          } else {
            alert("Error: " + respuesta.error);
          }
        },
        error: function(xhr) {
          alert("Error al enviar la solicitud.");
          console.log(xhr.responseText);
        }
      });
    });
  });

  $(document).ready(function() {
    // Al abrir el modal, asignar el id_cita al input oculto
    $('#modalEliminar').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget); // Botón que activó el modal
      var idCita = button.data('id'); // Extraer el id_cita

      // Asignarlo al input oculto dentro del modal
      $('#idCitaEliminar').val(idCita);
    });

    // Manejo del formulario
    $('#procesarEliminacion').on('submit', function(e) {
      e.preventDefault();

      const datosFormulario = $(this).serialize();

      $.ajax({
        url: 'ajax/CancelarCita.php',
        type: 'POST',
        data: datosFormulario,
        dataType: 'json',
        success: function(respuesta) {
          if (respuesta.success) {
            alert("Cita eliminada correctamente.");
            $('#procesarEliminacion')[0].reset();
            $('#modalEliminar').modal('hide');
            // Aquí puedes actualizar la tabla si quieres con JS
          } else {
            alert("Error: " + respuesta.error);
          }
        },
        error: function(xhr) {
          alert("Error al enviar la solicitud.");
          console.log(xhr.responseText);
        }
      });
    });
  });


  $(document).ready(function() {
    // Al abrir el modal, asignar el id_cita al input oculto
    $('#modalEditar').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget); // Botón que activó el modal
      var idCita = button.data('id'); // Extraer el id_cita

      // Asignarlo al input oculto dentro del modal
      $('#idCitaEditar').val(idCita);
    });

    $('#procesarReagendamiento').on('submit', function(e) {
      e.preventDefault();

      const datosFormulario = $(this).serialize();

      $.ajax({
        url: 'ajax/reagendadaCita.php',
        type: 'POST',
        data: datosFormulario,
        dataType: 'json',
        success: function(respuesta) {
          if (respuesta.success) {
            alert("Cita Reagendada correctamente.");
            $('#procesarReagendamiento')[0].reset();
            $('#modalEditar').modal('hide'); // <- este es el correcto
          } else {
            alert("Error: " + respuesta.error);
          }
        },
        error: function(xhr) {
          console.log("XHR Status:", xhr.status);
          console.log("XHR Response:", xhr.responseText);
          alert("Error al enviar la solicitud.");
        }

      });
    });
  });
</script>