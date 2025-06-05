<?php
if ($_SESSION["role"] == "P") {
    $persona = new Paciente($_SESSION["id"]);
    $persona->consultarPorId();
} else if ($_SESSION["role"] == "M") {
    $persona = new Medico($_SESSION["id"]);
    $persona->consultarPorId();
} else {
	header("Location: ?pid=" . base64_encode("views/login.php"));
	exit();
}
?>

<body id="body-pd">
    <?php
    include("components/menu.php");
    ?>
    <!--Container Main-->
    <div class="container">
        <h4> modulo para gestionar informacion de medicos y paciones, ademas registrar ingreso de los pacientes al hospital</h4>
    </div>
    <script src="js/home.js"></script>
</body>
