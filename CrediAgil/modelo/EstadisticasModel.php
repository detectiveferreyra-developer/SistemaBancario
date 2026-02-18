<?php
/*
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡
░░                         CrediAgil S.A DE C.V                                                  
░░                       SISTEMA FINANCIERO / BANCARIO 
░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡                       
░░                                                                               
░░   -> ESTADÍSTICAS Y KPI'S DEL SISTEMA                       
░░   -> PHP 8.1, MYSQL, MVC                       
░░                                                                               
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
*/

class EstadisticasModel
{
    // OBTENER TOTAL COLOCADO (SUMA DE MONTOS DE CRÉDITOS)
    public function getTotalColocacion($conectarsistema)
    {
        $sql = "SELECT SUM(montocredito) as total FROM creditos WHERE estado = 'aprobado'";
        $resultado = mysqli_query($conectarsistema, $sql);
        $fila = mysqli_fetch_assoc($resultado);
        return $fila['total'] ?? 0;
    }

    // OBTENER CAPITAL EN RIESGO (SUMA DE SALDO DE CRÉDITOS CON MORA)
    public function getCapitalEnRiesgo($conectarsistema)
    {
        // Se considera en riesgo si tiene cuotas con incumplimiento_pago = 'SI'
        $sql = "SELECT SUM(c.saldocredito) as total 
                FROM creditos c 
                WHERE c.idcreditos IN (SELECT idcreditos FROM cuotas WHERE incumplimiento_pago = 'SI' AND estadocuota = 'pendiente')
                AND c.estado = 'aprobado'";
        $resultado = mysqli_query($conectarsistema, $sql);
        $fila = mysqli_fetch_assoc($resultado);
        return $fila['total'] ?? 0;
    }

    // OBTENER TICKET PROMEDIO
    public function getTicketPromedio($conectarsistema)
    {
        $sql = "SELECT AVG(montocredito) as promedio FROM creditos WHERE estado = 'aprobado'";
        $resultado = mysqli_query($conectarsistema, $sql);
        $fila = mysqli_fetch_assoc($resultado);
        return $fila['promedio'] ?? 0;
    }

    // OBTENER EFECTIVIDAD (CRÉDITOS FINALIZADOS VS TOTAL APROBADOS)
    public function getEfectividad($conectarsistema)
    {
        $sqlTotal = "SELECT COUNT(*) as total FROM creditos WHERE estado = 'aprobado'";
        $sqlFinalizados = "SELECT COUNT(*) as total FROM creditos WHERE proceso_finalizado = 'si' AND estado = 'aprobado'";

        $resTotal = mysqli_query($conectarsistema, $sqlTotal);
        $resFin = mysqli_query($conectarsistema, $sqlFinalizados);

        $total = mysqli_fetch_assoc($resTotal)['total'];
        $finalizados = mysqli_fetch_assoc($resFin)['total'];

        if ($total > 0) {
            return ($finalizados / $total) * 100;
        }
        return 0;
    }

    // OBTENER DISTRIBUCIÓN POR PRODUCTO (PARA GRÁFICO DE PIE/DONA)
    public function getDistribucionProductos($conectarsistema)
    {
        $sql = "SELECT p.nombreproducto, COUNT(c.idcreditos) as cantidad 
                FROM productos p 
                LEFT JOIN creditos c ON p.idproducto = c.idproducto 
                GROUP BY p.idproducto";
        $resultado = mysqli_query($conectarsistema, $sql);
        $datos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $datos[] = $fila;
        }
        return $datos;
    }

    // OBTENER CARTERA POR ESTADO CREDITICIO (EXCELENTE, REGULAR, ETC)
    public function getCarteraPorEstado($conectarsistema)
    {
        $sql = "SELECT estadocrediticio, COUNT(*) as cantidad 
                FROM creditos 
                WHERE estado = 'aprobado' 
                GROUP BY estadocrediticio";
        $resultado = mysqli_query($conectarsistema, $sql);
        $datos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $datos[] = $fila;
        }
        return $datos;
    }
}
