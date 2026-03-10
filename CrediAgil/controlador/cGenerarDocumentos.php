<?php
ob_start();
/**
 * cGenerarDocumentos.php
 * Genera los 3 documentos adicionales por cliente nuevo:
 *   1. DECLARACION JURADA.docx
 *   2. PAGARE.docx
 *   3. MODELO DE CRONOGRAMA POR CLIENTE.xlsx
 *
 * Placeholders DECLARACION JURADA:
 *   NOMBRE_COMPLETO_CLIENTE, DNI_CLIENTE, DIRECCION_CLIENTE, DISTRITO_CLIENTE,
 *   PROVINCIA_CLIENTE, DEPARTAMENTO_CLIENTE, NOMBRE_CONYUGE, DNI_CONYUGE,
 *   DIRECCION_CONYUGE, DISTRITO_CONYUGE, PROVINCIA_CONYUGE,
 *   CHECK_MENAJE, CHECK_EQUIPOS, DESCRIPCION_PRENDA, FECHA_CONTRATO_LETRAS
 *
 * Placeholders PAGARE:
 *   NUM_PAGARE, ANIO, NOMBRE_CLIENTE, DNI_CLIENTE, DIRECCION_CLIENTE,
 *   DISTRITO_CLIENTE, PROVINCIA_CLIENTE, DEPARTAMENTO_CLIENTE,
 *   FECHA_VENCIMIENTO, SIMBOLO_MONEDA, MONTO_PRESTAMO, MONTO_LETRAS,
 *   TASA_INTERES, TASA_MORATORIA, FECHA_CONTRATO_LETRAS,
 *   NOMBRE_CONYUGE, DNI_CONYUGE, DIRECCION_CONYUGE, DISTRITO_CONYUGE, PROVINCIA_CONYUGE
 *
 * Placeholders CRONOGRAMA (XLSX ${VAR}):
 *   PRODUCTO_NOMBRE, NUM_CUOTAS, DESCRIPCION_PRENDA, NOMBRE_COMPLETO_CLIENTE,
 *   MONTO_PRESTAMO, FECHA_DESEMBOLSO, FECHA_PAGO_FINAL, DIRECCION_CLIENTE,
 *   TELEFONO_CLIENTE, CELULAR_CLIENTE, EMAIL_CLIENTE,
 *   FECHA_VENC_1, CAPITAL_1, TOTAL_1, NOMBRE_CLIENTE, DNI_CLIENTE
 */

session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_usuario'])) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Sesión no iniciada.']);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

// ─────────────────────────────────────────────
// 1. DATOS RECIBIDOS (Datos del cliente ya enviados via POST)
// ─────────────────────────────────────────────
$p = $_POST;

$up = function (string $key, string $default = '') use ($p): string {
    return strtoupper(trim($p[$key] ?? $default));
};
$raw = function (string $key, string $default = '') use ($p): string {
    return trim($p[$key] ?? $default);
};

// ─────────────────────────────────────────────
// 2. FECHAS Y AUTO-VALORES
// ─────────────────────────────────────────────
$dia = date('d');
$mes_num = date('m');
$anio = date('Y');

