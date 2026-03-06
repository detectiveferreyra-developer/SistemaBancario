<?php
/**
 * cGenerarContrato.php
 * Genera el contrato DOCX a partir de los datos del formulario nuevo-cliente.
 * Llena los placeholders ${VAR} en la plantilla Word correspondiente.
 */

session_start();
header('Content-Type: application/json; charset=utf-8');

// ─────────────────────────────────────────────
// 1. VALIDAR SESIÓN
// ─────────────────────────────────────────────
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Sesión no iniciada.']);
    exit;
}

// ─────────────────────────────────────────────
// 2. DATOS RECIBIDOS
// ─────────────────────────────────────────────
$tipo_personeria = $_POST['tipo_personeria'] ?? '';
$tipo_contrato = $_POST['tipo_contrato'] ?? '';

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
    echo json_encode(['status' => 'error', 'message' => 'Tipo de contrato o personería no válido.']);
    exit;
}

$template_filename = "CONTRATO - PRENDA {$tipo_doc} - {$tipo_pers}.docx";
$template_path = realpath(__DIR__ . '/../Templates/' . $template_filename);

if (!$template_path || !file_exists($template_path)) {
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

// Número de contrato (en producción esto vendría de la BD)
$num_contrato = 'CA-' . $anio . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

// Apoderado CrediÁgil (del servidor / sesión)
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
    $decenas = [
        '',
        '',
        'VEINTE',
        'TREINTA',
        'CUARENTA',
        'CINCUENTA',
        'SESENTA',
        'SETENTA',
        'OCHENTA',
        'NOVENTA'
    ];
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

    function convertGroup(int $n, $u, $d, $c): string
    {
        if ($n === 0)
            return '';
        $str = '';
        $c_idx = intdiv($n, 100);
        $r = $n % 100;
        if ($c_idx > 0) {
            $str .= ($c_idx === 1 && $r > 0) ? 'CIENTO ' : $c[$c_idx] . ' ';
        }
        if ($r > 0) {
            if ($r < 20) {
                $str .= $u[$r] . ' ';
            } elseif ($r === 20) {
                $str .= 'VEINTE ';
            } elseif ($r <= 29) {
                $str .= 'VEINTI' . $u[$r - 20] . ' ';
            } else {
                $d_idx = intdiv($r, 10);
                $u_idx = $r % 10;
                $str .= $d[$d_idx];
                if ($u_idx > 0)
                    $str .= ' Y ' . $u[$u_idx];
                $str .= ' ';
            }
        }
        return $str;
    }

    if ($entero === 0)
        return 'CERO';

    $millones = intdiv($entero, 1000000);
    $miles = intdiv($entero % 1000000, 1000);
    $resto = $entero % 1000;

    $resultado = '';

    if ($millones > 0) {
        $resultado .= ($millones === 1)
            ? 'UN MILLÓN '
            : convertGroup($millones, $unidades, $decenas, $centenas) . 'MILLONES ';
    }
    if ($miles > 0) {
        $resultado .= ($miles === 1)
            ? 'MIL '
            : convertGroup($miles, $unidades, $decenas, $centenas) . 'MIL ';
    }
    if ($resto > 0) {
        $resultado .= convertGroup($resto, $unidades, $decenas, $centenas);
    }

    return rtrim($resultado);
}

// ─────────────────────────────────────────────
// 5. MAPA DE REEMPLAZOS
// ─────────────────────────────────────────────
$p = $_POST; // shorthand

