<?php
ob_start();
/**
 * cGuardarContrato.php
 * Mueve el documento .docx temporal a la carpeta final del cliente de forma permanente.
 */

session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_usuario'])) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Sesión no iniciada.']);
    exit;
}

$docx_filename = $_POST['docx_filename'] ?? '';
$cliente_nombre = $_POST['cliente_nombre'] ?? '';

if (!$docx_filename || !$cliente_nombre) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Faltan parámetros obligatorios.']);
    exit;
}

// Rutas base
$base_dir = realpath(__DIR__ . '/..');
$tmp_dir = $base_dir . '/tmp_contratos/';
$clientes_dir = $base_dir . '/Clientes/';

$src_path = $tmp_dir . basename($docx_filename);

if (!file_exists($src_path)) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'El contrato temporal no existe o expiró.']);
    exit;
}

// Limpiar nombre del cliente para nombre de carpeta
// Remover caracteres no alfanuméricos excepto espacios, y limitar longitud
$safe_cliente_nombre = preg_replace('/[^a-zA-Z0-9\s_-]/', '', $cliente_nombre);
$safe_cliente_nombre = trim(mb_strimwidth($safe_cliente_nombre, 0, 50, ''));

if (empty($safe_cliente_nombre)) {
    $safe_cliente_nombre = 'CLIENTE_ID_' . time();
}

$target_dir = $clientes_dir . $safe_cliente_nombre . '/';

// Crear carpeta del cliente si no existe
if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0755, true)) {
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'No se pudo crear la carpeta para el cliente.']);
        exit;
    }
}

// Renombrar el archivo al guardarlo
$target_path = $target_dir . basename($docx_filename);
$pdf_filename = str_replace('.docx', '.pdf', basename($docx_filename));
$src_pdf = $tmp_dir . $pdf_filename;
$target_pdf = $target_dir . $pdf_filename;

ob_clean();
if (rename($src_path, $target_path)) {
    if (file_exists($src_pdf)) {
        rename($src_pdf, $target_pdf);
    }
    // Éxito
    echo json_encode(['status' => 'ok', 'message' => 'Contrato guardado exitosamente.', 'path' => $target_path, 'pdf_path' => $target_pdf]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al mover el archivo a la carpeta del cliente.']);
}
exit;
