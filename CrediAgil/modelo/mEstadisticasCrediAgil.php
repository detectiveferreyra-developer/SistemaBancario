<?php
/*
    ░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡
    ░░              CrediÁgil S.A DE C.V
    ░░          MÓDULO DE ESTADÍSTICAS - REFACTORIZADO
    ░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡
*/

/**
 * Obtiene datos para gráfico tipo Forex (candlestick OHLC):
 * Cada día de los últimos N días = una vela.
 *   open  = saldo de créditos activos al inicio del día
 *   high  = monto de cuotas cobradas ese día (ganancia)
 *   low   = monto de cuotas vencidas ese día (pérdida/riesgo)
 *   close = open + cobradas - vencidas
 * Verde: close > open   (se cobró más de lo que venció)
 * Rojo:  close <= open  (venció más de lo que se cobró)
 */
function obtenerDatosCandlestick($conexion, $dias = 60)
{
    $sql = "SELECT
                dia,
                IFNULL(cobrado, 0)  AS cobrado,
                IFNULL(vencido, 0)  AS vencido
            FROM (
                SELECT
                    DATE(t.fecha) AS dia,
                    SUM(t.monto)  AS cobrado,
                    NULL          AS vencido
                FROM transacciones t
                WHERE t.fecha >= DATE_SUB(CURDATE(), INTERVAL $dias DAY)
                GROUP BY DATE(t.fecha)
                UNION ALL
                SELECT
                    cu.fechavencimiento AS dia,
                    NULL               AS cobrado,
                    SUM(cu.montocancelar) AS vencido
                FROM cuotas cu
                WHERE cu.estadocuota = 'pendiente'
                  AND cu.fechavencimiento < CURDATE()
                  AND cu.fechavencimiento >= DATE_SUB(CURDATE(), INTERVAL $dias DAY)
                GROUP BY cu.fechavencimiento
            ) sub
            ORDER BY dia ASC";

    $res = mysqli_query($conexion, $sql);
    $rows = [];
    while ($f = mysqli_fetch_assoc($res)) {
        $rows[$f['dia']]['cobrado'] = floatval($f['cobrado']);
        $rows[$f['dia']]['vencido'] = floatval($f['vencido']);
    }

    // Construir velas OHLC acumulando un "saldo base" fijo de 100.000 para dar escala
    $base = 100000;
    $current = $base;
    $candles = [];
    foreach ($rows as $dia => $v) {
        $cobrado = $v['cobrado'] ?? 0;
        $vencido = $v['vencido'] ?? 0;
        $open = $current;
        $close = round($open + $cobrado - $vencido, 2);
        $high = round(max($open, $close) + $cobrado * 0.1, 2);  // ligera amplitud alta
        $low = round(min($open, $close) - $vencido * 0.1, 2); // ligera amplitud baja
        $candles[] = [
            'x' => $dia,
            'y' => [$open, $high, $low, $close],
            'cobrado' => $cobrado,
            'vencido' => $vencido,
        ];
        $current = $close;
    }
    return $candles;
}

/**
 * KPIs principales del dashboard
 */
