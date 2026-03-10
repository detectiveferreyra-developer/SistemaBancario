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

$p         = $preview;
$prestamo  = $p['prestamo'] ?? [];
$conyuge   = $p['conyuge']  ?? [];
$prenda    = $p['prenda']   ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Declaración Jurada | CrediÁgil</title>
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
        .section { margin-bottom: 16px; }
        .section-title {
            font-size: 10.5pt; font-weight: bold; text-transform: uppercase;
            background: #184897; color: #fff; padding: 4px 10px;
            border-radius: 2px; margin-bottom: 8px;
        }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 5px 8px; border: 1px solid #ddd; font-size: 9.5pt; vertical-align: top; }
        .data-table td:first-child { font-weight: bold; background: #f5f5f5; width: 38%; color: #184897; }
        .body-text { font-size: 10.5pt; text-align: justify; margin-bottom: 12px; }
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
        <div class="company-sub">Tel: +51 998 277 396 | informes@crediagilperu.com | www.crediagildelperu.com</div>
    </div>

    <div class="doc-title">Declaración Jurada</div>
    <div class="date-city">Lima, <?php echo htmlspecialchars($p['fecha_letras'] ?? ''); ?></div>

    <div class="section">
        <div class="section-title">📋 Datos del Declarante</div>
        <table class="data-table">
            <tr><td>Nombre Completo</td><td><?php echo htmlspecialchars($p['cliente_nombre'] ?? ''); ?></td></tr>
            <tr><td>DNI / RUC</td><td><?php echo htmlspecialchars($p['dni'] ?? ''); ?></td></tr>
            <tr><td>Dirección</td><td><?php echo htmlspecialchars($p['direccion'] ?? ''); ?></td></tr>
            <?php if (!empty($conyuge['nombre'])): ?>
            <tr><td>Cónyuge</td><td><?php echo htmlspecialchars($conyuge['nombre']); ?></td></tr>
            <tr><td>DNI Cónyuge</td><td><?php echo htmlspecialchars($conyuge['dni']); ?></td></tr>
            <tr><td>Dirección Cónyuge</td><td><?php echo htmlspecialchars($conyuge['direccion']); ?></td></tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="section">
        <div class="section-title">🔒 Bien en Garantía</div>
        <table class="data-table">
            <tr><td>Tipo de Prenda</td><td><?php echo htmlspecialchars($prenda['tipo'] ?? ''); ?></td></tr>
            <tr><td>Descripción</td><td><?php echo htmlspecialchars($prenda['descripcion'] ?? ''); ?></td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">📝 Declaración</div>
        <p class="body-text">
            Yo, <strong><?php echo htmlspecialchars($p['cliente_nombre'] ?? ''); ?></strong>, identificado(a) con DNI/RUC
            N° <strong><?php echo htmlspecialchars($p['dni'] ?? ''); ?></strong>, con domicilio en
            <?php echo htmlspecialchars($p['direccion'] ?? ''); ?>, declaro bajo juramento lo siguiente:
        </p>
        <p class="body-text">
            1. Que soy el legítimo propietario(a) del bien indicado en el acápite "Bien en Garantía" y que
            dicho bien no tiene gravamen, embargo ni carga alguna que lo afecte.
        </p>
        <p class="body-text">
            2. Que el bien ha sido entregado voluntariamente a INVERSIONES CREDIÁGIL DEL PERÚ E.I.R.L.
            como garantía prendaria del préstamo otorgado con fecha <strong><?php echo htmlspecialchars($p['fecha_letras'] ?? ''); ?></strong>,
            por un monto de <strong><?php echo htmlspecialchars($prestamo['monto'] ?? ''); ?></strong>
            (<em><?php echo htmlspecialchars($prestamo['en_letras'] ?? ''); ?></em>).
        </p>
        <p class="body-text">
            3. Que me comprometo a no enajenar, transferir ni gravar el bien entregado en garantía sin la
            previa autorización escrita de CREDIÁGIL, bajo responsabilidad penal y civil.
        </p>
        <p class="body-text">
            4. Que los datos consignados en el presente documento son verídicos, siendo de mi entera
            responsabilidad cualquier falsedad u omisión.
        </p>
    </div>

    <div class="footer-section">
        <div class="nota-legal">
            <strong>Nota Legal:</strong> La falsedad de la declaración jurada acarrea responsabilidad penal, conforme
            al Art. 438° del Código Penal Peruano. Documento generado por el Sistema CrediÁgil.
        </div>
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line">&nbsp;</div>
                <div><strong>INVERSIONES CREDIÁGIL DEL PERÚ E.I.R.L.</strong></div>
                <div class="signature-label">Representante autorizado</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">&nbsp;</div>
                <div><strong><?php echo htmlspecialchars($p['cliente_nombre'] ?? 'EL DECLARANTE'); ?></strong></div>
                <div class="signature-label"><?php echo htmlspecialchars($p['dni'] ?? ''); ?></div>
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
