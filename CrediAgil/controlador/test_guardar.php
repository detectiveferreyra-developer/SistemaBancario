<?php
session_start();
$_SESSION['id_usuario'] = 1;
$_SESSION['usuario_unico'] = 'admin';

$_POST = json_decode('{"tipo_personeria":"natural","nombre_completo":"jorge luna","dni":"12345678","estado_civil":"CASADO(A)","direccion_cliente":"por ahi noma","distrito_cliente":"miraflores","provincia_cliente":"lima","departamento_cliente":"lima","celular_cliente":"12345789","email_cliente":"jorge.luna@gmail.com","nombre_conyuge":"elena lazo","dni_conyuge":"87654321","celular_conyuge":"987654321","direccion_conyuge":"por el otro lado","distrito_conyuge":"lince","provincia_conyuge":"lima","departamento_conyuge":"lima","email_conyuge":"elena.lazo@gmail.com","razon_social":"","ruc":"","domicilio_fiscal":"","distrito_rep_legal":"","provincia_rep_legal":"","departamento_rep_legal":"","representante_legal":"","dni_representante":"","partida_electronica":"","direccion_rep_legal":"","tipo_contrato":"electro","auto_placa":"","auto_marca":"","auto_modelo":"","auto_anio":"","auto_color":"","auto_motor":"","auto_serie":"","auto_partida_registral":"","auto_oficina_registral":"","joyas_material_ley":"","joyas_valorizacion":"","joyas_peso_bruto":"","joyas_peso_neto":"","joyas_descripcion":"","electro_tipo_bien":"123","electro_marca":"123","electro_modelo":"123","electro_numero_serie":"123","electro_color":"456","electro_fabric":"123123","electro_accesorios":"123","monto_prestamo":"1000","plazo_dias":"30","monto_tasacion":"1000","tipo_interes":"monto_fijo","valor_interes":"100","fecha_desembolso":"2026-03-30","tasa_moratoria":"6"}', true);

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Starting cGuardarCliente.php...\n";
require __DIR__ . '/cGuardarCliente.php';
echo "\nFinished testing.\n";