$meses_nombre = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
$meses_texto = ['','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
$mes_nombre = $meses_nombre[(int)$mes_num];
$mes_texto = $meses_texto[(int)$mes_num];

// Función: número a letras
function numberToWordsDoc(float $num): string {
    $num = round($num, 2);
    $entero = (int) floor($num);
    $unidades = ['','UNO','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE','DIEZ','ONCE','DOCE','TRECE','CATORCE','QUINCE','DIECISÉIS','DIECISIETE','DIECIOCHO','DIECINUEVE'];
    $decenas = ['','','VEINTE','TREINTA','CUARENTA','CINCUENTA','SESENTA','SETENTA','OCHENTA','NOVENTA'];
    $centenas = ['','CIEN','DOSCIENTOS','TRESCIENTOS','CUATROCIENTOS','QUINIENTOS','SEISCIENTOS','SETECIENTOS','OCHOCIENTOS','NOVECIENTOS'];
    $convertGroup = function(int $n) use ($unidades, $decenas, $centenas): string {
        if ($n === 0) return '';
        $str = '';
        $c_idx = intdiv($n, 100);
        $r = $n % 100;
        if ($c_idx > 0) $str .= ($c_idx === 1 && $r > 0) ? 'CIENTO ' : $centenas[$c_idx] . ' ';
        if ($r > 0) {
            if ($r < 20) $str .= $unidades[$r] . ' ';
            elseif ($r === 20) $str .= 'VEINTE ';
            elseif ($r <= 29) $str .= 'VEINTI' . $unidades[$r - 20] . ' ';
            else {
                $d_idx = intdiv($r, 10); $u_idx = $r % 10;
                $str .= $decenas[$d_idx];
                if ($u_idx > 0) $str .= ' Y ' . $unidades[$u_idx];
                $str .= ' ';
            }
        }
        return $str;
    };
    if ($entero === 0) return 'CERO';
    $millones = intdiv($entero, 1000000);
    $miles = intdiv($entero % 1000000, 1000);
    $resto = $entero % 1000;
    $resultado = '';
    if ($millones > 0) $resultado .= ($millones === 1) ? 'UN MILLÓN ' : $convertGroup($millones) . 'MILLONES ';
    if ($miles > 0) $resultado .= ($miles === 1) ? 'MIL ' : $convertGroup($miles) . 'MIL ';
    if ($resto > 0) $resultado .= $convertGroup($resto);
    return rtrim($resultado);
}

// Montos
$monto_prestamo = floatval($p['monto_prestamo'] ?? 0);
$valor_interes = floatval($p['valor_interes'] ?? 0);
$tipo_interes = $p['tipo_interes'] ?? '';
$plazo_dias = intval($p['plazo_dias'] ?? 30);
$comision = ($tipo_interes === 'porcentaje') ? ($monto_prestamo * $valor_interes) / 100 : $valor_interes;
$monto_devolucion = $monto_prestamo + $comision;
$tasa_moratoria = floatval($p['tasa_moratoria'] ?? 5.99);

// Número de pagaré
$num_pagare = 'PAG-' . $anio . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

// Fechas
$fecha_desembolso_raw = $raw('fecha_desembolso'); // YYYY-MM-DD
$fecha_vencimiento_raw = '';
if ($fecha_desembolso_raw) {
    $ts = strtotime($fecha_desembolso_raw . " +{$plazo_dias} days");
    $fecha_vencimiento_raw = date('d/m/Y', $ts);
    $fecha_pago_final = date('d/m/Y', $ts);
    $desembolso_display = date('d/m/Y', strtotime($fecha_desembolso_raw));
} else {
    $ts = time() + ($plazo_dias * 86400);
    $fecha_vencimiento_raw = date('d/m/Y', $ts);
    $fecha_pago_final = date('d/m/Y', $ts);
    $desembolso_display = date('d/m/Y');
}

// Fecha en letras: "10 de Marzo de 2025"
$fecha_contrato_letras = intval($dia) . ' de ' . $mes_nombre . ' de ' . $anio;

// Tipo de contrato para producto_nombre
$tipo_contrato = strtolower(trim($p['tipo_contrato'] ?? ''));
$tipo_labels = ['auto' => 'Prenda Auto', 'joyas' => 'Prenda Joyas', 'electro' => 'Prenda Electro'];
$producto_nombre = $tipo_labels[$tipo_contrato] ?? 'Préstamo';

// Tipo de personería
$tipo_personeria = strtolower(trim($p['tipo_personeria'] ?? ''));

// Nombre del cliente para carpeta
$nombre_display = ($tipo_personeria === 'empresa')
    ? $up('razon_social')
    : $up('nombre_completo');

// Dirección del cliente
$direccion_cliente = ($tipo_personeria === 'empresa')
    ? $up('domicilio_fiscal')
    : implode(', ', array_filter([$raw('domicilio_calle'), $raw('domicilio_urbanizacion')]));

$distrito_cliente = ($tipo_personeria === 'empresa') ? $up('distrito_rep_legal') : $up('domicilio_distrito');
$provincia_cliente = ($tipo_personeria === 'empresa') ? $up('provincia_rep_legal') : $up('domicilio_provincia');
$departamento_cliente = ($tipo_personeria === 'empresa') ? $up('departamento_rep_legal') : $up('domicilio_departamento');

// DNI del cliente
$dni_cliente = ($tipo_personeria === 'empresa') ? $raw('ruc') : $raw('dni');

// Descripcion de la prenda
$descripcion_prenda = '';
switch ($tipo_contrato) {
    case 'auto':
        $descripcion_prenda = strtoupper(implode(' ', array_filter([
            $raw('auto_marca'), $raw('auto_modelo'), $raw('auto_anio'), 'PLACA:', $raw('auto_placa')
        ])));
        break;
    case 'joyas':
        $descripcion_prenda = strtoupper(implode(' - ', array_filter([
            $raw('joyas_descripcion'), $raw('joyas_material_ley'), $raw('joyas_peso_bruto') . 'g'
        ])));
        break;
    case 'electro':
        $descripcion_prenda = strtoupper(implode(' ', array_filter([
            $raw('electro_tipo_bien'), $raw('electro_marca'), $raw('electro_modelo'), 'SERIE:', $raw('electro_numero_serie')
        ])));
        break;
}

// CHECK boxes para DECLARACION JURADA
$check_menaje  = ($tipo_contrato === 'electro') ? 'X' : '';
$check_equipos = ($tipo_contrato === 'electro') ? '' : '';

// Número cuotas (para cronograma, 1 cuota ya que es plazo fijo)
$num_cuotas = 1;

// ─────────────────────────────────────────────
// 3. MAPA DE REEMPLAZOS COMUNES
// ─────────────────────────────────────────────
// Contacto de Cliente
$telefono_cliente          = $_POST['telefono_cliente'] ?? '';
$celular_cliente           = $_POST['celular_cliente'] ?? '';
$email_cliente             = strtolower($_POST['email_cliente'] ?? '');

// Datos del Cónyuge (si aplica)
$estado_civil              = strtoupper($_POST['estado_civil'] ?? '');
$nombre_conyuge            = strtoupper($_POST['nombre_conyuge'] ?? '');
$profesion_conyuge         = strtoupper($_POST['profesion_conyuge'] ?? '');
$nacionalidad_conyuge      = strtoupper($_POST['nacionalidad_conyuge'] ?? '');
$dni_conyuge               = $_POST['dni_conyuge'] ?? '';
$direccion_conyuge         = strtoupper($_POST['direccion_conyuge'] ?? '');
$distrito_conyuge          = strtoupper($_POST['distrito_conyuge'] ?? '');
$provincia_conyuge         = strtoupper($_POST['provincia_conyuge'] ?? '');
$departamento_conyuge      = strtoupper($_POST['departamento_conyuge'] ?? '');
// Contacto de Cónyuge
$telefono_conyuge          = $_POST['telefono_conyuge'] ?? '';
$celular_conyuge           = $_POST['celular_conyuge'] ?? '';
$email_conyuge             = strtolower($_POST['email_conyuge'] ?? '');
$reemplazos_dj = [
    'NOMBRE_COMPLETO_CLIENTE' => $nombre_display,
    'DNI_CLIENTE'             => $dni_cliente,
    'DIRECCION_CLIENTE'       => $direccion_cliente,
    'DISTRITO_CLIENTE'        => $distrito_cliente,
    'PROVINCIA_CLIENTE'       => $provincia_cliente,
    'DEPARTAMENTO_CLIENTE'    => $departamento_cliente,
    'NOMBRE_CONYUGE'          => $nombre_conyuge,
    'DNI_CONYUGE'             => $dni_conyuge,
    'DIRECCION_CONYUGE'       => $direccion_conyuge,
    'DISTRITO_CONYUGE'        => $distrito_conyuge,
    'PROVINCIA_CONYUGE'       => $provincia_conyuge,
    'CHECK_MENAJE'            => $check_menaje,
    'CHECK_EQUIPOS'           => $check_equipos,
    'DESCRIPCION_PRENDA'      => $descripcion_prenda,
    'FECHA_CONTRATO_LETRAS'   => strtoupper($fecha_contrato_letras),
];

$tasa_interes_display = ($tipo_interes === 'porcentaje')
    ? number_format($valor_interes, 2) . '%'
    : 'S/ ' . number_format($valor_interes, 2, '.', ',') . ' MONTO FIJO';

$reemplazos_pagare = [
    'NUM_PAGARE'              => $num_pagare,
    'ANIO'                    => $anio,
    'NOMBRE_CLIENTE'          => $nombre_display,
    'DNI_CLIENTE'             => $dni_cliente,
    'DIRECCION_CLIENTE'       => $direccion_cliente,
    'DISTRITO_CLIENTE'        => $distrito_cliente,
    'PROVINCIA_CLIENTE'       => $provincia_cliente,
    'DEPARTAMENTO_CLIENTE'    => $departamento_cliente,
    'FECHA_VENCIMIENTO'       => $fecha_vencimiento_raw,
    'SIMBOLO_MONEDA'          => 'S/',
    'MONTO_PRESTAMO'          => 'S/ ' . number_format($monto_devolucion, 2, '.', ','),
    'MONTO_LETRAS'            => numberToWordsDoc($monto_devolucion) . ' Y 00/100 SOLES',
    'TASA_INTERES'            => $tasa_interes_display,
    'TASA_MORATORIA'          => number_format($tasa_moratoria, 2) . '%',
    'FECHA_CONTRATO_LETRAS'   => strtoupper($fecha_contrato_letras),
    'NOMBRE_CONYUGE'          => $up('nombre_conyuge'),
    'DNI_CONYUGE'             => $raw('dni_conyuge'),
    'DIRECCION_CONYUGE'       => $up('direccion_conyuge'),
    'DISTRITO_CONYUGE'        => $up('distrito_conyuge'),
    'PROVINCIA_CONYUGE'       => $up('provincia_conyuge'),
];

// Reemplazos para XLSX (usa ${VAR} estilo)
$reemplazos_xlsx = [
    'PRODUCTO_NOMBRE'          => $producto_nombre,
    'NUM_CUOTAS'               => (string)$num_cuotas,
    'DESCRIPCION_PRENDA'       => $descripcion_prenda,
    'NOMBRE_COMPLETO_CLIENTE'  => $nombre_display,
    'NOMBRE_CLIENTE'           => $nombre_display,
    'DNI_CLIENTE'              => $dni_cliente,
    'MONTO_PRESTAMO'           => 'S/ ' . number_format($monto_prestamo, 2, '.', ','),
    'FECHA_DESEMBOLSO'         => $desembolso_display,
    'FECHA_PAGO_FINAL'         => $fecha_pago_final,
    'DIRECCION_CLIENTE'        => $direccion_cliente,
    'TELEFONO_CLIENTE'         => $raw('telefono_cliente'),
    'CELULAR_CLIENTE'          => $raw('celular_cliente'),
    'EMAIL_CLIENTE'            => $raw('email_cliente'),
    'FECHA_VENC_1'             => $fecha_vencimiento_raw,
    'CAPITAL_1'                => number_format($monto_prestamo, 2, '.', ','),
    'TOTAL_1'                  => number_format($monto_devolucion, 2, '.', ','),
];

// ─────────────────────────────────────────────
// 4. DIRECTORIO TEMP
// ─────────────────────────────────────────────
$tmp_dir = realpath(__DIR__ . '/..') . '/tmp_contratos/';
if (!is_dir($tmp_dir)) mkdir($tmp_dir, 0755, true);

$ts_id = time() . '_' . rand(100, 999);
$results = [];

// ─────────────────────────────────────────────
// 5. GENERAR DECLARACION JURADA
// ─────────────────────────────────────────────
try {
    $tpl_dj = realpath(__DIR__ . '/../Templates/DECLARACION JURADA.docx');
    if (!$tpl_dj) throw new Exception('Plantilla DECLARACION JURADA no encontrada.');
    $proc_dj = new \PhpOffice\PhpWord\TemplateProcessor($tpl_dj);
    foreach ($reemplazos_dj as $key => $val) {
        $proc_dj->setValue($key, $val);
    }
    $dj_filename = 'declaracion_jurada_' . $ts_id . '.docx';
    $proc_dj->saveAs($tmp_dir . $dj_filename);
    $results['dj_docx']  = $dj_filename;
} catch (Exception $e) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Error DJ: ' . $e->getMessage()]);
    exit;
}

