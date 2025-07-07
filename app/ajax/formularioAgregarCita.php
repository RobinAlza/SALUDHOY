<?php
session_start();

//input id_paciente
$paciente = new Paciente($_SESSION["id"]);
$idPasiente = $paciente->consultarPorIdentificacion();

//Especialidad
$tipo = new Especializacion();
$tipos = $tipo->consultarTodos();

//select medico
$medico = new Medico();
$medicos = $medico->listarMedicos();

//select consultorio
$con = new Consultorio();
$cons = $con->consultarTodos();


?>


<div class="card">
    <div class="card-body">
        <h5 class="card-title">Agendar Cita</h5>

        <form id="add-Cita" method="post" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" name="id_paciente" id="id_paciente" value="<?= $paciente->getNumeroIdentificacion() ?>">

                <!-- especilidad de cita -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tipoCita" class="form-label">* Especialidad de Cita</label>
                        <select class="form-select" name="tipoCita" id="tipoCita" required>
                            <option value="-1">Seleccione...</option>
                            <?php foreach ($tipos as $tipoActual) { ?>
                                <option value="<?= $tipoActual->getIdEspecializacion(); ?>">
                                    <?= $tipoActual->getEspecializacion(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- Especialista -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="especialista" class="form-label">* Especialista</label>
                        <select class="form-select" name="especialista" id="especialista" required>
                            <option value="-1">Seleccione...</option>
                            <?php foreach ($medicos as $tipoActual) { ?>
                                <option value="<?= $tipoActual->getNumeroIdentificacion(); ?>">
                                    <?= $tipoActual->getNombre(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- Fecha de la cita -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_cita" class="form-label">* Fecha de Cita</label>
                        <input type="date" class="form-control" name="fecha_cita" id="fecha_cita" required>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="hora_cita" class="form-label">* Hora de Cita</label>
                        <input type="time" class="form-control" name="hora_cita" id="hora_cita" required>
                    </div>

                </div>
                <!-- Consultorio -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="consultorio" class="form-label">* Consultorio</label>
                        <select class="form-select" name="consultorio" id="consultorio" required>
                            <option value="-1">Seleccione...</option>
                            <?php foreach ($cons as $tipoActual) { ?>
                                <option value="<?= $tipoActual->getIdConsultorio(); ?>">
                                    <?= $tipoActual->getLugarCita(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between align-items-start my-2">
                <div>
                    <button type="button" class="btn btn-danger me-2" id="cancel-button">Cancelar</button>
                    <button type="submit" class="btn btn-success" name="Add-Cita">Agregar</button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#add-Cita').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'ajax/agregarCita.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Cita registrada correctamente');
                        $('#add-Cita')[0].reset();
                    } else {
                        alert('Error al registrar la cita: ' + (response.message || ''));
                    }
                },
                error: function() {
                    alert('Error en el servidor o en la conexión');
                }
            });
        });
    });

    $(document).ready(function() {

        // Eliminar una propiedad agregada
        $(document).on('click', '.remove-number', function() {
            $(this).closest('.extra-number-content').remove();
        });

        // Manejo del botón de cancelar
        $('#cancel-button').on('click', function() {
            $.ajax({
                url: 'indexServer.php',
                type: 'GET',
                data: {
                    pid: '<?= base64_encode("ajax/tablaCitas.php") ?>',
                    tipo: 'pendientes',
                    filtro: ''
                },
                success: function(response) {
                    $('#data-component').html(response);
                }
            });
        });
    })
    
    document.getElementById('tipoCita').addEventListener('change', function() {
        console.log("Cambio detectado en tipoCita"); 

        const especialidadId = this.value;
        const pacienteId = document.getElementById('id_paciente').value;

        fetch('ajax/restrincionCita.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_especialidad=${encodeURIComponent(especialidadId)}&id_paciente=${encodeURIComponent(pacienteId)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.permitido === false) {
                    // Si no puede agendar, mostrar alerta y resetear select
                    alert("⚠️ No puedes agendar más de 2 citas para esta especialidad este mes.");
                    document.getElementById('tipoCita').value = "-1";
                    document.getElementById('especialista').innerHTML = '<option value="-1">Seleccione...</option>';
                } else {
                    // Cargar médicos disponibles
                    const selectMedico = document.getElementById('especialista');
                    selectMedico.innerHTML = '<option value="-1">Seleccione...</option>';

                    data.medicos.forEach(medico => {
                        const option = document.createElement('option');
                        option.value = medico.numero_identificacion;
                        option.textContent = medico.nombre + ' ' + medico.apellido;
                        selectMedico.appendChild(option);
                    });
                }
            });
    });
</script>