<?php
ob_start();
/**
 * cGenerarContrato.php
 * Genera el contrato DOCX a partir de los datos del formulario nuevo-cliente.
 * Llena los placeholders ${VAR} en la plantilla Word correspondiente.
 *
 * Variables de los templates (67 únicas detectadas):
 * Sistema: NUM_CONTRATO, SISTEMA_DIA, SISTEMA_MES, SISTEMA_MES_NUM, SISTEMA_ANIO,
 *          SISTEMA_CIUDAD, SISTEMA_MES_TEXTO
 * Apoderado: NOMBRE_APODERADO_CA, DNI_APODERADO_CA
 * Persona Natural: NOMBRE_CLIENTE, DNI_CLIENTE, DIRECCION_CLIENTE, DISTRITO_CLIENTE,
 *                  PROVINCIA_CLIENTE, DEPARTAMENTO_CLIENTE
 *                  NOMBRE_CONYUGE, DNI_CONYUGE, DIRECCION_CONYUGE, DISTRITO_CONYUGE,
 *                  PROVINCIA_CONYUGE, DEPARTAMENTO_CONYUGE
 * Empresa: RAZON_SOCIAL, RUC_EMPRESA, DIRECCION_FISCAL, REP_LEGAL_EMPRESA,
 *          DNI_REP_LEGAL, DIRECCION_REP_LEGAL, DISTRITO_REP_LEGAL, PROVINCIA_REP_LEGAL,
 *          DEPARTAMENTO_REP_LEGAL, PARTIDA_EMPRESA, ZONA_REGISTRAL, CIUDAD_REGISTRO
 * Auto: AUTO_PLACA, AUTO_MARCA, AUTO_MODELO, AUTO_ANIO, AUTO_COLOR, AUTO_MOTOR,
 *       AUTO_SERIE, AUTO_PARTIDA, AUTO_OFICINA_REGISTRAL, AUTO_DESCRIPCION
 * Joyas: JOYA_KILATES, JOYA_DESCRIPCION, JOYA_PESO_BRUTO, JOYA_PESO_NETO, JOYA_ESTADO
 * Electro: ELECTRO_MARCA, ELECTRO_MODELO, ELECTRO_SERIE, ELECTRO_COLOR,
 *           ELECTRO_DESCRIPCION, ELECTRO_FABRIC
 * Garante: NOMBRE_GARANTE, DNI_GARANTE, CONYUGE_GARANTE, DNI_CONYUGE_GARANTE,
 *           DOMICILIO_GARANTE
 * Préstamo: MONTO_PRESTAMO, MONTO_TASACION, MONTO_DEVOLUCION, COMISION_TOTAL,
 *           PLAZO_DIAS, LETRAS_PRESTAMO, LETRAS_TASACION, LETRAS_DEVOLUCION
 */

session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header('Content-Type: application/json; charset=utf-8');

// ─────────────────────────────────────────────
// 1. VALIDAR SESIÓN
// ─────────────────────────────────────────────
if (!isset($_SESSION['id_usuario'])) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Sesión no iniciada.']);
    exit;
}

// ─────────────────────────────────────────────
// 2. DATOS RECIBIDOS
// ─────────────────────────────────────────────
$tipo_personeria = strtolower(trim($_POST['tipo_personeria'] ?? ''));
$tipo_contrato = strtolower(trim($_POST['tipo_contrato'] ?? ''));

$tipo_map = [
    'auto' => 'AUTO',
    'joyas' => 'JOYAS',
    'electro' => 'ELECTRO',
];
$tipo_personeria_map = [
    'natural' => 'PERSONA',
    'empresa' => 'EMPRESA',
];

$tipo_doc = $tipo_map[$tipo_contrato] ?? '';
$tipo_pers = $tipo_personeria_map[$tipo_personeria] ?? '';

if (!$tipo_doc || !$tipo_pers) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Tipo de contrato o personería no válido.']);
    exit;
}

$template_filename = "CONTRATO - PRENDA {$tipo_doc} - {$tipo_pers}.docx";
$template_path = realpath(__DIR__ . '/../Templates/' . $template_filename);

if (!$template_path || !file_exists($template_path)) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => "Plantilla no encontrada: {$template_filename}"]);
    exit;
}

