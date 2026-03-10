<?php
ob_start();
/**
 * cGuardarDocumentos.php
 * Mueve los 3 documentos adicionales del tmp a la carpeta del cliente.
 * Espera POST: cliente_nombre, dj_docx, pagare_docx, cronograma_xlsx
 * (y opcionalmente dj_pdf, pagare_pdf si la conversión tuvo éxito)
 */

session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_usuario'])) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Sesión no iniciada.']);
    exit;
}

$cliente_nombre    = $_POST['cliente_nombre']    ?? '';
$dj_docx           = basename($_POST['dj_docx']           ?? '');
$dj_pdf            = basename($_POST['dj_pdf']            ?? '');
$pagare_docx       = basename($_POST['pagare_docx']       ?? '');
$pagare_pdf        = basename($_POST['pagare_pdf']        ?? '');
$cronograma_xlsx   = basename($_POST['cronograma_xlsx']   ?? '');

if (!$cliente_nombre || !$dj_docx || !$pagare_docx || !$cronograma_xlsx) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Faltan parámetros. Verifique que los documentos fueron generados.']);
    exit;
}

$base_dir    = realpath(__DIR__ . '/..');
$tmp_dir     = $base_dir . '/tmp_contratos/';
$clientes_dir = $base_dir . '/Clientes/';

// Limpiar nombre del cliente
$safe_nombre = preg_replace('/[^a-zA-Z0-9\s_-]/', '', $cliente_nombre);
$safe_nombre = trim(mb_strimwidth($safe_nombre, 0, 50, ''));
if (empty($safe_nombre)) $safe_nombre = 'CLIENTE_ID_' . time();

$target_dir = $clientes_dir . $safe_nombre . '/';
if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0755, true)) {
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'No se pudo crear la carpeta del cliente.']);
        exit;
    }
}

$errors = [];
$moved  = [];

// Función auxiliar para mover archivo
$moveFile = function(string $filename, string $label) use ($tmp_dir, $target_dir, &$errors, &$moved) {
    if (!$filename) return;
    $src = $tmp_dir . $filename;
    $dst = $target_dir . $filename;
    if (file_exists($src)) {
        if (rename($src, $dst)) {
            $moved[] = $label . ': ' . $filename;
        } else {
            $errors[] = "No se pudo mover $label.";
        }
    }
};

$moveFile($dj_docx,         'Declaración Jurada (DOCX)');
$moveFile($dj_pdf,          'Declaración Jurada (PDF)');
$moveFile($pagare_docx,     'Pagaré (DOCX)');
$moveFile($pagare_pdf,      'Pagaré (PDF)');
$moveFile($cronograma_xlsx, 'Cronograma (XLSX)');

ob_clean();
if (!empty($errors) && empty($moved)) {
    echo json_encode(['status' => 'error', 'message' => implode(' ', $errors)]);
} else {
    echo json_encode([
        'status'   => 'ok',
        'message'  => 'Documentos guardados en la carpeta del cliente.',
        'moved'    => $moved,
        'warnings' => $errors,
        'folder'   => $safe_nombre,
    ]);
}
exit;
