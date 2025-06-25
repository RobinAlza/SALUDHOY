<?php
session_start();
if (isset($_GET["CerrarSesion"])) {
    session_destroy();
    exit();
}

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









$pagesWithOutSession = array(
    "views/login.php"
);
$pagesWithSession = array(
    "views/home.php",
    "views/users.php",
    "views/citas.php",
    "views/agenda.php",
    "views/sinPermisos.php",
);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALUDHOY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
    <div id="body-pd">


        <?php
        if (!isset($_GET["pid"])) {
            include("views/login.php");
        } else {
            $pid = base64_decode($_GET["pid"]);
            if (in_array($pid, $pagesWithOutSession)) {
                include($pid);
            } else if (in_array($pid, $pagesWithSession)) {
                if (isset($_SESSION["id"])) {
                    include("components/menu.php");
                    include($pid);
                } else {
                    include("views/login.php");
                }
            } else {
                echo "<h1>Error 404</h1>";
            }
        }
        ?>
    </div>

</body>

<script src="js/home.js"></script>

</html>