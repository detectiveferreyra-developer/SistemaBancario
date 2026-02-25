<?php
// IMPORTANDO MODELO DE CLIMA EN TIEMPO REAL -> API CLIMA OPENWEATHERMAP
require('../modelo/mAPIClima_Openweathermap.php');
// IMPORTANDO MODELO DE CONTEO NUMERO DE NOTIFICACIONES RECIBIDAS
require('../modelo/mConteoNotificacionesRecibidasUsuarios.php');
// IMPORTANDO MODELO DE ESTADÍSTICAS
require('../modelo/mEstadisticasCrediAgil.php');

// DATOS DE LOCALIZACION -> IDIOMA ESPAÑOL -> ZONA HORARIA EL SALVADOR (UTC-6)
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/El_Salvador');
// OBTENER HORA LOCAL
$hora = new DateTime("now");

// VALIDACION DE PARAMETRO CrediAgilgestion -> SI NO EXISTE MOSTRAR PAGINA 404 ERROR
if (!isset($_GET['CrediAgilgestion'])) {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=error-404');
}
// SI LOS USUARIOS INICIAN POR PRIMERA VEZ, MOSTRAR PAGINA DONDE DEBERAN REALIZAR EL CAMBIO OBLIGATORIO DE SU CONTRASEÑA GENERADA AUTOMATICAMENTE
if ($_SESSION['comprobar_iniciosesion_primeravez'] == "si") {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=gestiones-nuevos-usuarios-registrados');
} else {

    // OBTENER DATOS ESTADÍSTICOS
    $estadisticas = obtenerEstadisticasGenerales($conectarsistemaEstadisticas);
    ?>
    <!DOCTYPE html>
    <html lang="ES-SV">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>CrediAgil | Estadísticas</title>
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $UrlGlobal; ?>vista/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $UrlGlobal; ?>vista/images/favicon-16x16.png">
        <link href="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/css/bootstrap-select.min.css"
            rel="stylesheet">
        <link href="<?php echo $UrlGlobal; ?>vista/css/style.css" rel="stylesheet">
        <link href="<?php echo $UrlGlobal; ?>vista/css/crediagil-theme.css" rel="stylesheet">
        <link href="<?php echo $UrlGlobal; ?>vista/css/estadisticas.css" rel="stylesheet">
        <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
        <!-- ApexCharts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            .stats-page-header,
            .stats-kpi-value,
            .stats-kpi-label,
            .stats-section-header h5 {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>

    <body>
        <!--*******************
        Preloader start
        ********************-->
        <div id="preloader">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>
        <!--*******************
        Preloader end
        ********************-->

        <div id="main-wrapper">
            <!--**********************************
            Nav header start
            ***********************************-->
            <div class="nav-header">
                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=inicioadministradores"
                    class="brand-logo">
                    <img class="logo-abbr" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                    <img class="logo-compact" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                    <img class="brand-title" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                </a>
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="line"></span><span class="line"></span><span class="line"></span>
                    </div>
                </div>
            </div>
            <!--**********************************
            Nav header end
            ***********************************-->

            <!--**********************************
            Header start
            ***********************************-->
            <div class="header">
                <div class="header-content">
                    <nav class="navbar navbar-expand">
                        <div class="collapse navbar-collapse justify-content-between">
                            <div class="header-left">
                                <div class="dashboard_bar">
                                    <h4 style="font-weight: 600;">Estadísticas</h4>
                                </div>
                            </div>
                            <ul class="navbar-nav header-right">
                                <li class="nav-item dropdown notification_dropdown">
                                    <a class="nav-link ai-icon" href="#" role="button" data-toggle="dropdown">
                                        <svg fill="#6418C3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            width="24" height="24">
                                            <path fill="none" d="M0 0h24v24H0z" />
                                            <path
                                                d="M22 20H2v-2h1v-6.969C3 6.043 7.03 2 12 2s9 4.043 9 9.031V18h1v2zM5 18h14v-6.969C19 7.148 15.866 4 12 4s-7 3.148-7 7.031V18zm4.5 3h5a2.5 2.5 0 1 1-5 0z" />
                                        </svg>
                                        <span class="badge light text-white bg-primary">
                                            <?php echo NumeroNotificacionesRecibidasUsuarios($conectarsistema2, $_SESSION['id_usuario']); ?>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown header-profile">
                                    <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                        <div class="header-info">
                                            <span class="text-black">Hola, <strong>
                                                    <?php $Nombre = $_SESSION['nombre_usuario'];
                                                    $PrimerNombre = explode(' ', $Nombre, 2);
                                                    print_r($PrimerNombre[0]); ?>
                                                </strong></span>
                                            <p class="fs-12 mb-0">
                                                <?php if ($_SESSION['id_rol'] == 1) {
                                                    echo "Administradores";
                                                } else if ($_SESSION['id_rol'] == 2) {
                                                    echo "Presidencia";
                                                } else if ($_SESSION['id_rol'] == 3) {
                                                    echo "Gerencia";
                                                } else if ($_SESSION['id_rol'] == 4) {
                                                    echo "Atenci&oacute;n al Cliente";
                                                } else if ($_SESSION['id_rol'] == 5) {
                                                    echo "Clientes";
                                                } ?>
                                            </p>
                                        </div>
                                        <img src="<?php echo $UrlGlobal; ?>vista/images/fotoperfil/<?php echo $_SESSION['foto_perfil']; ?>"
                                            width="20" alt="" />
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="<?php echo $UrlGlobal ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=perfiladministradores"
                                            class="dropdown-item ai-icon">
                                            <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                                width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                            <span class="ml-2">Mi Perfil </span>
                                        </a>
                                        <a href="<?php echo $UrlGlobal ?>controlador/cIniciosSesionesUsuarios.php?CrediAgil=cerrarsesion"
                                            class="dropdown-item ai-icon">
                                            <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                                width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                <polyline points="16 17 21 12 16 7"></polyline>
                                                <line x1="21" y1="12" x2="9" y2="12"></line>
                                            </svg>
                                            <span class="ml-2">Cerrar Sesi&oacute;n </span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!--**********************************
            Header end
            ***********************************-->

            <!--**********************************
            Sidebar start
            ***********************************-->
            <?php
            // IMPORTAR MENU DE NAVEGACION SEGUN ROL
            if ($_SESSION['id_rol'] == 1) {
                require('../vista/MenuNavegacion/menu-administradores.php');
            }
            ?>
            <!--**********************************
            Sidebar end
            ***********************************-->

            <!--**********************************
            Content body start
            ***********************************-->
            <div class="content-body">
                <div class="container-fluid">
                    <!-- Page Header -->
                    <div class="stats-page-header">
                        <h3>📊 Panel de Estad&iacute;sticas</h3>
                        <p>Rendimiento de cartera de pr&eacute;stamos, niveles de riesgo y proyecciones de cobro en tiempo
                            real</p>
                    </div>

                    <!-- ============= FILTER BAR ============= -->
                    <div class="stats-filter-bar" id="statsFilterBar">
                        <label><i class="lni lni-calendar"></i> Rango:</label>
                        <input type="date" class="form-control" id="filtroFechaInicio" style="max-width:160px;">
                        <input type="date" class="form-control" id="filtroFechaFin" style="max-width:160px;">
                        <label><i class="lni lni-layout"></i> Estado:</label>
                        <select class="form-control" id="filtroEstado" style="max-width:160px;">
                            <option value="">Todos</option>
                            <option value="aprobado">Vigente</option>
                            <option value="en proceso">En Proceso</option>
                            <option value="cancelado">Cancelado</option>
                            <option value="denegado">Denegado</option>
                        </select>
                        <button class="btn btn-filter" onclick="aplicarFiltros()"><i class="lni lni-search"></i>
                            Filtrar</button>
                    </div>

                    <!-- ============= KPI CARDS ============= -->
                    <div class="row">
                        <!-- Capital en Riesgo -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                            <div class="card stats-kpi-card kpi-danger stats-animate stats-animate-delay-1">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="stats-kpi-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                            </svg>
                                        </div>
                                        <div class="text-right">
                                            <span class="stats-kpi-label">Capital en Riesgo</span>
                                            <div class="stats-kpi-value" id="kpiCapitalRiesgo">$
                                                <?php echo number_format($estadisticas['capital_riesgo'], 2); ?>
                                            </div>
                                            <span class="stats-kpi-sublabel">
                                                <?php echo $estadisticas['cuotas_vencidas']; ?> cuotas vencidas
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Colocación Total -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                            <div class="card stats-kpi-card kpi-success stats-animate stats-animate-delay-2">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="stats-kpi-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="text-right">
                                            <span class="stats-kpi-label">Colocaci&oacute;n Total</span>
                                            <div class="stats-kpi-value" id="kpiColocacionTotal">$
                                                <?php echo number_format($estadisticas['colocacion_total'], 2); ?>
                                            </div>
                                            <span class="stats-kpi-sublabel">Mes actual: $
                                                <?php echo number_format($estadisticas['colocacion_mes'], 2); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Efectividad de Cobro -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                            <div class="card stats-kpi-card kpi-primary stats-animate stats-animate-delay-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="stats-kpi-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="text-right">
                                            <span class="stats-kpi-label">Efectividad de Cobro</span>
                                            <div class="stats-kpi-value" id="kpiEfectividad">
                                                <?php echo $estadisticas['efectividad_cobro']; ?>%
                                            </div>
                                            <span class="stats-kpi-sublabel">
                                                <?php echo $estadisticas['cuotas_a_tiempo']; ?> a tiempo /
                                                <?php echo $estadisticas['cuotas_pagadas']; ?> pagadas
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Promedio -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                            <div class="card stats-kpi-card kpi-warning stats-animate stats-animate-delay-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="stats-kpi-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                        </div>
                                        <div class="text-right">
                                            <span class="stats-kpi-label">Ticket Promedio</span>
                                            <div class="stats-kpi-value" id="kpiTicketPromedio">$
                                                <?php echo number_format($estadisticas['ticket_promedio_global'], 2); ?>
                                            </div>
                                            <span class="stats-kpi-sublabel">
                                                <?php echo $estadisticas['creditos_activos']; ?> cr&eacute;ditos activos
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============= SECTION: GRÁFICOS DINÁMICOS ============= -->
                    <div class="stats-section-header">
                        <div class="stats-section-icon" style="background: rgba(100, 24, 195, 0.1); color: #6418C3;">
                            <i class="lni lni-bar-chart"></i>
                        </div>
                        <div>
                            <h5>Gr&aacute;ficos Din&aacute;micos</h5>
                            <p>Visualizaci&oacute;n de datos de cartera y rendimiento</p>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Funnel Chart -->
                        <div class="col-xl-4 col-lg-12">
                            <div class="card stats-chart-card">
                                <div class="card-header">
                                    <h4>🔽 Embudo de Clientes</h4>
                                    <div class="stats-subtitle">Solicitud → Contrato → Finalizado</div>
                                </div>
                                <div class="card-body">
                                    <div class="funnel-container">
                                        <?php
                                        $maxFunnel = max($estadisticas['funnel_solicitudes'], 1);
                                        ?>
                                        <div class="funnel-step step-1">
                                            <div class="funnel-bar" style="width: 100%; background: #6418C3;"></div>
                                            <div class="funnel-number">1</div>
                                            <div class="funnel-label">Solicitudes Recibidas</div>
                                            <div class="funnel-value">
                                                <?php echo number_format($estadisticas['funnel_solicitudes']); ?>
                                            </div>
                                        </div>
                                        <div class="funnel-step step-2">
                                            <div class="funnel-bar"
                                                style="width: <?php echo round(($estadisticas['funnel_contratos'] / $maxFunnel) * 100); ?>%; background: #27ae60;">
                                            </div>
                                            <div class="funnel-number">2</div>
                                            <div class="funnel-label">Contratos Generados</div>
                                            <div class="funnel-value">
                                                <?php echo number_format($estadisticas['funnel_contratos']); ?>
                                            </div>
                                        </div>
                                        <div class="funnel-step step-3">
                                            <div class="funnel-bar"
                                                style="width: <?php echo round(($estadisticas['funnel_finalizados'] / $maxFunnel) * 100); ?>%; background: #3498db;">
                                            </div>
                                            <div class="funnel-number">3</div>
                                            <div class="funnel-label">Pr&eacute;stamos Finalizados</div>
                                            <div class="funnel-value">
                                                <?php echo number_format($estadisticas['funnel_finalizados']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Distribution by Estado -->
                                    <hr style="opacity: 0.1;">
                                    <small class="text-muted font-weight-bold">DISTRIBUCIÓN POR ESTADO</small>
                                    <div id="chartEstadoDistribucion" style="min-height: 200px;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Chart: Monto por Tipo -->
                        <div class="col-xl-8 col-lg-12">
                            <div class="card stats-chart-card">
                                <div class="card-header">
                                    <h4>📊 Colocaci&oacute;n por Tipo de Contrato</h4>
                                    <div class="stats-subtitle">Monto total colocado por categor&iacute;a de producto</div>
                                </div>
                                <div class="card-body">
                                    <div id="chartMontoPorProducto" style="min-height: 320px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Recuperaciones -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card stats-chart-card">
                                <div class="card-header">
                                    <h4>📈 L&iacute;nea de Tiempo de Recuperaciones</h4>
                                    <div class="stats-subtitle">Dinero recuperado por mes durante los &uacute;ltimos 12
                                        meses</div>
                                </div>
                                <div class="card-body">
                                    <div id="chartRecuperacionesTimeline" style="min-height: 320px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============= SECTION: INTELIGENCIA ESTRATÉGICA ============= -->
                    <div class="stats-section-header">
                        <div class="stats-section-icon" style="background: rgba(39, 174, 96, 0.1); color: #27ae60;">
                            <i class="lni lni-target"></i>
                        </div>
                        <div>
                            <h5>Inteligencia Estrat&eacute;gica</h5>
                            <p>M&eacute;tricas exclusivas para Credi &Aacute;gil</p>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Garantías -->
                        <div class="col-xl-4 col-lg-6">
                            <div class="card stats-chart-card">
                                <div class="card-header">
                                    <h4>🏆 M&eacute;trica de Garant&iacute;as</h4>
                                    <div class="stats-subtitle">Distribuci&oacute;n de bienes en garant&iacute;a</div>
                                </div>
                                <div class="card-body">
                                    <div id="chartGarantias" style="min-height: 220px;"></div>
                                    <div class="mt-3">
                                        <?php
                                        $colors = ['#6418C3', '#27ae60', '#f39c12', '#e74c3c', '#3498db', '#9b59b6', '#1abc9c'];
                                        $idx = 0;
                                        foreach ($estadisticas['garantias'] as $g) {
                                            $color = $colors[$idx % count($colors)];
                                            ?>
                                            <div class="guarantee-item">
                                                <div class="guarantee-dot" style="background: <?php echo $color; ?>"></div>
                                                <span class="guarantee-name">
                                                    <?php echo htmlspecialchars($g['producto']); ?>
                                                </span>
                                                <span class="guarantee-pct" style="color: <?php echo $color; ?>">
                                                    <?php echo $g['porcentaje']; ?>%
                                                </span>
                                            </div>
                                            <?php
                                            $idx++;
                                        }
                                        if (empty($estadisticas['garantias'])) {
                                            echo '<p class="text-muted text-center mb-0">Sin datos de garant&iacute;as disponibles</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fiadores -->
                        <div class="col-xl-4 col-lg-6">
                            <div class="card stats-chart-card">
                                <div class="card-header">
                                    <h4>👥 M&eacute;trica de Fiadores</h4>
                                    <div class="stats-subtitle">Contratos con fiadores y tasa de cumplimiento</div>
                                </div>
                                <div class="card-body text-center">
                                    <div id="chartFiadores" style="min-height: 200px;"></div>
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <div class="stats-metric-card" style="background: #f8f9fa;">
                                                <small class="text-muted font-weight-bold">CON FIADORES</small>
                                                <div class="stats-metric-value" style="color: #27ae60;">
                                                    <?php echo $estadisticas['fiadores_porcentaje']; ?>%
                                                </div>
                                                <small class="text-muted">
                                                    <?php echo $estadisticas['fiadores_total']; ?> contratos
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stats-metric-card" style="background: #f8f9fa;">
                                                <small class="text-muted font-weight-bold">CUMPLIMIENTO</small>
                                                <div class="stats-metric-value" style="color: #6418C3;">
                                                    <?php echo $estadisticas['fiadores_cumplimiento']; ?>%
                                                </div>
                                                <small class="text-muted">Cuotas a tiempo</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Proyección de Flujo -->
                        <div class="col-xl-4 col-lg-12">
                            <div class="card stats-chart-card">
                                <div class="card-header">
                                    <h4>🔮 Proyecci&oacute;n de Flujo</h4>
                                    <div class="stats-subtitle">Ingresos esperados pr&oacute;ximos 30 d&iacute;as</div>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <small class="text-muted font-weight-bold">TOTAL PROYECTADO</small>
                                        <div class="stats-metric-value" style="color: #27ae60; font-size: 2rem;">$
                                            <?php echo number_format($estadisticas['proyeccion_total'], 2); ?>
                                        </div>
                                    </div>
                                    <div id="chartProyeccion" style="min-height: 220px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Promedio por Producto -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card stats-chart-card">
                                <div class="card-header">
                                    <h4>🎯 Ticket Promedio por Tipo de Bien</h4>
                                    <div class="stats-subtitle">Monto promedio de pr&eacute;stamo seg&uacute;n el tipo de
                                        producto</div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php
                                        $iconsProducto = ['💎', '🚗', '📱', '💰', '🏠', '📋'];
                                        $colorsProducto = ['#6418C3', '#27ae60', '#f39c12', '#e74c3c', '#3498db', '#9b59b6'];
                                        $idx = 0;
                                        foreach ($estadisticas['tickets_por_producto'] as $tp) {
                                            $icon = $iconsProducto[$idx % count($iconsProducto)];
                                            $color = $colorsProducto[$idx % count($colorsProducto)];
                                            ?>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3">
                                                <div class="stats-metric-card"
                                                    style="border-left: 4px solid <?php echo $color; ?>;">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span style="font-size: 1.5rem;">
                                                            <?php echo $icon; ?>
                                                        </span>
                                                        <strong style="font-size: 0.85rem; color: #1a1a2e;">
                                                            <?php echo htmlspecialchars($tp['producto']); ?>
                                                        </strong>
                                                    </div>
                                                    <div class="stats-metric-value" style="color: <?php echo $color; ?>;">$
                                                        <?php echo number_format($tp['promedio'], 2); ?>
                                                    </div>
                                                    <small class="text-muted">
                                                        <?php echo $tp['total']; ?> cr&eacute;ditos
                                                    </small>
                                                </div>
                                            </div>
                                            <?php
                                            $idx++;
                                        }
                                        if (empty($estadisticas['tickets_por_producto'])) {
                                            echo '<div class="col-12"><p class="text-muted text-center">Sin datos de productos disponibles</p></div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--**********************************
            Content body end
            ***********************************-->

            <!--**********************************
            Footer start
            ***********************************-->
            <div class="footer">
                <div class="copyright">
                    <p>CrediÁgil &copy;
                        <?php echo date('Y'); ?> | M&oacute;dulo de Estad&iacute;sticas
                    </p>
                </div>
            </div>
            <!--**********************************
            Footer end
            ***********************************-->
        </div>
        <!--**********************************
        Main wrapper end
        ***********************************-->

        <!-- Required vendors -->
        <script src="<?php echo $UrlGlobal; ?>vista/vendor/global/global.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/js/custom.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/js/deznav-init.js"></script>

        <!-- ApexCharts Initialization -->
        <script>
            // ============================================
            // DATA FROM PHP -> JS
            // ============================================
            var statsData = <?php echo json_encode($estadisticas); ?>;

            document.addEventListener('DOMContentLoaded', function () {
                initCharts();
            });

            function initCharts() {
                // ---- Estado Distribution (Donut) ----
                if (statsData.distribucion_estados && statsData.distribucion_estados.length > 0) {
                    var estadoLabels = statsData.distribucion_estados.map(function (e) { return e.estado; });
                    var estadoValues = statsData.distribucion_estados.map(function (e) { return e.total; });
                    new ApexCharts(document.querySelector("#chartEstadoDistribucion"), {
                        chart: { type: 'donut', height: 200 },
                        series: estadoValues,
                        labels: estadoLabels,
                        colors: ['#27ae60', '#6418C3', '#f39c12', '#e74c3c', '#3498db', '#868e96'],
                        legend: { position: 'bottom', fontSize: '11px' },
                        plotOptions: { pie: { donut: { size: '60%' } } },
                        dataLabels: { enabled: false },
                        stroke: { width: 2, colors: ['#fff'] }
                    }).render();
                }

                // ---- Monto por Producto (Bar Chart) ----
                if (statsData.monto_por_producto && statsData.monto_por_producto.length > 0) {
                    var prodLabels = statsData.monto_por_producto.map(function (e) { return e.producto; });
                    var prodValues = statsData.monto_por_producto.map(function (e) { return e.monto; });
                    new ApexCharts(document.querySelector("#chartMontoPorProducto"), {
                        chart: { type: 'bar', height: 320, toolbar: { show: false } },
                        series: [{ name: 'Monto Colocado', data: prodValues }],
                        xaxis: { categories: prodLabels, labels: { style: { fontSize: '12px', fontWeight: 600 } } },
                        yaxis: { labels: { formatter: function (v) { return '$' + v.toLocaleString(); } } },
                        colors: ['#6418C3'],
                        plotOptions: {
                            bar: {
                                borderRadius: 8,
                                columnWidth: '55%',
                                distributed: true
                            }
                        },
                        fill: { type: 'gradient', gradient: { shade: 'light', type: 'vertical', opacityFrom: 0.95, opacityTo: 0.85 } },
                        dataLabels: {
                            enabled: true,
                            formatter: function (v) { return '$' + Number(v).toLocaleString(); },
                            style: { fontSize: '11px', fontWeight: 700 }
                        },
                        tooltip: { y: { formatter: function (v) { return '$' + Number(v).toLocaleString('en-US', { minimumFractionDigits: 2 }); } } },
                        grid: { borderColor: '#f1f1f1', strokeDashArray: 4 },
                        legend: { show: false }
                    }).render();
                }

                // ---- Recuperaciones Timeline (Area Chart) ----
                if (statsData.recuperaciones_timeline && statsData.recuperaciones_timeline.length > 0) {
                    var recLabels = statsData.recuperaciones_timeline.map(function (e) { return e.periodo; });
                    var recValues = statsData.recuperaciones_timeline.map(function (e) { return e.monto; });
                    var recTx = statsData.recuperaciones_timeline.map(function (e) { return e.transacciones; });
                    new ApexCharts(document.querySelector("#chartRecuperacionesTimeline"), {
                        chart: { type: 'area', height: 320, toolbar: { show: true, tools: { download: true, selection: false, zoom: false, zoomin: false, zoomout: false, pan: false, reset: false } } },
                        series: [
                            { name: 'Monto Recuperado', data: recValues },
                            { name: 'Transacciones', data: recTx }
                        ],
                        xaxis: { categories: recLabels, labels: { style: { fontSize: '11px' } } },
                        yaxis: [
                            { title: { text: 'Monto ($)' }, labels: { formatter: function (v) { return '$' + Number(v).toLocaleString(); } } },
                            { opposite: true, title: { text: 'Transacciones' }, labels: { formatter: function (v) { return Math.round(v); } } }
                        ],
                        colors: ['#27ae60', '#6418C3'],
                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                        stroke: { curve: 'smooth', width: [3, 2] },
                        dataLabels: { enabled: false },
                        tooltip: { shared: true, y: { formatter: function (v, opts) { return opts.seriesIndex === 0 ? '$' + Number(v).toLocaleString('en-US', { minimumFractionDigits: 2 }) : v + ' pagos'; } } },
                        grid: { borderColor: '#f1f1f1', strokeDashArray: 4 },
                        markers: { size: 4, hover: { size: 6 } }
                    }).render();
                } else {
                    document.querySelector("#chartRecuperacionesTimeline").innerHTML = '<div class="text-center text-muted py-5"><p>Sin datos de recuperaciones disponibles</p></div>';
                }

                // ---- Garantías (Donut) ----
                if (statsData.garantias && statsData.garantias.length > 0) {
                    var garLabels = statsData.garantias.map(function (e) { return e.producto; });
                    var garValues = statsData.garantias.map(function (e) { return e.total; });
                    new ApexCharts(document.querySelector("#chartGarantias"), {
                        chart: { type: 'donut', height: 220 },
                        series: garValues,
                        labels: garLabels,
                        colors: ['#6418C3', '#27ae60', '#f39c12', '#e74c3c', '#3498db', '#9b59b6', '#1abc9c'],
                        legend: { show: false },
                        plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '14px', fontWeight: 700, formatter: function (w) { return w.globals.seriesTotals.reduce(function (a, b) { return a + b; }, 0); } } } } } },
                        dataLabels: { enabled: false },
                        stroke: { width: 2, colors: ['#fff'] }
                    }).render();
                }

                // ---- Fiadores (Radial Bar) ----
                new ApexCharts(document.querySelector("#chartFiadores"), {
                    chart: { type: 'radialBar', height: 200 },
                    series: [statsData.fiadores_porcentaje || 0, statsData.fiadores_cumplimiento || 0],
                    labels: ['Con Fiadores', 'Cumplimiento'],
                    colors: ['#27ae60', '#6418C3'],
                    plotOptions: {
                        radialBar: {
                            hollow: { size: '40%' },
                            dataLabels: {
                                name: { fontSize: '12px', offsetY: -5 },
                                value: { fontSize: '16px', fontWeight: 700, formatter: function (v) { return v + '%'; } }
                            },
                            track: { background: '#f1f1f1' }
                        }
                    }
                }).render();

                // ---- Proyección de Flujo (Bar Chart) ----
                if (statsData.proyeccion_30dias && statsData.proyeccion_30dias.length > 0) {
                    var proyLabels = statsData.proyeccion_30dias.map(function (e) {
                        var d = new Date(e.fecha + 'T00:00:00');
                        return (d.getDate()) + '/' + (d.getMonth() + 1);
                    });
                    var proyValues = statsData.proyeccion_30dias.map(function (e) { return e.monto; });
                    new ApexCharts(document.querySelector("#chartProyeccion"), {
                        chart: { type: 'bar', height: 220, toolbar: { show: false }, sparkline: { enabled: false } },
                        series: [{ name: 'Ingreso Esperado', data: proyValues }],
                        xaxis: { categories: proyLabels, labels: { style: { fontSize: '10px' }, rotate: -45 } },
                        yaxis: { labels: { formatter: function (v) { return '$' + Number(v).toLocaleString(); }, style: { fontSize: '10px' } } },
                        colors: ['#27ae60'],
                        plotOptions: { bar: { borderRadius: 4, columnWidth: '65%' } },
                        fill: { type: 'gradient', gradient: { shade: 'light', type: 'vertical', opacityFrom: 0.9, opacityTo: 0.7 } },
                        dataLabels: { enabled: false },
                        tooltip: { y: { formatter: function (v) { return '$' + Number(v).toLocaleString('en-US', { minimumFractionDigits: 2 }); } } },
                        grid: { borderColor: '#f1f1f1', strokeDashArray: 4 }
                    }).render();
                } else {
                    document.querySelector("#chartProyeccion").innerHTML = '<div class="text-center text-muted py-4"><p>Sin cuotas pendientes en los pr&oacute;ximos 30 d&iacute;as</p></div>';
                }
            }

            // ---- Filter Logic (client-side refresh) ----
            function aplicarFiltros() {
                var fechaInicio = document.getElementById('filtroFechaInicio').value;
                var fechaFin = document.getElementById('filtroFechaFin').value;
                var estado = document.getElementById('filtroEstado').value;
                var params = new URLSearchParams(window.location.search);
                params.set('CrediAgilgestion', 'estadisticas-generales');
                if (fechaInicio) params.set('fecha_inicio', fechaInicio);
                if (fechaFin) params.set('fecha_fin', fechaFin);
                if (estado) params.set('estado', estado);
                window.location.href = window.location.pathname + '?' + params.toString();
            }
        </script>

    </body>

    </html>
<?php } ?>