<?php
if (!isset($_SESSION['id'])) {
    header("Location: ?pid=" . base64_encode("views/login.php"));
    exit();
}
?>

<body id="body-pd">
    <!--Container Main-->
    <div class="container">
        <h4>Main Components</h4>
        <?/* Pedidos por proveedor*/ ?>
        <div class="card mb-5">
            <div class="container row my-3 p-3">
                <h4>Gráficos de Medico</h4>
                <div class="col-6" id="graficoBarras-proveedor" style="width: 600px; height: 400px;"></div>
                <div class="col-6" id="graficoPie-proveedor" style="width: 600px; height: 400px;"></div>
            </div>
        </div>
        <?/* Cliente con mas compras*/ ?>
        <div class="card mb-5">
            <div class="container row my-3 p-3">
                <h4>Gráficos de Paciente</h4>
                <div class="col-6" id="graficoPie-cliente" style="width: 600px; height: 400px;"></div>
                <div class="col-6" id="graficoBarras-cliente" style="width: 600px; height: 400px;"></div>
            </div>
        </div>
        <?/* Vendedor con mas ventas*/ ?>
        <div class="card mb-5">
            <div class="container row my-3 p-3">
                <h4>Gráficos de Citas</h4>
                <div class="col-6" id="graficoBarras-vendedor" style="width: 95%; height: 600px;"></div>
            </div>
            <div class="col-6" id="tabla-vendedor" style="width: 600px; height: 400px;"></div>
        </div>
    </div>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
</body>