$replacements = [
    // Sistema
    'NUM_CONTRATO' => $num_contrato,
    'SISTEMA_DIA' => $dia,
    'SISTEMA_MES' => $mes_nombre,
    'SISTEMA_MES_TEXTO' => $mes_texto,
    'SISTEMA_MES_NUM' => $mes_num,
    'SISTEMA_ANIO' => $anio,
    'SISTEMA_CIUDAD' => 'LIMA',

    // Apoderado CrediÁgil
    'NOMBRE_APODERADO_CA' => $nombre_apoderado,
    'NOMBRE_APODERADO__CA' => $nombre_apoderado,
    'DNI_APODERADO_CA' => $dni_apoderado,
    'DNI_APODERADO__CA' => $dni_apoderado,

    // Cliente – Persona Natural
    'NOMBRE_CLIENTE' => strtoupper($p['nombre_completo'] ?? ''),
    'DNI_CLIENTE' => $p['dni'] ?? '',
    'DIRECCION_CLIENTE' => strtoupper($p['direccion_cliente'] ?? ''),
    'DISTRITO_CLIENTE' => strtoupper($p['distrito_cliente'] ?? ''),
    'PROVINCIA_CLIENTE' => strtoupper($p['provincia_cliente'] ?? ''),
    'DEPARTAMENTO_CLIENTE' => strtoupper($p['departamento_cliente'] ?? ''),

    // Cónyuge del cliente
    'NOMBRE_CONYUGE' => strtoupper($p['nombre_conyuge'] ?? ''),
    'DNI_CONYUGE' => $p['dni_conyuge'] ?? '',
    'DIRECCION_CONYUGE' => strtoupper($p['direccion_conyuge'] ?? ''),
    'DISTRITO_CONYUGE' => strtoupper($p['distrito_conyuge'] ?? ''),
    'PROVINCIA_CONYUGE' => strtoupper($p['provincia_conyuge'] ?? ''),
    'DEPARTAMENTO_CONYUGE' => strtoupper($p['departamento_conyuge'] ?? ''),

    // Empresa
    'RAZON_SOCIAL' => strtoupper($p['razon_social'] ?? ''),
    'RUC_EMPRESA' => $p['ruc'] ?? '',
    'DIRECCION_FISCAL' => strtoupper($p['domicilio_fiscal'] ?? ''),
    'REP_LEGAL_EMPRESA' => strtoupper($p['representante_legal'] ?? ''),
    'DNI_REP_LEGAL' => $p['dni_representante'] ?? '',
    'DIRECCION_REP_LEGAL' => strtoupper($p['direccion_rep_legal'] ?? ''),
    'DISTRITO_REP_LEGAL' => strtoupper($p['distrito_rep_legal'] ?? ''),
    'PROVINCIA_REP_LEGAL' => strtoupper($p['provincia_rep_legal'] ?? ''),
    'DEPARTAMENTO_REP_LEGAL' => strtoupper($p['departamento_rep_legal'] ?? ''),
    'PARTIDA_EMPRESA' => $p['partida_electronica'] ?? '',
    'ZONA_REGISTRAL' => strtoupper($p['zona_registral'] ?? ''),
    'CIUDAD_REGISTRO' => strtoupper($p['ciudad_registro'] ?? ''),

    // Vehículo (AUTO)
    'AUTO_PLACA' => strtoupper($p['auto_placa'] ?? ''),
    'AUTO__PLACA' => strtoupper($p['auto_placa'] ?? ''),
    'AUTO_MARCA' => strtoupper($p['auto_marca'] ?? ''),
    'AUTO_MODELO' => strtoupper($p['auto_modelo'] ?? ''),
    'AUTO__MODELO' => strtoupper($p['auto_modelo'] ?? ''),
    'AUTO_ANIO' => $p['auto_anio'] ?? '',
    'AUTO_COLOR' => strtoupper($p['auto_color'] ?? ''),
    'AUTO_MOTOR' => strtoupper($p['auto_motor'] ?? ''),
    'AUTO__MOTOR' => strtoupper($p['auto_motor'] ?? ''),
    'AUTO_SERIE' => strtoupper($p['auto_serie'] ?? ''),
    'AUTO_PARTIDA' => $p['auto_partida_registral'] ?? '',
    'AUTO_OFICINA_REGISTRAL' => strtoupper($p['auto_oficina_registral'] ?? ''),
    'AUTO_DESCRIPCION' => strtoupper($p['auto_descripcion'] ?? ''),

    // Joyas
    'JOYA_KILATES' => $p['joya_kilates'] ?? '',
    'JOYA_DESCRIPCION' => strtoupper($p['joyas_descripcion'] ?? ''),
    'JOYA_PESO_BRUTO' => $p['joyas_peso_bruto'] ?? '',
    'JOYA_PESO_NETO' => $p['joyas_peso_neto'] ?? '',
    'JOYA_ESTADO' => strtoupper($p['joya_estado'] ?? ''),

    // Electrodomésticos / Electrónico
    'ELECTRO_MARCA' => strtoupper($p['electro_marca'] ?? ''),
    'ELECTRO_MODELO' => strtoupper($p['electro_modelo'] ?? ''),
    'ELECTRO__MODELO' => strtoupper($p['electro_modelo'] ?? ''),
    'ELECTRO_SERIE' => strtoupper($p['electro_numero_serie'] ?? ''),
    'ELECTRO__SERIE' => strtoupper($p['electro_numero_serie'] ?? ''),
    'ELECTRO_COLOR' => strtoupper($p['electro_color'] ?? ''),
    'ELECTRO_DESCRIPCION' => strtoupper($p['electro_descripcion'] ?? ''),
    'ELECTRO_FABRIC' => strtoupper($p['electro_fabric'] ?? ''),

    // Garante Mobiliario (opcional)
    'NOMBRE_GARANTE' => strtoupper($p['nombre_garante'] ?? ''),
    'DNI_GARANTE' => $p['dni_garante'] ?? '',
    'CONYUGE_GARANTE' => strtoupper($p['conyuge_garante'] ?? ''),
    'DNI_CONYUGE_GARANTE' => $p['dni_conyuge_garante'] ?? '',
    'DOMICILIO_GARANTE' => strtoupper($p['domicilio_garante'] ?? ''),

    // Préstamo
    'MONTO_PRESTAMO' => number_format($monto_prestamo, 2, '.', ','),
    'MONTO_TASACION' => number_format($monto_tasacion, 2, '.', ','),
    'MONTO_DEVOLUCION' => number_format($monto_devolucion, 2, '.', ','),
    'COMISION_TOTAL' => number_format($comision, 2, '.', ','),
    'PLAZO_DIAS' => (string) $plazo_dias,
    'LETRAS_PRESTAMO' => numberToWords($monto_prestamo),
    'LETRAS_TASACION' => numberToWords($monto_tasacion),
    'LETRAS_DEVOLUCION' => numberToWords($monto_devolucion),
];