// ─────────────────────────────────────────────
// 3. FECHAS Y AUTO-VALORES
// ─────────────────────────────────────────────
$dia = date('d');
$mes_num = date('m');
$anio = date('Y');

$meses_texto = [
    '',
    'ENERO',
    'FEBRERO',
    'MARZO',
    'ABRIL',
    'MAYO',
    'JUNIO',
    'JULIO',
    'AGOSTO',
    'SEPTIEMBRE',
    'OCTUBRE',
    'NOVIEMBRE',
    'DICIEMBRE'
];
$meses_nombre = [
    '',
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
];

$mes_texto = $meses_texto[(int) $mes_num];
$mes_nombre = $meses_nombre[(int) $mes_num];

// Montos
$monto_prestamo = floatval($_POST['monto_prestamo'] ?? 0);
$monto_tasacion = floatval($_POST['monto_tasacion'] ?? 0);
$valor_interes = floatval($_POST['valor_interes'] ?? 0);
$tipo_interes = $_POST['tipo_interes'] ?? '';
$plazo_dias = intval($_POST['plazo_dias'] ?? 30);

$comision = ($tipo_interes === 'porcentaje')
    ? ($monto_prestamo * $valor_interes) / 100
    : $valor_interes;
$monto_devolucion = $monto_prestamo + $comision;

// Número de contrato
$num_contrato = 'CA-' . $anio . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

// Apoderado CrediÁgil (de sesión)
$nombre_apoderado = strtoupper($_SESSION['nombre_completo_usuario'] ?? 'REPRESENTANTE CREDIÁGIL');
$dni_apoderado = $_SESSION['dni_usuario'] ?? '00000000';

