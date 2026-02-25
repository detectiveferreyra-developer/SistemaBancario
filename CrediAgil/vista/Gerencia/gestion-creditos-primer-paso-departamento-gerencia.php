<?php
// IMPORTANDO MODELO DE CLIMA EN TIEMPO REAL -> API CLIMA OPENWEATHERMAP
require('../modelo/mAPIClima_Openweathermap.php');
// IMPORTANDO MODELO DE CONTEO NUMERO DE NOTIFICACIONES RECIBIDAS
require('../modelo/mConteoNotificacionesRecibidasUsuarios.php');
// IMPORTANDO MODELO DE CONTEO NUMERO DE MENSAJES RECIBIDOS

// DATOS DE LOCALIZACION -> IDIOMA ESPAÑOL -> ZONA HORARIA EL SALVADOR (UTC-6)
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/El_Salvador');
// OBTENER HORA LOCAL
$hora = new DateTime("now");
// NO PERMITIR INGRESO SI PARAMETRO NO EXISTE
if (empty($_GET['idusuario'])) {
    // MOSTRAR PAGINA DE ERROR 404 SI NO EXISTE INFORMACION QUE MOSTRAR
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=error-404');
}
// SI LOS USUARIOS INICIAN POR PRIMERA VEZ, MOSTRAR PAGINA DONDE DEBERAN REALIZAR EL CAMBIO OBLIGATORIO DE SU CONTRASEÑA GENERADA AUTOMATICAMENTE
if ($_SESSION['comprobar_iniciosesion_primeravez'] == "si") {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=gestiones-nuevos-usuarios-registrados');
    // CASO CONTRARIO, MOSTRAR PORTAL DE USUARIOS -> SEGUN ROL DE USUARIO ASIGNADO
} else {
    /*
		-> CREDITOS PERSONALES
	*/
    // VALIDACION SEGUN RANGOS ESTIPULADOS POR ENTIDAD FINANCIERA
    // -> PRESTAMOS PERSONALES
    if ($Gestiones->getNombreProductos() == "Préstamos Personales") {
        if ($Gestiones->getMontoFinanciamientoCreditos() < 300) { // $0.00 - $299.00 USD
            $SeguroDeuda = 0.00;
            $GastosAdministrativos = 0.00;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() >= 300 && $Gestiones->getMontoFinanciamientoCreditos() < 500) { // $300.00 - $499.00 USD
            $SeguroDeuda = 1.95;
            $GastosAdministrativos = 0.00;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() >= 500 && $Gestiones->getMontoFinanciamientoCreditos() < 1000) { // $500.00 - $999.00 USD
            $SeguroDeuda = 3.95;
            $GastosAdministrativos = 2.00;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() >= 1000 && $Gestiones->getMontoFinanciamientoCreditos() < 2500) { // $1000.00 - $2499.00 USD
            $SeguroDeuda = 6.95;
            $GastosAdministrativos = 6.00;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() >= 2500 && $Gestiones->getMontoFinanciamientoCreditos() < 9500) { // $2500.00 - $9499.00 USD
            $SeguroDeuda = 7.95;
            $GastosAdministrativos = 12.00;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() >= 9500) { // $9500.00 USD HASTA POLITICA DE ENTIDAD FINANCIERA
            $SeguroDeuda = 13.95;
            $GastosAdministrativos = 18.00;
        }
        /*
		-> CREDITOS DE VEHICULOS
	*/
        // -> PRESTAMOS DE VEHICULOS
    } else if ($Gestiones->getNombreProductos() == "Préstamos de Vehículos") {
        if ($Gestiones->getMontoFinanciamientoCreditos() >= 10000 && $Gestiones->getMontoFinanciamientoCreditos() <= 25000) { // $10,000.00 - $25,000.00 USD
            $SeguroDeuda = 12.99;
            $GastosAdministrativos = 25.99;
            $ServicioGPS = 20.99;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() > 25000 && $Gestiones->getMontoFinanciamientoCreditos() <= 50000) { // $25,001.00 - $50,000.00 USD
            $SeguroDeuda = 18.99;
            $GastosAdministrativos = 29.99;
            $ServicioGPS = 20.99;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() > 50000 && $Gestiones->getMontoFinanciamientoCreditos() <= 100000) { // $50,001.00 - $100,000.00 USD
            $SeguroDeuda = 26.99;
            $GastosAdministrativos = 59.99;
            $ServicioGPS = 20.99;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() > 100000 && $Gestiones->getMontoFinanciamientoCreditos() <= 200000) { // $100,001.00 - $200,000.00 USD
            $SeguroDeuda = 37.99;
            $GastosAdministrativos = 99.99;
            $ServicioGPS = 20.99;
        }
        /*
		-> CREDITOS HIPOTECARIOS
	*/
        // -> PRESTAMOS HIPOTECARIOS
    } else if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") {
        if ($Gestiones->getMontoFinanciamientoCreditos() >= 30000 && $Gestiones->getMontoFinanciamientoCreditos() <= 50000) { // $30,000.00 - $50,0000.00 USD
            $SeguroDeuda = 35.50;
            $GastosAdministrativos = 110.99;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() > 50000 && $Gestiones->getMontoFinanciamientoCreditos() <= 50000) { // $50,001.00 - $75,000.00 USD
            $SeguroDeuda = 41.50;
            $GastosAdministrativos = 114.99;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() > 50000 && $Gestiones->getMontoFinanciamientoCreditos() <= 150000) { // $75,001.00 - $150,000.00 USD
            $SeguroDeuda = 61.50;
            $GastosAdministrativos = 154.99;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() > 150000 && $Gestiones->getMontoFinanciamientoCreditos() <= 500000) { // $150,001.00 - $500,000.00 USD
            $SeguroDeuda = 140.50;
            $GastosAdministrativos = 354.99;
        } else if ($Gestiones->getMontoFinanciamientoCreditos() > 500000) { // MAYORES A $500,000.00 USD
            $SeguroDeuda = 540.50;
            $GastosAdministrativos = 954.99;
        }
    }
    // VALIDACION DE NO INGRESO SI DATOS NO EXISTEN [VALIDO SI EL USUARIO EN CUESTION SIMPLEMENTE NO EXISTE, O BIEN LA SOLICITUD DE APROBACION HA AVANZADO A LA ULTIMA FASE, NECESITA REESTRUCTURACION O SIMPLEMENTE SE HA DENEGADO]
    if ($Gestiones->getIdUsuarios() == "") {
        // VALIDACION SEGUN ROLES DE USUARIOS, REDIRECCIONAR A INICIO DE LA PLATAFORMA
        /*
			-> USUARIOS ADMINISTRADORES
		*/
        if ($_SESSION['id_rol'] == 1) {
            header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=inicioadministradores');
        }
    } else { // SI EL USUARIO NO HA SIDO GESTIONADO, DESPLEGAR TODA LA INFORMACION
?>
        <!-- 

░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡
░░              CrediAgil S.A DE C.V                                                  
░░          SISTEMA FINANCIERO / BANCARIO 
░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡                      
░░                                                                               
░░ -> AUTOR: DANIEL RIVERA                                                               
░░ -> PHP 8.1, MYSQL, MVC, JAVASCRIPT, AJAX, JQUERY                       
░░ -> GITHUB: (danielrivera03)                                             
░░ -> TODOS LOS DERECHOS RESERVADOS                           
░░     © 2021 - 2022    
░░                                                      
░░ -> POR FAVOR TOMAR EN CUENTA TODOS LOS COMENTARIOS
░░    Y REALIZAR LOS AJUSTES PERTINENTES ANTES DE INICIAR
░░
░░          ♥♥ HECHO CON MUCHAS TAZAS DE CAFE ♥♥
░░                                                                               
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░

-->
        <!DOCTYPE html>
        <html lang="ES-SV">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <title>CrediAgil | Gestionar Cr&eacute;dito <?php echo $Gestiones->getNombreProductos(); ?> </title>
            <!-- Favicon icon -->
            <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-57x57.png">
            <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-60x60.png">
            <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-72x72.png">
            <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-76x76.png">
            <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-114x114.png">
            <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-120x120.png">
            <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-144x144.png">
            <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-152x152.png">
            <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-180x180.png">
            <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $UrlGlobal; ?>vista/images/android-icon-192x192.png">
            <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $UrlGlobal; ?>vista/images/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $UrlGlobal; ?>vista/images/favicon-96x96.png">
            <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $UrlGlobal; ?>vista/images/favicon-16x16.png">
            <link rel="manifest" href="<?php echo $UrlGlobal; ?>vista/images/manifest.json">
            <meta name="msapplication-TileColor" content="#ffffff">
            <meta name="msapplication-TileImage" content="<?php echo $UrlGlobal; ?>vista/images/ms-icon-144x144.png">
            <meta name="theme-color" content="#ffffff">
            <link href="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
            <link href="<?php echo $UrlGlobal; ?>vista/css/style.css" rel="stylesheet">
        <!-- CrediAgil Corporate Theme -->
        <link href="<?php echo $UrlGlobal; ?>vista/css/crediagil-theme.css" rel="stylesheet">
            <!-- Daterange picker -->
            <link href="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <!-- Clockpicker -->
            <link href="<?php echo $UrlGlobal; ?>vista/vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
            <!-- asColorpicker -->
            <link href="<?php echo $UrlGlobal; ?>vista/vendor/jquery-asColorPicker/css/asColorPicker.min.css" rel="stylesheet">
            <!-- Material color picker -->
            <link href="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
            <!-- Pick date -->
            <link rel="stylesheet" href="<?php echo $UrlGlobal; ?>vista/vendor/pickadate/themes/default.css">
            <link rel="stylesheet" href="<?php echo $UrlGlobal; ?>vista/vendor/pickadate/themes/default.date.css">
            <!-- Bootstrap Dropzone CSS -->
            <link href="<?php echo $UrlGlobal; ?>vista/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css" />
            <!-- Bootstrap Dropzone CSS -->
            <link href="<?php echo $UrlGlobal; ?>vista/dropify/dist/css/dropify.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo $UrlGlobal; ?>vista/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
            <!-- Toastr -->
            <link rel="stylesheet" href="<?php echo $UrlGlobal; ?>vista/vendor/toastr/css/toastr.min.css">
            <link rel="stylesheet" href="<?php echo $UrlGlobal; ?>vista/dist/mc-calendar.min.css" />

        </head>

        <body>

            <!--*******************
        Preloader start
    ********************-->
            <div id="preloader">
                <div class="sk-three-bounce">
                    <div class="sk-child sk-bounce1"></div>
                    <div class="sk-child sk-bounce2"></div>
                    <div class="sk-child sk-bounce3"></div>
                </div>
            </div>
            <!--*******************
        Preloader end
    ********************-->


            <!--**********************************
        Main wrapper start
    ***********************************-->
            <div id="main-wrapper">

                <!--**********************************
            Nav header start
        ***********************************-->
                <div class="nav-header">
                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=iniciogerencia" class="brand-logo">
                        <img class="logo-abbr" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                        <img class="logo-compact" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                        <img class="brand-title" src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="">
                    </a>

                    <div class="nav-control">
                        <div class="hamburger">
                            <span class="line"></span><span class="line"></span><span class="line"></span>
                        </div>
                    </div>
                </div>
                <!--**********************************
            Nav header end
        ***********************************-->

                <!--**********************************
            Header start
        ***********************************-->
                <div class="header">
                    <div class="header-content">
                        <nav class="navbar navbar-expand">
                            <div class="collapse navbar-collapse justify-content-between">
                                <div class="header-left">
                                    <div class="dashboard_bar">
                                        <h4 style="font-weight: 600;">Gestionar Nuevos <?php echo $Gestiones->getNombreProductos(); ?></h4>
                                    </div>
                                </div>

                                <ul class="navbar-nav header-right">
                                    <li class="nav-item dropdown header-profile">
                                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                            <div class="header-info">
                                                <span class="text-black">Hola, <strong><?php $Nombre = $_SESSION['nombre_usuario'];
                                                                                        $PrimerNombre = explode(' ', $Nombre, 2);
                                                                                        print_r($PrimerNombre[0]); ?></strong></span>
                                                <p class="fs-12 mb-0">
                                                    <!-- VALIDACION SEGUN ROLES DE USUARIOS -->
                                                    <?php if ($_SESSION['id_rol'] == 1) {
                                                        echo "Administradores";
                                                    } else if ($_SESSION['id_rol'] == 2) {
                                                        echo "Presidencia";
                                                    } else if ($_SESSION['id_rol'] == 3) {
                                                        echo "Gerencia";
                                                    } else if ($_SESSION['id_rol'] == 4) {
                                                        echo "Atenci&oacute;n al Cliente";
                                                    } else if ($_SESSION['id_rol'] == 5) {
                                                        echo "Clientes";
                                                    } ?>
                                                </p>
                                            </div>
                                            <img src="<?php echo $UrlGlobal; ?>vista/images/fotoperfil/<?php echo $_SESSION['foto_perfil']; ?>" width="20" alt="" />
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="<?php echo $UrlGlobal ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=perfilgerencia" class="dropdown-item ai-icon">
                                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                                <span class="ml-2">Mi Perfil </span>
                                            </a>
                                            
                                            <a href="<?php echo $UrlGlobal ?>controlador/cIniciosSesionesUsuarios.php?CrediAgil=cerrarsesion" class="dropdown-item ai-icon">
                                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                    <polyline points="16 17 21 12 16 7"></polyline>
                                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                                </svg>
                                                <span class="ml-2">Cerrar Sesi&oacute;n </span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

                <!--**********************************
            Sidebar start
        ***********************************-->
                <?php
                // IMPORTAR MENU DE NAVEGACION PARA USUARIOS ROL GERENCIA
                require('../vista/MenuNavegacion/menu-gerencia.php');
                ?>
                <!--**********************************
            Sidebar end
        ***********************************-->

                <!--**********************************
            Content body start
        ***********************************-->
                <div class="content-body">
                    <div class="container-fluid">
                        <div class="page-titles">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Productos</a></li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Registrar Productos</a></li>
                            </ol>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                                    <div class="alert alert-info alert-dismissible fade show">
                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="16" x2="12" y2="12"></line>
                                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                        </svg>
                                        <strong>Solicitud registrada y gestionada por el empleado: <?php echo $Gestiones->getEmpleadoRegistroCredito(); ?></strong>
                                    </div>
                                    <div class="card overflow-hidden">
                                        <div class="text-center p-5 overlay-box" style="background-image: url(<?php echo $UrlGlobal; ?>vista/images/logo-negro.png);">
                                            <img src="<?php echo $UrlGlobal; ?>vista/images/fotoperfil/<?php echo $Gestiones->getFotoUsuarios(); ?>" width="100" class="img-fluid rounded-circle" alt="">
                                            <h3 class="mt-3 mb-0 text-white"><?php echo $Gestiones->getNombresUsuarios(); ?> <?php echo $Gestiones->getApellidosUsuarios(); ?></h3>
                                        </div>
                                        <div class="card text-white bg-light text-black">
                                            <ul class="list-group list-group-flush">

                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"> <strong>DATOS GENERALES</strong></span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Nombre Producto Solicitado :</span><strong><?php echo $Gestiones->getNombreProductos(); ?> [<?php echo $Gestiones->getCodigoProductos(); ?>]</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Dui Cliente :</span><strong><?php echo $Gestiones->getDuiUsuarios(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Nit Cliente :</span><strong><?php echo $Gestiones->getNitUsuarios(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Tipo de Cliente :</span><strong><?php echo $Gestiones->getTipoClienteCreditos(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Monto Financiamiento Cr&eacute;dito :</span><strong>$<?php echo number_format($Gestiones->getMontoFinanciamientoCreditos(), 2); ?> USD</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Tasa de Inter&eacute;s Mensual Cr&eacute;dito :</span><strong><?php echo $Gestiones->getTasaInteresCreditos(); ?> %</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Plazo Cr&eacute;dito :</span><strong><?php echo $Gestiones->getTiempoPlazoCreditos(); ?> <?php if ($Gestiones->getCodigoProductos() == "PrHipoteca-CHSA") {
                                                                                                                                                                                                                                                                    echo "a&ntilde;os";
                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                    echo "meses";
                                                                                                                                                                                                                                                                } ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Cuota Mensual Asignada Cr&eacute;dito :</span><strong>$<?php echo number_format($Gestiones->getCuotaMensualCreditos(), 2); ?> USD</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Ingresos Declarado Por Cliente :</span><strong>$<?php echo number_format($Gestiones->getSalarioClienteCreditos(), 2); ?> USD</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Fecha de Ingreso Solicitud :</span><strong><?php echo $Gestiones->getFechaIngresoSolicitudCreditos(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Progreso Solicitud de Cr&eacute;dito :</span><strong><a href="javascript:void()" class="badge badge-circle badge-outline-dark"><?php echo $Gestiones->getProgresoInicialSolicitudCreditos(); ?>% de avance</a></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"> <strong>INFORMACION PERSONAL</strong></span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Direcci&oacute;n Residencia Cliente :</span><strong><?php echo $Gestiones->getDireccionUsuarios(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Tel&eacute;fono Principal Cliente :</span><strong><?php if (empty($Gestiones->getTelefonoUsuarios())) {
                                                                                                                                                                                                                            echo "No Disponible";
                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                            echo $Gestiones->getTelefonoUsuarios();
                                                                                                                                                                                                                        } ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Tel&eacute;fono Celular Cliente :</span><strong><?php if (empty($Gestiones->getCelularUsuarios())) {
                                                                                                                                                                                                                        echo "No Disponible";
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                        echo $Gestiones->getCelularUsuarios();
                                                                                                                                                                                                                    } ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Tel&eacute;fono Trabajo Cliente :</span><strong><?php if (empty($Gestiones->getTelefonoTrabajoUsuarios())) {
                                                                                                                                                                                                                        echo "No Disponible";
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                        echo $Gestiones->getTelefonoTrabajoUsuarios();
                                                                                                                                                                                                                    } ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Empresa D&oacute;nde Labora :</span><strong><?php echo $Gestiones->getEmpresaUsuarios(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Cargo Desempe&ntilde;ado :</span><strong><?php echo $Gestiones->getCargoEmpresaUsuarios(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"> <strong>REFERENCIA PERSONAL</strong></span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Nombres Completo :</span><strong><?php echo $Gestiones->getNombresReferenciaPersonal();
                                                                                                                                                                                                        echo ' ';
                                                                                                                                                                                                        echo $Gestiones->getApellidosReferenciaPersonal(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Empresa D&oacute;nde Labora :</span><strong><?php echo $Gestiones->getEmpresaReferenciaPersonal(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Profesi&oacute;n u Oficio :</span><strong><?php echo $Gestiones->getProfesionOficioReferenciaPersonal(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Tel&eacute;fono Cont&aacute;cto :</span><strong><?php echo $Gestiones->getTelefonoReferenciaPersonal(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"> <strong>REFERENCIA LABORAL</strong></span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Nombres Completo :</span><strong><?php echo $Gestiones->getNombresReferenciaLaboral();
                                                                                                                                                                                                        echo ' ';
                                                                                                                                                                                                        echo $Gestiones->getApellidosReferenciaLaboral(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Empresa D&oacute;nde Labora :</span><strong><?php echo $Gestiones->getEmpresaReferenciaLaboral(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Profesi&oacute;n u Oficio :</span><strong><?php echo $Gestiones->getProfesionOficioReferenciaLaboral(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i> Tel&eacute;fono Cont&aacute;cto :</span><strong><?php echo $Gestiones->getTelefonoReferenciaLaboral(); ?></strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"> <strong>OBSERVACION INICIAL</strong></span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><i class="ti ti-shift-right-alt"></i></span><strong> <?php if (empty($Gestiones->getObservacionesEmpleadosCreditos())) {
                                                                                                                                                                                        echo ' El empleado(a) ';
                                                                                                                                                                                        echo $Gestiones->getEmpleadoRegistroCredito();
                                                                                                                                                                                        echo ' no ha registrado ninguna observaci&oacute;n para esta solicitud de cr&eacute;dito.';
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo  $Gestiones->getObservacionesEmpleadosCreditos();
                                                                                                                                                                                    } ?></strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-light alert-dismissible alert-alt fade show">
                                            <strong>Tomar Nota:</strong> Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
                                                                                        $PrimerNombre = explode(' ', $Nombre, 2);
                                                                                        print_r($PrimerNombre[0]); ?>, este es el primer filtro de dos para el estudio y aprobaci&oacute;n, reestructuraci&oacute;n o rechaz&oacute; de este cr&eacute;dito. Por favor sea concreto y consulte el manual que la empresa le ha proporcionado para el estudio de nuevas asignaciones de cr&eacute;ditos. Tome en cuenta que los clientes pueden consultar de manera general el avance de sus tr&aacute;mites en su portal<br><br>Para el caso de una reestructuraci&oacute;n debe llamar al cliente por medio de sus cont&aacute;ctos lo m&aacute;s pronto posible y debe solicitarle que se acerque a la agencia personalmente para dar detalles del mismo y as&iacute; proseguir con el tr&aacute;mite. <strong>Los estudios no deben extenderse por m&aacute;s de 72 horas, y en el caso de las reestructuraciones, si el cliente no se presenta posterior a su llamado 3 d&iacute;as h&aacute;biles, su tr&aacute;mite se dar&aacute; por denegado y se enviar&aacute; al hist&oacute;rico.</strong>
                                        </div>
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home8">
                                                    <span>
                                                        <i class="ti-cloud-up"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane fade show active" id="home8" role="tabpanel">
                                                <div class="pt-4">
                                                    <h4>Primera Revisi&oacute;n</h4><br>
                                                    <div class="col-xl-12">
                                                        <form data-id="<?php echo $Gestiones->getIdUsuarios(); ?>" id="ingreso-datos-credito-clientes" class="validacion-actualizacion-revisiones-creditos-clientes" name="<?php if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") {
                                                                                                                                                                                                                                echo "formulariocreditosclienteshipotecas";
                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                echo "formulariocreditosclientes";
                                                                                                                                                                                                                            } ?>" method="post" autocomplete="off" enctype="multipart/form-data" <?php if ($Gestiones->getNombreProductos() == "Préstamos Personales") {
                                                                                                                                                                                                                                                                                                        echo 'onKeyUp="ConsultarRequisitosPrestamosPersonales()" ';
                                                                                                                                                                                                                                                                                                    } else if ($Gestiones->getNombreProductos() == "Préstamos de Vehículos") {
                                                                                                                                                                                                                                                                                                        echo 'onKeyUp="ConsultarRequisitosPrestamosVehiculos()" ';
                                                                                                                                                                                                                                                                                                    } else if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") {
                                                                                                                                                                                                                                                                                                        echo 'onKeyUp="ConsultarRequisitosPrestamosHipotecarios()" ';
                                                                                                                                                                                                                                                                                                    } ?>>
                                                            <div class="row form-validation">
                                                                <div class="col-lg-12 mb-2">
                                                                    <input type="hidden" name="idunicocreditoregistrado" value="<?php echo $Gestiones->getIdCreditos(); ?>">
                                                                    <input type="hidden" id="cuotamensualasignada" name="cuotamensualasignada" value="<?php echo $Gestiones->getCuotaMensualCreditos(); ?>">
                                                                    <div class="form-group">
                                                                        <label class="text-label">Producto CrediAgil Seleccionado<span class="text-danger">*</span></label>
                                                                        <div class="col-lg-12">
                                                                            <select class="form-control" id="val-productocreditos" name="productocreditos">
                                                                                <?php
                                                                                while ($filas = mysqli_fetch_array($consulta1)) {
                                                                                    // VALIDACION SEGUN TIPO DE PRESTAMO
                                                                                    if ($Gestiones->getNombreProductos() == "Préstamos Personales") {
                                                                                        // OMITIR TODOS LOS PRODUCTOS A EXCEPCION DEL PRODUCTO EN CUESTION EN ESTA SECCION DE ASIGNACION DE NUEVOS CREDITOS.
                                                                                        // PRODUCTO: PRESTAMOS PERSONALES -> MODIFICAR CADENA SI EXISTE ALGUN CAMBIO EN EL NOMBRE DE LOS PRODUCTOS, TOMAR NOTA -> IMPORTANTE <-
                                                                                        if ($filas['nombreproducto'] != "Cuentas de Ahorro Personales" && $filas['nombreproducto'] != "Depósito a Plazo Fijo" && $filas['nombreproducto'] != "Préstamos Hipotecarios" && $filas['nombreproducto'] != "Préstamos de Vehículos") {
                                                                                            echo '
                                                                    		<option value="';
                                                                                            echo $filas['idproducto'];
                                                                                            echo '">';
                                                                                            echo $filas['nombreproducto'];
                                                                                            echo '</option>';
                                                                                        }
                                                                                    } else if ($Gestiones->getNombreProductos() == "Préstamos de Vehículos") {
                                                                                        // OMITIR TODOS LOS PRODUCTOS A EXCEPCION DEL PRODUCTO EN CUESTION EN ESTA SECCION DE ASIGNACION DE NUEVOS CREDITOS.
                                                                                        // PRODUCTO: PRESTAMOS DE VEHICULOS -> MODIFICAR CADENA SI EXISTE ALGUN CAMBIO EN EL NOMBRE DE LOS PRODUCTOS, TOMAR NOTA -> IMPORTANTE <-
                                                                                        if ($filas['nombreproducto'] != "Cuentas de Ahorro Personales" && $filas['nombreproducto'] != "Depósito a Plazo Fijo" && $filas['nombreproducto'] != "Préstamos Hipotecarios" && $filas['nombreproducto'] != "Préstamos Personales") {
                                                                                            echo '
                                                                    		<option value="';
                                                                                            echo $filas['idproducto'];
                                                                                            echo '">';
                                                                                            echo $filas['nombreproducto'];
                                                                                            echo '</option>';
                                                                                        }
                                                                                    } else if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") {
                                                                                        // OMITIR TODOS LOS PRODUCTOS A EXCEPCION DEL PRODUCTO EN CUESTION EN ESTA SECCION DE ASIGNACION DE NUEVOS CREDITOS.
                                                                                        // PRODUCTO: PRESTAMOS HIPOTECARIOS -> MODIFICAR CADENA SI EXISTE ALGUN CAMBIO EN EL NOMBRE DE LOS PRODUCTOS, TOMAR NOTA -> IMPORTANTE <-
                                                                                        if ($filas['nombreproducto'] != "Cuentas de Ahorro Personales" && $filas['nombreproducto'] != "Depósito a Plazo Fijo" && $filas['nombreproducto'] != "Préstamos de Vehículos" && $filas['nombreproducto'] != "Préstamos Personales") {
                                                                                            echo '
                                                                    		<option value="';
                                                                                            echo $filas['idproducto'];
                                                                                            echo '">';
                                                                                            echo $filas['nombreproducto'];
                                                                                            echo '</option>';
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 mb-2">
                                                                    <div class="form-group">
                                                                        <label class="text-label">Seleccione un tipo de cliente <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-12">
                                                                            <select class="form-control" class="tipoclientecredito" id="valtipoclientecredito" name="tipoclientecredito">
                                                                                <?php
                                                                                if ($Gestiones->getTipoClienteCreditos() == "asalariado") {
                                                                                    echo '
																	<option value="asalariado">Empleados (Asalariados)</option>
																	<option value="jubilado">Jubilados (Pensionados)</option>
																	<option value="independiente">Independientes (Formal &Uacute;nicamente)</option>
																	';
                                                                                } else if ($Gestiones->getTipoClienteCreditos() == "jubilado") {
                                                                                    echo '
																	<option value="jubilado">Jubilados (Pensionados)</option>
																	<option value="independiente">Independientes (Formal &Uacute;nicamente)</option>
																	<option value="asalariado">Empleados (Asalariados)</option>
																	';
                                                                                } else if ($Gestiones->getTipoClienteCreditos() == "independiente") {
                                                                                    echo '
																	<option value="independiente">Independientes (Formal &Uacute;nicamente)</option>
																	<option value="asalariado">Empleados (Asalariados)</option>
																	<option value="jubilado">Jubilados (Pensionados)</option>
																	';
                                                                                }
                                                                                ?>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 mb-2">
                                                                    <div class="form-group">
                                                                        <label class="text-label">Tasa de Inter&eacute;s Cr&eacute;dito <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-12">
                                                                            <div class="etiqueta text-center"></div>
                                                                            <?php
                                                                            // VALIDACION SEGUN TIPO DE PRESTAMO, RANGO DE INTERESES MINIMOS Y MAXIMOS
                                                                            if ($Gestiones->getNombreProductos() == "Préstamos Personales") {
                                                                            ?>
                                                                                <input type="range" class="form-control" value="<?php echo $Gestiones->getTasaInteresCreditos(); ?>" min="3" max="20" autocomplete="off" id="rangointereses" name="rangointereses" onKeyUp="CalculoCuotaMensual()" step="0.05">
                                                                                <p>(% Por Ciento Mensual)</p>
                                                                            <?php } else if ($Gestiones->getNombreProductos() == "Préstamos de Vehículos") { ?>
                                                                                <input type="range" class="form-control" value="<?php echo $Gestiones->getTasaInteresCreditos(); ?>" min="10" max="60" autocomplete="off" id="rangointereses" name="rangointereses" onKeyUp="CalculoCuotaMensual()" step="0.05">
                                                                                <p>(% Por Ciento Mensual)</p>
                                                                            <?php } else if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") { ?>
                                                                                <input type="range" class="form-control" value="<?php echo $Gestiones->getTasaInteresCreditos(); ?>" min="1.05" max="12" autocomplete="off" id="rangointereses" name="rangointereses" onKeyUp="CalculoCuotaMensualHipotecas()" step="0.05">
                                                                                <p>(% Por Ciento Mensual)</p>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 mb-2">
                                                                    <div id="consultarequisitos"></div>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <div class="form-group">
                                                                        <label class="text-label">Salario de Cliente <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-12">
                                                                            <div class="input-group mb-3  input-primary">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">$</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" id="valsalariocliente" name="valsalariocliente" placeholder="Ingrese el salario l&iacute;quido de cliente" value="<?php echo $Gestiones->getSalarioClienteCreditos(); ?>" onkeypress="return (event.charCode <= 57)">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <div class="form-group">
                                                                        <label class="text-label">Monto de Cr&eacute;dito <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-12">
                                                                            <div class="input-group mb-3  input-primary">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">$</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" id="valmontocreditoclientes" name="valmontocreditoclientes" placeholder="Ingrese monto de cr&eacute;dito" value="<?php echo floor($Gestiones->getMontoFinanciamientoCreditos()); ?>" onKeyUp="<?php if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") {
                                                                                                                                                                                                                                                                                                                            echo "CalculoCuotaMensualHipotecas()";
                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                            echo "CalculoCuotaMensual()";
                                                                                                                                                                                                                                                                                                                        } ?>" onkeypress="return (event.charCode <= 57)">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <div class="form-group">
                                                                        <label class="text-label">N&uacute;mero de Meses Plazo Cr&eacute;dito <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-12">
                                                                            <div class="input-group mb-3  input-primary">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="ti ti-shopping-cart-full"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" id="valplazocredito" name="valplazocredito" placeholder="Ingrese el n&uacute;mero de meses plazo" value="<?php echo $Gestiones->getTiempoPlazoCreditos(); ?>" onKeyUp="<?php if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") {
                                                                                                                                                                                                                                                                                                    echo "CalculoCuotaMensualHipotecas()";
                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                    echo "CalculoCuotaMensual()";
                                                                                                                                                                                                                                                                                                } ?>" onkeypress="return (event.charCode <= 57)" maxlength="3">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-2">
                                                                    <div class="form-group">
                                                                        <label class="text-label">Fecha Ingreso Solicitud <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-12">
                                                                            <div class="input-group mb-3  input-primary">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                                                                </div>
                                                                                <input style="cursor: no-drop;" type="text" class=" form-control" id="valfechaingresosolicitud" name="valfechaingresosolicitud" placeholder="Ingrese fecha de inicio de cr&eacute;dito" value="<?php echo $Gestiones->getFechaIngresoSolicitudCreditos() ?>" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 mb-2">
                                                                    <div class="form-group">
                                                                        <label class="text-label">¿Procede esta nueva asignaci&oacute;n de cr&eacute;dito? Seleccione un estado <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-12">
                                                                            <select class="form-control" class="tipoclientecredito" id="valestadoinicialcreditos" name="valestadoinicialcreditos">
                                                                                <option value="">Seleccione una opci&oacute;n...</option>
                                                                                <option value="reestructuracion">Cr&eacute;dito Necesita Reestructurarse</option>
                                                                                <option value="denegado">Cr&eacute;dito Denegado (Rechazado)</option>
                                                                                <option value="aprobacioninicial">Cr&eacute;dito Aprobado, Pasa a &Uacute;ltima Revisi&oacute;n</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 mb-2">
                                                                    <div class="form-group">
                                                                        <label class="text-label">Observaciones <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-12">
                                                                            <div class="input-group mb-3  input-primary">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="ti ti-ruler-pencil"></i></span>
                                                                                </div>
                                                                                <textarea class="form-control" placeholder="Ingrese las observaciones de seguimiento para este tr&aacute;mite" id="valobservacionesgerencia" name="valobservacionesgerencia" rows="5"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <h4 class="text-primary mb-4">C&aacute;lculo Cuota Mensual Final</h4>
                                                                    <div class="tarjeta" id="tarjeta">
                                                                        <div class="col-xl-12 col-lg-12 col-sm-12">
                                                                            <div class="widget-stat card bg-dark">
                                                                                <div class="card-body p-4">
                                                                                    <div class="media">
                                                                                        <span class="mr-3">
                                                                                            <img class="img-fluid" src="<?php echo $UrlGlobal; ?>vista/images/3d_dollarsing.gif" alt="logo-dolar">
                                                                                        </span>
                                                                                        <div class="media-body text-white text-center">
                                                                                            <p class="mb-1">Cuota Mensual</p>
                                                                                            <h3 class="text-white">$ <span class="resultado" id="resultado"><?php echo $Gestiones->getCuotaMensualCreditos(); ?></span> USD.</h3>
                                                                                            <div class="progress mb-2 bg-secondary">

                                                                                            </div>
                                                                                            <small style="font-size: 1rem;"><strong>Su cr&eacute;dito solicitado es de $ <span id="monto-credito-solicitado" class="monto-credito-solicitado"><strong><?php echo number_format($Gestiones->getMontoFinanciamientoCreditos(), 2); ?></strong></span> USD.</strong></small><br>
                                                                                            <?php
                                                                                            if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") {
                                                                                            ?>
                                                                                                <small style="font-size: .95rem;"><strong>Monto final a financiar: $<span class="calculofinanciamientomaximo" id="calculofinanciamientomaximo"><?php echo number_format($Gestiones->getMontoFinanciamientoCreditos() * .9, 2); ?></span> USD.</strong></small><br>
                                                                                                <small style="font-size: .8rem;"><strong>Monto final a entregar: $<span class="calculodesembolso" id="calculodesembolso"><?php echo number_format($DesembolsoClientes = $Gestiones->getMontoFinanciamientoCreditos() * .9 - $GastosAdministrativos, 2) ?></span> USD.</strong></small><br>
                                                                                            <?php } else { ?>
                                                                                                <small style="font-size: .8rem;"><strong>Monto final a entregar: $<span class="calculodesembolso" id="calculodesembolso"><?php echo number_format($DesembolsoClientes = $Gestiones->getMontoFinanciamientoCreditos() - $GastosAdministrativos, 2) ?></span> USD.</strong></small><br>
                                                                                            <?php } ?>
                                                                                            <ul class="list-group list-group-flush">
                                                                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Tasa de Inter&eacute;s Mensual : </span><span><strong id="tasa-interes-credito" class="tasa-interes-credito"></strong>%</span> </li>
                                                                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Plazo :</span><strong id="plazo-credito" class="plazo-credito"><?php echo $Gestiones->getTiempoPlazoCreditos(); ?> <?php if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") {
                                                                                                                                                                                                                                                                                                        echo "a&ntilde;os";
                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                        echo "meses";
                                                                                                                                                                                                                                                                                                    } ?></strong></li>
                                                                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Seguro Deuda : </span><span><strong>$</strong><strong id="segurodeuda" class="segurodeuda">
                                                                                                            <?php echo number_format($SeguroDeuda, 2); ?>
                                                                                                        </strong><strong> USD</strong></span> </li>
                                                                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Gastos Administrativos : </span><span><strong>$</strong><strong id="gastosadministrativos" class="gastosadministrativos"><?php echo number_format($GastosAdministrativos, 2); ?></strong><strong> USD</strong></span></li>
                                                                                                <?php if ($Gestiones->getNombreProductos() == "Préstamos de Vehículos") { ?>
                                                                                                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Servicio GPS : </span><span><strong>$</strong><strong id="serviciogps" class="serviciogps"><?php echo $ServicioGPS; ?></strong><strong> USD</strong></span> </li><br>
                                                                                                    <p>** Todos los clientes est&aacute;n obligados a contratar una p&oacute;liza de seguro contra da&ntilde;os. Es parte de los requisitos para poder aprobar dicho cr&eacute;dito. <strong>La compa&ntilde;ia puede ser de su elecci&oacute;n.</strong></p>
                                                                                                <?php } ?>
                                                                                                <?php
                                                                                                if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") {
                                                                                                ?>
                                                                                                    <br>
                                                                                                    <p>** Gastos de escrituraci&oacute;n, aval&uacute;o y relacionados, ser&aacute;n por cuenta del cliente ante la entidad correspondiente.</p>
                                                                                                <?php } ?>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- ENVIO DATOS -->
                                                                <button type="submit" id="enviar-datos-creditos" class="btn light btn-success"><i class="ti-hand-point-right"></i> Aprobar Primera Revisi&oacute;n Solicitud de Cr&eacute;dito</button>
                                                        </form>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>

            </div>
            </div>
            </div>
            <!--**********************************
            Content body end
        ***********************************-->


            <!--**********************************
            Footer start
        ***********************************-->
            <div class="footer">
                <div class="copyright">
                    <p>Copyright &copy; <?php echo date('Y'); ?> CrediAgil &amp; Desarrollo de Sistemas CrediAgil</p>
                </div>
            </div>
            <!--**********************************
            Footer end
        ***********************************-->

            <!--**********************************
           Support ticket button start
        ***********************************-->

            <!--**********************************
           Support ticket button end
        ***********************************-->


            </div>
            <!--**********************************
        Main wrapper end
    ***********************************-->

            <!--**********************************
        Scripts
    ***********************************-->
            <!-- Required vendors -->
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/global/global.min.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/js/custom.min.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/js/deznav-init.js"></script>
            <!-- Jquery Validation -->
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/jquery-validation/jquery.validate.min.js"></script>
            <!-- Form validate init -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/jquery.validate-init.js"></script>
            <!-- Daterangepicker -->
            <!-- momment js is must -->
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/moment/moment.min.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
            <!-- clockpicker -->
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/clockpicker/js/bootstrap-clockpicker.min.js"></script>
            <!-- asColorPicker -->
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/jquery-asColor/jquery-asColor.min.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/jquery-asGradient/jquery-asGradient.min.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js"></script>
            <!-- Material color picker -->
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
            <!-- pickdate -->
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/pickadate/picker.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/pickadate/picker.time.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/pickadate/picker.date.js"></script>



            <!-- Daterangepicker -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/bs-daterange-picker-init.js"></script>
            <!-- Clockpicker init -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/clock-picker-init.js"></script>
            <!-- asColorPicker init -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/jquery-asColorPicker.init.js"></script>
            <!-- Material color picker init -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/material-date-picker-init.js"></script>
            <!-- Pickdate -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/pickadate-init.js"></script>
            <!-- Mask -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/mask.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/js/mascaras-datos.js"></script>
            <!-- Dropzone JavaScript -->
            <script src="<?php echo $UrlGlobal; ?>vista/dropzone/dist/dropzone.js"></script>
            <!-- Dropify JavaScript -->
            <script src="<?php echo $UrlGlobal; ?>vista/dropify/dist/js/dropify.min.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/js/dropzone-configuration.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/js/alerta-ingreso-nuevos-productos-CrediAgil.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/js/comprobarCodigoUnicoProductos.js"></script>
            <!-- Datatable -->
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/datatables.init.js"></script>
            <!-- Time ago -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/jquery.timeago.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/js/control_tiempo.js"></script>
            <!-- Toastr -->
            <script src="<?php echo $UrlGlobal; ?>vista/vendor/toastr/js/toastr.min.js"></script>
            <!-- All init script -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/toastr-init.js"></script>
            <!-- Mask -->
            <script src="<?php echo $UrlGlobal; ?>vista/js/mask.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/js/mascara-datos-productos.js"></script>
            <script src="<?php echo $UrlGlobal; ?>vista/dist/mc-calendar.min.js"></script>
            <?php
            // VALIDACION DE CARGA DE SCRIPTS SEGUN PRODUCTO REGISTRADO EN LA SOLICITUD DE CREDITO
            // -> PRESTAMOS PERSONALES
            if ($Gestiones->getNombreProductos() == "Préstamos Personales") {
            ?>
                <script src="<?php echo $UrlGlobal; ?>vista/js/gestiones-creditos.js"></script>
                <script src="<?php echo $UrlGlobal; ?>vista/js/calculocuotamensualclientes.js"></script>
                <script src="<?php echo $UrlGlobal; ?>vista/js/ConsultarRequisitosPrestamosPersonales.js"></script>
            <?php
                // -> PRESTAMOS HIPOTECARIOS
            } else if ($Gestiones->getNombreProductos() == "Préstamos Hipotecarios") { ?>
                <script src="<?php echo $UrlGlobal; ?>vista/js/gestiones-creditos-hipotecarios.js"></script>
                <script src="<?php echo $UrlGlobal; ?>vista/js/calculocuotamensualhipotecasclientes.js"></script>
                <script src="<?php echo $UrlGlobal; ?>vista/js/ConsultarRequisitosPrestamosHipotecarios.js"></script>
            <?php
                // -> PRESTAMOS PARA VEHICULOS
            } else if ($Gestiones->getNombreProductos() == "Préstamos de Vehículos") { ?>
                <script src="<?php echo $UrlGlobal; ?>vista/js/gestiones-creditos.js"></script>
                <script src="<?php echo $UrlGlobal; ?>vista/js/calculocuotamensualvehiculos.js"></script>
                <script src="<?php echo $UrlGlobal; ?>vista/js/ConsultarRequisitosPrestamosVehiculos.js"></script>
            <?php } ?>
            <script src="<?php echo $UrlGlobal; ?>vista/js/alerta-actualizacion-revisiones-solicitudes-creditos-clientes.js"></script>
            <script>
                const firstCalendar = MCDatepicker.create({
                    el: '#valfechaingresosolicitud',
                    customMonths: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    customWeekDays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'],
                    dateFormat: 'YYYY-MM-DD',
                    customOkBTN: 'OK',
                    customClearBTN: 'Limpiar',
                    customCancelBTN: 'Cancelar',
                    disableWeekends: true,
                    minDate: new Date(),

                })
            </script>

        </body>

        </html>
<?php }
} ?>