// ─────────────────────────────────────────────
// 6. GENERAR PAGARÉ
// ─────────────────────────────────────────────
try {
    $tpl_pg = realpath(__DIR__ . '/../Templates/PAGARE.docx');
    if (!$tpl_pg) throw new Exception('Plantilla PAGARE no encontrada.');
    $proc_pg = new \PhpOffice\PhpWord\TemplateProcessor($tpl_pg);
    foreach ($reemplazos_pagare as $key => $val) {
        $proc_pg->setValue($key, $val);
    }
    $pg_filename = 'pagare_' . $ts_id . '.docx';
    $proc_pg->saveAs($tmp_dir . $pg_filename);
    $results['pagare_docx'] = $pg_filename;
} catch (Exception $e) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Error Pagaré: ' . $e->getMessage()]);
    exit;
}

// ─────────────────────────────────────────────
// 7. GENERAR CRONOGRAMA XLSX
// ─────────────────────────────────────────────
try {
    $xlsx_tpl = realpath(__DIR__ . '/../Templates/MODELO DE CRONOGRAMA POR CLIENTE.xlsx');
    if (!$xlsx_tpl) throw new Exception('Plantilla CRONOGRAMA no encontrada.');

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($xlsx_tpl);
    $spreadsheet = $reader->load($xlsx_tpl);

    // Reemplazar ${VAR} en todas las celdas de todas las hojas
    foreach ($spreadsheet->getAllSheets() as $sheet) {
        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $val = $cell->getValue();
                if ($val && is_string($val)) {
                    foreach ($reemplazos_xlsx as $varName => $replacement) {
                        $val = str_replace('${' . $varName . '}', $replacement, $val);
                    }
                    $cell->setValue($val);
                }
            }
        }
    }

    $xlsx_filename = 'cronograma_' . $ts_id . '.xlsx';
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($tmp_dir . $xlsx_filename);
    $results['cronograma_xlsx'] = $xlsx_filename;
} catch (Exception $e) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Error Cronograma: ' . $e->getMessage()]);
    exit;
}

