<?php
// IMPORTANDO MODELO DE CONTEO NUMERO DE NOTIFICACIONES RECIBIDAS
require('../modelo/mConteoNotificacionesRecibidasUsuarios.php');
// IMPORTANDO MODELO DE CONTEO NUMERO DE MENSAJES RECIBIDOS

// DATOS DE LOCALIZACION -> IDIOMA ESPAOL -> ZONA HORARIA EL SALVADOR (UTC-6)
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/El_Salvador');
// OBTENER HORA LOCAL
$hora = new DateTime("now");
/*
    -> VALIDACION DE PARAMETROS PRINCIPALES DEL SISTEMA
*/
// VALIDACION DE PARAMETRO CrediAgilgestion -> SI NO EXISTE MOSTRAR PAGINA 404 ERROR
if (!isset($_GET['CrediAgilgestion'])) {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=error-404');
}
// SI LOS USUARIOS INICIAN POR PRIMERA VEZ, MOSTRAR PAGINA DONDE DEBERAN REALIZAR EL CAMBIO OBLIGATORIO DE SU CONTRASEA GENERADA AUTOMATICAMENTE
if ($_SESSION['comprobar_iniciosesion_primeravez'] == "si") {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=gestiones-nuevos-usuarios-registrados');
    // CASO CONTRARIO, MOSTRAR PORTAL DE USUARIOS -> SEGUN ROL DE USUARIO ASIGNADO
} else {
    ?>
    <!DOCTYPE html>
    <html lang="ES-SV">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>CrediAgil | Nuevo Cliente</title>
        <!-- Favicon icon -->
        <link rel="apple-touch-icon" sizes="57x57"
            href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-57x57.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <link href="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/css/bootstrap-select.min.css"
            rel="stylesheet">
        <link href="<?php echo $UrlGlobal; ?>vista/css/style.css" rel="stylesheet">
        <!-- CrediAgil Corporate Theme -->
        <link href="<?php echo $UrlGlobal; ?>vista/css/crediagil-theme.css" rel="stylesheet">
        <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
        <style>
            /* INSTITUTIONAL GRAPHITE THEME */
            .stepper-container {
                background: #ffffff;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                padding: 2rem;
                margin: 2rem 0;
            }

            .stepper-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 3rem;
                position: relative;
            }

            .stepper-header::before {
                content: '';
                position: absolute;
                top: 20px;
                left: 0;
                right: 0;
                height: 2px;
                background: #e0e0e0;
                z-index: 0;
            }

            .step {
                flex: 1;
                text-align: center;
                position: relative;
                z-index: 1;
            }

            .step-circle {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #e0e0e0;
                color: #666;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                margin-bottom: 0.5rem;
                transition: all 0.3s ease;
            }

            .step.active .step-circle {
                background: #FF6B35;
                color: #ffffff;
                box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
            }

            .step.completed .step-circle {
                background: #28a745;
                color: #ffffff;
            }

            .step-label {
                font-size: 0.875rem;
                color: #666;
                font-weight: 500;
            }

            .step.active .step-label {
                color: #FF6B35;
                font-weight: 600;
            }

            .step-content {
                display: none;
            }

            .step-content.active {
                display: block;
                animation: fadeIn 0.3s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .form-group label {
                font-weight: 600;
                color: #2c3e50;
                margin-bottom: 0.5rem;
            }

            .form-control {
                border: 1px solid #d1d5db;
                border-radius: 6px;
                padding: 0.75rem;
                transition: all 0.2s ease;
            }

            .form-control:focus {
                border-color: #FF6B35;
                box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
            }

            .btn-primary {
                background: #FF6B35;
                border: none;
                padding: 0.75rem 2rem;
                border-radius: 6px;
                font-weight: 600;
                transition: all 0.2s ease;
            }

            .btn-primary:hover {
                background: #e55a28;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
            }

            .btn-secondary {
                background: #6c757d;
                border: none;
                padding: 0.75rem 2rem;
                border-radius: 6px;
                font-weight: 600;
            }

            .btn-secondary:hover {
                background: #5a6268;
            }

            .calculator-result {
                background: #f8f9fa;
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                padding: 1.5rem;
                margin-top: 1rem;
            }

            .calculator-result h4 {
                color: #FF6B35;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .result-item {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem 0;
                border-bottom: 1px solid #e0e0e0;
            }

            .result-item:last-child {
                border-bottom: none;
                font-size: 1.25rem;
                font-weight: 700;
                color: #FF6B35;
            }

            .review-section {
                background: #f8f9fa;
                border-radius: 6px;
                padding: 1.5rem;
                margin-bottom: 1rem;
            }

            .review-section h5 {
                color: #FF6B35;
                font-weight: 700;
                margin-bottom: 1rem;
                border-bottom: 2px solid #FF6B35;
                padding-bottom: 0.5rem;
            }

            .review-item {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem 0;
            }

            .review-item strong {
                color: #2c3e50;
            }

            .required-field::after {
                content: ' *';
                color: #dc3545;
            }
        </style>
    </head>

    <body class="has-topnav">

        <!--**********************************
            Main wrapper start
        ***********************************-->
        <div id="main-wrapper">
            <?php require('../vista/MenuNavegacion/navbar-administradores.php'); ?>

            <!--**********************************
Nav header start
***********************************-->
            <div class="nav-header">
                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales"
                    class="brand-logo">
                    <img class="logo-abbr" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                    <img class="logo-compact" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                    <img class="brand-title" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                </a>
            </div>
            <!--**********************************
Nav header end
***********************************-->



            <!--**********************************
            Sidebar start
        ***********************************-->
            <?php require('../vista/MenuNavegacion/menu-administradores.php'); ?>
            <!--**********************************
            Sidebar end
        ***********************************-->

            <!--**********************************
            Content body start
        ***********************************-->
            <div class="content-body">
                <div class="container-fluid">
                    <!-- Page title -->
                    <div class="row page-titles mx-0">
                        <div class="col-sm-6 p-md-0">
                            <div class="welcome-text">
                                <h4>Nuevo Cliente</h4>
                                <p class="mb-0">Registro de cliente con garantia mobiliaria</p>
                            </div>
                        </div>
                        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales">Inicio</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Nuevo Cliente</a></li>
                            </ol>
                        </div>
                    </div>

                    <!-- Stepper Form -->
                    <div class="row">
                        <div class="col-12">
                            <div class="stepper-container">
                                <!-- Stepper Header -->
                                <div class="stepper-header">
                                    <div class="step active" data-step="1">
                                        <div class="step-circle">1</div>
                                        <div class="step-label">Datos del Cliente</div>
                                    </div>
                                    <div class="step" data-step="2">
                                        <div class="step-circle">2</div>
                                        <div class="step-label">Datos de la Prenda</div>
                                    </div>
                                    <div class="step" data-step="3">
                                        <div class="step-circle">3</div>
                                        <div class="step-label">Configuracion del Prestamo</div>
                                    </div>
                                    <div class="step" data-step="4">
                                        <div class="step-circle">4</div>
                                        <div class="step-label">Revision y Confirmacion</div>
                                    </div>
                                </div>

                                <!-- Form -->
                                <form id="nuevo-cliente-form">
                                    <!-- Step 1: Datos del Cliente -->
                                    <div class="step-content active" data-step="1">
                                        <h5 class="mb-4" style="color: #FF6B35; font-weight: 700;">Perfil del Cliente</h5>

                                        <!-- Selector de Tipo de Personeria -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="required-field">Tipo de Personeria</label>
                                                    <select class="form-control" id="tipo_personeria" name="tipo_personeria"
                                                        required>
                                                        <option value="">Seleccione...</option>
                                                        <option value="natural">Persona Natural</option>
                                                        <option value="empresa">Empresa</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campos para Persona Natural -->
                                        <div id="campos_persona_natural" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Nombre Completo</label>
                                                        <input type="text" class="form-control" id="nombre_completo"
                                                            name="nombre_completo"
                                                            placeholder="Ej: Juan Carlos Perez Lopez">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">DNI / DUI</label>
                                                        <input type="text" class="form-control" id="dni" name="dni"
                                                            placeholder="Ej: 12345678-9" maxlength="10">
                                                        <small class="form-text text-muted">Formato: 12345678-9</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Datos del Conyuge (Opcionales) -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">
                                                        Datos del Conyuge <small class="text-muted">(Opcional - dejar vacio
                                                            si no aplica)</small>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nombre del Conyuge</label>
                                                        <input type="text" class="form-control" id="nombre_conyuge"
                                                            name="nombre_conyuge"
                                                            placeholder="Ej: Maria Elena Garcia Rodriguez">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>DNI del Conyuge</label>
                                                        <input type="text" class="form-control" id="dni_conyuge"
                                                            name="dni_conyuge" placeholder="Ej: 98765432-1" maxlength="10">
                                                        <small class="form-text text-muted">Formato: 98765432-1</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Domicilio del Cliente -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-3 mb-3" style="color: #6c757d; font-weight: 600;">
                                                        Domicilio del Cliente</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Direccion Completa</label>
                                                        <input type="text" class="form-control" id="domicilio_calle"
                                                            name="domicilio_calle"
                                                            placeholder="Ej: Av. Los Pinos 123, Urb. Las Flores">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Urbanizacion</label>
                                                        <input type="text" class="form-control" id="domicilio_urbanizacion"
                                                            name="domicilio_urbanizacion" placeholder="Ej: Las Flores">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Manzana</label>
                                                        <input type="text" class="form-control" id="domicilio_manzana"
                                                            name="domicilio_manzana" placeholder="Ej: A">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Lote</label>
                                                        <input type="text" class="form-control" id="domicilio_lote"
                                                            name="domicilio_lote" placeholder="Ej: 5">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Campos para Empresa -->
                                        <div id="campos_empresa" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Razon Social</label>
                                                        <input type="text" class="form-control" id="razon_social"
                                                            name="razon_social" placeholder="Ej: Inversiones ABC E.I.R.L.">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">RUC</label>
                                                        <input type="text" class="form-control" id="ruc" name="ruc"
                                                            placeholder="Ej: 20601767920" maxlength="11">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Domicilio Fiscal</label>
                                                        <input type="text" class="form-control" id="domicilio_fiscal"
                                                            name="domicilio_fiscal"
                                                            placeholder="Ej: Jr. Las Alenas 200, Lima">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-3 mb-2" style="color:#6c757d;font-weight:600;">
                                                        Representante Legal</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Nombre del Representante Legal</label>
                                                        <input type="text" class="form-control" id="representante_legal"
                                                            name="representante_legal" placeholder="Ej: Carlos Martinez">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">DNI del Representante</label>
                                                        <input type="text" class="form-control" id="dni_representante"
                                                            name="dni_representante" placeholder="Ej: 12345678"
                                                            maxlength="8">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Partida Electronica N#</label>
                                                        <input type="text" class="form-control" id="partida_electronica"
                                                            name="partida_electronica" placeholder="Ej: 13782080">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Step 2: Datos de la Prenda -->
                                    <div class="step-content" data-step="2">
                                        <h5 class="mb-4" style="color: #FF6B35; font-weight: 700;">Detalles de la Prenda
                                            (Garantia Mobiliaria)</h5>

                                        <!-- Selector de Tipo de Contrato -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="required-field">Tipo de Contrato</label>
                                                    <select class="form-control" id="tipo_contrato" name="tipo_contrato"
                                                        required>
                                                        <option value="">Seleccione...</option>
                                                        <option value="auto">Prenda Auto</option>
                                                        <option value="joyas">Prenda Joyas</option>
                                                        <option value="electro">Prenda Electro</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campos para Prenda AUTO -->
                                        <div id="campos_auto" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Placa</label>
                                                        <input type="text" class="form-control" id="auto_placa"
                                                            name="auto_placa" placeholder="Ej: P123456">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Marca</label>
                                                        <input type="text" class="form-control" id="auto_marca"
                                                            name="auto_marca" placeholder="Ej: Toyota">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Modelo</label>
                                                        <input type="text" class="form-control" id="auto_modelo"
                                                            name="auto_modelo" placeholder="Ej: Corolla">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Ano</label>
                                                        <input type="number" class="form-control" id="auto_anio"
                                                            name="auto_anio" placeholder="Ej: 2020" min="1900" max="2099">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Color</label>
                                                        <input type="text" class="form-control" id="auto_color"
                                                            name="auto_color" placeholder="Ej: Blanco">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Motor</label>
                                                        <input type="text" class="form-control" id="auto_motor"
                                                            name="auto_motor" placeholder="Ej: ABC123456">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Serie</label>
                                                        <input type="text" class="form-control" id="auto_serie"
                                                            name="auto_serie" placeholder="Ej: XYZ789012">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Partida Registral</label>
                                                        <input type="text" class="form-control" id="auto_partida_registral"
                                                            name="auto_partida_registral" placeholder="Ej: 123456">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required-field">Oficina Registral</label>
                                                        <input type="text" class="form-control" id="auto_oficina_registral"
                                                            name="auto_oficina_registral" placeholder="Ej: San Salvador">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campos para Prenda JOYAS -->
                                        <div id="campos_joyas" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Material / Ley</label>
                                                        <input type="text" class="form-control" id="joyas_material_ley"
                                                            name="joyas_material_ley" placeholder="Ej: Oro 18k">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Valorizacion (S/)</label>
                                                        <input type="number" class="form-control" id="joyas_valorizacion"
                                                            name="joyas_valorizacion" placeholder="Ej: 5000" step="0.01">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Peso Bruto (g)</label>
                                                        <input type="number" class="form-control" id="joyas_peso_bruto"
                                                            name="joyas_peso_bruto" placeholder="Ej: 25.5" step="0.01">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Peso Neto (g)</label>
                                                        <input type="number" class="form-control" id="joyas_peso_neto"
                                                            name="joyas_peso_neto" placeholder="Ej: 24.0" step="0.01">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="required-field">Descripcion Detallada</label>
                                                        <textarea class="form-control" id="joyas_descripcion"
                                                            name="joyas_descripcion" rows="3"
                                                            placeholder="Ej: Anillo de oro 18k con diamante central..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Campos para Prenda ELECTRO -->
                                        <div id="campos_electro" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Tipo de Bien</label>
                                                        <input type="text" class="form-control" id="electro_tipo_bien"
                                                            name="electro_tipo_bien" placeholder="Ej: Laptop, Televisor">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Marca</label>
                                                        <input type="text" class="form-control" id="electro_marca"
                                                            name="electro_marca" placeholder="Ej: Samsung">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Modelo</label>
                                                        <input type="text" class="form-control" id="electro_modelo"
                                                            name="electro_modelo" placeholder="Ej: Galaxy Book Pro">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="required-field">Numero de Serie</label>
                                                        <input type="text" class="form-control" id="electro_numero_serie"
                                                            name="electro_numero_serie" placeholder="Ej: SN123456789ABC">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Color</label>
                                                        <input type="text" class="form-control" id="electro_color"
                                                            name="electro_color" placeholder="Ej: Negro, Plateado">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fabricante / Ano</label>
                                                        <input type="text" class="form-control" id="electro_fabric"
                                                            name="electro_fabric" placeholder="Ej: Samsung / 2022">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Accesorios</label>
                                                        <input type="text" class="form-control" id="electro_accesorios"
                                                            name="electro_accesorios"
                                                            placeholder="Ej: Cargador original, Funda">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Step 3: Configuracion del Prestamo -->
                                    <div class="step-content" data-step="3">
                                        <h5 class="mb-4" style="color: #FF6B35; font-weight: 700;">Configuracion del
                                            Prestamo</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-field">Monto del Prestamo (S/)</label>
                                                    <input type="number" class="form-control" id="monto_prestamo"
                                                        name="monto_prestamo" placeholder="Ej: 10000" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="required-field">Plazo (dias)</label>
                                                    <input type="number" class="form-control" id="plazo_dias"
                                                        name="plazo_dias" value="30" min="1" max="365" required>
                                                    <small class="form-text text-muted">Dias calendario</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="required-field">Valor Tasacion (S/)</label>
                                                    <input type="number" class="form-control" id="monto_tasacion"
                                                        name="monto_tasacion" placeholder="Ej: 15000" step="0.01" required>
                                                    <small class="form-text text-muted">Valor del bien garantizado</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-field">Tipo de Interes</label>
                                                    <select class="form-control" id="tipo_interes" name="tipo_interes"
                                                        required>
                                                        <option value="">Seleccione...</option>
                                                        <option value="porcentaje">Porcentaje sobre capital</option>
                                                        <option value="monto_fijo">Monto fijo acordado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-field" id="label_valor_interes">Valor del
                                                        Interes</label>
                                                    <input type="number" class="form-control" id="valor_interes"
                                                        name="valor_interes" placeholder="Ej: 10" step="0.01" required>
                                                    <small class="form-text text-muted" id="hint_valor_interes">Ingrese el
                                                        porcentaje o monto fijo</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="required-field">Fecha de Desembolso</label>
                                                    <input type="date" class="form-control" id="fecha_desembolso"
                                                        name="fecha_desembolso" required>
                                                    <small class="form-text text-muted">Fecha en que se entrega el
                                                        prestamo</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Calculadora en Tiempo Real -->
                                        <div class="calculator-result" id="calculator_result" style="display: none;">
                                            <h4>Resumen del Prestamo</h4>
                                            <div class="result-item">
                                                <span>Capital:</span>
                                                <span id="display_capital">S/ 0.00</span>
                                            </div>
                                            <div class="result-item">
                                                <span>Interes:</span>
                                                <span id="display_interes">S/ 0.00</span>
                                            </div>
                                            <div class="result-item">
                                                <span>Plazo:</span>
                                                <span>30 dias</span>
                                            </div>
                                            <div class="result-item">
                                                <span>Total a Pagar:</span>
                                                <span id="display_total">S/ 0.00</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 4: Revision y Confirmacion -->
                                    <div class="step-content" data-step="4">
                                        <h5 class="mb-4" style="color: #FF6B35; font-weight: 700;">Revision y Confirmacion
                                        </h5>

                                        <!-- Datos del Cliente -->
                                        <div class="review-section">
                                            <h5>Datos del Cliente</h5>
                                            <div class="review-item">
                                                <strong>Nombre:</strong>
                                                <span id="review_nombre"></span>
                                            </div>
                                            <div class="review-item">
                                                <strong>DNI:</strong>
                                                <span id="review_dni"></span>
                                            </div>
                                            <div class="review-item">
                                                <strong>Domicilio:</strong>
                                                <span id="review_domicilio"></span>
                                            </div>
                                        </div>

                                        <!-- Datos de la Prenda -->
                                        <div class="review-section">
                                            <h5>Datos de la Prenda</h5>
                                            <div class="review-item">
                                                <strong>Clasificacion:</strong>
                                                <span id="review_clasificacion"></span>
                                            </div>
                                            <div class="review-item">
                                                <strong>Tipo:</strong>
                                                <span id="review_tipo"></span>
                                            </div>
                                            <div class="review-item">
                                                <strong>Marca/Modelo:</strong>
                                                <span id="review_marca_modelo"></span>
                                            </div>
                                            <div class="review-item">
                                                <strong>Valorizacion:</strong>
                                                <span id="review_valorizacion"></span>
                                            </div>
                                        </div>

                                        <!-- Datos del Prestamo -->
                                        <div class="review-section">
                                            <h5>Configuracion del Prestamo</h5>
                                            <div class="review-item">
                                                <strong>Monto:</strong>
                                                <span id="review_monto"></span>
                                            </div>
                                            <div class="review-item">
                                                <strong>Tipo de Interes:</strong>
                                                <span id="review_tipo_interes"></span>
                                            </div>
                                            <div class="review-item">
                                                <strong>Interes Calculado:</strong>
                                                <span id="review_interes"></span>
                                            </div>
                                            <div class="review-item"
                                                style="font-size: 1.25rem; font-weight: 700; color: #FF6B35;">
                                                <strong>Total a Pagar:</strong>
                                                <span id="review_total"></span>
                                            </div>
                                        </div>

                                        <div class="alert alert-info mt-4">
                                            <strong>Nota:</strong> Por favor revise cuidadosamente toda la informacion antes
                                            de confirmar. Una vez guardado, se generaran los documentos legales
                                            correspondientes.
                                        </div>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary" id="btn_prev"
                                            style="display: none;">
                                            <i class="fa fa-arrow-left mr-2"></i> Anterior
                                        </button>
                                        <div></div>
                                        <button type="button" class="btn btn-primary" id="btn_next">
                                            Siguiente <i class="fa fa-arrow-right ml-2"></i>
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="btn_submit"
                                            style="display: none;">
                                            <i class="fa fa-check mr-2"></i> Confirmar y Guardar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--**********************************
            Content body end
        ***********************************-->

            <!-- MODAL PREVIEW CONTRATO -->
            <div class="modal fade" id="contratoModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                    <div class="modal-content" style="border:none;border-radius:12px;overflow:hidden;">
                        <div class="modal-header"
                            style="background:linear-gradient(135deg,#184897,#1a6bc7);color:#fff;border:none;padding:1.5rem 2rem;">
                            <div>
                                <h5 class="modal-title" style="font-weight:700;margin:0;">Contrato Generado</h5>
                                <div style="font-size:0.85rem;opacity:0.85;margin-top:4px;" id="modal_num_contrato">N&#176;
                                    &mdash;</div>
                            </div>
                            <button type="button" class="close" data-dismiss="modal"
                                style="color:#fff;opacity:1;">&times;</button>
                        </div>
                        <div class="modal-body p-0">
                            <div
                                style="background:#e8f5e9;border-bottom:1px solid #c8e6c9;padding:12px 2rem;display:flex;align-items:center;gap:10px;">
                                <span style="font-size:1.4rem;color:#388e3c;">OK</span>
                                <div><strong style="color:#388e3c;">Contrato completado con los datos ingresados.</strong>
                                    <div style="font-size:0.85rem;color:#555;">Revise antes de imprimir. Use "Modificar" si
                                        hay errores.</div>
                                </div>
                            </div>
                            <div style="padding:1.5rem;" id="pdf_container">
                                <iframe id="pdf_preview_frame" src=""
                                    style="width:100%; height:650px; border:none; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15);"></iframe>
                            </div>
                        </div>
                        <div class="modal-footer"
                            style="background:#f8f9fa;border-top:1px solid #e0e0e0;padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;">
                            <button type="button" id="btn_modificar" class="btn btn-outline-secondary"
                                style="font-weight:600;">Modificar</button>
                            <div style="display:flex;gap:10px;">
                                <a id="btn_imprimir" href="#" target="_blank" class="btn btn-outline-primary"
                                    style="font-weight:700;padding:0.6rem 1.4rem;border-radius:6px;text-decoration:none;">
                                    <i class="fa fa-print mr-2"></i>Imprimir Contrato
                                </a>
                                <button type="button" id="btn_aceptar" class="btn"
                                    style="background:#F5812A;color:#fff;font-weight:700;padding:0.6rem 1.8rem;border-radius:6px;border:none;">
                                    <i class="fa fa-check mr-2"></i>Aceptar y Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div class="copyright">
                    <p>Copyright @ Designed &amp; Developed by <a href="https://crediagil.com/"
                            target="_blank">CrediAgil</a> <?php echo date('Y'); ?></p>
                </div>
            </div>

        </div>
        <!--**********************************
        Main wrapper end
    ***********************************-->

        <script src="<?php echo $UrlGlobal; ?>vista/vendor/global/global.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/js/custom.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/js/deznav-init.js"></script>

        <script>
            $(document).ready(function () {
                let currentStep = 1;
                const totalSteps = 4;

                $('#tipo_personeria').change(function () {
                    const tipo = $(this).val();
                    if (tipo === 'natural') {
                        $('#campos_persona_natural').slideDown();
                        $('#campos_empresa').slideUp();
                        $('#nombre_completo, #dni, #domicilio_calle').attr('required', true);
                        $('#razon_social, #ruc, #representante_legal, #dni_representante, #partida_electronica, #domicilio_fiscal').attr('required', false);
                    } else if (tipo === 'empresa') {
                        $('#campos_persona_natural').slideUp();
                        $('#campos_empresa').slideDown();
                        $('#razon_social, #ruc, #representante_legal, #dni_representante, #partida_electronica, #domicilio_fiscal').attr('required', true);
                        $('#nombre_completo, #dni, #domicilio_calle').attr('required', false);
                    } else {
                        $('#campos_persona_natural, #campos_empresa').slideUp();
                    }
                });

                $('#tipo_contrato').change(function () {
                    const tipo = $(this).val();
                    $('#campos_auto, #campos_joyas, #campos_electro').slideUp();
                    if (tipo === 'auto') {
                        $('#campos_auto').slideDown();
                        $('#auto_placa, #auto_marca, #auto_modelo, #auto_anio, #auto_color, #auto_motor, #auto_serie, #auto_partida_registral, #auto_oficina_registral').attr('required', true);
                        $('#joyas_material_ley, #joyas_valorizacion, #joyas_peso_bruto, #joyas_peso_neto, #joyas_descripcion').attr('required', false);
                        $('#electro_tipo_bien, #electro_marca, #electro_modelo, #electro_numero_serie').attr('required', false);
                    } else if (tipo === 'joyas') {
                        $('#campos_joyas').slideDown();
                        $('#joyas_material_ley, #joyas_valorizacion, #joyas_peso_bruto, #joyas_peso_neto, #joyas_descripcion').attr('required', true);
                        $('#auto_placa, #auto_marca, #auto_modelo, #auto_anio, #auto_color, #auto_motor, #auto_serie, #auto_partida_registral, #auto_oficina_registral').attr('required', false);
                        $('#electro_tipo_bien, #electro_marca, #electro_modelo, #electro_numero_serie').attr('required', false);
                    } else if (tipo === 'electro') {
                        $('#campos_electro').slideDown();
                        $('#electro_tipo_bien, #electro_marca, #electro_modelo, #electro_numero_serie').attr('required', true);
                        $('#auto_placa, #auto_marca, #auto_modelo, #auto_anio, #auto_color, #auto_motor, #auto_serie, #auto_partida_registral, #auto_oficina_registral').attr('required', false);
                        $('#joyas_material_ley, #joyas_valorizacion, #joyas_peso_bruto, #joyas_peso_neto, #joyas_descripcion').attr('required', false);
                    }
                });

                function showStep(step) {
                    $('.step-content').removeClass('active');
                    $(`.step-content[data-step="${step}"]`).addClass('active');
                    $('.step').removeClass('active completed');
                    for (let i = 1; i < step; i++) {
                        $(`.step[data-step="${i}"]`).addClass('completed');
                    }
                    $(`.step[data-step="${step}"]`).addClass('active');
                    if (step === 1) $('#btn_prev').hide(); else $('#btn_prev').show();
                    if (step === totalSteps) {
                        $('#btn_next').hide();
                        $('#btn_submit').show();
                    } else {
                        $('#btn_next').show();
                        $('#btn_submit').hide();
                    }
                    if (step === 4) updateReview();
                }

                $('#btn_next').click(function () {
                    if (validateStep(currentStep)) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });

                $('#btn_prev').click(function () {
                    currentStep--;
                    showStep(currentStep);
                });

                function validateStep(step) {
                    let isValid = true;
                    $(`.step-content[data-step="${step}"] input[required], .step-content[data-step="${step}"] select[required]`).each(function () {
                        if (!this.checkValidity()) {
                            isValid = false;
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });
                    if (!isValid) alert('Por favor complete todos los campos obligatorios (*)');
                    return isValid;
                }

                $('#monto_prestamo, #tipo_interes, #valor_interes').on('input change', function () {
                    calcularPrestamo();
                });

                $('#tipo_interes').change(function () {
                    const tipo = $(this).val();
                    if (tipo === 'porcentaje') {
                        $('#label_valor_interes').html('Porcentaje (%) <span style="color: #dc3545;">*</span>');
                        $('#hint_valor_interes').text('Ingrese el porcentaje (Ej: 10 para 10%)');
                        $('#valor_interes').attr('placeholder', 'Ej: 10');
                    } else if (tipo === 'monto_fijo') {
                        $('#label_valor_interes').html('Monto Fijo (S/) <span style="color: #dc3545;">*</span>');
                        $('#hint_valor_interes').text('Ingrese el monto fijo acordado');
                        $('#valor_interes').attr('placeholder', 'Ej: 1500');
                    }
                    calcularPrestamo();
                });

                function calcularPrestamo() {
                    const monto = parseFloat($('#monto_prestamo').val()) || 0;
                    const tipo = $('#tipo_interes').val();
                    const valor = parseFloat($('#valor_interes').val()) || 0;
                    if (monto > 0 && tipo && valor > 0) {
                        let interes = 0;
                        if (tipo === 'porcentaje') interes = (monto * valor) / 100;
                        else if (tipo === 'monto_fijo') interes = valor;
                        const total = monto + interes;
                        $('#display_capital').text('S/ ' + monto.toFixed(2));
                        $('#display_interes').text('S/ ' + interes.toFixed(2));
                        $('#display_total').text('S/ ' + total.toFixed(2));
                        $('#calculator_result').slideDown();
                    } else {
                        $('#calculator_result').slideUp();
                    }
                }

                function updateReview() {
                    const tipoPersoneria = $('#tipo_personeria').val();
                    if (tipoPersoneria === 'natural') {
                        $('#review_nombre').text($('#nombre_completo').val() || 'No especificado');
                        $('#review_dni').text($('#dni').val() || 'No especificado');
                        const nombreConyuge = $('#nombre_conyuge').val();
                        const dniConyuge = $('#dni_conyuge').val();
                        if (nombreConyuge || dniConyuge) {
                            $('#review_nombre').text($('#review_nombre').text() + ' (Conyuge: ' + (nombreConyuge || 'N/A') + ')');
                        }
                        const domicilio = [
                            $('#domicilio_calle').val(),
                            $('#domicilio_urbanizacion').val(),
                            $('#domicilio_manzana').val() ? 'Mz. ' + $('#domicilio_manzana').val() : '',
                            $('#domicilio_lote').val() ? 'Lt. ' + $('#domicilio_lote').val() : ''
                        ].filter(Boolean).join(', ');
                        $('#review_domicilio').text(domicilio || 'No especificado');
                    } else if (tipoPersoneria === 'empresa') {
                        $('#review_nombre').text($('#razon_social').val() || 'No especificado');
                        $('#review_dni').text('RUC: ' + ($('#ruc').val() || 'No especificado'));
                        $('#review_domicilio').text($('#domicilio_fiscal').val() || 'No especificado');
                    }

                    const tipoContrato = $('#tipo_contrato').val();
                    let prendaInfo = '';
                    if (tipoContrato === 'auto') {
                        $('#review_clasificacion').text('Prenda Auto');
                        prendaInfo = ['Placa: ' + ($('#auto_placa').val() || 'N/A'), $('#auto_marca').val(), $('#auto_modelo').val(), $('#auto_anio').val(), $('#auto_color').val()].filter(Boolean).join(' - ');
                        $('#review_tipo').text(prendaInfo || 'No especificado');
                        $('#review_marca_modelo').text('Motor: ' + ($('#auto_motor').val() || 'N/A') + ' | Serie: ' + ($('#auto_serie').val() || 'N/A'));
                        $('#review_valorizacion').text('Partida: ' + ($('#auto_partida_registral').val() || 'N/A'));
                    } else if (tipoContrato === 'joyas') {
                        $('#review_clasificacion').text('Prenda Joyas');
                        prendaInfo = $('#joyas_material_ley').val() || 'No especificado';
                        $('#review_tipo').text(prendaInfo);
                        $('#review_marca_modelo').text('Peso Bruto: ' + ($('#joyas_peso_bruto').val() || '0') + 'g | Peso Neto: ' + ($('#joyas_peso_neto').val() || '0') + 'g');
                        const valorizacion = parseFloat($('#joyas_valorizacion').val()) || 0;
                        $('#review_valorizacion').text('S/ ' + valorizacion.toFixed(2));
                    } else if (tipoContrato === 'electro') {
                        $('#review_clasificacion').text('Prenda Electro');
                        prendaInfo = [$('#electro_tipo_bien').val(), $('#electro_marca').val(), $('#electro_modelo').val()].filter(Boolean).join(' - ');
                        $('#review_tipo').text(prendaInfo || 'No especificado');
                        $('#review_marca_modelo').text('Serie: ' + ($('#electro_numero_serie').val() || 'N/A'));
                        $('#review_valorizacion').text('Accesorios: ' + ($('#electro_accesorios').val() || 'Ninguno'));
                    }

                    const monto = parseFloat($('#monto_prestamo').val()) || 0;
                    $('#review_monto').text('S/ ' + monto.toFixed(2));
                    const tipoInteres = $('#tipo_interes option:selected').text();
                    $('#review_tipo_interes').text(tipoInteres || 'No especificado');
                    $('#review_interes').text($('#display_interes').text() || 'S/ 0.00');
                    $('#review_total').text($('#display_total').text() || 'S/ 0.00');
                    const fechaDesembolso = $('#fecha_desembolso').val();
                    if (fechaDesembolso) {
                        $('#review_total').text($('#review_total').text() + ' (Desembolso: ' + fechaDesembolso + ')');
                    }
                }

                $('#nuevo-cliente-form').submit(function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const $btn = $('#btn_submit');
                    const originalHtml = $btn.html();
                    $btn.html('<i class="fa fa-spinner fa-spin mr-2"></i> Generando...').prop('disabled', true);

                    $.ajax({
                        url: '../controlador/cGenerarContrato.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            $btn.html(originalHtml).prop('disabled', false);
                            try {
                                const res = typeof response === 'string' ? JSON.parse(response) : response;
                                if (res.status === 'ok') {
                                    fillContratoModal(res.preview, res.docx_filename, res.pdf_filename);
                                    $('#contratoModal').modal('show');
                                } else {
                                    alert('Error: ' + (res.message || 'Error al generar el contrato.'));
                                }
                            } catch (ex) {
                                alert('Error al procesar la respuesta del servidor.');
                            }
                        },
                        error: function (xhr) {
                            $btn.html(originalHtml).prop('disabled', false);
                            alert('Error de conexion: ' + xhr.status + ' ' + xhr.statusText);
                        }
                    });
                });
            });

            // === FUNCIONES DEL MODAL DE CONTRATO ===
            let currentDocxFile = '';
            let currentClienteNombre = '';

            function fillContratoModal(preview, docxFile, pdfFile) {
                currentDocxFile = docxFile || '';
                const p = preview || {};
                const c = p.cliente || {};
                currentClienteNombre = c.nombre || 'Cliente_Desconocido';
                $('#modal_num_contrato').html('N&#176; ' + (p.num_contrato || ''));

                if (pdfFile) {
                    $('#pdf_preview_frame').attr('src', '../tmp_contratos/' + pdfFile);
                } else {
                    $('#pdf_preview_frame').attr('src', 'about:blank');
                    $('#pdf_container').html('<div class="alert alert-warning">No se pudo generar la vista previa en PDF. Por favor descargue el documento Word (Imprimir Contrato).</div>');
                }

                $('#btn_imprimir')
                    .attr('href', '../tmp_contratos/' + (pdfFile ? pdfFile : docxFile))
                    .attr('download', 'Contrato_' + (p.num_contrato || 'Generado') + (pdfFile ? '.pdf' : '.docx'));
            }

            function rowPrev(label, value) {
                return '<div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #e0e0e0;font-size:0.88rem;"><span style="color:#555;font-weight:600;width:40%;">' + label + '</span><span style="color:#222;width:58%;text-align:right;">' + value + '</span></div>';
            }

            $('#btn_modificar').on('click', function () {
                $('#contratoModal').modal('hide');
            });

            $('#btn_aceptar').on('click', function () {
                const $btn = $(this);
                const originalHtml = $btn.html();
                $btn.html('<i class="fa fa-spinner fa-spin mr-2"></i> Guardando...').prop('disabled', true);

                $.ajax({
                    url: '../controlador/cGuardarContrato.php',
                    type: 'POST',
                    data: {
                        docx_filename: currentDocxFile,
                        cliente_nombre: currentClienteNombre
                    },
                    success: function (response) {
                        $btn.html(originalHtml).prop('disabled', false);
                        try {
                            const res = typeof response === 'string' ? JSON.parse(response) : response;
                            if (res.status === 'ok') {
                                alert('Contrato guardado exitosamente en la carpeta del cliente.');
                                window.location.reload();
                            } else {
                                alert('Error: ' + (res.message || 'Error al guardar el contrato.'));
                            }
                        } catch (ex) {
                            alert('Error al procesar la respuesta del servidor al guardar.');
                        }
                    },
                    error: function (xhr) {
                        $btn.html(originalHtml).prop('disabled', false);
                        alert('Error de conexion: ' + xhr.status + ' ' + xhr.statusText);
                    }
                });
            });
        </script>

    </body>

    </html>
    <?php
} // CIERRE else
?>