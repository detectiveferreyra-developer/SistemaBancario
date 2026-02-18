<?php
// IMPORTANDO MODELO DE CONTEO NUMERO DE NOTIFICACIONES RECIBIDAS
require('../modelo/mConteoNotificacionesRecibidasUsuarios.php');

// DATOS DE LOCALIZACION
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/El_Salvador');

if (!isset($_GET['CrediAgilgestion'])) {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=error-404');
}
?>
<!DOCTYPE html>
<html lang="ES-SV">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>CrediAgil | Estadísticas</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $UrlGlobal; ?>vista/images/favicon-16x16.png">
    <link href="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/css/bootstrap-select.min.css"
        rel="stylesheet">
    <link href="<?php echo $UrlGlobal; ?>vista/css/style.css" rel="stylesheet">
    <link href="<?php echo $UrlGlobal; ?>vista/css/crediagil-theme.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <style>
        .card-kpi {
            border-radius: 15px;
            padding: 20px;
            color: white;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card-kpi:hover {
            transform: translateY(-5px);
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #6418C3, #8D44F2);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #2BC155, #49D271);
        }

        .bg-gradient-danger {
            background: linear-gradient(45deg, #FF2E2E, #FF5C5C);
        }

        .bg-gradient-info {
            background: linear-gradient(45deg, #21B6FF, #5ED0FF);
        }

        .kpi-title {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .kpi-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="nav-header">
            <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=inicioadministradores"
                class="brand-logo">
                <img class="logo-abbr" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                <img class="logo-compact" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                <img class="brand-title" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
            </a>
            <div class="nav-control">
                <div class="hamburger"><span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                <h4 style="font-weight: 600;">Estadísticas del Sistema</h4>
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
                            <!-- User profiling and notifications (simplified for space) -->
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <div class="header-info"><span class="text-black">Administrador</span></div>
                                    <img src="<?php echo $UrlGlobal; ?>vista/images/fotoperfil/<?php echo $_SESSION['foto_perfil']; ?>"
                                        width="20" alt="" />
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <?php require('../vista/MenuNavegacion/menu-administradores.php'); ?>

        <div class="content-body">
            <div class="container-fluid">
                <!-- KPI Row -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="card-kpi bg-gradient-primary">
                            <div class="kpi-title">Capital Colocado</div>
                            <div class="kpi-value">$
                                <?php echo number_format($totalColocacion, 2); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="card-kpi bg-gradient-danger">
                            <div class="kpi-title">Capital en Riesgo</div>
                            <div class="kpi-value">$
                                <?php echo number_format($capitalRiesgo, 2); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="card-kpi bg-gradient-success">
                            <div class="kpi-title">Ticket Promedio</div>
                            <div class="kpi-value">$
                                <?php echo number_format($ticketPromedio, 2); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="card-kpi bg-gradient-info">
                            <div class="kpi-title">Efectividad Mora</div>
                            <div class="kpi-value">
                                <?php echo number_format($efectividad, 2); ?>%
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <h4 class="text-black">Distribución por Producto</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartProductos"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <h4 class="text-black">Cartera por Estado Crediticio</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartEstados"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy;
                    <?php echo date('Y'); ?> CrediAgil
                </p>
            </div>
        </div>
    </div>

    <script src="<?php echo $UrlGlobal; ?>vista/vendor/global/global.min.js"></script>
    <script src="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?php echo $UrlGlobal; ?>vista/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="<?php echo $UrlGlobal; ?>vista/js/custom.min.js"></script>
    <script src="<?php echo $UrlGlobal; ?>vista/js/deznav-init.js"></script>

    <script>
        // Data from PHP
        const distProductos = <?php echo json_encode($distribucionProductos); ?>;
        const distEstados = <?php echo json_encode($carteraEstado); ?>;

        // Chart 1: Productos (Pie)
        new Chart(document.getElementById('chartProductos'), {
            type: 'pie',
            data: {
                labels: distProductos.map(item => item.nombreproducto),
                datasets: [{
                    data: distProductos.map(item => item.cantidad),
                    backgroundColor: ['#6418C3', '#2BC155', '#FF2E2E', '#21B6FF', '#FFAA2E']
                }]
            },
            options: { responsive: true, legend: { position: 'bottom' } }
        });

        // Chart 2: Estados (Bar)
        new Chart(document.getElementById('chartEstados'), {
            type: 'bar',
            data: {
                labels: distEstados.map(item => item.estadocrediticio),
                datasets: [{
                    label: 'Créditos',
                    data: distEstados.map(item => item.cantidad),
                    backgroundColor: '#6418C3'
                }]
            },
            options: {
                responsive: true,
                scales: { yAxes: [{ ticks: { beginAtZero: true } }] },
                legend: { display: false }
            }
        });
    </script>
</body>

</html>