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
		<title>CrediAgil | Registro Nuevos Usuarios</title>
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
		<link rel="stylesheet" href="<?php echo $UrlGlobal; ?>vista/dist/mc-calendar.min.css" />

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
							<li class="breadcrumb-item"><a href="javascript:void(0)">Usuarios</a></li>
							<li class="breadcrumb-item active"><a href="javascript:void(0)">Registrar Detalles Usuarios</a></li>
						</ol>
					</div>
					<div class="row">
						<div class="col-xl-12">
							<div class="alert alert-danger left-icon-big alert-dismissible fade show">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
								<div class="media">
									<div class="alert-left-icon-big">
										<span><i class="mdi mdi-help-circle-outline"></i></span>
									</div>
									<div class="media-body">
										<h5 class="mt-1 mb-2">Instrucciones:</h5>
										<p class="mb-0">
											<i class="ti-direction"></i> Por favor complete todos los campos requeridos <strong>( * )</strong>. Respete el orden al momento de adjuntar los respectivos documentos solicitados. <br><br>
											<i class="ti-direction"></i> En los campos [Dui, Nit y Firma]. <strong>Por favor establezca un nombre claro y conciso seg&uacute;n los campos mencionados.</strong> Esto con el fin de mantener una buena organizaci&oacute;n de los diferentes archivos alojados en nuestro servidor, y facilitar su b&uacute;squeda en posteriores usos. <strong>Evite el uso de solo n&uacute;meros.</strong>
										</p>
									</div>
								</div>
							</div>
							<div class="card-body">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#home8">
											<span>
												<i class="ti-id-badge"></i>
											</span>
										</a>
									</li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content tabcontent-border">
									<div class="tab-pane fade show active" id="home8" role="tabpanel">
										<div class="pt-4">
											<h4>Registrar Detalle de Usuario / Cliente CrediAgil</h4><br>
											<form id="ingreso-detalles-nuevos-clientes" class="validacion-registro-detalles-usuarios" method="post" autocomplete="off" enctype="multipart/form-data">
												<div class="row form-validation">
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">Dui <span class="text-danger">*</span></label>
															<input type="hidden" name="codigounicousuario" value="<?php echo $_GET['codigounicousuario']; ?>">
															<div class="col-lg-12">
																<input type="text" class="form-control" id="val-dui" name="val-dui" placeholder="XXXXXXXX-X" onkeypress="return (event.charCode <= 57)">
															</div>
														</div>
													</div>
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">Nit <span class="text-danger">*</span></label>
															<div class="col-lg-12">
																<input type="text" class="form-control" id="val-nit" name="val-nit" placeholder="XXXX-XXXXXX-XXX-X" onkeypress="return (event.charCode <= 57)">
															</div>
														</div>
													</div>
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">Tel&eacute;fono </label>
															<div class="col-lg-12">
																<input type="text" class="form-control" id="val-telefono1" name="val-telefono1" placeholder="XXXX-XXXX" onkeypress="return (event.charCode <= 57)">
															</div>
														</div>
													</div>
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">Celular</label>
															<div class="col-lg-12">
																<input type="text" class="form-control" id="val-telefono2" name="val-telefono2" placeholder="XXXX-XXXX" onkeypress="return (event.charCode <= 57)">
															</div>
														</div>
													</div>
													<div class="col-lg-12 mb-2">
														<div class="form-group">
															<label class="text-label">Direcci&oacute;n Residencia Completa <span class="text-danger">*</span></label>
															<div class="col-lg-12">
																<textarea class="form-control" placeholder="Ingrese su direcci&oacute;n de residencia completa" id="val-direccion1" name="val-direccion1" rows="3"></textarea>
															</div>
														</div>
													</div>
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">Nombre empresa donde labora <span class="text-danger">*</span></label>
															<div class="col-lg-12">
																<input type="text" class="form-control" id="val-nombreempresa" name="val-nombreempresa" placeholder="Ingrese nombre de empresa d&oacute;nde labora">
															</div>
														</div>
													</div>
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">Cargo que desempe&ntilde;a <span class="text-danger">*</span></label>
															<div class="col-lg-12">
																<input type="text" class="form-control" id="val-cargoempresa" name="val-cargoempresa" placeholder="Ingrese el cargo que desempe&ntilde;a">
															</div>
														</div>
													</div>
													<div class="col-lg-12 mb-2">
														<div class="form-group">
															<label class="text-label">Direcci&oacute;n donde trabaja completa <span class="text-danger">*</span></label>
															<div class="col-lg-12">
																<textarea class="form-control" placeholder="Ingrese direcci&oacute;n completa d&oacute;nde labora" id="val-direccion2" name="val-direccion2" rows="3"></textarea>
															</div>
														</div>
													</div>
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">Tel&eacute;fono empresa donde labora </label>
															<div class="col-lg-12">
																<input type="text" class="form-control" id="val-telefono3" name="val-telefono3" placeholder="XXXX-XXXX" onkeypress="return (event.charCode <= 57)">
															</div>
														</div>
													</div>
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
															<div class="col-lg-12">
																<input type="text" class=" form-control" id="val-fechanacimiento" name="val-fechanacimiento" placeholder="Ingrese su fecha de nacimiento">
															</div>
														</div>
													</div>
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">G&eacute;nero <span class="text-danger">*</span></label>
															<div class="col-lg-12">
																<select class="form-control" id="val-genero" name="val-genero">
																	<option value="">Seleccione una opci&oacute;n...</option>
																	<option value="m">Masculino</option>
																	<option value="f">Femenino</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-lg-6 mb-2">
														<div class="form-group">
															<label class="text-label">Estado Civil <span class="text-danger">*</span></label>
															<div class="col-lg-12">
																<select class="form-control" id="val-estadocivil" name="val-estadocivil">
																	<option value="">Seleccione una opci&oacute;n...</option>
																	<option value="Soltero">Soltero(a)</option>
																	<option value="Casado">Casado(a)</option>
																	<option value="Divorciado">Divorciado(a)</option>
																	<option value="Comprometido">Comprometido(a)</option>
																	<option value="Viudo">Viudo(a)</option>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="form-group">
														<label class="text-label">Adjuntar documento &uacute;nico de identidad <strong>(DUI <i class="ti-hand-point-right"></i> Frontal)<span class="text-danger"> *</span></strong></label>
														<div class="col-lg-12">
															<input type="file" name="fotoduiusuariosfrontal" id="fotoduiusuariosfrontal" class="dropify" data-max-file-size="3M" accept="image/x-png,image/jpeg,image/jpg,image/gif" data-allowed-file-extensions='["png", "jpeg","jpg","gif"]' required />
														</div>
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="form-group">
														<label class="text-label">Adjuntar documento &uacute;nico de identidad <strong>(DUI <i class="ti-hand-point-right"></i> Reverso)<span class="text-danger"> *</span></strong></label>
														<div class="col-lg-12">
															<input type="file" name="fotoduiusuariosreverso" id="fotoduiusuariosreverso" class="dropify" data-max-file-size="3M" accept="image/x-png,image/jpeg,image/jpg,image/gif" data-allowed-file-extensions='["png", "jpeg","jpg","gif"]' required />
														</div>
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="form-group">
														<label class="text-label">Adjuntar documento n&uacute;mero de identificaci&oacute;n tributaria <strong>(NIT <i class="ti-hand-point-right"></i> Frontal)<span class="text-danger"> *</span></strong></label>

														<div class="col-lg-12">
															<input type="file" name="fotonitusuarios" id="fotonitusuarios" class="dropify" data-max-file-size="3M" accept="image/x-png,image/jpeg,image/jpg,image/gif" data-allowed-file-extensions='["png", "jpeg","jpg","gif"]' required />
														</div>
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="form-group">
														<label class="text-label">Adjuntar Firma de Cliente<span class="text-danger"> *</span></label>
														<div class="col-lg-12">
															<input type="file" name="fotofirmausuarios" id="fotofirmausuarios" class="dropify" data-max-file-size="3M" accept="image/x-png,image/jpeg,image/jpg,image/gif" data-allowed-file-extensions='["png", "jpeg","jpg","gif"]' required />
														</div>
													</div>
												</div>
												<!-- ENVIO DATOS -->
												<button type="submit" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="ti-user"></i></span>Registrar Detalle de Usuario</button>
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
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-ingreso-detalles-nuevos-usuarios-clientes.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/comprobarcontrasenia.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/comprobarUsuarioUnico.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/comprobarCorreoPerfilUsuarios.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/control-ingreso-usuarios.js"></script>
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
		<script src="<?php echo $UrlGlobal; ?>vista/dist/mc-calendar.min.js"></script>
		<script>
			const firstCalendar = MCDatepicker.create({
				el: '#val-fechanacimiento',
				customMonths: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				customWeekDays: ['Domingo', 'Lunes', 'Martes', 'Mi?rcoles', 'Jueves', 'Viernes', 'Sabado'],
				dateFormat: 'YYYY-MM-DD',
				customOkBTN: 'OK',
				customClearBTN: 'Limpiar',
				customCancelBTN: 'Cancelar',
				minDate: new Date(1940, 01, 01),
				maxDate: new Date(2003, 11, 31),
			})
		</script>

	</body>

	</html>

<?php } ?>




