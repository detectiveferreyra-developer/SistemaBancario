<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=utf-8');

// Log the start of the request
$debugLog = __DIR__ . '/../tmp/debug_save.log';
file_put_contents($debugLog, date('[Y-m-d H:i:s] ') . "Request started\n", FILE_APPEND);
file_put_contents($debugLog, "POST data: " . json_encode($_POST) . "\n", FILE_APPEND);

file_put_contents($debugLog, "Step 1: Connecting to DB\n", FILE_APPEND);
require(__DIR__ . '/../modelo/conexion.php');
require(__DIR__ . '/../modelo/mGestionesCrediAgil.php');

$Gestiones = new GestionesClientes();
$Conexion = new conexion();
$Conexion->conectar('crediagil');
$conectarsistema = $Conexion->establecerconexion;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

file_put_contents($debugLog, "Step 2: Checking session\n", FILE_APPEND);
if (!isset($_SESSION['id_usuario'])) {
    file_put_contents($debugLog, "Step 2.1: No session\n", FILE_APPEND);
    echo json_encode(['status' => 'error', 'message' => 'Sesión no iniciada.']);
    exit;
}

$quien_registro = $_SESSION['usuario_unico'] ?? 'admin';
$tipo_personeria = strtolower(trim($_POST['tipo_personeria'] ?? ''));
$tipo_contrato = strtolower(trim($_POST['tipo_contrato'] ?? ''));

// 1. DATOS DE USUARIO BASE
if ($tipo_personeria === 'natural') {
    $nombres = strtoupper(trim($_POST['nombre_completo'] ?? ''));
    $apellidos = ''; // Se agrupa todo en nombres para natural según DB actual
    $codigo_usuario = trim($_POST['dni'] ?? '');
    $correo = strtolower(trim($_POST['email_cliente'] ?? ''));
    $telefono = trim($_POST['telefono_cliente'] ?? '');
    $celular = trim($_POST['celular_cliente'] ?? '');
    
    // Consolidar dirección completa para DB
    $direccion = strtoupper(implode(', ', array_filter([
        trim($_POST['direccion_cliente'] ?? ''),
        trim($_POST['distrito_cliente'] ?? ''),
        trim($_POST['provincia_cliente'] ?? ''),
        trim($_POST['departamento_cliente'] ?? '')
    ])));
} else {
    $nombres = strtoupper(trim($_POST['razon_social'] ?? ''));
    $apellidos = '';
    $codigo_usuario = trim($_POST['ruc'] ?? '');
    $correo = strtolower(trim($_POST['email_cliente'] ?? '')); 
    $telefono = trim($_POST['telefono_cliente'] ?? '');
    $celular = trim($_POST['celular_cliente'] ?? '');
    
    // Consolidar dirección fiscal
    $direccion = strtoupper(implode(', ', array_filter([
        trim($_POST['domicilio_fiscal'] ?? ''),
        trim($_POST['distrito_rep_legal'] ?? ''),
        trim($_POST['provincia_rep_legal'] ?? ''),
        trim($_POST['departamento_rep_legal'] ?? '')
    ])));
}

if (empty($codigo_usuario)) {
    echo json_encode(['status' => 'error', 'message' => 'Falta el DUI o RUC del cliente.']);
    exit;
}

// Generar contraseña
$cifrado = sha1($conectarsistema->real_escape_string($codigo_usuario));
$contrasenia_hash = crypt($conectarsistema->real_escape_string($codigo_usuario), $cifrado);
$id_rol = 5; // Clientes

file_put_contents($debugLog, "Step 3: Registering in usuarios\n", FILE_APPEND);
// REGISTRAR EN LA TABLA usuarios
$resultado_usuarios = 'ERROR';
try {
    $resultado_usuarios = $Gestiones->RegistroClientesAdministradores(
        $conectarsistema, $nombres, $apellidos, $codigo_usuario, $contrasenia_hash, $correo, $id_rol, $quien_registro
    );
} catch (Exception $e) {
    file_put_contents($debugLog, "MySQL Error in Step 3: " . $e->getMessage() . "\n", FILE_APPEND);
    $error_msg = $e->getMessage();
}

$is_new_user = true;
if ($resultado_usuarios !== 'OK') {
    $error_msg = mysqli_error($conectarsistema);
    // Verificar si el usuario ya existe
    if (strpos($error_msg, 'Duplicate entry') !== false) {
        // Obtenemos el ID existente y continuamos para crear el nuevo crédito
        $is_new_user = false;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo crear el usuario (' . $error_msg . ').']);
        exit;
    }
}

