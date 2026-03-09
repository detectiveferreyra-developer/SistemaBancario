<?php
session_start();
$_SESSION['id_usuario'] = 1;
$_SESSION['nombre_completo_usuario'] = 'ADMINISTRADOR PRUEBA';
$_SESSION['dni_usuario'] = '11111111';

$_POST = [
    'tipo_personeria' => 'natural',
    'tipo_contrato' => 'auto',
    'nombre_completo' => 'Perez Rojas, Juan',
    'dni' => '12345678',
    'direccion_cliente' => 'Av. Los Próceres 123',
    'distrito_cliente' => 'San Juan',
    'provincia_cliente' => 'Lima',
    'departamento_cliente' => 'Lima',
    'auto_placa' => 'A1B-234',
    'auto_marca' => 'Toyota',
    'auto_modelo' => 'Corolla',
    'auto_anio' => '2020',
    'auto_color' => 'Rojo',
    'auto_motor' => 'M-123',
    'auto_serie' => 'S-456',
    'auto_partida_registral' => '9999',
    'auto_oficina_registral' => 'Lima',
    'monto_prestamo' => '5000',
    'monto_tasacion' => '7000',
    'tipo_interes' => 'porcentaje',
    'valor_interes' => '10',
    'plazo_dias' => '30',
    'fecha_desembolso' => '2026-03-09'
];

require 'cGenerarContrato.php';
