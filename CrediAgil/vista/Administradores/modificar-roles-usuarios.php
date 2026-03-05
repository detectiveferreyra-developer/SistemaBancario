<?php
// IMPORTANDO MODELO DE CLIMA EN TIEMPO REAL -> API CLIMA OPENWEATHERMAP
require('../modelo/mAPIClima_Openweathermap.php');
// IMPORTANDO MODELO DE CONTEO NUMERO DE NOTIFICACIONES RECIBIDAS
require('../modelo/mConteoNotificacionesRecibidasUsuarios.php');
// IMPORTANDO MODELO DE CONTEO NUMERO DE MENSAJES RECIBIDOS

// DATOS DE LOCALIZACION -> IDIOMA ESPA?OL -> ZONA HORARIA EL SALVADOR (UTC-6)
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/El_Salvador');
// OBTENER HORA LOCAL
$hora = new DateTime("now");
// NO PERMITIR INGRESO SI PARAMETRO DE ROL DE USUARIOS SE ENCUENTRA VACIO
if (empty($_GET['idunicorolusuarios'])) {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=redirecciones-sistema-CrediAgil');
}
// NO PERMITIR INGRESO SI NO EXISTE INFORMACION QUE MOSTRAR
if (empty($Gestiones->getIdRolUsuarios())) {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=redirecciones-sistema-CrediAgil');
}
// SI LOS USUARIOS INICIAN POR PRIMERA VEZ, MOSTRAR PAGINA DONDE DEBERAN REALIZAR EL CAMBIO OBLIGATORIO DE SU CONTRASE?A GENERADA AUTOMATICAMENTE
if ($_SESSION['comprobar_iniciosesion_primeravez'] == "si") {
    header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=gestiones-nuevos-usuarios-registrados');
    // CASO CONTRARIO, MOSTRAR PORTAL DE USUARIOS -> SEGUN ROL DE USUARIO ASIGNADO
} else {
?>
    <!-- 

?????????????????????????????????????????????????????????
?????????????????????????????????????????????????????????
??=======================================================
??              CrediAgil S.A DE C.V                                                  
??          SISTEMA FINANCIERO / BANCARIO 
??=======================================================                      
??                                                                               
?? -> AUTOR: DANIEL RIVERA                                                               
?? -> PHP 8.1, MYSQL, MVC, JAVASCRIPT, AJAX, JQUERY                       
?? -> GITHUB: (danielrivera03)                                             
?? -> TODOS LOS DERECHOS RESERVADOS                           
??     ? 2021 - 2022    
??                                                      
?? -> POR FAVOR TOMAR EN CUENTA TODOS LOS COMENTARIOS
??    Y REALIZAR LOS AJUSTES PERTINENTES ANTES DE INICIAR
??
??          ?? HECHO CON MUCHAS TAZAS DE CAFE ??
??                                                                               
??????????????????????????????????????????????????????????
??????????????????????????????????????????????????????????

-->
    <!DOCTYPE html>
    <html lang="ES-SV">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>CrediAgil | Modificar Roles de Usuarios</title>
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
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
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
<a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales" class="brand-logo">
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
            Sidebar start
        ***********************************-->
            <?php
            // IMPORTAR MENU DE NAVEGACION PARA USUARIOS ROL ADMINISTRADORES
            require('../vista/MenuNavegacion/menu-administradores.php');
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Roles</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Modificar Roles de Usuarios</a></li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div id="accordion-six" class="accordion accordion-with-icon accordion-danger-solid">
                                <div class="accordion__item">
                                    <div class="accordion__header collapsed" data-toggle="collapse" data-target="#with-icon_collapseOne">
                                        <span class="accordion__header--icon"></span>
                                        <span class="accordion__header--text">Por favor, antes de continuar</span>
                                        <span class="accordion__header--indicator indicator_bordered"></span>
                                    </div>
                                    <div id="with-icon_collapseOne" class="accordion__body collapse" data-parent="#accordion-six">
                                        <div class="accordion__body--text"><i class="ti-direction"></i> Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
                                                                                                                    $PrimerNombre = explode(' ', $Nombre, 2);
                                                                                                                    print_r($PrimerNombre[0]); ?>, el registro de nuevos roles de usuarios, as&iacute; como su mantenimiento debe ser autorizado previamente en presidencia y gerencia.<strong> Le ser&aacute; notificado con much&iacute;sima anticipaci&oacute;n para realizar los respectivos cambios dentro del sistema. Adem&aacute;s le recordamos que cualquier cambio imprevisto, puede afectar seriamente la funcionalidad del sistema.</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
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
                                                <h4>Modificar Roles de Usuarios - CrediAgil</h4><br>
                                                <?php
                                                // SOLO UN ADMINISTRADOR TENDRA AUTORIZACION DE REALIZAR EL CAMBIO DE NOMBRE DE ROLES DE USUARIOS REGISTRADOS
                                                if ($_SESSION['usuario_unico'] != "daniel.rivera") {
                                                ?>
                                                    <div class="alert alert-danger alert-dismissible alert-alt fade show">
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Tomar Nota:</strong> Estimado <?php $Nombre = $_SESSION['nombre_usuario'];
                                                                                                $PrimerNombre = explode(' ', $Nombre, 2);
                                                                                                print_r($PrimerNombre[0]); ?>, usted no tiene autorizaci&oacute;n para realizar cambios en el nombre de los roles de usuarios. Lo anterior para evitar cambios que afecten significativamente el funcionamiento de la plataforma.
                                                    </div>
                                                <?php } ?>
                                                <form id="modificar-nuevos-roles-usuarios" class="validacion-registro-roles-usuarios" method="post" autocomplete="off" enctype="multipart/form-data">
                                                    <div class="row form-validation">
                                                        <div class="col-lg-12 mb-2">
                                                            <div class="form-group">
                                                                <input type="hidden" name="idunicorolusuarios" value="<?php echo $Gestiones->getIdRolUsuarios(); ?>">
                                                                <label class="text-label">Nombre de Rol de Usuario <span class="text-danger">*</span></label>
                                                                <div class="col-lg-12">
                                                                    <input type="text" class="form-control" id="val-nombrerolusuarios" name="val-nombrerolusuarios" placeholder="Ingrese el nombre del nuevo rol de usuario a registrar" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $Gestiones->getNombreRolUsuario(); ?>" <?php
                                                                                                                                                                                                                                                                                                                                                            // SOLO UN ADMINISTRADOR TENDRA AUTORIZACION DE REALIZAR EL CAMBIO DE NOMBRE DE ROLES DE USUARIOS REGISTRADOS
                                                                                                                                                                                                                                                                                                                                                            if ($_SESSION['usuario_unico'] != "daniel.rivera") {
                                                                                                                                                                                                                                                                                                                                                                echo 'readonly style="cursor: no-drop;"';
                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                            ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 mb-2">
                                                            <div class="form-group">
                                                                <label class="text-label">Descripci&oacute;n Completa <span class="text-danger">*</span></label>
                                                                <div class="col-lg-12">
                                                                    <textarea class="form-control" placeholder="Ingrese la descripci&oacute;n completa del nuevo rol de usuario a registrar" id="val-descripcion-rolusuarios" name="val-descripcion-rolusuarios" rows="3"><?php echo $Gestiones->getDescripcionRolUsuario(); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- ENVIO DATOS -->
                                                    <button type="submit" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="ti-user"></i></span>Modificar Rol de Usuario</button>
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
        <script src="<?php echo $UrlGlobal; ?>vista/js/alerta-modificar-roles-usuarios.js"></script>
        <!-- Datatable -->
        <script src="<?php echo $UrlGlobal; ?>vista/vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/datatables.init.js"></script>
        <!-- Toastr -->
        <script src="<?php echo $UrlGlobal; ?>vista/vendor/toastr/js/toastr.min.js"></script>
        <!-- All init script -->
        <script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/toastr-init.js"></script>
        <!-- Time ago -->
        <script src="<?php echo $UrlGlobal; ?>vista/js/jquery.timeago.js"></script>
        <script src="<?php echo $UrlGlobal; ?>vista/js/control_tiempo.js"></script>

    </body>

    </html>
<?php } ?>




