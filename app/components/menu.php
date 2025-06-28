<?php
$route = base64_decode($_GET['pid']);
?>

<header class="header" id="header">
    <div class="header_toggle" id="header-toggle">
        <span class="material-symbols-rounded">Menu</span>
    </div>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle d-flex align-items-center justify-content-center" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="header_img d-flex align-items-center">
                <!--<img src="" alt="User Image" id="userImage" class="rounded-circle me-2" style="width: 40px; height: 40px;">-->
            </div>
            <?php
            if ($_SESSION["role"] == 'M') {
                // Es medico
                $medico = new Medico($_SESSION["id"]);
                $medico->consultarPorId();
                echo '<p class="user-name m-0 ms-2 text-center">' . $medico->NombreCompleto() . '</p>';
            } else if ($_SESSION["role"] == 'P') {
                // Es paciente
                $paciente = new Paciente($_SESSION["id"]);
                $paciente->consultarPorId();
                echo '<p class="user-name m-0 ms-2 text-center">' . $paciente->NombreCompleto() . '</p>';
            } else {
                // Es paciente
                $admin = new Admin($_SESSION["id"]);
                $admin->consultarPorId();
                echo '<p class="user-name m-0 ms-2 text-center">' . $admin->NombreCompleto() . '</p>';
            }
            ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
            <li><a class="dropdown-item d-flex align-items-center justify-content-center" href="">Perfil</a></li>
            <li><a class="dropdown-item d-flex align-items-center justify-content-center" href="">Edit Perfil</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item d-flex align-items-center justify-content-center" href="?pid=<?= base64_encode("views/login.php") ?>">Logout</a></li>
        </ul>
    </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="?pid=<?= base64_encode("views/home.php") ?>" class="nav_logo">
                <span class="material-symbols-rounded nav_logo-icon">layers</span>
                <span class="nav_logo-name">SALUDHOY</span>
            </a>
            <div class="nav_list">
                <?php
                if ($_SESSION["role"] == 'A') {
                    // Es cliente
                    $admin = new Admin($_SESSION["id"]);
                    $admin->consultarPorId();
                ?>
                    <a href="?pid=<?= base64_encode("views/home.php") ?>" class="nav_link <?= ($route == "views/home.php") ? "active" : "" ?>">
                        <span class="material-symbols-rounded nav_icon">Home</span>
                        <span class="nav_name">Home</span>
                    </a>
                    <a href="?pid=<?= base64_encode("views/users.php") ?>" class="nav_link <?= ($route == "views/users.php") ? "active" : "" ?>">
                        <span class="material-symbols-rounded nav_icon">person</span>
                        <span class="nav_name">Users</span>
                    </a>
                    <a href="?pid=<?= base64_encode("views/agenda.php") ?>" class="nav_link <?= ($route == "views/agenda.php") ? "active" : "" ?>">
                        <span class="material-symbols-rounded nav_icon">event</span>
                        <span class="nav_name">Agenda</span>
                    </a>
                <?php
                } else {
                    // Es usuario
                    $medico = new Medico($_SESSION["id"]);
                    $medico->consultarPorId();
                ?>
                    <a href="?pid=<?= base64_encode("views/agenda.php") ?>" class="nav_link <?= ($route == "views/agenda.php") ? "active" : "" ?>">
                        <span class="material-symbols-rounded nav_icon">event</span>
                        <span class="nav_name">Agenda</span>
                    </a>
                <?php
                }
                ?>
                <a href="?pid=<?= base64_encode("views/citas.php") ?>" class="nav_link <?= ($route == "views/citas.php") ? "active" : "" ?>">
                    <span class="material-symbols-rounded nav_icon">assignment_add</span>
                    <span class="nav_name">Citas</span>
                </a>
            </div>
        </div>
        <a href="#" class="nav_link">

        </a>
    </nav>
</div>