// ─────────────────────────────────────────────
// 6. ABRIR TEMPLATE, REEMPLAZAR, GUARDAR
// ─────────────────────────────────────────────
$zip = new ZipArchive();
if ($zip->open($template_path) !== true) {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo abrir la plantilla.']);
    exit;
}

// Los archivos XML a procesar dentro del docx
$xml_files = ['word/document.xml', 'word/header1.xml', 'word/footer1.xml'];
$xml_contents = [];

foreach ($xml_files as $xml_file) {
    $content = $zip->getFromName($xml_file);
    if ($content !== false) {
        $xml_contents[$xml_file] = $content;
    }
}
$zip->close();

// Realizar reemplazos en cada archivo XML
foreach ($xml_contents as $xml_file => &$content) {
    foreach ($replacements as $var => $value) {
        // Reemplaza ${ VAR } con o sin espacios
        $content = preg_replace(
            '/\$\{\s*' . preg_quote($var, '/') . '\s*\}/',
            htmlspecialchars($value, ENT_XML1, 'UTF-8'),
            $content
        );
    }
    // Limpiar placeholders no reemplazados
    $content = preg_replace('/\$\{\s*[A-Z_0-9]+\s*\}/', '', $content);
}
unset($content);

// Crear carpeta temporal
$tmp_dir = realpath(__DIR__ . '/..') . '/tmp_contratos/';
if (!is_dir($tmp_dir)) {
    mkdir($tmp_dir, 0755, true);
}

$tmp_filename = $tmp_dir . 'contrato_' . time() . '_' . rand(100, 999) . '.docx';
$download_name = "Contrato_{$num_contrato}_{$tipo_doc}_{$tipo_pers}.docx";

