<?php
$items = [];
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $filtro = $_GET['filtro'] ?? '';

    if ($tipo === "medicos") {
        $medico = new Medico(null, null, $filtro);
        $items = $medico->consultarPorNombre();
    } elseif ($tipo === "pacientes") {
        $paciente = new Paciente(null, null, $filtro);
        $items = $paciente->consultarPorNombre();
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
                <th>Nombre Completo</th>
                <th>Identificación</th>
                <th>Tipo ID</th>
                <th>Dirección</th>
                <th>Municipio</th>
                <th>Fecha Nacimiento</th>
                <?php if ($tipo === "medicos"): ?>
                    <th>Especialización</th>
                <?php else: ?>
                    <th>Tipo Paciente</th>
                <?php endif; ?>
                <th>Teléfonos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itemsPagina as $item): ?>
                <tr>
                    <td><?= $item->getNombre() . " " . $item->getApellido() ?></td>
                    <td><?= $item->getNumeroIdentificacion() ?></td>
                    <td><?= $item->getIdTipoIdentificacion()->getTipoIdentificacion() ?></td>
                    <td><?= $item->getDireccion() ?></td>
                    <td><?= $item->getIdMunicipioResidencia()->getMunicipio() ?></td>
                    <td><?= $item->getFechaNacimiento() ?></td>
                    <?php if ($tipo === "medicos"): ?>
                        <td><?= $item->getIdEspecializacion()->getEspecializacion() ?></td>
                    <?php elseif ($tipo === "pacientes" && method_exists($item, 'getIdTipoPaciente')): ?>
                        <td><?= $item->getIdTipoPaciente()->getNombreTipo() ?></td>
                    <?php else: ?>
                        <td><em>Tipo no válido</em></td>
                    <?php endif; ?>

                    <td>
                        <?php
                        $telefonoObj = new TelefonoPersona($item->getNumeroIdentificacion());
                        $telefonos = $telefonoObj->consultarNumeros();

                        if (count($telefonos) > 0) {
                            foreach ($telefonos as $telefono) {
                                echo $telefono . "<br>";
                            }
                        }
                        ?>
                    </td>

                    <td>
                        <button
                            class="btn btn-success btn-editar-usuario"
                            data-id="<?= $item->getNumeroIdentificacion() ?>"
                            data-tipo="<?= $tipo ?>"
                            style="color: white;">
                            <span class='material-symbols-rounded'>edit</span>
                        </button>
                    </td>
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