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
    <?php include("components/menu.php"); ?>

    <!--Container Main-->
    <div class="container">
        <h4>Estadísticas de Citas (Últimos 6 meses)</h4>
        
        <!-- Mensaje informativo -->
        <div class="alert alert-info mb-4">
            Se muestran las estadísticas de los últimos 6 meses
        </div>

        <?php if ($_SESSION["role"] == "P"): ?>
        <!-- Gráfico para paciente: Total de citas por mes -->
        <div class="card mb-5">
            <div class="container row my-3 p-3">
                <h4>Total de Citas por Mes</h4>
                <canvas id="graficaPaciente" height="200"></canvas>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($_SESSION["role"] == "M"): ?>
        <!-- Gráfico para médico: Citas atendidas por mes -->
        <div class="card mb-5">
            <div class="container row my-3 p-3">
                <h4>Citas Atendidas por Mes</h4>
                <canvas id="graficaMedico" height="200"></canvas>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($_SESSION["role"] == "P"): ?>
        <!-- Gráfico de inasistencias por mes -->
        <div class="card mb-5">
            <div class="container row my-3 p-3">
                <h4>Inasistencias por Mes</h4>
                <canvas id="graficaInasistencias" height="200"></canvas>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const rol = "<?php echo $_SESSION['role']; ?>";
        
        // Obtener datos de las gráficas
        fetch("/SALUDHOY/app/dao/infocharts.php")
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                console.log("Datos recibidos:", data); // Depuración
                
                // Formatear nombres de meses
                const formatearMes = (mes) => {
                const [anio, mesNum] = mes.split('-');
                const meses = [
                  'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                  ];
                return `${meses[parseInt(mesNum)-1]} ${anio}`;
                };
                
                // Gráfico para paciente: Total de citas por mes
                if (rol === "P" && document.getElementById("graficaPaciente")) {
                    const ctx = document.getElementById("graficaPaciente");
                    const meses = data.paciente.map(item => formatearMes(item.mes));
                    const totales = data.paciente.map(item => item.total);
                    
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: meses,
                            datasets: [{
                                label: 'Total de Citas',
                                data: totales,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Número de citas'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mes'
                                    }
                                }
                            }
                        }
                    });
                }

                // Gráfico para médico: Citas atendidas por mes
                if (rol === "M" && document.getElementById("graficaMedico")) {
                    const ctx = document.getElementById("graficaMedico");
                    const meses = data.medico.map(item => formatearMes(item.mes));
                    const totales = data.medico.map(item => item.total);
                    
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: meses,
                            datasets: [{
                                label: 'Citas Atendidas',
                                data: totales,
                                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Número de citas'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mes'
                                    }
                                }
                            }
                        }
                    });
                }

                // Gráfico de inasistencias para paciente por mes
                if (rol === "P" && document.getElementById("graficaInasistencias")) {
                    const ctx = document.getElementById("graficaInasistencias");
                    const meses = data.inasistencias.map(item => formatearMes(item.mes));
                    const totales = data.inasistencias.map(item => item.total);
                    
                    if (totales.some(total => total > 0)) {
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: meses,
                                datasets: [{
                                    label: 'Inasistencias',
                                    data: totales,
                                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Número de inasistencias'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Mes'
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        ctx.parentElement.innerHTML = `
                            <div class="alert alert-success text-center">
                                <h4>¡Excelente!</h4>
                                <p>No tienes inasistencias en los últimos meses</p>
                            </div>
                        `;
                    }
                }
            })
            .catch(error => {
                console.error("Error cargando datos de gráfica:", error);
                const container = document.querySelector('.container');
                if (container) {
                    container.innerHTML += `
                        <div class="alert alert-danger mt-4">
                            Error al cargar los datos de las gráficas: ${error.message}
                        </div>
                    `;
                }
            });
        </script>
    <script src="js/home.js"></script>
</body>
