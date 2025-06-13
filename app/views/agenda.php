<?php
if ($_SESSION["role"] == "M") {
    $persona = new Medico($_SESSION["id"]);
    $persona->consultarPorId();
}else {
    header("Location: ?pid=" . base64_encode("views/sinPermisos.php"));
}
  if ($_POST['agendaBTN'] or $_POST['disponibilidadBTN']) {
    echo '<div class="eventos">';
    if (isset($_POST['fechaSeleccionada'])) {
        $fechaSeleccionada = $_POST['fechaSeleccionada'];
        mostrarEventos($fechaSeleccionada);
    } else {
        echo "Seleccione una fecha para ver los eventos.";
    }
    echo '</div>';
}


function generarCalendario($mes, $año) {

        $diasEnMes = date('t', mktime(0, 0, 0, $mes, 1, $año));
        $primerDia = date('N', mktime(0, 0, 0, $mes, 1, $año)); 
        
        //  tabla HTML
        $html = '<table>';
        $html .= '<thead><tr>';
        $html .= '<th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th>';
        $html .= '</tr></thead><tbody>';
        $html .= '<tr>';
        
        // celdas vacías
        for ($i = 1; $i < $primerDia; $i++) {
            $html .= '<td class="empty-day"></td>';
        }
        
        // Generar celdas para cada día del mes
        $diaActual = 1;
        while ($diaActual <= $diasEnMes) {
            // Si llegamos al final de la semana (domingo), cerramos la fila
            if (($diaActual + $primerDia - 2) % 7 == 0 && $diaActual != 1) {
                $html .= '</tr><tr>';
            }
            
            // Formatear fecha completa (YYYY-MM-DD)
            $fechaCompleta = sprintf('%04d-%02d-%02d', $año, $mes, $diaActual);
            
            // Celda con botón
            $html .= '<td>';
            $html .= '<form method="post" action="?pid='.base64_encode("views/agenda.php").'">';
            $html .= '<button type="submit" name="'.$fechaCompleta.'">';
            $html .= $diaActual; // Mostrar solo el número del día
            $html .= '</button>';
            $html .= '</form>';
            $html .= '</td>';
            
            $diaActual++;
        }
        
        // Completar la última fila con celdas vacías si es necesario
        $celdasRestantes = 7 - (($diasEnMes + $primerDia - 1) % 7);
        if ($celdasRestantes < 7) {
            for ($i = 0; $i < $celdasRestantes; $i++) {
                $html .= '<td class="empty-day"></td>';
            }
        }
        
        $html .= '</tr></tbody></table>';
        return $html;
    }

    function mostrarEventos($fecha) {

        global $conexion, $medicoDAO;

        $eventos = $conexion->ejecutarConsulta($medicoDAO->agenda($fecha));

        if (empty($eventos)) {
            echo "No hay eventos programados para esta fecha.";
        } else {
            echo "<ul>";
            foreach ($eventos as $evento) {
                echo "<li>" . htmlspecialchars($evento['nombre']) . " - " . htmlspecialchars($evento['hora']) . "</li>";
            }
            echo "</ul>";
        }
    }
?>
<body id="body-pd">
    <?php
    include("components/menu.php");
    ?>

    <!--Container Main-->
    <div class="container">
        
        <form method="post" action="?pid=<?= base64_encode("views/agenda.php") ?>">
            <button id="agendaButton" class="btn btn-primary mb-3" name="agendaBTN">Ver Agenda</button>
            <button id="disponibilidadButton" class="btn btn-secondary mb-3" name="disponibilidadBTN">Disponibilidad</button>
        </form>
        <?php
        if (isset($_POST['agendaBTN'])) {
            echo '<div>' . generarCalendario(date('m'), date('Y')) . '</div>';
            
        } elseif (isset($_POST['disponibilidadBTN'])) {
            //agregar logica para modificar la disponibilidad de medico
        }
        ?>
    </div>
    <script src="js/home.js"></script>
</body>