// Copiar plantilla original y sobreescribir los XML modificados
copy($template_path, $tmp_filename);
$zip = new ZipArchive();
if ($zip->open($tmp_filename) !== true) {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo crear el contrato.']);
    exit;
}

foreach ($xml_contents as $xml_file => $content) {
    $zip->deleteName($xml_file);
    $zip->addFromString($xml_file, $content);
}
$zip->close();

// ─────────────────────────────────────────────
// 7. CONSTRUIR DATOS DE PREVIEW
// ─────────────────────────────────────────────
$nombre_display = ($tipo_personeria === 'empresa')
    ? strtoupper($p['razon_social'] ?? '')
    : strtoupper($p['nombre_completo'] ?? '');

$id_display = ($tipo_personeria === 'empresa')
    ? 'RUC: ' . ($p['ruc'] ?? '')
    : 'DNI: ' . ($p['dni'] ?? '');

$dir_display = ($tipo_personeria === 'empresa')
    ? strtoupper($p['domicilio_fiscal'] ?? '')
    : implode(', ', array_filter([
        strtoupper($p['direccion_cliente'] ?? ''),
        strtoupper($p['distrito_cliente'] ?? ''),
        strtoupper($p['provincia_cliente'] ?? ''),
        strtoupper($p['departamento_cliente'] ?? ''),
    ]));

// Preview general del contrato
$tipo_labels = ['auto' => 'Prenda Auto', 'joyas' => 'Prenda Joyas', 'electro' => 'Prenda Electro'];
$pers_labels = ['natural' => 'Persona Natural', 'empresa' => 'Empresa'];

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
        'nombre' => strtoupper($p['nombre_garante'] ?? ''),
        'dni' => $p['dni_garante'] ?? '',
        'domicilio' => strtoupper($p['domicilio_garante'] ?? ''),
    ],
    'bien' => buildBienPreview($tipo_contrato, $p),
];

function buildBienPreview(string $tipo, array $p): array
{
    switch ($tipo) {
        case 'auto':
            return [
                'placa' => strtoupper($p['auto_placa'] ?? ''),
                'marca' => strtoupper($p['auto_marca'] ?? ''),
                'modelo' => strtoupper($p['auto_modelo'] ?? ''),
                'anio' => $p['auto_anio'] ?? '',
                'color' => strtoupper($p['auto_color'] ?? ''),
                'motor' => strtoupper($p['auto_motor'] ?? ''),
                'serie' => strtoupper($p['auto_serie'] ?? ''),
                'partida' => $p['auto_partida_registral'] ?? '',
                'oficina' => strtoupper($p['auto_oficina_registral'] ?? ''),
                'descripcion' => strtoupper($p['auto_descripcion'] ?? ''),
            ];
        case 'joyas':
            return [
                'kilates' => $p['joya_kilates'] ?? '',
                'descripcion' => strtoupper($p['joyas_descripcion'] ?? ''),
                'peso_bruto' => $p['joyas_peso_bruto'] ?? '',
                'peso_neto' => $p['joyas_peso_neto'] ?? '',
                'estado' => strtoupper($p['joya_estado'] ?? ''),
            ];
        case 'electro':
            return [
                'tipo' => strtoupper($p['electro_tipo_bien'] ?? ''),
                'marca' => strtoupper($p['electro_marca'] ?? ''),
                'modelo' => strtoupper($p['electro_modelo'] ?? ''),
                'serie' => strtoupper($p['electro_numero_serie'] ?? ''),
                'color' => strtoupper($p['electro_color'] ?? ''),
                'descripcion' => strtoupper($p['electro_descripcion'] ?? ''),
                'fabricante' => strtoupper($p['electro_fabric'] ?? ''),
            ];
        default:
            return [];
    }
}

echo json_encode([
    'status' => 'ok',
    'docx_filename' => basename($tmp_filename),
    'download_name' => $download_name,
    'preview' => $preview,
]);
exit;
