<?php
if (!isset($_SESSION["id"])) {
    header("Location: ?pid=" . base64_encode("views/login.php"));
    exit();
}

if ($_SESSION["role"] == "P") {
    $persona = new Paciente($_SESSION["id"]);
    $persona->consultarPorId();
} else if ($_SESSION["role"] == "M") {
    $persona = new Medico($_SESSION["id"]);
    $persona->consultarPorId();
} else if ($_SESSION["role"] == "A") {
    // Administrador, no se carga una persona específica
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
        
        <?php if ($_SESSION["role"] == "A"): ?>
        <!-- Filtro para administrador -->
        <div class="card mb-4 p-3">
            <form id="filtroAdminForm">
                <div class="row">
                    <div class="col-md-6">
                        <label for="filtroTipo" class="form-label"><strong>Tipo de usuario:</strong></label>
                        <select id="filtroTipo" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="P">Paciente</option>
                            <option value="M">Médico</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6" id="usuarioContainer" style="display:none;">
                        <label for="filtroUsuario" class="form-label"><strong>Usuario:</strong></label>
                        <select id="filtroUsuario" class="form-select">
                            <!-- Opciones se cargarán dinámicamente -->
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mt-3">Mostrar Gráficas</button>
            </form>
        </div>
        
        <div id="graficasAdmin"></div>
        <?php endif; ?>
        
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const rol = "<?php echo $_SESSION['role']; ?>";
        
        // Obtener datos de las gráficas para pacientes y médicos (no administrador)
        if (rol !== "A") {
            fetch("dao/infocharts.php")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Datos recibidos:", data);
                    
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
        }

        <?php if ($_SESSION["role"] == "A"): ?>
        // Script para administrador
        $(document).ready(function() {
            // Inicialmente remover el atributo required
            $('#filtroUsuario').prop('required', false);
            
            // Cargar usuarios cuando se selecciona el tipo
            $('#filtroTipo').change(function() {
                const tipo = $(this).val();
                if (tipo) {
                    $.ajax({
                        url: 'dao/persona.php',
                        type: 'GET',
                        data: { tipo: tipo },
                        dataType: 'json',
                        success: function(data) {
                            const $select = $('#filtroUsuario');
                            $select.empty().append('<option value="" selected disabled>Seleccionar...</option>');
                            
                            data.forEach(usuario => {
                                $select.append(`<option value="${usuario.id}">${usuario.nombre}</option>`);
                            });
                            
                            $('#usuarioContainer').show();
                            $select.prop('required', true);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error cargando usuarios:", xhr.responseText);
                            alert('Error cargando usuarios: ' + xhr.statusText);
                        }
                    });
                } else {
                    $('#usuarioContainer').hide();
                    $('#filtroUsuario').prop('required', false);
                }
            });

            // Enviar formulario de filtro
            $('#filtroAdminForm').submit(function(e) {
                e.preventDefault();
                
                const tipo = $('#filtroTipo').val();
                const usuarioId = $('#filtroUsuario').val();
                
                if (!tipo) {
                    alert('Seleccione un tipo de usuario');
                    return;
                }
                
                if (!usuarioId) {
                    alert('Seleccione un usuario específico');
                    return;
                }
                
                // Cargar gráficas
                $.ajax({
                    url: 'dao/infocharts.php',
                    type: 'GET',
                    data: { 
                        tipoFiltro: tipo,
                        idFiltro: usuarioId
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Verificar si la respuesta es un objeto JSON
                        if (typeof data === 'object' && data !== null) {
                            renderAdminCharts(data, tipo);
                        } else {
                            console.error("Respuesta inválida:", data);
                            $('#graficasAdmin').html(`
                                <div class="alert alert-danger mt-4">
                                    Error: Respuesta inválida del servidor
                                </div>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error cargando datos:", xhr.responseText);
                        $('#graficasAdmin').html(`
                            <div class="alert alert-danger mt-4">
                                Error al cargar las gráficas: ${xhr.status} ${xhr.statusText}
                            </div>
                        `);
                    }
                });
            });
            
            // Función para renderizar gráficas de administrador
            function renderAdminCharts(data, tipo) {
                const container = $('#graficasAdmin');
                container.empty();
                
                // Verificar si hay datos para el tipo seleccionado
                if (tipo === 'P' && (!data.paciente || data.paciente.length === 0)) {
                    container.html(`
                        <div class="alert alert-warning">
                            No se encontraron datos de citas para este paciente
                        </div>
                    `);
                    return;
                } else if (tipo === 'M' && (!data.medico || data.medico.length === 0)) {
                    container.html(`
                        <div class="alert alert-warning">
                            No se encontraron datos de citas atendidas para este médico
                        </div>
                    `);
                    return;
                }
                
                const formatearMes = (mes) => {
                    const [anio, mesNum] = mes.split('-');
                    const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    return `${meses[parseInt(mesNum)-1]} ${anio}`;
                };
                
                if (tipo === 'P') {
                    // Gráficas para paciente
                    container.append(`
                        <div class="card mb-5">
                            <div class="container row my-3 p-3">
                                <h4>Total de Citas por Mes</h4>
                                <canvas id="adminGraficaPaciente" height="200"></canvas>
                            </div>
                        </div>
                        <div class="card mb-5">
                            <div class="container row my-3 p-3">
                                <h4>Inasistencias por Mes</h4>
                                <canvas id="adminGraficaInasistencias" height="200"></canvas>
                            </div>
                        </div>
                    `);
                    
                    // Gráfica de citas
                    const ctxPaciente = document.getElementById('adminGraficaPaciente');
                    const mesesPac = data.paciente.map(item => formatearMes(item.mes));
                    const totalesPac = data.paciente.map(item => item.total);
                    
                    new Chart(ctxPaciente, {
                        type: 'bar',
                        data: {
                            labels: mesesPac,
                            datasets: [{
                                label: 'Total de Citas',
                                data: totalesPac,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: { display: true, text: 'Número de citas' }
                                },
                                x: {
                                    title: { display: true, text: 'Mes' }
                                }
                            }
                        }
                    });
                    
                    // Gráfica de inasistencias
                    const ctxInasistencias = document.getElementById('adminGraficaInasistencias');
                    const mesesInas = data.inasistencias.map(item => formatearMes(item.mes));
                    const totalesInas = data.inasistencias.map(item => item.total);
                    
                    if (totalesInas.some(total => total > 0)) {
                        new Chart(ctxInasistencias, {
                            type: 'bar',
                            data: {
                                labels: mesesInas,
                                datasets: [{
                                    label: 'Inasistencias',
                                    data: totalesInas,
                                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: { display: true, text: 'Número de inasistencias' }
                                    },
                                    x: {
                                        title: { display: true, text: 'Mes' }
                                    }
                                }
                            }
                        });
                    } else {
                        ctxInasistencias.parentElement.innerHTML = `
                            <div class="alert alert-success text-center">
                                <h4>¡Excelente!</h4>
                                <p>No hay inasistencias en los últimos meses</p>
                            </div>
                        `;
                    }
                    
                } else if (tipo === 'M') {
                    // Gráfica para médico
                    container.append(`
                        <div class="card mb-5">
                            <div class="container row my-3 p-3">
                                <h4>Citas Atendidas por Mes</h4>
                                <canvas id="adminGraficaMedico" height="200"></canvas>
                            </div>
                        </div>
                    `);
                    
                    const ctxMedico = document.getElementById('adminGraficaMedico');
                    const meses = data.medico.map(item => formatearMes(item.mes));
                    const totales = data.medico.map(item => item.total);
                    
                    new Chart(ctxMedico, {
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
                                    title: { display: true, text: 'Número de citas' }
                                },
                                x: {
                                    title: { display: true, text: 'Mes' }
                                }
                            }
                        }
                    });
                }
            }
        });
        <?php endif; ?>
    </script>
    <script src="js/home.js"></script>
</body>