// ─────────────────────────────────────────────
// 8. CONVERTIR DOCX A PDF CON VBS
// ─────────────────────────────────────────────
$vbs_path = $tmp_dir . 'convert.vbs';
if (!file_exists($vbs_path)) {
    $vbs = "Set objWord = CreateObject(\"Word.Application\")\n";
    $vbs .= "objWord.Visible = False\n";
    $vbs .= "Set objDoc = objWord.Documents.Open(WScript.Arguments(0))\n";
    $vbs .= "objDoc.SaveAs WScript.Arguments(1), 17\n";
    $vbs .= "objDoc.Close\n";
    $vbs .= "objWord.Quit\n";
    file_put_contents($vbs_path, $vbs);
}

// Convertir Declaracion Jurada
$dj_docx_path  = $tmp_dir . $results['dj_docx'];
$dj_pdf        = str_replace('.docx', '.pdf', $dj_docx_path);
shell_exec("cscript //nologo \"{$vbs_path}\" \"{$dj_docx_path}\" \"{$dj_pdf}\"");
if (file_exists($dj_pdf)) $results['dj_pdf'] = basename($dj_pdf);

// Convertir Pagaré
$pg_docx_path  = $tmp_dir . $results['pagare_docx'];
$pg_pdf        = str_replace('.docx', '.pdf', $pg_docx_path);
shell_exec("cscript //nologo \"{$vbs_path}\" \"{$pg_docx_path}\" \"{$pg_pdf}\"");
if (file_exists($pg_pdf)) $results['pagare_pdf'] = basename($pg_pdf);

