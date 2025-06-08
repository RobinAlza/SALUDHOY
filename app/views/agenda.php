<?php
if ($_SESSION["role"] == "M") {
    $persona = new Medico($_SESSION["id"]);
    $persona->consultarPorId();
} else {
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
        <h4> modulo para que el medico pueda ver las citas medicas asignadas
        </h4>
    </div>
    <script src="js/home.js"></script>
</body>