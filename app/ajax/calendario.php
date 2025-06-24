<?php

if (isset($_GET['anio']) && isset($_GET['mes'])) {
    $year = intval($_GET['anio']);
    $month  = intval($_GET['mes']);


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
?>
<script>
function seleccionarFecha(anio, mes, dia) {
    $.ajax({
        url: 'ajax/eventos.php',
        type: 'GET',
        data: {
            year: anio,
            month: mes,
            day: dia
        },
        success: function(response) {
            $('#eventos-container').html(response);
        },
        error: function(xhr) {
            console.error('Error al cargar eventos:', xhr.responseText);
            $('#eventos-container').html('<div class="alert alert-danger">Error al cargar eventos</div>');
        }
    });
}
</script>
