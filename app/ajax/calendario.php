<?php
session_start();
require_once(__DIR__ . '/../models/Medico.php');

if (isset($_GET['anio']) && isset($_GET['mes'])) {
    $year = intval($_GET['anio']);
    $month  = intval($_GET['mes']);
    $btn = $_GET['btn'];

    $medico = new Medico($_SESSION["id"]);
    $medico->consultarPorId();
    $id_medico = $medico->getIdMedico();


    // Obtener número de días y primer día del mes
    $diasEnMes = date('t', mktime(0, 0, 0, $month, 1, $year));
    $primerDiaSemana = date('N', mktime(0, 0, 0, $month, 1, $year)); // 1 = lunes, 7 = domingo

    // Encabezados de la tabla
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered text-center'>";
    echo "<thead class='table-light'><tr>
            <th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th>
          </tr></thead>";
    echo "<tbody><tr>";

    // Celdas vacías hasta el primer día
    for ($i = 1; $i < $primerDiaSemana; $i++) {
        echo "<td></td>";
    }

    // Generar celdas para cada día del mes
    $dia = 1;
    for ($i = $primerDiaSemana; $dia <= $diasEnMes; $i++) {
        // Mostrar el número del día
        echo "<td><button class='btn' onclick='seleccionarFecha($year, " . str_pad($month, 2, '0', STR_PAD_LEFT) . 
        ", " . str_pad($dia, 2, '0', STR_PAD_LEFT) . ")'>" . $dia . "</button></td>";


        // Si es domingo, cerrar fila y abrir nueva
        if ($i % 7 == 0) {
            echo "</tr><tr>";
        }

        $dia++;
    }

    // Rellenar los últimos días vacíos si el mes no termina en domingo
    $celdasRestantes = (7 - (($diasEnMes + $primerDiaSemana - 1) % 7)) % 7;
    for ($i = 0; $i < $celdasRestantes; $i++) {
        echo "<td></td>";
    }

    echo "</tr></tbody></table>";
    echo "</div>";
} else {
    echo "<p>Faltan parámetros para generar el calendario.</p>";
}

echo "<div class='text-center mt-3'>Botón: $btn</div>";




?>
<!-- Modal para mostrar habilitacion de horarios -->
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
        <button class="btn btn-primary" id="guardarHorarios" >Guardar</button>
      </div>
    </div>
  </div>
</div>

<script>
    function seleccionarFecha(anio, mes, dia) {
        var btn = '<?= $btn=$_GET['btn']?>';

        let url = (btn == 'agenda') ? 'ajax/eventos.php' : 'ajax/horarios.php';
        let cont = (btn == 'agenda') ? '#eventos-container' : '#detalleContenido';

        $.ajax({
            url: url,
            type: 'GET',
            data: { 
                year: anio,
                month: mes,
                day: dia
            },
            success: function(response) {
                $(cont).html(response);

                if (btn != 'agenda') {
                    var myModal = new bootstrap.Modal(document.getElementById('detalleModal'));
                    myModal.show();
                }
            },
            error: function(xhr) {
                console.error('Error al cargar eventos:', xhr.responseText);
                $(cont).html('<div class="alert alert-danger">Error al cargar eventos</div>');
            }
        });

        if(btn == 'disonibilidad') {
            $(document).ready(function() {
                // Manejo de boton guardar 
                $('#guardarHorarios').click(function() {
                    // Crear un array para almacenar 
                    var horas = [];

                    // Recorrer todos los checkboxes dentro del modal
                    $('#detalleContenido .horario-checkbox').each(function() {
                        var hora = $(this).val();
                        var estado = $(this).is(':checked') ? 1 : 0; 

                        // Agregar al array
                        horas.push({
                            hora: hora,
                            estado: estado
                        });
                    });

                    console.log(horas);

                    // Llamada a la función guardar
                    guardarFranjaHoraria(horas, year + '-' + month + '-' + day, '<?= $id_medico ?>');
                });
            });

        }
        
    }


</script>

