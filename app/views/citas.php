<?php
if (!isset($_SESSION['id'])) {
    header("Location: ?pid=" . base64_encode("views/login.php"));
    exit();
}


//notificacion 
$toastVisible = false;
$toastMensaje = "";

?>

<body id="body-pd">
    <!--Container Main-->
    <div class="container">
        <h4>Citas Medicas</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="pendientes">Pendientes</button>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="historico">Historico</button>
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


    <script>
        $(document).ready(function() {
            const pacienteId = '<?= $_SESSION["id"] ?>';

            function cargarUsuarios(pagina = 1, filtro = '', tipo = 'pendientes') {
                $.ajax({
                    url: 'indexServer.php',
                    type: 'GET',
                    data: {
                        pid: '<?= base64_encode("ajax/tablaCitas.php") ?>',
                        pagina: pagina,
                        filtro: filtro,
                        tipo: tipo,
                        id: pacienteId
                    },
                    success: function(response) {
                        $('#data-component').html(response);
                    }
                });
            }

            // Carga por defecto
            cargarUsuarios(1, '<?php echo $_GET['filtro'] ?? ""; ?>', 'pendientes');

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
                    let tipo = $('button[data-value].active').data('value') || 'pendientes';
                    cargarUsuarios(1, filtro, tipo);
                }
            });

            // Paginación
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let pagina = $(this).data('pagina');
                const filtro = $('#search').val();
                let tipo = $('button[data-value].active').data('value') || 'pendientes';

                if (!$(this).parent().hasClass('disabled')) {
                    cargarUsuarios(pagina, filtro, tipo);
                }
            });

            // Formulario de agregar
            $('#button-addon2').on('click', function() {
                let tipo = $('button[data-value].active').data('value') || 'pendientes';
                let url = 'indexServer.php?pid=<?= base64_encode("ajax/formularioAgregarCita.php") ?>&tipo=' + tipo;
                $('#data-component').load(url);
            });
        });
    </script>
</body>