// ─────────────────────────────────────────────
// 4. FUNCIÓN: NÚMERO A LETRAS (ESPAÑOL)
// ─────────────────────────────────────────────
function numberToWords(float $num): string
{
    $num = round($num, 2);
    $entero = (int) floor($num);

    $unidades = [
        '',
        'UNO',
        'DOS',
        'TRES',
        'CUATRO',
        'CINCO',
        'SEIS',
        'SIETE',
        'OCHO',
        'NUEVE',
        'DIEZ',
        'ONCE',
        'DOCE',
        'TRECE',
        'CATORCE',
        'QUINCE',
        'DIECISÉIS',
        'DIECISIETE',
        'DIECIOCHO',
        'DIECINUEVE'
    ];
    $decenas = ['', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
    $centenas = [
        '',
        'CIEN',
        'DOSCIENTOS',
        'TRESCIENTOS',
        'CUATROCIENTOS',
        'QUINIENTOS',
        'SEISCIENTOS',
        'SETECIENTOS',
        'OCHOCIENTOS',
        'NOVECIENTOS'
    ];

    $convertGroup = function (int $n) use ($unidades, $decenas, $centenas): string {
        if ($n === 0)
            return '';
        $str = '';
        $c_idx = intdiv($n, 100);
        $r = $n % 100;
        if ($c_idx > 0) {
            $str .= ($c_idx === 1 && $r > 0) ? 'CIENTO ' : $centenas[$c_idx] . ' ';
        }
        if ($r > 0) {
            if ($r < 20) {
                $str .= $unidades[$r] . ' ';
            } elseif ($r === 20) {
                $str .= 'VEINTE ';
            } elseif ($r <= 29) {
                $str .= 'VEINTI' . $unidades[$r - 20] . ' ';
            } else {
                $d_idx = intdiv($r, 10);
                $u_idx = $r % 10;
                $str .= $decenas[$d_idx];
                if ($u_idx > 0)
                    $str .= ' Y ' . $unidades[$u_idx];
                $str .= ' ';
            }
        }
        return $str;
    };

    if ($entero === 0)
        return 'CERO';

    $millones = intdiv($entero, 1000000);
    $miles = intdiv($entero % 1000000, 1000);
    $resto = $entero % 1000;
    $resultado = '';

    if ($millones > 0) {
        $resultado .= ($millones === 1) ? 'UN MILLÓN ' : $convertGroup($millones) . 'MILLONES ';
    }
    if ($miles > 0) {
        $resultado .= ($miles === 1) ? 'MIL ' : $convertGroup($miles) . 'MIL ';
    }
    if ($resto > 0) {
        $resultado .= $convertGroup($resto);
    }

    return rtrim($resultado);
}

// ─────────────────────────────────────────────
// 5. MAPA DE REEMPLAZOS (todos los templates)
// ─────────────────────────────────────────────
$p = $_POST; // shorthand

// Helper para obtener un campo limpio en MAYÚSCULAS
$up = function (string $key, string $default = '') use ($p): string {
    return strtoupper(trim($p[$key] ?? $default));
};
$raw = function (string $key, string $default = '') use ($p): string {
    return trim($p[$key] ?? $default);
};

$replacements = [
    // ── Sistema ──────────────────────────────────────────────────────────
    'NUM_CONTRATO' => $num_contrato,
    'SISTEMA_DIA' => $dia,
    'SISTEMA_MES' => $mes_nombre,
    'SISTEMA_MES_TEXTO' => $mes_texto,
    'SISTEMA_MES_NUM' => $mes_num,
    'SISTEMA_ANIO' => $anio,
    'SISTEMA_CIUDAD' => 'LIMA',

    // ── Apoderado CrediÁgil ───────────────────────────────────────────────
    'NOMBRE_APODERADO_CA' => $nombre_apoderado,
    'DNI_APODERADO_CA' => $dni_apoderado,

    // ── Persona Natural ───────────────────────────────────────────────────
    'NOMBRE_CLIENTE' => $up('nombre_completo'),
    'DNI_CLIENTE' => $raw('dni'),
    'DIRECCION_CLIENTE' => $up('direccion_cliente'),
    'DISTRITO_CLIENTE' => $up('distrito_cliente'),
    'PROVINCIA_CLIENTE' => $up('provincia_cliente'),
    'DEPARTAMENTO_CLIENTE' => $up('departamento_cliente'),

    // Cónyuge del cliente (persona natural)
    'NOMBRE_CONYUGE' => $up('nombre_conyuge'),
    'DNI_CONYUGE' => $raw('dni_conyuge'),
    'DIRECCION_CONYUGE' => $up('direccion_conyuge'),
    'DISTRITO_CONYUGE' => $up('distrito_conyuge'),
    'PROVINCIA_CONYUGE' => $up('provincia_conyuge'),
    'DEPARTAMENTO_CONYUGE' => $up('departamento_conyuge'),

    // ── Empresa ───────────────────────────────────────────────────────────
    'RAZON_SOCIAL' => $up('razon_social'),
    'RUC_EMPRESA' => $raw('ruc'),
    'DIRECCION_FISCAL' => $up('domicilio_fiscal'),
    'REP_LEGAL_EMPRESA' => $up('representante_legal'),
    'DNI_REP_LEGAL' => $raw('dni_representante'),
    'DIRECCION_REP_LEGAL' => $up('direccion_rep_legal'),
    'DISTRITO_REP_LEGAL' => $up('distrito_rep_legal'),
    'PROVINCIA_REP_LEGAL' => $up('provincia_rep_legal'),
    'DEPARTAMENTO_REP_LEGAL' => $up('departamento_rep_legal'),
    'PARTIDA_EMPRESA' => $raw('partida_electronica'),
    'ZONA_REGISTRAL' => $up('zona_registral'),
    'CIUDAD_REGISTRO' => $up('ciudad_registro'),

    // ── Vehículo (AUTO) ───────────────────────────────────────────────────
    'AUTO_PLACA' => $up('auto_placa'),
    'AUTO_MARCA' => $up('auto_marca'),
    'AUTO_MODELO' => $up('auto_modelo'),
    'AUTO_ANIO' => $raw('auto_anio'),
    'AUTO_COLOR' => $up('auto_color'),
    'AUTO_MOTOR' => $up('auto_motor'),
    'AUTO_SERIE' => $up('auto_serie'),
    'AUTO_PARTIDA' => $raw('auto_partida_registral'),
    'AUTO_OFICINA_REGISTRAL' => $up('auto_oficina_registral'),
    'AUTO_DESCRIPCION' => $up('auto_descripcion'),

    // ── Joyas ─────────────────────────────────────────────────────────────
    'JOYA_KILATES' => $raw('joya_kilates'),
    'JOYA_DESCRIPCION' => $up('joyas_descripcion'),
    'JOYA_PESO_BRUTO' => $raw('joyas_peso_bruto'),
    'JOYA_PESO_NETO' => $raw('joyas_peso_neto'),
    'JOYA_ESTADO' => $up('joya_estado'),

    // ── Electrodomésticos ─────────────────────────────────────────────────
    'ELECTRO_MARCA' => $up('electro_marca'),
    'ELECTRO_MODELO' => $up('electro_modelo'),
    'ELECTRO_SERIE' => $up('electro_numero_serie'),
    'ELECTRO_COLOR' => $up('electro_color'),
    'ELECTRO_DESCRIPCION' => $up('electro_descripcion'),
    'ELECTRO_FABRIC' => $up('electro_fabric'),

    // ── Garante ───────────────────────────────────────────────────────────
    'NOMBRE_GARANTE' => $up('nombre_garante'),
    'DNI_GARANTE' => $raw('dni_garante'),
    'CONYUGE_GARANTE' => $up('conyuge_garante'),
    'DNI_CONYUGE_GARANTE' => $raw('dni_conyuge_garante'),
    'DOMICILIO_GARANTE' => $up('domicilio_garante'),

    // ── Préstamo ──────────────────────────────────────────────────────────
    'MONTO_PRESTAMO' => 'S/ ' . number_format($monto_prestamo, 2, '.', ','),
    'MONTO_TASACION' => 'S/ ' . number_format($monto_tasacion, 2, '.', ','),
    'MONTO_DEVOLUCION' => 'S/ ' . number_format($monto_devolucion, 2, '.', ','),
    'COMISION_TOTAL' => 'S/ ' . number_format($comision, 2, '.', ','),
    'PLAZO_DIAS' => (string) $plazo_dias,
    'LETRAS_PRESTAMO' => numberToWords($monto_prestamo),
    'LETRAS_TASACION' => numberToWords($monto_tasacion),
    'LETRAS_DEVOLUCION' => numberToWords($monto_devolucion),
];

// ─────────────────────────────────────────────
// 6. ABRIR TEMPLATE, REEMPLAZAR, GUARDAR (USANDO TemplateProcessor)
// ─────────────────────────────────────────────
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($template_path);

    // Reemplazar todas las variables
    foreach ($replacements as $key => $value) {
        $templateProcessor->setValue($key, $value);
    }

    // ─────────────────────────────────────────────
    // 7. ESCRIBIR EL DOCX RESULTADO
    // ─────────────────────────────────────────────
    $tmp_dir = realpath(__DIR__ . '/..') . '/tmp_contratos/';
    if (!is_dir($tmp_dir)) {
        mkdir($tmp_dir, 0755, true);
    }

    $tmp_filename = $tmp_dir . 'contrato_' . time() . '_' . rand(100, 999) . '.docx';
    $download_name = "Contrato_{$num_contrato}_{$tipo_doc}_{$tipo_pers}.docx";

    $templateProcessor->saveAs($tmp_filename);

} catch (Exception $e) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Error procesando la plantilla: ' . $e->getMessage()]);
    exit;
}

