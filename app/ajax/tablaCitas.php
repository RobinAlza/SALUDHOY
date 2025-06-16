<?php
$items = [];
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $filtro = $_GET['filtro'] ?? '';
    $idPaciente = $_GET['id'];

    $cita = new CitaMedica();
    $items = $cita->consultaPendientes($idPaciente);

    if ($tipo === "historico") {
    } elseif ($tipo === "pendientes") {
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
                    <td><?= $item->getIdTipoCita()->getEspecialidad() ?></td>
                    <td><?= $item->getIdConsultorio()->getLugarCita() ?></td>
                    <td><?= $item->getIdMedico()->nombreCompleto() ?></td>
                    <td><?= $item->getIdEstadoCita()->getEstadoCita() ?></td>
                    <?php if ($tipo === "historico"): ?>
                        <td><?= $item->getIdEstadoCita()->getMotivo() ?></td>
                    <?php endif; ?>
                    <?php if ($tipo === "pendientes"): ?>
                        <td>
                            <button
                                class="btn btn-success btn-editar-usuario"
                                data-id="<?= $item->getCodigoCita() ?>"
                                data-tipo="<?= $tipo ?>"
                                style="color: white;">
                                <span class='material-symbols-rounded'>edit</span>
                            </button>
                        </td>
                        <td>
                            <button
                                class="btn btn-danger btn-editar-usuario"
                                data-id="<?= $item->getCodigoCita() ?>"
                                data-tipo="<?= $tipo ?>"
                                style="color: white;">
                                <span class="material-symbols-rounded">
                                    delete
                                </span>
                            </button>
                        </td>

                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


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

<script>
    $(document).on('click', '.btn-editar-usuario', function() {

        const id = $(this).data('id');
        const tipo = $(this).data('tipo');

        const url = 'indexServer.php?pid=<?= base64_encode("ajax/formularioEditarUsuario.php") ?>&id=' + id + '&tipo=' + tipo;

        $('#data-component').load(url);
    });
</script>