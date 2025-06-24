<?php

if ($_SESSION["role"] == "M") {
    $persona = new Medico($_SESSION["id"]);
    $persona->consultarPorId();
} else {
    header("Location: ?pid=" . base64_encode("views/sinPermisos.php"));
    exit();
}
?>

<body id="body-pd">
    <?php include("components/menu.php"); ?>

    <div class="container">
        <div class="row">
            <div class="input-group mb-3 mt-3">
                <h1>Agenda de <?= htmlspecialchars($persona->getNombre()) . " " . htmlspecialchars($persona->getApellido()) ?></h1>
            </div>
            <div class="col-2">
                <button id="agendaButton" class="btn btn-primary" data-value="agenda">Ver Agenda</button>
            </div>
            <div class="col-2">
                <button id="disponibilidadButton" class="btn btn-secondary" data-value="disponibilidad">Disponibilidad</button>
            </div>
        </div>
    </div>

    <div class="container mt-4" id="data-component">
        <!-- Aquí se cargará selectorFecha.php y luego calendario.php -->
    </div>
    <div id="eventos-container" class="mt-4">
        <!-- Aquí se cargarán los eventos del calendario -->
        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        function cargarFormularioAgenda() {
            $.ajax({
                url: 'ajax/selectorFecha.php',
                type: 'GET',
                success: function (response) {
                    $('#data-component').html(response);
                },
                error: function () {
                    $('#data-component').html("<p class='text-danger'>Error al cargar el formulario de selección de fecha.</p>");
                }
            });
        }

        $('button[data-value]').on('click', function () {
            const tipo = $(this).data('value');
            $('button[data-value]').removeClass('active');
            $(this).addClass('active');

            if (tipo === "agenda") {
                cargarFormularioAgenda();
            } else if (tipo === "disponibilidad") {
                $('#data-component').html("<p class='text-info'>Funcionalidad de disponibilidad aún no implementada.</p>");
            }
        });
    });
    </script>
</body>
