<?php
//Especialidad
$tipo = new TipoCita();
$tipos = $tipo->consultarTodos();

//select medico
//$medico = new Medico();
//$medicos = $medico->consultarTodos();

?>


<div class="card">
    <div class="card-body">
        <h5 class="card-title">Agendar Cita</h5>

        <form id="add-cita" method="post" action="?pid=<?= base64_encode("views/citas/agendarCita.php") ?>" enctype="multipart/form-data">
            <div class="row">
                <!-- especilidad de cita -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tipoCita" class="form-label">* Especialidad de Cita</label>
                        <select class="form-select" name="tipoCita" id="tipoCita" required>
                            <option value="-1">Seleccione...</option>
                            <?php foreach ($tipos as $tipoActual) { ?>
                                <option value="<?= $tipoActual->getIdTipoCita(); ?>"> 
                                    <?= $tipoActual->getEspecialidad(); ?>
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
                        <label for="Hora" class="form-label">* Hora Cita</label>
                        <select class="form-select" name="Hora" id="Hora" required>
                            <option value="-1">Seleccione...</option>
                              <?php foreach ($tipos as $tipoActual) { ?>
                                <option value="<?= $tipoActual->getIdTipoCita(); ?>"> 
                                    <?= $tipoActual->getEspecialidad(); ?>
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
                              <?php foreach ($tipos as $tipoActual) { ?>
                                <option value="<?= $tipoActual->getIdTipoCita(); ?>"> 
                                    <?= $tipoActual->getEspecialidad(); ?>
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
    });
</script>