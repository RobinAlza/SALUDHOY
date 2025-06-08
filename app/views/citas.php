<?php
if ($_SESSION["role"] == "P") {
    $persona = new Paciente($_SESSION["id"]);
    $persona->consultarPorId();
}else {
    header("Location: ?pid=" . base64_encode("views/sinPermisos.php"));
    exit;
}
?>

<body id="body-pd">
    <?php
    include("components/menu.php");
    ?>
    <!--Container Main-->
    <div class="container">
        <h4> modulo para ver el historico y estado de citas medicas de un paciente, ademas la gestion de un anueva cita

        </h4>
    </div>
    <script src="js/home.js"></script>
</body>