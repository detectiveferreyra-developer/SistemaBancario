<?php
/**
 * contrato-preview-print.php
 * Vista de impresión del contrato. Recibe los datos del contrato via $_GET (JSON encoded)
 * y genera una vista print-ready que lanza automáticamente el diálogo de impresión.
 */
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo '<p>Acceso no autorizado.</p>';
    exit;
}

$preview_json = $_GET['data'] ?? '{}';
$preview = json_decode(urldecode($preview_json), true);

if (!$preview) {
    echo '<p>Datos de contrato no válidos.</p>';
    exit;
}

$p = $preview;
$cliente = $p['cliente'] ?? [];
$prestamo = $p['prestamo'] ?? [];
$bien = $p['bien'] ?? [];
$garante = $p['garante'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato
        <?php echo htmlspecialchars($p['num_contrato'] ?? ''); ?> | CrediÁgil
    </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            background: #fff;
            padding: 2cm;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #184897;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header .company-name {
            font-size: 18pt;
            font-weight: bold;
            color: #184897;
            letter-spacing: 2px;
        }

        .header .company-sub {
            font-size: 9pt;
            color: #555;
        }

        .contract-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 18px 0 8px;
            color: #184897;
        }

        .contract-number {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 20px;
            color: #333;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            background: #184897;
            color: #fff;
            padding: 4px 10px;
            border-radius: 2px;
            margin-bottom: 8px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 5px 8px;
            border: 1px solid #ddd;
            font-size: 10pt;
            vertical-align: top;
        }

        .data-table td:first-child {
            font-weight: bold;
            background: #f5f5f5;
            width: 35%;
            color: #184897;
        }

        .highlight-row td {
            background: #fff3e0 !important;
            font-weight: bold;
            font-size: 11pt;
        }

        .total-row td {
            background: #184897 !important;
            color: #fff !important;
            font-weight: bold;
            font-size: 12pt;
        }

        .footer-section {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
        }

        .signature-box {
            text-align: center;
            width: 42%;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-bottom: 6px;
        }

        .signature-label {
            font-size: 9pt;
            color: #555;
        }

        .date-city {
            text-align: right;
            margin-bottom: 16px;
            font-size: 10pt;
            color: #555;
        }

        .nota-legal {
            font-size: 8.5pt;
            color: #666;
            border: 1px solid #ccc;
            padding: 10px;
            background: #f9f9f9;
            margin-top: 20px;
            line-height: 1.4;
        }

        .badge-tipo {
            display: inline-block;
            background: #F5812A;
            color: #fff;
            font-size: 9pt;
            padding: 2px 10px;
            border-radius: 12px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        @media print {
            body {
                padding: 1cm;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <!-- BOTONES DE CONTROL (solo pantalla) -->
    <div class="no-print" style="position:fixed; top:16px; right:16px; z-index:999; display:flex; gap:10px;">
        <button onclick="window.print()"
            style="background:#184897;color:#fff;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-size:13px;font-weight:bold;">
            🖨️ Imprimir
        </button>
        <button onclick="window.close()"
            style="background:#6c757d;color:#fff;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-size:13px;">
            ✕ Cerrar
        </button>
    </div>

    <!-- CABECERA -->
    <div class="header">
        <div class="company-name">INVERSIONES CREDIÁGIL DEL PERÚ E.I.R.L.</div>
        <div class="company-sub">R.U.C. N° 20601767920 | Av. Próceres de la Independencia 2517, Asc. Jorge Basadre,
            S.J.L.</div>
        <div class="company-sub">Tel: +51 998 277 396 | informes@crediagilperu.com | www.crediagildelperu.com</div>
    </div>

    <div class="contract-title">
        Contrato de Préstamo con Garantía Mobiliaria<br>
        <span class="badge-tipo">
            <?php echo htmlspecialchars($p['tipo_contrato'] ?? ''); ?>
        </span>
    </div>
    <div class="contract-number">
        N° <strong>
            <?php echo htmlspecialchars($p['num_contrato'] ?? ''); ?>
        </strong>
    </div>

    <div class="date-city">
        <?php echo htmlspecialchars($p['ciudad'] ?? 'Lima'); ?>,
        <?php echo htmlspecialchars($p['fecha'] ?? ''); ?>
    </div>

    <!-- DATOS DEL CLIENTE -->
    <div class="section">
        <div class="section-title">📋 Datos del Cliente (
            <?php echo htmlspecialchars($p['tipo_personeria'] ?? ''); ?>)
        </div>
        <table class="data-table">
            <tr>
                <td>Nombre / Razón Social</td>
                <td>
                    <?php echo htmlspecialchars($cliente['nombre'] ?? ''); ?>
                </td>
            </tr>
            <tr>
                <td>DNI / RUC</td>
                <td>
                    <?php echo htmlspecialchars($cliente['id'] ?? ''); ?>
                </td>
            </tr>
            <tr>
                <td>Dirección</td>
                <td>
                    <?php echo htmlspecialchars($cliente['direccion'] ?? ''); ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- DATOS DEL BIEN -->
    <div class="section">
        <div class="section-title">🔒 Descripción del Bien en Garantía</div>
        <table class="data-table">
            <?php foreach ($bien as $label => $value):
                if (!$value)
                    continue; ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $label))); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($value); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- GARANTE (si hay) -->
    <?php if (!empty($garante['nombre'])): ?>
        <div class="section">
            <div class="section-title">👤 Garante Mobiliario</div>
            <table class="data-table">
                <tr>
                    <td>Nombre del Garante</td>
                    <td>
                        <?php echo htmlspecialchars($garante['nombre']); ?>
                    </td>
                </tr>
                <?php if (!empty($garante['dni'])): ?>
                    <tr>
                        <td>DNI del Garante</td>
                        <td>
                            <?php echo htmlspecialchars($garante['dni']); ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($garante['domicilio'])): ?>
                    <tr>
                        <td>Domicilio</td>
                        <td>
                            <?php echo htmlspecialchars($garante['domicilio']); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    <?php endif; ?>

    <!-- CONDICIONES DEL PRÉSTAMO -->
    <div class="section">
        <div class="section-title">💰 Condiciones del Préstamo</div>
        <table class="data-table">
            <tr>
                <td>Monto del Préstamo</td>
                <td>
                    <?php echo htmlspecialchars($prestamo['monto'] ?? ''); ?>
                </td>
            </tr>
            <tr>
                <td>En letras</td>
                <td>
                    <?php echo htmlspecialchars($prestamo['letras_prestamo'] ?? ''); ?> Y 00/100 SOLES
                </td>
            </tr>
            <tr>
                <td>Valor de Tasación</td>
                <td>
                    <?php echo htmlspecialchars($prestamo['tasacion'] ?? ''); ?>
                </td>
            </tr>
            <tr>
                <td>Plazo</td>
                <td>
                    <?php echo htmlspecialchars($prestamo['plazo'] ?? ''); ?>
                </td>
            </tr>
            <tr>
                <td>Comisión / Interés</td>
                <td>
                    <?php echo htmlspecialchars($prestamo['comision'] ?? ''); ?>
                </td>
            </tr>
            <tr class="highlight-row">
                <td>TOTAL A DEVOLVER</td>
                <td>
                    <?php echo htmlspecialchars($prestamo['total'] ?? ''); ?>
                </td>
            </tr>
            <tr>
                <td>En letras</td>
                <td>
                    <?php echo htmlspecialchars($prestamo['letras_devolucion'] ?? ''); ?> Y 00/100 SOLES
                </td>
            </tr>
        </table>
    </div>

    <!-- FIRMAS -->
    <div class="footer-section">
        <div class="nota-legal">
            <strong>Nota Legal:</strong> Las partes declaran haber leído y comprendido la totalidad de las cláusulas del
            presente contrato.
            El incumplimiento de pago faculta a CREDIÁGIL a ejecutar extrajudicialmente la garantía mobiliaria, conforme
            a la Ley N° 28677.
            Documento generado electrónicamente por el Sistema CrediÁgil.
        </div>
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line">&nbsp;</div>
                <div><strong>INVERSIONES CREDIÁGIL DEL PERÚ E.I.R.L.</strong></div>
                <div class="signature-label">Representante autorizado</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">&nbsp;</div>
                <div><strong>
                        <?php echo htmlspecialchars($cliente['nombre'] ?? 'EL CLIENTE'); ?>
                    </strong></div>
                <div class="signature-label">
                    <?php echo htmlspecialchars($cliente['id'] ?? ''); ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-lanzar impresión al cargar
        window.addEventListener('load', function () {
            setTimeout(function () { window.print(); }, 600);
        });
    </script>
</body>

</html>