// ─────────────────────────────────────────────
// 9. DATOS DE PREVIEW
// ─────────────────────────────────────────────
$preview = [
    'cliente_nombre'    => $nombre_display,
    'dni'               => $dni_cliente,
    'direccion'         => $direccion_cliente,
    'fecha_letras'      => $fecha_contrato_letras,
    'fecha_desembolso'  => $desembolso_display,
    'fecha_vencimiento' => $fecha_vencimiento_raw,
    'telefono'          => $raw('telefono_cliente'),
    'celular'           => $raw('celular_cliente'),
    'email'             => $raw('email_cliente'),
    'prestamo' => [
        'monto'      => 'S/ ' . number_format($monto_prestamo, 2, '.', ','),
        'comision'   => 'S/ ' . number_format($comision, 2, '.', ','),
        'devolucion' => 'S/ ' . number_format($monto_devolucion, 2, '.', ','),
        'en_letras'  => numberToWordsDoc($monto_devolucion) . ' Y 00/100 SOLES',
        'tasa'       => $tasa_interes_display,
        'tasa_moratoria' => number_format($tasa_moratoria, 2) . '%',
        'plazo_dias' => $plazo_dias,
    ],
    'prenda' => [
        'tipo'        => $producto_nombre,
        'descripcion' => $descripcion_prenda,
    ],
    'pagare_num'  => $num_pagare,
    'tipo_personeria' => $tipo_personeria,
    'conyuge' => [
        'nombre'    => $up('nombre_conyuge'),
        'dni'       => $raw('dni_conyuge'),
        'direccion' => $up('direccion_conyuge'),
    ],
];

ob_clean();
echo json_encode([
    'status'  => 'ok',
    'results' => $results,
    'preview' => $preview,
]);
exit;
