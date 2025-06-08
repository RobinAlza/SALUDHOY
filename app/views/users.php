<?php
if ($_SESSION["role"] == "P") {
    $persona = new Paciente($_SESSION["id"]);
    $persona->consultarPorId();
} else if ($_SESSION["role"] == "M") {
    $persona = new Medico($_SESSION["id"]);
    $persona->consultarPorId();
} else {
    header("Location: ?pid=" . base64_encode("views/login.php"));
    exit;
}

//notificacion 
$toastVisible = false;
$toastMensaje = "";


if (isset($_POST['Add-medicos'])) {
    if (isset($_POST['identificacion'], $_POST['tipo-id'], $_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['municipio'], $_POST['fecha-nacimiento'], $_POST['clave'], $_POST['especializacion'], $_POST['numbers'])) {
        $identificacion = $_POST['identificacion'];
        $tipoId = $_POST['tipo-id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $municipio = $_POST['municipio'];
        $fecha = $_POST['fecha-nacimiento'];
        $password = $_POST['clave'];
        $especializacion =  $_POST['especializacion'];
        $numbers = $_POST['numbers'];
        $medico = new Medico($identificacion, $tipoId, $nombre, $apellido, $direccion, $municipio, $fecha, $password, $especializacion);
        $idMedico = $medico->guardar();

        foreach ($numbers as $number) {
            $telefono = new TelefonoPersona($identificacion, $number['value']);
            $telefono->guardarNumeros();
        }
        $toastVisible = true;
        $toastMensaje = "El médico ha sido agregado correctamente.";
    }
} else if (isset($_POST['Add-pacientes'])) {
    if (isset($_POST['identificacion'], $_POST['tipo-id'], $_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['municipio'], $_POST['fecha-nacimiento'], $_POST['clave'], $_POST['paciente'], $_POST['numbers'])) {
        $identificacion = $_POST['identificacion'];
        $tipoId = $_POST['tipo-id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $municipio = $_POST['municipio'];
        $fecha = $_POST['fecha-nacimiento'];
        $password = $_POST['clave'];
        $paciente =  $_POST['paciente'];
        $numbers = $_POST['numbers'];
        $pacien = new Paciente($identificacion, $tipoId, $nombre, $apellido, $direccion, $municipio, $fecha, $password, $paciente);
        $idPaciente = $pacien->guardar();

        foreach ($numbers as $number) {
            $telefono = new TelefonoPersona($identificacion, $number['value']);
            $telefono->guardarNumeros();
        }
        $toastVisible = true;

        $toastMensaje = "El paciente ha sido agregado correctamente.";
    }
}


if (isset($_POST['upDate-medicos'])) {
    if (isset($_POST['identificacion'], $_POST['tipo-id'], $_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['municipio'], $_POST['fecha-nacimiento'], $_POST['clave'], $_POST['especializacion'], $_POST['numbers'])) {
        $identificacion = $_POST['identificacion'];
        $tipoId = $_POST['tipo-id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $municipio = $_POST['municipio'];
        $fecha = $_POST['fecha-nacimiento'];
        $password = $_POST['clave'];
        $especializacion =  $_POST['especializacion'];
        $numbers = $_POST['numbers'];
        $medico = new Medico($identificacion, $tipoId, $nombre, $apellido, $direccion, $municipio, $fecha, $password, $especializacion);
        $idMedico = $medico->actualizar();

        foreach ($numbers as $number) {
            $telefono = new TelefonoPersona($identificacion, $number['value']);
            $telefono->actualizarNumeros();
        }
        $toastVisible = true;
        $toastMensaje = "El médico ha sido Actualizado correctamente.";
    }
} else if (isset($_POST['upDate-pacientes'])) {
    if (isset($_POST['identificacion'], $_POST['tipo-id'], $_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['municipio'], $_POST['fecha-nacimiento'], $_POST['clave'], $_POST['paciente'], $_POST['numbers'])) {
        $identificacion = $_POST['identificacion'];
        $tipoId = $_POST['tipo-id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $municipio = $_POST['municipio'];
        $fecha = $_POST['fecha-nacimiento'];
        $password = $_POST['clave'];
        $paciente =  $_POST['paciente'];
        $numbers = $_POST['numbers'];
        $pacien = new Paciente($identificacion, $tipoId, $nombre, $apellido, $direccion, $municipio, $fecha, $password, $paciente);
        $idPaciente = $pacien->actualizar();

        foreach ($numbers as $number) {
            $telefono = new TelefonoPersona($identificacion, $number['value']);
            $telefono->actualizarNumeros();
        }
        $toastVisible = true;
        $toastMensaje = "El médico ha sido Actualizado correctamente.";
    }
}


?>

<body id="body-pd">
    <?php
    include("components/menu.php");
    ?>
    <!--Container Main-->
    <div class="container">
        <h4>Administracion de usuarios</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="pacientes">Pacientes</button>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="medicos">Medicos</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="container">
                <div class="input-group mb-3 mt-3">
                    <input type="text" class="form-control" id="search" placeholder="Buscar" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn btn-success" type="button" id="button-addon"><span class="material-symbols-rounded">filter_alt</span></button>
                    <button class="btn btn btn-primary" type="button" id="button-addon2"><span class="material-symbols-rounded">add</span></button>
                </div>
                <div class="container" id="data-component">
                </div>
            </div>
        </div>
    </div>

    <!--Notificacion-->

    <?php if ($toastVisible): ?>
        <div class="position-fixed end-0 p-3" style="top: 50px; z-index: 1055;">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" class="rounded me-2" alt="check" width="20">
                    <strong class="me-auto">Sistema</strong>
                    <small class="text-muted">just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <?= $toastMensaje ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <script src="js/home.js"></script>
    <script>
        $(document).ready(function() {
            function cargarUsuarios(pagina = 1, filtro = '', tipo = 'medicos') {
                $.ajax({
                    url: 'indexServer.php',
                    type: 'GET',
                    data: {
                        pid: '<?= base64_encode("ajax/tablaUsuarios.php") ?>',
                        pagina: pagina,
                        filtro: filtro,
                        tipo: tipo
                    },
                    success: function(response) {
                        $('#data-component').html(response);
                    }
                });
            }

            // Carga por defecto
            cargarUsuarios(1, '<?php echo $_GET['filtro'] ?? ""; ?>', 'medicos');

            // Botones tipo usuario
            $('button[data-value]').on('click', function() {
                let tipo = $(this).data('value');
                $('button[data-value]').removeClass('active');
                $(this).addClass('active');
                cargarUsuarios(1, $('#search').val(), tipo);
            });

            // Búsqueda
            $('#search').keyup(function() {
                const filtro = $(this).val();
                if (filtro.length >= 3 || filtro.length === 0) {
                    let tipo = $('button[data-value].active').data('value') || 'medicos';
                    cargarUsuarios(1, filtro, tipo);
                }
            });

            // Paginación
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let pagina = $(this).data('pagina');
                const filtro = $('#search').val();
                let tipo = $('button[data-value].active').data('value') || 'medicos';

                if (!$(this).parent().hasClass('disabled')) {
                    cargarUsuarios(pagina, filtro, tipo);
                }
            });

            // Formulario de agregar
            $('#button-addon2').on('click', function() {
                let tipo = $('button[data-value].active').data('value') || 'medicos';
                let url = 'indexServer.php?pid=<?= base64_encode("ajax/formularioAgregarUsuarios.php") ?>&tipo=' + tipo;
                $('#data-component').load(url);
            });
        });
    </script>
</body>