<?php
session_start();
require_once '../models/medico.php';

// Verificamos permiso
if ($_SESSION["role"] !== "M") {
    header("Location: ?pid=" . base64_encode("views/sinPermisos.php"));
    exit;
}   

// Creamos el objeto Medico y obtenemos año/mes actuales y año minimo
$persona = new Medico($_SESSION["id"]);
$persona->consultarPorId();

$fechaMin = $persona->fechaMin(); 
$year  = date('Y');
$month = date('m');



?>
<div class="selectorFecha p-3">
    <h4>Seleccione la fecha para ver las citas agendadas en el mes</h4>
    <p></p>
    <div class="mb-2">
        <label for="anioInput" class="form-label">Año</label>
        <input
            type="number"
            id="anioInput"
            name="anio"
            class="form-control"
            min="<?php echo $fechaMin; ?>"
            max="<?= $year + 1 ?>"
            required
            value="<?= $year ?>"
        >
    </div>
    <div class="mb-3">
        <label for="mesInput" class="form-label">Mes</label>
        <input
            type="month"
            id="mesInput"
            name="mes"
            class="form-control"
            required
            value="<?= date('m') ?>"
        >
    </div>
    <div class="d-grid">
        <button type="button" id="ok" class="btn btn-primary">
            OK
        </button>
    </div>
</div>

<script>
$(document).ready(function() {
    var $btn = '<?= $btn=$_GET['btn']?>';
    $('#ok').on('click', function(e) {
        e.preventDefault();

        const mesCompleto = $('#mesInput').val(); // "2025-09"
        const partes = mesCompleto.split('-');
        const anio = parseInt(partes[0]);
        const mes = parseInt(partes[1]);

        $.ajax({
            url: 'ajax/calendario.php',
            type: 'GET',
            data: {
                anio: $('#anioInput').val(),
                mes:  mes,
                btn: $btn
            },
            success: function(response) {
                $('#data-component').html(response);
            },
            error: function(xhr) {
                console.error('Error al cargar el calendario:', xhr.responseText);
            }
        });
    });
});
</script>