// OBTENER EL ID DEL USUARIO CREADO (O YA EXISTENTE)
$query_id = mysqli_query($conectarsistema, "SELECT idusuarios FROM usuarios WHERE codigousuario = '" . $conectarsistema->real_escape_string($codigo_usuario) . "' LIMIT 1");
$row_id = mysqli_fetch_assoc($query_id);
if (!$row_id) {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo recuperar el ID del usuario.']);
    exit;
}
$id_usuario = $row_id['idusuarios'];

// REGISTRAR DETALLES DEL USUARIO SOLO SI ES NUEVO
if ($is_new_user) {
    $fecha_nac = date('Y-m-d', strtotime('-18 years')); // Default if not provided
    $estado_civil = strtoupper(trim($_POST['estado_civil'] ?? 'NR'));
    $telefono = trim($_POST['telefono_cliente'] ?? '');
    $celular = trim($_POST['celular_cliente'] ?? '');
    $direccion = trim($_POST['direccion_cliente'] ?? '');
    
    $resultado_detalles = $Gestiones->RegistroNuevosDetallesPerfilUsuarios(
        $conectarsistema,
        ($tipo_personeria === 'natural' ? $codigo_usuario : ''), // DUI
        ($tipo_personeria === 'empresa' ? $codigo_usuario : ''), // NIT / RUC
        $telefono,
        $celular,
        '', // telefono trabajo
        $direccion,
        ($tipo_personeria === 'empresa' ? $nombres : ''), // Empresa
        '', // Cargo
        '', // Direccion Trabajo
        $fecha_nac,
        'M', // default
        $estado_civil,
        '', '', '', '', // FOTOS (vacías por ahora)
        $id_usuario
    );
}

// REGISTRAR EL CREDITO
$id_producto = 2; // Por defecto Personales
if ($tipo_contrato === 'auto') {
    $id_producto = 4;
}

$monto_prestamo = floatval($_POST['monto_prestamo'] ?? 0);
$valor_interes = floatval($_POST['valor_interes'] ?? 0);
$tipo_interes = $_POST['tipo_interes'] ?? '';
$plazo_dias = intval($_POST['plazo_dias'] ?? 30);
// Calculo interes/comision
$comision = ($tipo_interes === 'porcentaje') ? ($monto_prestamo * $valor_interes) / 100 : $valor_interes;
$cuota_total = $monto_prestamo + $comision;

$observaciones = "CRÉDITO GARANTÍA MOBILIARIA - TIPO: " . strtoupper($tipo_contrato);
$nombre_conyuge = trim($_POST['nombre_conyuge'] ?? '');
if (!empty($nombre_conyuge)) {
    $dni_conyuge = trim($_POST['dni_conyuge'] ?? '');
    $observaciones .= " | CÓNYUGE: $nombre_conyuge ($dni_conyuge)";
}
$tipo_cliente = ($tipo_personeria === 'empresa') ? 'Empresarial' : 'Natural';

file_put_contents($debugLog, "Step 4: Registering Credit\n", FILE_APPEND);

$resultado_credito = $Gestiones->RegistroNuevaAsignacionesCreditosClientes(
    $conectarsistema,
    $id_usuario,
    $id_producto,
    $tipo_cliente,
    $monto_prestamo,
    $valor_interes, // interes numerico
    $plazo_dias,     // plazo en dias
    $cuota_total,    // Cuota Total o saldo a devolver
    date('Y-m-d'),   // Fecha solicitud
    0,               // Salario cliente (no aplicable a prendario directo)
    $cuota_total,    // Saldo
    $observaciones,
    $quien_registro
);


if ($resultado_credito !== 'OK') {
    file_put_contents($debugLog, "Step 4.1: Credit registration failed\n", FILE_APPEND);
    echo json_encode(['status' => 'error', 'message' => 'El cliente fue creado pero falló el registro del crédito.']);
    exit;
}

file_put_contents($debugLog, "Step 5: Updating profile completion\n", FILE_APPEND);
// UPDATE usuarios SET completoperfil = ...
mysqli_query($conectarsistema, "UPDATE usuarios SET completoperfil = 'si', poseecredito = 'si', habilitarsistema = 'si', nuevousuario = 'no' WHERE idusuarios = $id_usuario");

file_put_contents($debugLog, "Step 6: Success! Sending JSON response\n", FILE_APPEND);
echo json_encode(['status' => 'ok', 'message' => 'Cliente y crédito registrados correctamente.']);
$conectarsistema->close();
?>
