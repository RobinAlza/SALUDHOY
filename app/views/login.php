<?php
if (isset($_POST['sendButton'])) {
    $nombre = $_POST["name"];
    $clave = ($_POST["password"]);
    $medico = new Medico(null, null, $nombre, null, null, null, null, $clave, null);
    if($medico->autenticar()) {
        $_SESSION["id"] = $medico->getNumeroIdentificacion();
        $_SESSION["role"] = "M";
        header("Location: ?pid=" . base64_encode("views/home.php"));
        exit;
    }else {
        $persona = new Paciente(null, null, $nombre, null, null, null, null, $clave, null);
        if($persona->autenticar()) {
            $_SESSION["id"] = $persona->getNumeroIdentificacion();
            $_SESSION["role"] = "P";
            header("Location: ?pid=" . base64_encode("views/home.php"));
            exit;
        } else {
            echo "no autenticado";
            $error = true;
        }
    }
}
?>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="text-center">
                    <img src="./img/logo_saludHoy.png" alt="logo" width="150">
                </div>
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <form method="post" action="?pid=<?= base64_encode("views/login.php") ?>" class="needs-validation" novalidate="" autocomplete="on">
                            <h1 class="fs-4 card-title fw-bold mb-4">Inicio Sesion</h1>
                            <?php if (isset($error) && $error): ?>
                                <div class="alert alert-danger mt-3" role="alert" id="alertContainer">
                                    <p id="alert">Error en el inicio de sesión. Verifique credenciales</p>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="mb-3 text-muted" for="name">Correo Electrónico</label>
                                <input name="name" type="name" class="form-control" required autofocus>
                            </div>
                            <label class="mb-3 text-muted" for="passwordInput">Contraseña</label>
                            <div class="input-group mb-3">
                                <input id="passwordInput" name="password" type="password" class="form-control">
                                <button class="btn btn-outline-secondary" type="button" id="seeButton">
                                    <span class="material-symbols-rounded" id="icon">visibility</span>
                                </button>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="sendButton" class="btn btn-primary max-width">
                                    Iniciar Sesion
                                </button>
                            </div>
                            <div class="mt-4 text-center">
                                <a href="views/signOn.php" class="fs-5">Sign On</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Footer -->
                <?php include("../app/components/footer.php") ?>
            </div>
        </div>
    </div>
</section>
<script>
    const btnPasswordInput = document.getElementById('seeButton');
    btnPasswordInput.addEventListener("click", () => {
        const passwordInput = document.getElementById('passwordInput');
        const icon = document.getElementById('icon');

        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        icon.textContent = isPassword ? 'visibility_off' : 'visibility';
    });
</script>