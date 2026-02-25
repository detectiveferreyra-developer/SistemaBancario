<?php
/*
    ░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡
    ░░              CrediÁgil S.A DE C.V
    ░░          MÓDULO DE ESTADÍSTICAS
    ░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡
*/

/**
 * Obtiene estadísticas generales para el módulo de Estadísticas.
 * Retorna un array asociativo JSON-ready con todos los KPIs, datos de gráficos y métricas estratégicas.
 */
function obtenerEstadisticasGenerales($conexion, $fechaInicio = null, $fechaFin = null, $estadoFiltro = null)
{
    $resultado = [];

    // =====================================================
    // 1. KPIs PRINCIPALES
    // =====================================================

    // --- Capital en Riesgo: saldo de créditos con cuotas vencidas (incumplimiento_pago = 'SI') ---
    $sqlCapitalRiesgo = "SELECT IFNULL(SUM(c.saldocredito), 0) AS capital_riesgo
        FROM creditos c
        WHERE c.estado = 'aprobado'
        AND c.creditoactivo = 'si'
        AND EXISTS (
            SELECT 1 FROM cuotas cu
            WHERE cu.idcreditos = c.idcreditos
            AND cu.estadocuota = 'pendiente'
            AND cu.fechavencimiento < CURDATE()
        )";
    $resCapitalRiesgo = mysqli_query($conexion, $sqlCapitalRiesgo);
    $filaRiesgo = mysqli_fetch_assoc($resCapitalRiesgo);
    $resultado['capital_riesgo'] = floatval($filaRiesgo['capital_riesgo'] ?? 0);

    // --- Colocación Total: monto acumulado de todos los préstamos ---
    // Histórico
    $sqlColocacionTotal = "SELECT IFNULL(SUM(montocredito), 0) AS colocacion_total FROM creditos WHERE estado = 'aprobado'";
    $resColocacionTotal = mysqli_query($conexion, $sqlColocacionTotal);
    $filaColocacion = mysqli_fetch_assoc($resColocacionTotal);
    $resultado['colocacion_total'] = floatval($filaColocacion['colocacion_total'] ?? 0);

    // Colocación del mes actual
    $sqlColocacionMes = "SELECT IFNULL(SUM(montocredito), 0) AS colocacion_mes
        FROM creditos
        WHERE estado = 'aprobado'
        AND MONTH(fechasolicitud) = MONTH(CURDATE())
        AND YEAR(fechasolicitud) = YEAR(CURDATE())";
    $resColocacionMes = mysqli_query($conexion, $sqlColocacionMes);
    $filaColocacionMes = mysqli_fetch_assoc($resColocacionMes);
    $resultado['colocacion_mes'] = floatval($filaColocacionMes['colocacion_mes'] ?? 0);

    // --- Efectividad de Cobro: cuotas pagadas a tiempo vs cuotas vencidas ---
    $sqlCuotasPagadas = "SELECT COUNT(*) AS total FROM cuotas WHERE estadocuota = 'cancelada'";
    $resCuotasPagadas = mysqli_query($conexion, $sqlCuotasPagadas);
    $filaPagadas = mysqli_fetch_assoc($resCuotasPagadas);
    $cuotasPagadas = intval($filaPagadas['total'] ?? 0);

    $sqlCuotasPagadasATiempo = "SELECT COUNT(*) AS total FROM cuotas WHERE estadocuota = 'cancelada' AND incumplimiento_pago = 'NO'";
    $resPagadasATiempo = mysqli_query($conexion, $sqlCuotasPagadasATiempo);
    $filaPagadasATiempo = mysqli_fetch_assoc($resPagadasATiempo);
    $cuotasPagadasATiempo = intval($filaPagadasATiempo['total'] ?? 0);

    $sqlCuotasVencidas = "SELECT COUNT(*) AS total FROM cuotas WHERE estadocuota = 'pendiente' AND fechavencimiento < CURDATE()";
    $resCuotasVencidas = mysqli_query($conexion, $sqlCuotasVencidas);
    $filaCuotasVencidas = mysqli_fetch_assoc($resCuotasVencidas);
    $cuotasVencidas = intval($filaCuotasVencidas['total'] ?? 0);

    $totalCuotasEvaluadas = $cuotasPagadas + $cuotasVencidas;
    $resultado['efectividad_cobro'] = $totalCuotasEvaluadas > 0
        ? round(($cuotasPagadasATiempo / $totalCuotasEvaluadas) * 100, 1)
        : 0;
    $resultado['cuotas_pagadas'] = $cuotasPagadas;
    $resultado['cuotas_vencidas'] = $cuotasVencidas;
    $resultado['cuotas_a_tiempo'] = $cuotasPagadasATiempo;

    // --- Ticket Promedio por tipo de producto ---
    $sqlTicketPromedio = "SELECT p.nombreproducto, IFNULL(AVG(c.montocredito), 0) AS ticket_promedio, COUNT(c.idcreditos) AS total_creditos
        FROM creditos c
        INNER JOIN productos p ON c.idproducto = p.idproducto
        WHERE c.estado = 'aprobado'
        GROUP BY p.idproducto, p.nombreproducto
        ORDER BY ticket_promedio DESC";
    $resTicketPromedio = mysqli_query($conexion, $sqlTicketPromedio);
    $ticketsPromedio = [];
    $ticketPromedioGlobal = 0;
    $totalCreditosGlobal = 0;
    while ($fila = mysqli_fetch_assoc($resTicketPromedio)) {
        $ticketsPromedio[] = [
            'producto' => $fila['nombreproducto'],
            'promedio' => floatval($fila['ticket_promedio']),
            'total' => intval($fila['total_creditos'])
        ];
        $ticketPromedioGlobal += floatval($fila['ticket_promedio']) * intval($fila['total_creditos']);
        $totalCreditosGlobal += intval($fila['total_creditos']);
    }
    $resultado['tickets_por_producto'] = $ticketsPromedio;
    $resultado['ticket_promedio_global'] = $totalCreditosGlobal > 0 ? round($ticketPromedioGlobal / $totalCreditosGlobal, 2) : 0;

    // =====================================================
    // 2. DATOS PARA GRÁFICOS DINÁMICOS
    // =====================================================

    // --- Embudo de Ventas: Solicitud → Contrato → Finalizado ---
    $sqlSolicitudes = "SELECT COUNT(*) AS total FROM creditos";
    $resSolicitudes = mysqli_query($conexion, $sqlSolicitudes);
    $resultado['funnel_solicitudes'] = intval(mysqli_fetch_assoc($resSolicitudes)['total'] ?? 0);

    $sqlAprobados = "SELECT COUNT(*) AS total FROM creditos WHERE estado = 'aprobado'";
    $resAprobados = mysqli_query($conexion, $sqlAprobados);
    $resultado['funnel_contratos'] = intval(mysqli_fetch_assoc($resAprobados)['total'] ?? 0);

    $sqlFinalizados = "SELECT COUNT(*) AS total FROM historicocreditos WHERE estado = 'cancelado'";
    $resFinalizados = mysqli_query($conexion, $sqlFinalizados);
    $resultado['funnel_finalizados'] = intval(mysqli_fetch_assoc($resFinalizados)['total'] ?? 0);

    // --- Barras Comparativas: Monto por tipo de producto ---
    $sqlMontoPorProducto = "SELECT p.nombreproducto, IFNULL(SUM(c.montocredito), 0) AS monto_total
        FROM creditos c
        INNER JOIN productos p ON c.idproducto = p.idproducto
        WHERE c.estado = 'aprobado'
        GROUP BY p.idproducto, p.nombreproducto
        ORDER BY monto_total DESC";
    $resMontoPorProducto = mysqli_query($conexion, $sqlMontoPorProducto);
    $montoPorProducto = [];
    while ($fila = mysqli_fetch_assoc($resMontoPorProducto)) {
        $montoPorProducto[] = [
            'producto' => $fila['nombreproducto'],
            'monto' => floatval($fila['monto_total'])
        ];
    }
    $resultado['monto_por_producto'] = $montoPorProducto;

    // --- Línea de Tiempo de Recuperaciones: dinero recuperado por mes (últimos 12 meses) ---
    $sqlRecuperaciones = "SELECT
            DATE_FORMAT(t.fecha, '%Y-%m') AS periodo,
            IFNULL(SUM(t.monto), 0) AS monto_recuperado,
            COUNT(t.idtransaccion) AS num_transacciones
        FROM transacciones t
        WHERE t.fecha >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
        GROUP BY DATE_FORMAT(t.fecha, '%Y-%m')
        ORDER BY periodo ASC";
    $resRecuperaciones = mysqli_query($conexion, $sqlRecuperaciones);
    $recuperaciones = [];
    while ($fila = mysqli_fetch_assoc($resRecuperaciones)) {
        $recuperaciones[] = [
            'periodo' => $fila['periodo'],
            'monto' => floatval($fila['monto_recuperado']),
            'transacciones' => intval($fila['num_transacciones'])
        ];
    }
    $resultado['recuperaciones_timeline'] = $recuperaciones;

    // =====================================================
    // 3. ESTADÍSTICAS DE INTELIGENCIA ESTRATÉGICA
    // =====================================================

    // --- Métrica de Garantías: Distribución por tipo de producto (bien en garantía) ---
    $sqlGarantias = "SELECT p.nombreproducto, COUNT(c.idcreditos) AS total
        FROM creditos c
        INNER JOIN productos p ON c.idproducto = p.idproducto
        WHERE c.estado = 'aprobado'
        GROUP BY p.idproducto, p.nombreproducto
        ORDER BY total DESC";
    $resGarantias = mysqli_query($conexion, $sqlGarantias);
    $garantias = [];
    $totalGarantias = 0;
    while ($fila = mysqli_fetch_assoc($resGarantias)) {
        $garantias[] = [
            'producto' => $fila['nombreproducto'],
            'total' => intval($fila['total'])
        ];
        $totalGarantias += intval($fila['total']);
    }
    // Calcular porcentajes
    foreach ($garantias as &$g) {
        $g['porcentaje'] = $totalGarantias > 0 ? round(($g['total'] / $totalGarantias) * 100, 1) : 0;
    }
    unset($g);
    $resultado['garantias'] = $garantias;

    // --- Métrica de Fiadores: Contratos con referencias (fiadores) y su tasa de cumplimiento ---
    $sqlConFiadores = "SELECT COUNT(DISTINCT r.idcreditos) AS con_fiador
        FROM referenciaspersonales r
        INNER JOIN creditos c ON r.idcreditos = c.idcreditos
        WHERE c.estado = 'aprobado'";
    $resConFiadores = mysqli_query($conexion, $sqlConFiadores);
    $conFiadores = intval(mysqli_fetch_assoc($resConFiadores)['con_fiador'] ?? 0);

    $sqlTotalAprobados = "SELECT COUNT(*) AS total FROM creditos WHERE estado = 'aprobado'";
    $resTotalAprobados = mysqli_query($conexion, $sqlTotalAprobados);
    $totalAprobados = intval(mysqli_fetch_assoc($resTotalAprobados)['total'] ?? 0);

    $resultado['fiadores_total'] = $conFiadores;
    $resultado['fiadores_porcentaje'] = $totalAprobados > 0 ? round(($conFiadores / $totalAprobados) * 100, 1) : 0;

    // Tasa de cumplimiento de créditos con fiadores
    $sqlCumplimientoFiadores = "SELECT
            COUNT(DISTINCT CASE WHEN cu.incumplimiento_pago = 'NO' THEN cu.idcuotas END) AS cuotas_cumplidas,
            COUNT(DISTINCT cu.idcuotas) AS cuotas_totales
        FROM referenciaspersonales r
        INNER JOIN cuotas cu ON r.idcreditos = cu.idcreditos
        WHERE cu.estadocuota = 'cancelada'";
    $resCumplimiento = mysqli_query($conexion, $sqlCumplimientoFiadores);
    $filaCumplimiento = mysqli_fetch_assoc($resCumplimiento);
    $cuotasCumplidasFiadores = intval($filaCumplimiento['cuotas_cumplidas'] ?? 0);
    $cuotasTotalesFiadores = intval($filaCumplimiento['cuotas_totales'] ?? 0);
    $resultado['fiadores_cumplimiento'] = $cuotasTotalesFiadores > 0
        ? round(($cuotasCumplidasFiadores / $cuotasTotalesFiadores) * 100, 1)
        : 0;

    // --- Proyección de Flujo: Ingresos esperados próximos 30 días ---
    $sqlProyeccion = "SELECT
            fechavencimiento,
            SUM(montocancelar) AS monto_esperado,
            COUNT(*) AS num_cuotas
        FROM cuotas
        WHERE estadocuota = 'pendiente'
        AND fechavencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
        GROUP BY fechavencimiento
        ORDER BY fechavencimiento ASC";
    $resProyeccion = mysqli_query($conexion, $sqlProyeccion);
    $proyeccion = [];
    $totalProyeccion = 0;
    while ($fila = mysqli_fetch_assoc($resProyeccion)) {
        $proyeccion[] = [
            'fecha' => $fila['fechavencimiento'],
            'monto' => floatval($fila['monto_esperado']),
            'cuotas' => intval($fila['num_cuotas'])
        ];
        $totalProyeccion += floatval($fila['monto_esperado']);
    }
    $resultado['proyeccion_30dias'] = $proyeccion;
    $resultado['proyeccion_total'] = $totalProyeccion;

    // =====================================================
    // 4. DATOS ADICIONALES: Distribución por estado de contratos
    // =====================================================
    $sqlEstados = "SELECT estado, COUNT(*) AS total FROM creditos GROUP BY estado ORDER BY total DESC";
    $resEstados = mysqli_query($conexion, $sqlEstados);
    $estados = [];
    while ($fila = mysqli_fetch_assoc($resEstados)) {
        $estados[] = [
            'estado' => ucfirst($fila['estado']),
            'total' => intval($fila['total'])
        ];
    }
    $resultado['distribucion_estados'] = $estados;

    // Total de clientes activos
    $sqlTotalClientes = "SELECT COUNT(*) AS total FROM usuarios WHERE idrol = 5 AND estado_usuario = 'activo'";
    $resTotalClientes = mysqli_query($conexion, $sqlTotalClientes);
    $resultado['total_clientes'] = intval(mysqli_fetch_assoc($resTotalClientes)['total'] ?? 0);

    // Créditos activos
    $sqlCreditosActivos = "SELECT COUNT(*) AS total FROM creditos WHERE estado = 'aprobado' AND creditoactivo = 'si'";
    $resCreditosActivos = mysqli_query($conexion, $sqlCreditosActivos);
    $resultado['creditos_activos'] = intval(mysqli_fetch_assoc($resCreditosActivos)['total'] ?? 0);

    return $resultado;
}
