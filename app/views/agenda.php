<?php
if (!isset($_SESSION['id'])) {
    header("Location: ?pid=" . base64_encode("views/login.php"));
    exit();

}
?>

<body id="body-pd">
    <!--Container Main-->
    <div class="container">
        <h4> modulo para que el medico pueda ver las citas medicas asignadas
        </h4>
    </div>
</body>