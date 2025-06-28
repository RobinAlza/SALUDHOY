<?php
require("models/persona.php");
require("models/paciente.php");
require("models/medico.php");
require("models/tipoIdentificacion.php");
require("models/municipioResidencia.php");
require("models/especializacion.php");
require("models/tipoPaciente.php");
require("models/telefonoPersona.php");
require("models/citaMedica.php");
require("models/consultorio.php");
require("models/estadoCita.php");
require("models/tipoCita.php");
require("models/historialCita.php");
require("models/administrador.php");




$pid = base64_decode($_GET["pid"]);
include($pid);
?>