// ─────────────────────────────────────────────
// 7.5. GENERAR EL PDF CON MS WORD (VBSCRIPT)
// ─────────────────────────────────────────────
$pdf_filename = str_replace('.docx', '.pdf', $tmp_filename);

// Crear el script VBS si no existe
$vbs_path = $tmp_dir . 'convert.vbs';
if (!file_exists($vbs_path)) {
    $vbs_content = "Set objWord = CreateObject(\"Word.Application\")\n";
    $vbs_content .= "objWord.Visible = False\n";
    $vbs_content .= "Set objDoc = objWord.Documents.Open(WScript.Arguments(0))\n";
    $vbs_content .= "objDoc.SaveAs WScript.Arguments(1), 17\n";
    $vbs_content .= "objDoc.Close\n";
    $vbs_content .= "objWord.Quit\n";
    file_put_contents($vbs_path, $vbs_content);
}

// Ejecutar el script VBS para la conversión
$command = "cscript //nologo \"$vbs_path\" \"$tmp_filename\" \"$pdf_filename\"";
shell_exec($command);

// ─────────────────────────────────────────────
// 8. DATOS DE PREVIEW
// ─────────────────────────────────────────────
$nombre_display = ($tipo_personeria === 'empresa')
    ? $up('razon_social')
    : $up('nombre_completo');

