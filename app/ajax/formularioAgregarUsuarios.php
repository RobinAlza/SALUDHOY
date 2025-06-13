<?php
$tipoAgregacion = isset($_GET['tipo']) ? $_GET['tipo'] : ''; // Obtener el tipo desde GET
//select tipo Identificaicon
$tipo = new TipoIdentificacion();
$tipos = $tipo->consultarTodos();

//select municipio
$muni = new MunicipioResidencia();
$municipios = $muni->consultarTodos();

//select espcecializacion
$espe = new Especializacion();
$espes = $espe->consultarTodos();

//select espcecializacion
$tipoP = new TipoPaciente();
$tipoPacientes = $tipoP->consultarTodos();

$campos = '';

if ($tipoAgregacion == 'medicos' || $tipoAgregacion == 'pacientes') {
    $campos = "<div class='row'>
    <div class='col-4'>
        <!-- Identificacion -->
        <div class='mb-3'>
            <label for='identificacion' class='form-label'>* Identificacion</label>
            <input type='number' class='form-control' name='identificacion' aria-describedby='emailHelp' required>
        </div>
    </div>
    <div class='col-4'>
        <!-- tipo iD -->
        <label for='tipo-id' class='form-label'>* Tipo Identificacion</label>
        <select class='form-select' name='tipo-id' aria-label='Default select example' required>
            <option value='-1'>Seleccione...</option>";
    foreach ($tipos as $tipoActual) {
        $campos .= "<option value='" . $tipoActual->getIdTipoIdentificacion() . "'>" . $tipoActual->getTipoIdentificacion() . "</option>";
    }
    $campos .= "
        </select>
    </div>
    <div class='col-4'>
        <!-- nombre -->
        <div class='mb-3'>
            <label for='nombre' class='form-label'>* Nombres</label>
            <input type='text' class='form-control' name='nombre' aria-describedby='emailHelp' required>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-4'>
        <!-- apellido -->
        <div class='mb-3'>
            <label for='apellido' class='form-label'>* Apellidos</label>
            <input type='text' class='form-control' name='apellido' aria-describedby='emailHelp' required>
        </div>
    </div>
    <div class='col-4'>
        <!-- Direccion -->
        <div class='mb-3'>
            <label for='direccion' class='form-label'>* Direccion</label>
            <input type='text' class='form-control' name='direccion' aria-describedby='emailHelp' required>
        </div>
    </div>
    <div class='col-4'>
        <!-- Municipio -->
        <label for='municipio' class='form-label'>* Ciudad</label>
        <select class='form-select' name='municipio' aria-label='Default select example' required>
            <option value='-1'>Seleccione...</option>";
    foreach ($municipios as $muniActual) {
        $campos .= "<option value='" . $muniActual->getIdMunicipioResidencia() . "'>" . $muniActual->getMunicipio() . "</option>";
    }
    $campos .= "
        </select>
    </div>
</div>
<div class='row'>
    <div class='col-4'>
        <!-- Fecha de Nacimiento -->
        <div class='mb-3'>
            <label for='fecha-nacimiento' class='form-label'>* Fecha de Nacimiento</label>
            <input
                type='date'
                class='form-control'
                name='fecha-nacimiento'
                id='fecha-nacimiento'
                required>
        </div>
    </div>
    <div class='col-4'>
        <!-- clave -->
        <div class='mb-3'>
            <label for='clave' class='form-label'>* Contraseña</label>
            <input type='text' class='form-control' name='clave' aria-describedby='emailHelp' required>
        </div>
    </div>";

    if ($tipoAgregacion == 'medicos') {
        $campos .= "
    <div class='col-4'>
        <!-- especializacion -->
        <label for='especializacion' class='form-label'>* Tipo Especializacion</label>
        <select class='form-select' name='especializacion' aria-label='Default select example' required>
            <option value=''>Seleccione...</option>";
        foreach ($espes as $espeActual) {
            $campos .= "<option value='" . $espeActual->getIdEspecializacion() . "'>" . $espeActual->getEspecializacion() . "</option>";
        }
        $campos .= "
        </select>
    </div>";
    } else {
        $campos .= "
    <div class='col-4'>
        <!-- tipo paciente -->
        <label for='paciente' class='form-label'>* Tipo Paciente</label>
        <select class='form-select' name='paciente' aria-label='Default select example' required>
            <option value=''>Seleccione...</option>";
        foreach ($tipoPacientes as $tipoPActual) {
            $campos .= "<option value='" . $tipoPActual->getIdTipoPaciente() . "'>" . $tipoPActual->getNombreTipo() . "</option>";
        }
        $campos .= "
        </select>
    </div>";
    }

    $campos .= "</div>";
}
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Agregar <?= $tipoAgregacion ?></h5>
        <form id="add-<?= $tipoAgregacion ?>" method="post" action="?pid=<?= base64_encode("views/users.php") ?>" enctype="multipart/form-data">
            <div id="dynamic-fields">
                <?= $campos ?>
                <!-- telefono contacto -->
                <div class='mb-3'>
                    <label for='numbers' class='form-label'>* Numero Telefono</label>
                    <input type='number' class='form-control' name='numbers[0][value]' required>
                </div>
                <div class='mb-3' id='extra-numbers'></div>

            </div>
            <div class="d-flex justify-content-between align-items-start my-2">
                <!-- Botón a la izquierda -->
                <div>
                    <button type="button" class="btn btn-outline-primary" id="add-number">Agregar otro número</button>
                </div>

                <!-- Botones a la derecha -->
                <div>
                    <button type="button" class="btn btn-danger me-2" id="cancel-button">Cancelar</button>
                    <button type="submit" class="btn btn-success" name="Add-<?= $tipoAgregacion ?>">Agregar</button>
                </div>
            </div>


        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        let propiedadIndex = 1;
        $('#add-number').on('click', function() {
            let newPropertyHtml = `
            <div class="extra-number-content mt-2">
                <div class="mb-3">
                    <label for="numbers" class="form-label">Numero Telefono</label>
                    <input type="number" class="form-control" name="numbers[${propiedadIndex}][value]" required>
                </div>
                <button type='button' class='btn btn-danger remove-number'>Eliminar</button>
            </div>
        `;

            $('#extra-numbers').append(newPropertyHtml);
            propiedadIndex++;
        });

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
                    pid: '<?= base64_encode("ajax/tablaUsuarios.php") ?>',
                    tipo: 'productos',
                    filtro: ''
                },
                success: function(response) {
                    $('#data-component').html(response);
                }
            });
        });
    });
</script>