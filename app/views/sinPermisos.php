<?php
if (!isset($_SESSION['id'])) {
    header("Location: ?pid=" . base64_encode("views/login.php"));
    exit();
}
?>
<body id="body-pd">
    <!--Container Main-->

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <div class="card shadow-lg p-4 border-danger">
                <div class="card-body">
                    <h1 class="display-3 text-danger">403</h1>
                    <h2 class="mb-3">Acceso Denegado</h2>
                    <p class="text-muted mb-4">No tienes permisos para acceder a esta página.</p>
                    <a href="?pid=<?= base64_encode("views/home.php") ?>" class="btn btn-primary">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>

</body>