$id_display = ($tipo_personeria === 'empresa')
    ? 'RUC: ' . $raw('ruc')
    : 'DNI: ' . $raw('dni');

$dir_display = ($tipo_personeria === 'empresa')
    ? $up('domicilio_fiscal')
    : implode(', ', array_filter([
        $up('direccion_cliente'),
        $up('distrito_cliente'),
        $up('provincia_cliente'),
        $up('departamento_cliente'),
    ]));

$tipo_labels = ['auto' => 'Prenda Auto', 'joyas' => 'Prenda Joyas', 'electro' => 'Prenda Electro'];
$pers_labels = ['natural' => 'Persona Natural', 'empresa' => 'Empresa'];

// Preview del bien según tipo
$bien_preview = [];
switch ($tipo_contrato) {
    case 'auto':
        $bien_preview = [
            'Placa' => $up('auto_placa'),
            'Marca' => $up('auto_marca'),
            'Modelo' => $up('auto_modelo'),
            'Año' => $raw('auto_anio'),
            'Color' => $up('auto_color'),
            'Motor' => $up('auto_motor'),
            'Serie/Chasis' => $up('auto_serie'),
            'Partida Registral' => $raw('auto_partida_registral'),
            'Oficina Registral' => $up('auto_oficina_registral'),
            'Descripción' => $up('auto_descripcion'),
        ];
        break;
    case 'joyas':
        $bien_preview = [
            'Kilates' => $raw('joya_kilates'),
            'Descripción' => $up('joyas_descripcion'),
            'Peso Bruto' => $raw('joyas_peso_bruto') . ' gr',
            'Peso Neto' => $raw('joyas_peso_neto') . ' gr',
            'Estado' => $up('joya_estado'),
        ];
        break;
    case 'electro':
        $bien_preview = [
            'Marca' => $up('electro_marca'),
            'Modelo' => $up('electro_modelo'),
            'N° Serie' => $up('electro_numero_serie'),
            'Color' => $up('electro_color'),
            'Descripción' => $up('electro_descripcion'),
            'Fabricante' => $up('electro_fabric'),
        ];
        break;
}

$preview = [
    'num_contrato' => $num_contrato,
    'tipo_contrato' => $tipo_labels[$tipo_contrato] ?? $tipo_contrato,
    'tipo_personeria' => $pers_labels[$tipo_personeria] ?? $tipo_personeria,
    'fecha' => intval($dia) . ' de ' . $mes_nombre . ' de ' . $anio,
    'ciudad' => 'Lima',
    'cliente' => [
        'nombre' => $nombre_display,
        'id' => $id_display,
        'direccion' => $dir_display,
    ],
    'prestamo' => [
        'monto' => 'S/ ' . number_format($monto_prestamo, 2, '.', ','),
        'tasacion' => 'S/ ' . number_format($monto_tasacion, 2, '.', ','),
        'comision' => 'S/ ' . number_format($comision, 2, '.', ','),
        'total' => 'S/ ' . number_format($monto_devolucion, 2, '.', ','),
        'plazo' => $plazo_dias . ' días calendario',
        'letras_prestamo' => numberToWords($monto_prestamo),
        'letras_devolucion' => numberToWords($monto_devolucion),
    ],
    'garante' => [
        'nombre' => $up('nombre_garante'),
        'dni' => $raw('dni_garante'),
        'domicilio' => $up('domicilio_garante'),
        'conyuge' => $up('conyuge_garante'),
    ],
    'bien' => $bien_preview,
];

ob_clean();
echo json_encode([
    'status' => 'ok',
    'docx_filename' => basename($tmp_filename),
    'pdf_filename' => basename($pdf_filename),
    'download_name' => $download_name,
    'preview' => $preview,
]);
exit;
