<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo '<p>Acceso no autorizado.</p>';
    exit;
}

$preview_json = $_GET['data'] ?? '{}';
$preview = json_decode(urldecode($preview_json), true);

if (!$preview) {
    echo '<p>Datos no válidos.</p>';
    exit;
}

$p        = $preview;
$prestamo = $p['prestamo'] ?? [];
$conyuge  = $p['conyuge']  ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagaré | CrediÁgil</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt;
            color: #000;
            background: #fff;
            padding: 2cm;
            line-height: 1.55;
        }
        .header { text-align: center; border-bottom: 3px solid #184897; padding-bottom: 10px; margin-bottom: 20px; }
        .header .company-name { font-size: 16pt; font-weight: bold; color: #184897; letter-spacing: 1px; }
        .header .company-sub  { font-size: 8.5pt; color: #555; }
        .doc-title {
            text-align: center; font-size: 14pt; font-weight: bold;
            text-transform: uppercase; margin: 16px 0 4px; color: #184897;
        }
        .doc-subtitle { text-align: center; font-size: 10pt; color: #555; margin-bottom: 16px; }
        .section { margin-bottom: 16px; }
        .section-title {
            font-size: 10.5pt; font-weight: bold; text-transform: uppercase;
            background: #184897; color: #fff; padding: 4px 10px;
            border-radius: 2px; margin-bottom: 8px;
        }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 5px 8px; border: 1px solid #ddd; font-size: 9.5pt; vertical-align: top; }
        .data-table td:first-child { font-weight: bold; background: #f5f5f5; width: 38%; color: #184897; }
        .highlight-row td { background: #fff3e0 !important; font-weight: bold; }
        .total-row td { background: #184897 !important; color: #fff !important; font-weight: bold; font-size: 11pt; }
        .body-text { font-size: 10.5pt; text-align: justify; margin-bottom: 10px; }
        .monto-box {
            border: 2px solid #184897; border-radius: 6px; padding: 16px 20px;
            margin: 16px 0; background: #f5f8ff;
            text-align: center;
        }
        .monto-box .amount { font-size: 22pt; font-weight: bold; color: #184897; }
        .monto-box .letras { font-size: 9.5pt; color: #333; margin-top: 4px; font-style: italic; }
        .footer-section { margin-top: 40px; border-top: 1px solid #ccc; padding-top: 20px; }
        .signatures { display: flex; justify-content: space-around; margin-top: 60px; }
        .signature-box { text-align: center; width: 42%; }
        .signature-line { border-top: 1px solid #000; margin-bottom: 6px; }
        .signature-label { font-size: 8.5pt; color: #555; }
        .nota-legal {
            font-size: 8pt; color: #666; border: 1px solid #ccc;
            padding: 8px; background: #f9f9f9; margin-top: 16px; line-height: 1.4;
        }
        .date-city { text-align: right; margin-bottom: 14px; font-size: 9.5pt; color: #555; }
        @media print { body { padding: 1cm; } .no-print { display: none !important; } }
    </style>
</head>
<body>
    <div class="no-print" style="position:fixed;top:16px;right:16px;z-index:999;display:flex;gap:10px;">
        <button onclick="window.print()" style="background:#184897;color:#fff;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-size:13px;font-weight:bold;">🖨️ Imprimir</button>
        <button onclick="window.close()" style="background:#6c757d;color:#fff;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-size:13px;">✕ Cerrar</button>
    </div>

    <div class="header">
        <div class="company-name">INVERSIONES CREDIÁGIL DEL PERÚ E.I.R.L.</div>
        <div class="company-sub">R.U.C. N° 20601767920 | Av. Próceres de la Independencia 2517, Asc. Jorge Basadre, S.J.L.</div>
        <div class="company-sub">Tel: +51 998 277 396 | informes@crediagilperu.com</div>
    </div>

    <div class="doc-title">Pagaré</div>
    <div class="doc-subtitle">N° <?php echo htmlspecialchars($p['pagare_num'] ?? ''); ?></div>
    <div class="date-city">Lima, <?php echo htmlspecialchars($p['fecha_letras'] ?? ''); ?></div>

    <div class="monto-box">
        <div class="amount"><?php echo htmlspecialchars($prestamo['devolucion'] ?? ''); ?></div>
        <div class="letras"><?php echo htmlspecialchars($prestamo['en_letras'] ?? ''); ?></div>
    </div>

    <div class="section">
        <div class="section-title">📋 Datos del Emisor</div>
        <table class="data-table">
            <tr><td>Nombre Completo</td><td><?php echo htmlspecialchars($p['cliente_nombre'] ?? ''); ?></td></tr>
            <tr><td>DNI / RUC</td><td><?php echo htmlspecialchars($p['dni'] ?? ''); ?></td></tr>
            <tr><td>Dirección</td><td><?php echo htmlspecialchars($p['direccion'] ?? ''); ?></td></tr>
            <?php if (!empty($conyuge['nombre'])): ?>
            <tr><td>Cónyuge</td><td><?php echo htmlspecialchars($conyuge['nombre']); ?></td></tr>
            <tr><td>DNI Cónyuge</td><td><?php echo htmlspecialchars($conyuge['dni']); ?></td></tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="section">
        <div class="section-title">💰 Condiciones del Pagaré</div>
        <table class="data-table">
            <tr><td>Monto Prestado</td><td><?php echo htmlspecialchars($prestamo['monto'] ?? ''); ?></td></tr>
            <tr><td>Interés / Comisión</td><td><?php echo htmlspecialchars($prestamo['comision'] ?? ''); ?></td></tr>
            <tr class="highlight-row"><td>TOTAL A PAGAR</td><td><?php echo htmlspecialchars($prestamo['devolucion'] ?? ''); ?></td></tr>
            <tr><td>En Letras</td><td><em><?php echo htmlspecialchars($prestamo['en_letras'] ?? ''); ?></em></td></tr>
            <tr><td>Tasa de Interés</td><td><?php echo htmlspecialchars($prestamo['tasa'] ?? ''); ?></td></tr>
            <tr><td>Tasa Moratoria</td><td><?php echo htmlspecialchars($prestamo['tasa_moratoria'] ?? ''); ?></td></tr>
            <tr><td>Plazo</td><td><?php echo htmlspecialchars($prestamo['plazo_dias'] ?? ''); ?> días calendario</td></tr>
            <tr><td>Fecha de Desembolso</td><td><?php echo htmlspecialchars($p['fecha_desembolso'] ?? ''); ?></td></tr>
            <tr class="total-row"><td>Fecha de Vencimiento</td><td><?php echo htmlspecialchars($p['fecha_vencimiento'] ?? ''); ?></td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">📝 Cláusula de Pago</div>
        <p class="body-text">
            A la fecha de vencimiento indicada, me comprometo incondicionalmente a pagar a la orden de
            <strong>INVERSIONES CREDIÁGIL DEL PERÚ E.I.R.L.</strong> la suma total de
            <strong><?php echo htmlspecialchars($prestamo['devolucion'] ?? ''); ?></strong>
            (<em><?php echo htmlspecialchars($prestamo['en_letras'] ?? ''); ?></em>).
        </p>
        <p class="body-text">
            En caso de mora, se aplicará una tasa moratoria de <strong><?php echo htmlspecialchars($prestamo['tasa_moratoria'] ?? ''); ?></strong>
            mensual sobre el saldo insoluto, sin perjuicio de las acciones legales que correspondan.
        </p>
        <p class="body-text">
            El presente Pagaré tiene mérito ejecutivo conforme a los artículos 687° y siguientes de la
            Ley de Títulos Valores, Ley N° 27287.
        </p>
    </div>

    <div class="footer-section">
        <div class="nota-legal">
            <strong>Nota Legal:</strong> El incumplimiento del pago en la fecha de vencimiento faculta al tenedor
            a iniciar las acciones de cobro ejecutivo correspondientes. Documento generado por el Sistema CrediÁgil.
        </div>
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line">&nbsp;</div>
                <div><strong>INVERSIONES CREDIÁGIL DEL PERÚ E.I.R.L.</strong></div>
                <div class="signature-label">Beneficiario</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">&nbsp;</div>
                <div><strong><?php echo htmlspecialchars($p['cliente_nombre'] ?? 'EL CLIENTE'); ?></strong></div>
                <div class="signature-label">
                    <?php echo htmlspecialchars($p['dni'] ?? ''); ?> — Emisor del Pagaré
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() { window.print(); }, 600);
        });
    </script>
</body>
</html>