function obtenerKPIs($conexion)
{
    $data = [];

    // Capital en riesgo (cuotas vencidas activas)
    $r = mysqli_query($conexion, "SELECT
            IFNULL(SUM(c.saldocredito),0) AS capital_riesgo,
            COUNT(DISTINCT cu.idcreditos) AS creditos_morosos
        FROM creditos c
        JOIN cuotas cu ON c.idcreditos = cu.idcreditos
        WHERE c.estado='aprobado' AND c.creditoactivo='si'
          AND cu.estadocuota='pendiente' AND cu.fechavencimiento < CURDATE()");
    $f = mysqli_fetch_assoc($r);
    $data['capital_riesgo'] = floatval($f['capital_riesgo'] ?? 0);
    $data['creditos_morosos'] = intval($f['creditos_morosos'] ?? 0);

    // Colocación total aprobada
    $r = mysqli_query($conexion, "SELECT IFNULL(SUM(montocredito),0) AS total FROM creditos WHERE estado='aprobado'");
    $f = mysqli_fetch_assoc($r);
    $data['colocacion_total'] = floatval($f['total'] ?? 0);

    // Cuotas cobradas hoy / este mes
    $r = mysqli_query($conexion, "SELECT
            IFNULL(SUM(CASE WHEN DATE(fecha)=CURDATE() THEN monto ELSE 0 END),0) AS hoy,
            IFNULL(SUM(CASE WHEN MONTH(fecha)=MONTH(CURDATE()) AND YEAR(fecha)=YEAR(CURDATE()) THEN monto ELSE 0 END),0) AS mes
        FROM transacciones");
    $f = mysqli_fetch_assoc($r);
    $data['cobrado_hoy'] = floatval($f['hoy'] ?? 0);
    $data['cobrado_mes'] = floatval($f['mes'] ?? 0);

    // Efectividad de cobro
    $r = mysqli_query($conexion, "SELECT
            COUNT(*) AS total,
            SUM(CASE WHEN incumplimiento_pago='NO' THEN 1 ELSE 0 END) AS atime
        FROM cuotas WHERE estadocuota='cancelada'");
    $f = mysqli_fetch_assoc($r);
    $pagadas = intval($f['total'] ?? 0);
    $atime = intval($f['atime'] ?? 0);
    $data['efectividad_cobro'] = $pagadas > 0 ? round(($atime / $pagadas) * 100, 1) : 0;
    $data['cuotas_pagadas'] = $pagadas;

    // Cuotas pendientes con vencimiento hoy y en los próximos 7 días
    $r = mysqli_query($conexion, "SELECT
            SUM(CASE WHEN fechavencimiento=CURDATE() THEN montocancelar ELSE 0 END) AS hoy,
            SUM(CASE WHEN fechavencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN montocancelar ELSE 0 END) AS proximos7,
            COUNT(CASE WHEN fechavencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1 END) AS cuotas7
        FROM cuotas WHERE estadocuota='pendiente'");
    $f = mysqli_fetch_assoc($r);
    $data['vencimiento_hoy'] = floatval($f['hoy'] ?? 0);
    $data['proximos_7dias'] = floatval($f['proximos7'] ?? 0);
    $data['cuotas_proximas_7'] = intval($f['cuotas7'] ?? 0);

    return $data;
}

/**
 * Datos para gráfico de barras apiladas: Cobrado vs Vencido por mes (últimos 6 meses)
 */
function obtenerBarrasCobroVsVencido($conexion)
{
    $cobrado = [];
    $r = mysqli_query($conexion, "SELECT
            DATE_FORMAT(fecha,'%Y-%m') AS mes,
            SUM(monto) AS monto
        FROM transacciones
        WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY mes ORDER BY mes ASC");
    while ($f = mysqli_fetch_assoc($r)) {
        $cobrado[$f['mes']] = floatval($f['monto']);
    }

    $vencido = [];
    $r = mysqli_query($conexion, "SELECT
            DATE_FORMAT(fechavencimiento,'%Y-%m') AS mes,
            SUM(montocancelar) AS monto
        FROM cuotas
        WHERE estadocuota='pendiente' AND fechavencimiento < CURDATE()
          AND fechavencimiento >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY mes ORDER BY mes ASC");
    while ($f = mysqli_fetch_assoc($r)) {
        $vencido[$f['mes']] = floatval($f['monto']);
    }

    $meses = array_unique(array_merge(array_keys($cobrado), array_keys($vencido)));
    sort($meses);

    $result = [];
    foreach ($meses as $m) {
        $result[] = [
            'mes' => $m,
            'cobrado' => $cobrado[$m] ?? 0,
            'vencido' => $vencido[$m] ?? 0,
        ];
    }
    return $result;
}

/**
 * Distribución de créditos por estado (para donut pequeño)
 */
function obtenerDistribucionEstados($conexion)
{
    $r = mysqli_query($conexion, "SELECT estado, COUNT(*) AS total FROM creditos GROUP BY estado ORDER BY total DESC");
    $rows = [];
    while ($f = mysqli_fetch_assoc($r)) {
        $rows[] = ['estado' => ucfirst($f['estado']), 'total' => intval($f['total'])];
    }
    return $rows;
}

/**
 * Proyección de flujo: cuotas por vencer en los próximos 30 días (timeline)
 */
function obtenerProyeccionFlujo($conexion)
{
    $r = mysqli_query($conexion, "SELECT
            fechavencimiento AS fecha,
            SUM(montocancelar) AS monto,
            COUNT(*) AS cuotas
        FROM cuotas
        WHERE estadocuota='pendiente'
          AND fechavencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
        GROUP BY fechavencimiento ORDER BY fechavencimiento ASC");
    $rows = [];
    $total = 0;
    while ($f = mysqli_fetch_assoc($r)) {
        $rows[] = ['fecha' => $f['fecha'], 'monto' => floatval($f['monto']), 'cuotas' => intval($f['cuotas'])];
        $total += floatval($f['monto']);
    }
    return ['dias' => $rows, 'total' => $total];
}

/**
 * Función principal: retorna todo lo que la vista necesita
 */
function obtenerEstadisticasGenerales($conexion, $fechaInicio = null, $fechaFin = null, $estadoFiltro = null)
{
    $dias = 90;
    if ($fechaInicio && $fechaFin) {
        $d1 = new DateTime($fechaInicio);
        $d2 = new DateTime($fechaFin);
        $dias = $d2->diff($d1)->days + 1;
    }
    return [
        'kpis' => obtenerKPIs($conexion),
        'candlestick' => obtenerDatosCandlestick($conexion, $dias),
        'barras' => obtenerBarrasCobroVsVencido($conexion),
        'estados' => obtenerDistribucionEstados($conexion),
        'proyeccion' => obtenerProyeccionFlujo($conexion),
        'fecha_inicio' => $fechaInicio,
        'fecha_fin' => $fechaFin,
    ];
}
