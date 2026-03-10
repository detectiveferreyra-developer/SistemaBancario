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
$hora = new DateTime("now");

if (!isset($_GET['CrediAgilgestion'])) {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=error-404');
}
if ($_SESSION['comprobar_iniciosesion_primeravez'] == "si") {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=gestiones-nuevos-usuarios-registrados');
} else {
    // --- FILTROS ---
    $fechaInicio = isset($_GET['fecha_inicio']) && $_GET['fecha_inicio'] ? $_GET['fecha_inicio'] : null;
    $fechaFin = isset($_GET['fecha_fin']) && $_GET['fecha_fin'] ? $_GET['fecha_fin'] : null;
    $dias = 90;
    if ($fechaInicio && $fechaFin) {
        $d1 = new DateTime($fechaInicio);
        $d2 = new DateTime($fechaFin);
        $dias = max(1, $d2->diff($d1)->days + 1);
    }

    // --- DATOS ---
    $kpis = obtenerKPIs($conectarsistemaEstadisticas);
    $candles = obtenerDatosCandlestick($conectarsistemaEstadisticas, $dias);
    $barras = obtenerBarrasCobroVsVencido($conectarsistemaEstadisticas);
    $estados = obtenerDistribucionEstados($conectarsistemaEstadisticas);
    $proyeccion = obtenerProyeccionFlujo($conectarsistemaEstadisticas);
    ?>
    <!DOCTYPE html>
    <html lang="ES-SV">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>CrediAgil | Estad&iacute;sticas</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <!-- CSS del tema base -->
        <link href="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="<?php echo $UrlGlobal; ?>vista/css/style.css" rel="stylesheet">
        <link href="<?php echo $UrlGlobal; ?>vista/css/crediagil-theme.css" rel="stylesheet">
        <link href="<?php echo $UrlGlobal; ?>vista/css/estadisticas.css" rel="stylesheet">
        <!-- LineIcons -->
        <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
        <!-- ApexCharts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </head>

    <body class="has-topnav">
        <!-- Preloader -->
        <div id="preloader">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>

        <div id="main-wrapper">
            <?php require('../vista/MenuNavegacion/navbar-administradores.php'); ?>

            <!--**********************************
            Nav header start
        ***********************************-->
            <div class="nav-header">
                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales" class="brand-logo">
                    <img class="logo-abbr"    src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                    <img class="logo-compact" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                    <img class="brand-title"  src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
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
            Sidebar start
        ***********************************-->
            <?php
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

                    <!-- Breadcrumb -->
                    

                    <!-- ===================== FILTER BAR ===================== -->
                    <div class="stats-filter-bar stats-animate stats-d1">
                        <label><i class="lni lni-calendar"></i> Desde:</label>
                        <input type="date" class="form-control" id="filtroFechaInicio"
                               value="<?php echo $fechaInicio ?? ''; ?>" style="max-width:155px;">
                        <label>Hasta:</label>
                        <input type="date" class="form-control" id="filtroFechaFin"
                               value="<?php echo $fechaFin ?? ''; ?>" style="max-width:155px;">
                        <label><i class="lni lni-timer"></i> Per&iacute;odo r&aacute;pido:</label>
                        <select class="form-control" id="filtroPeriodo" style="max-width:145px;" onchange="aplicarPeriodo(this.value)">
                            <option value="">Personalizado</option>
                            <option value="30">30 d&iacute;as</option>
                            <option value="60">60 d&iacute;as</option>
                            <option value="90" selected>90 d&iacute;as</option>
                            <option value="180">6 meses</option>
                        </select>
                        <button class="btn-stats-filter" onclick="aplicarFiltros()">
                            <i class="lni lni-search"></i> Aplicar filtro
                        </button>
                    </div>


                    <!-- ===================== GRÁFICO FOREX (protagonista) ===================== -->
                    <div class="forex-chart-card stats-animate stats-d2">
                        <div class="forex-chart-header">
                            <div class="forex-chart-header-title">
                                <h4>
                                    <i class="lni lni-bar-chart" style="color:#6418C3;"></i>
                                    Flujo de Cartera &mdash; Vista Candlestick
                                    <span class="live-badge">LIVE</span>
                                </h4>
                                <p>
                                    Cada vela = un d&iacute;a.
                                    <span style="color:#26a641;font-weight:600;">Verde</span>: se cobr&oacute; m&aacute;s de lo que venci&oacute; &nbsp;|&nbsp;
                                    <span style="color:#f85149;font-weight:600;">Rojo</span>: vencieron m&aacute;s cuotas de las cobradas
                                </p>
                            </div>
                            <div class="forex-legend">
                                <div class="forex-legend-item"><div class="forex-legend-dot green"></div> D&iacute;a positivo</div>
                                <div class="forex-legend-item"><div class="forex-legend-dot red"></div> D&iacute;a en riesgo</div>
                            </div>
                        </div>
                        <!-- Dark body — solo el chart tiene fondo oscuro -->
                        <div class="forex-chart-body">
                            <div id="chartForexMain" style="min-height:420px;"></div>
                        </div>
                    </div>

                    <!-- ===================== GRÁFICOS SECUNDARIOS ===================== -->
                    <div class="stats-chart-grid">
                        <!-- Cobrado vs Vencido -->
                        <div class="stats-chart-card stats-animate stats-d3">
                            <div class="stats-chart-card-header">
                                <div class="stats-chart-card-icon" style="background:rgba(30,132,73,0.1);color:#1e8449;">
                                    <i class="lni lni-bar-chart-alt"></i>
                                </div>
                                <div>
                                    <h5>Cobrado vs. Vencido por Mes</h5>
                                    <p>&Uacute;ltimos 6 meses: ingresos recuperados vs cuotas ca&iacute;das</p>
                                </div>
                            </div>
                            <div class="stats-chart-card-body">
                                <div id="chartBarrasCobroVencido" style="min-height:280px;"></div>
                            </div>
                        </div>

                        <!-- Estado de Créditos -->
                        <div class="stats-chart-card stats-animate stats-d4">
                            <div class="stats-chart-card-header">
                                <div class="stats-chart-card-icon" style="background:rgba(100,24,195,0.1);color:#6418C3;">
                                    <i class="lni lni-pie-chart"></i>
                                </div>
                                <div>
                                    <h5>Estado de Cr&eacute;ditos</h5>
                                    <p>Distribuci&oacute;n actual de la cartera por estado</p>
                                </div>
                            </div>
                            <div class="stats-chart-card-body">
                                <div id="chartEstados" style="min-height:280px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Proyección 30 días (full width) -->
                    <div class="stats-chart-full stats-animate stats-d5">
                        <div class="stats-chart-card">
                            <div class="stats-chart-card-header">
                                <div class="stats-chart-card-icon" style="background:rgba(231,76,60,0.1);color:#c0392b;">
                                    <i class="lni lni-calendar"></i>
                                </div>
                                <div>
                                    <h5>Proyecci&oacute;n de Flujo &mdash; Pr&oacute;ximos 30 D&iacute;as</h5>
                                    <p>
                                        Cuotas pendientes por fecha de vencimiento &nbsp;|&nbsp;
                                        Total proyectado: <strong style="color:#27ae60;">$<?php echo number_format($proyeccion['total'], 2); ?></strong>
                                    </p>
                                </div>
                            </div>
                            <div class="stats-chart-card-body">
                                <div id="chartProyeccion" style="min-height:240px;"></div>
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
                    <p>Copyright &copy; <?php echo date('Y'); ?> CrediAgil &amp; M&oacute;dulo de Estad&iacute;sticas</p>
                </div>
            </div>
            <!--**********************************
            Footer end
        ***********************************-->
        </div>
        <!--**********************************
        Main wrapper end
    ***********************************-->

        <!-- Vendors -->
        <script src="<?php echo $UrlGlobal; ?>vista/vendor/global/global.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/js/custom.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/js/deznav-init.js"></script>

        <script>
        // ---- DATA FROM PHP -> JS ----
        var candleData  = <?php echo json_encode($candles); ?>;
        var barrasData  = <?php echo json_encode($barras); ?>;
        var estadosData = <?php echo json_encode($estados); ?>;
        var proyData    = <?php echo json_encode($proyeccion['dias']); ?>;

        // Colors
        var GREEN  = '#26a641';
        var RED    = '#f85149';
        var PURPLE = '#6418C3';
        var BLUE   = '#3498db';
        var YELLOW = '#f39c12';

        document.addEventListener('DOMContentLoaded', function () {
            renderForexChart();
            renderBarrasChart();
            renderEstadosChart();
            renderProyeccionChart();
        });

        // ==================================================
        // 1. FOREX CANDLESTICK — Protagonista
        // ==================================================
        function renderForexChart() {
            var el = document.querySelector('#chartForexMain');
            if (!el) return;
            if (!candleData || candleData.length === 0) {
                el.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:420px;color:#8b949e;font-size:0.88rem;">Sin movimientos registrados en el per&iacute;odo seleccionado</div>';
                return;
            }
            var series = candleData.map(function(c) {
                return { x: new Date(c.x + 'T00:00:00'), y: c.y };
            });
            new ApexCharts(el, {
                chart: {
                    type: 'candlestick', height: 420,
                    background: '#0d1117',
                    foreColor: '#8b949e',
                    toolbar: { show: true, tools: { download: true, selection: true, zoom: true, zoomin: true, zoomout: true, pan: true, reset: true } },
                    animations: { enabled: true, easing: 'easeinout', speed: 700 }
                },
                theme: { mode: 'dark' },
                series: [{ name: 'Cartera', data: series }],
                xaxis: {
                    type: 'datetime',
                    labels: { style: { colors: '#8b949e', fontSize: '11px' }, datetimeFormatter: { month: "MMM 'yy", day: 'dd MMM' } },
                    axisBorder: { color: 'rgba(255,255,255,0.06)' },
                    axisTicks:  { color: 'rgba(255,255,255,0.06)' }
                },
                yaxis: {
                    tooltip: { enabled: true },
                    labels: {
                        style: { colors: '#8b949e', fontSize: '11px' },
                        formatter: function(v) { return '$' + Number(v).toLocaleString('en-US', {minimumFractionDigits:0}); }
                    }
                },
                plotOptions: {
                    candlestick: {
                        colors: { upward: GREEN, downward: RED },
                        wick: { useFillColor: true }
                    }
                },
                tooltip: {
                    theme: 'dark',
                    custom: function(opts) {
                        var di = opts.dataPointIndex;
                        var c  = candleData[di];
                        if (!c) return '';
                        var ohlc = c.y;
                        var isUp = ohlc[3] >= ohlc[0];
                        var color = isUp ? GREEN : RED;
                        var arrow = isUp ? '&#9650;' : '&#9660;';
                        var diff  = Math.abs(ohlc[3] - ohlc[0]).toFixed(2);
                        return '<div style="padding:12px 16px;background:#1c2333;border:1px solid ' + color + ';border-radius:10px;font-size:11px;min-width:190px;color:#e6edf3;">' +
                            '<div style="color:#8b949e;margin-bottom:6px;font-size:10px;">' + c.x + '</div>' +
                            '<div style="font-weight:700;color:' + color + ';margin-bottom:8px;">' + arrow + ' ' + (isUp ? 'D&iacute;a Positivo' : 'D&iacute;a en Riesgo') + '</div>' +
                            '<table style="width:100%;font-size:11px;">' +
                            '<tr><td style="color:#8b949e;padding:2px 8px 2px 0">Open</td><td style="text-align:right">$' + Number(ohlc[0]).toLocaleString() + '</td></tr>' +
                            '<tr><td style="color:#8b949e;padding:2px 8px 2px 0">High</td><td style="text-align:right">$' + Number(ohlc[1]).toLocaleString() + '</td></tr>' +
                            '<tr><td style="color:#8b949e;padding:2px 8px 2px 0">Low</td><td style="text-align:right">$' + Number(ohlc[2]).toLocaleString() + '</td></tr>' +
                            '<tr><td style="color:#8b949e;padding:2px 8px 2px 0">Close</td><td style="text-align:right;color:' + color + ';font-weight:700;">$' + Number(ohlc[3]).toLocaleString() + '</td></tr>' +
                            '<tr><td colspan="2"><hr style="border-color:rgba(255,255,255,0.08);margin:6px 0;"></td></tr>' +
                            '<tr><td style="color:' + GREEN + ';padding:2px 8px 2px 0">Cobrado</td><td style="text-align:right;color:' + GREEN + ';">$' + Number(c.cobrado||0).toLocaleString('en-US',{minimumFractionDigits:2}) + '</td></tr>' +
                            '<tr><td style="color:' + RED + ';padding:2px 8px 2px 0">Vencido</td><td style="text-align:right;color:' + RED + ';">$' + Number(c.vencido||0).toLocaleString('en-US',{minimumFractionDigits:2}) + '</td></tr>' +
                            '<tr><td style="color:#8b949e;padding:2px 8px 2px 0">Delta</td><td style="text-align:right;color:' + color + ';">' + arrow + ' $' + Number(diff).toLocaleString('en-US',{minimumFractionDigits:2}) + '</td></tr>' +
                            '</table></div>';
                    }
                },
                grid: { borderColor: 'rgba(255,255,255,0.05)', strokeDashArray: 3, xaxis: { lines: { show: false } } }
            }).render();
        }

        // ==================================================
        // 2. BARRAS: COBRADO VS VENCIDO
        // ==================================================
        function renderBarrasChart() {
            var el = document.querySelector('#chartBarrasCobroVencido');
            if (!el || !barrasData || barrasData.length === 0) {
                if (el) el.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:280px;color:#868e96;font-size:0.88rem;">Sin datos disponibles</div>';
                return;
            }
            var meses    = barrasData.map(function(b){ return b.mes; });
            var cobrados = barrasData.map(function(b){ return parseFloat(b.cobrado); });
            var vencidos = barrasData.map(function(b){ return parseFloat(b.vencido); });
            new ApexCharts(el, {
                chart: { type: 'bar', height: 280, background: 'transparent', toolbar: { show: false } },
                series: [
                    { name: 'Cobrado', data: cobrados },
                    { name: 'Vencido (riesgo)', data: vencidos }
                ],
                xaxis: {
                    categories: meses,
                    labels: { style: { colors: '#868e96', fontSize: '11px' } },
                    axisBorder: { color: '#dee2e6' }, axisTicks: { color: '#dee2e6' }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#868e96', fontSize: '11px' },
                        formatter: function(v){ return '$' + Number(v).toLocaleString(); }
                    }
                },
                colors: ['#27ae60', '#e74c3c'],
                plotOptions: { bar: { borderRadius: 5, columnWidth: '55%' } },
                dataLabels: { enabled: false },
                tooltip: { y: { formatter: function(v){ return '$' + Number(v).toLocaleString('en-US',{minimumFractionDigits:2}); } } },
                grid: { borderColor: '#f1f1f1', strokeDashArray: 3 },
                legend: { markers: { radius: 3 } }
            }).render();
        }

        // ==================================================
        // 3. DONUT: ESTADO DE CRÉDITOS
        // ==================================================
        function renderEstadosChart() {
            var el = document.querySelector('#chartEstados');
            if (!el || !estadosData || estadosData.length === 0) {
                if (el) el.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:280px;color:#868e96;font-size:0.88rem;">Sin datos disponibles</div>';
                return;
            }
            var labels = estadosData.map(function(e){ return e.estado; });
            var values = estadosData.map(function(e){ return e.total; });
            new ApexCharts(el, {
                chart: { type: 'donut', height: 280, background: 'transparent' },
                series: values, labels: labels,
                colors: ['#27ae60', '#6418C3', '#f39c12', '#e74c3c', '#3498db', '#868e96'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true, label: 'Total', color: '#868e96', fontSize: '12px', fontWeight: 600,
                                    formatter: function(w){ return w.globals.seriesTotals.reduce(function(a,b){return a+b;},0); }
                                },
                                value: { color: '#1a1a2e', fontSize: '20px', fontWeight: 800 },
                                name: { color: '#868e96' }
                            }
                        }
                    }
                },
                legend: { position: 'bottom', fontSize: '12px', markers: { radius: 3 } },
                dataLabels: { enabled: false },
                stroke: { width: 2, colors: ['#fff'] },
                tooltip: { y: { formatter: function(v){ return v + ' cr&eacute;ditos'; } } }
            }).render();
        }

        // ==================================================
        // 4. ÁREA: PROYECCIÓN 30 DÍAS
        // ==================================================
        function renderProyeccionChart() {
            var el = document.querySelector('#chartProyeccion');
            if (!el || !proyData || proyData.length === 0) {
                if (el) el.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:240px;color:#868e96;font-size:0.88rem;">Sin cuotas pendientes en los pr&oacute;ximos 30 d&iacute;as</div>';
                return;
            }
            var labels = proyData.map(function(p){
                var d = new Date(p.fecha + 'T00:00:00');
                return (d.getDate()) + '/' + (d.getMonth()+1);
            });
            var values = proyData.map(function(p){ return parseFloat(p.monto); });
            new ApexCharts(el, {
                chart: { type: 'area', height: 240, background: 'transparent', toolbar: { show: false } },
                series: [{ name: 'Ingreso Esperado', data: values }],
                xaxis: {
                    categories: labels,
                    labels: { style: { colors: '#868e96', fontSize: '10px' }, rotate: -30 },
                    axisBorder: { color: '#dee2e6' }, axisTicks: { color: '#dee2e6' }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#868e96', fontSize: '10px' },
                        formatter: function(v){ return '$' + Number(v).toLocaleString(); }
                    }
                },
                colors: ['#6418C3'],
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.02, stops: [0, 100] } },
                stroke: { curve: 'smooth', width: 3 },
                markers: { size: 4, colors: ['#6418C3'], strokeColors: '#fff', strokeWidth: 2, hover: { size: 6 } },
                dataLabels: { enabled: false },
                tooltip: {
                    y: { formatter: function(v){ return '$' + Number(v).toLocaleString('en-US',{minimumFractionDigits:2}); } }
                },
                grid: { borderColor: '#f1f1f1', strokeDashArray: 3 }
            }).render();
        }

        // ==================================================
        // FILTROS
        // ==================================================
        function aplicarPeriodo(dias) {
            if (!dias) return;
            var hoy = new Date();
            var ini = new Date();
            ini.setDate(hoy.getDate() - parseInt(dias));
            document.getElementById('filtroFechaInicio').value = ini.toISOString().split('T')[0];
            document.getElementById('filtroFechaFin').value    = hoy.toISOString().split('T')[0];
        }

        function aplicarFiltros() {
            var inicio = document.getElementById('filtroFechaInicio').value;
            var fin    = document.getElementById('filtroFechaFin').value;
            var params = new URLSearchParams();
            params.set('CrediAgilgestion', 'estadisticas-generales');
            if (inicio) params.set('fecha_inicio', inicio);
            if (fin)    params.set('fecha_fin', fin);
            window.location.href = window.location.pathname + '?' + params.toString();
        }
        </script>
    </body>
    </html>
<?php } ?>