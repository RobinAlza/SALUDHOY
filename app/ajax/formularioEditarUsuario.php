<?php
$tipoAgregacion = isset($_GET['tipo']) ? $_GET['tipo'] : ''; // Obtener el tipo desde GET
$items = [];
$identificaicon =  $_GET['id'];

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

//campos de telefono
$telefonoObj = new TelefonoPersona($identificaicon);
$telefonos = $telefonoObj->consultarNumeros();


if ($tipoAgregacion === "medicos") {
    $medico = new Medico($identificaicon);
    $medico->consultar();
    $nombre = $medico->getNombre();
    $tipoId = $medico->getIdTipoIdentificacion()->getIdTipoIdentificacion();
    $tipoN = $medico->getIdTipoIdentificacion()->getTipoIdentificacion();
    $apellido = $medico->getApellido();
    $direccion = $medico->getDireccion();
    $municipioId = $medico->getIdMunicipioResidencia()->getIdMunicipioResidencia();
    $municipio = $medico->getIdMunicipioResidencia()->getMunicipio();
    $fechaNacimiento = $medico->getFechaNacimiento();
    $clave = $medico->getClave();
    $especializacionId = $medico->getIdEspecializacion()->getIdEspecializacion();
    $especializacion = $medico->getIdEspecializacion()->getEspecializacion();
} elseif ($tipoAgregacion === "pacientes") {
    $paciente = new Paciente($identificaicon);
    $paciente->consultar();
    $nombre = $paciente->getNombre();
    $tipoId = $paciente->getIdTipoIdentificacion()->getIdTipoIdentificacion();
    $tipoN = $paciente->getIdTipoIdentificacion()->getTipoIdentificacion();
    $apellido = $paciente->getApellido();
    $direccion = $paciente->getDireccion();
    $municipioId = $paciente->getIdMunicipioResidencia()->getIdMunicipioResidencia();
    $municipio = $paciente->getIdMunicipioResidencia()->getMunicipio();
    $fechaNacimiento = $paciente->getFechaNacimiento();
    $clave = $paciente->getClave();
    $pacienteId = $paciente->getIdTipoPaciente()->getIdTipoPaciente();
    $pacienteN = $paciente->getIdTipoPaciente()->getNombreTipo();
}


$campos = '';

if ($tipoAgregacion == 'medicos' || $tipoAgregacion == 'pacientes') {
    $campos = "<div class='row'>
    <div class='col-4'>
        <!-- Identificacion -->
        <div class='mb-3'>
            <label for='identificacion' class='form-label'>* Identificacion</label>
            <input type='number' class='form-control' name='identificacion' aria-describedby='emailHelp' value='$identificaicon' required >
        </div>
    </div>
    <div class='col-4'>
        <!-- tipo iD -->
        <label for='tipo-id' class='form-label'>* Tipo Identificacion</label>
        <select class='form-select' name='tipo-id' aria-label='Default select example' required>
            <option value='$tipoId'>$tipoN</option>";
    foreach ($tipos as $tipoActual) {
        if ($tipoActual->getIdTipoIdentificacion() == $tipoId) {
            continue; // Ya fue agregada como opción seleccionada arriba

        } else {
            $campos .= "<option value='" . $tipoActual->getIdTipoIdentificacion() . "'>" . $tipoActual->getTipoIdentificacion() . "</option>";
        }
    }
    $campos .= "
        </select>
    </div>
    <div class='col-4'>
        <!-- nombre -->
        <div class='mb-3'>
            <label for='nombre' lass='form-label'>* Nombres</label>
            <input type='text' class='form-control' name='nombre' aria-describedby='emailHelp'  value='$nombre' required>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-4'>
        <!-- apellido -->
        <div class='mb-3'>
            <label for='apellido' class='form-label'>* Apellidos</label>
            <input type='text' class='form-control' name='apellido' value='$apellido' aria-describedby='emailHelp' required>
        </div>
    </div>
    <div class='col-4'>
        <!-- Direccion -->
        <div class='mb-3'>
            <label for='direccion' class='form-label'>* Direccion</label>
            <input type='text' class='form-control' name='direccion' value='$direccion' aria-describedby='emailHelp' required>
        </div>
    </div>
    <div class='col-4'>
        <!-- Municipio -->
        <label for='municipio' class='form-label'>* Ciudad</label>
        <select class='form-select' name='municipio' aria-label='Default select example' required>
            <option value='$municipioId'>$municipio</option>";
    foreach ($municipios as $muniActual) {
        if ($muniActual->getIdMunicipioResidencia() == $municipioId) {
            continue; // Ya fue agregada como opción seleccionada arriba
        } else {
            $campos .= "<option value='" . $muniActual->getIdMunicipioResidencia() . "'>" . $muniActual->getMunicipio() . "</option>";
        }
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
                value='$fechaNacimiento'
                id='fecha-nacimiento'
                required>
        </div>
    </div>
    <div class='col-4'>
        <!-- clave -->
        <div class='mb-3'>
            <label for='clave' class='form-label'>* Contraseña</label>
            <input type='text' class='form-control' name='clave' value='$clave' aria-describedby='emailHelp' required>
        </div>
    </div>";

    if ($tipoAgregacion == 'medicos') {
        $campos .= "
    <div class='col-4'>
        <!-- especializacion -->
        <label for='especializacion' class='form-label'>* Tipo Especializacion</label>
        <select class='form-select' name='especializacion' aria-label='Default select example' required>
            <option value='$especializacionId'>$especializacion</option>";
        foreach ($espes as $espeActual) {
            if ($espeActual->getIdEspecializacion() == $especializacionId) {
                continue; // Ya fue agregada como opción seleccionada arriba
            } else {
                $campos .= "<option value='" . $espeActual->getIdEspecializacion() . "'>" . $espeActual->getEspecializacion() . "</option>";
            }
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
            <option value='$pacienteId'>$pacienteN</option>";
        foreach ($tipoPacientes as $tipoPActual) {
            $campos .= "<option value='" . $tipoPActual->getIdTipoPaciente() . "'>" . $tipoPActual->getNombreTipo() . "</option>";
        }
        $campos .= "
        </select>
    </div>";
    }
    // Campos de teléfonos
    if (count($telefonos) > 0) {
        foreach ($telefonos as $index => $telefono) {
            $campos .= "
        <div class='col-4'>
            <label for='numbers[$index][value]' class='form-label'>* Número Teléfono</label>
            <input type='number' class='form-control' name='numbers[$index][value]' value='$telefono' required>
        </div>";
        }
    } else {
        // Si no tiene teléfonos, se muestra un input vacío por defecto
        $campos .= "
    <div class='col-4'>
        <label for='numbers[0][value]' class='form-label'>* Número Teléfono</label>
        <input type='number' class='form-control' name='numbers[0][value]' required>
    </div>";
    }
    $campos .= "</div>";
}
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Agregar <?= $tipoAgregacion ?></h5>
        <form id="upDate-<?= $tipoAgregacion ?>" method="post" action="?pid=<?= base64_encode("views/users.php") ?>" enctype="multipart/form-data">
            <div id="dynamic-fields mb-3">
                <?= $campos ?>
            </div>
            <div class="align-item-end my-2">
                <!-- Botones a la derecha -->
                <div>
                    <button type="button" class="btn btn-danger me-2" id="cancel-button">Cancelar</button>
                    <button type="submit" class="btn btn-success" name="upDate-<?= $tipoAgregacion ?>">Actualizar</button>
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
                    tipo: 'medicos',
                    filtro: ''
                },
                success: function(response) {
                    $('#data-component').html(response);
                }
            });
        });
    });
</script>