<?php
// IMPORTANDO MODELO DE CLIMA EN TIEMPO REAL -> API CLIMA OPENWEATHERMAP
require('../modelo/mAPIClima_Openweathermap.php');
// IMPORTANDO MODELO DE CONTEO NUMERO DE NOTIFICACIONES RECIBIDAS
require('../modelo/mConteoNotificacionesRecibidasUsuarios.php');
// IMPORTANDO MODELO DE CONTEO NUMERO DE MENSAJES RECIBIDOS

// DATOS DE LOCALIZACION -> IDIOMA ESPA�OL -> ZONA HORARIA EL SALVADOR (UTC-6)
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/El_Salvador');
// OBTENER HORA LOCAL
$hora = new DateTime("now");
// NO PERMITIR INGRESO SI PARAMETRO DE ROL DE PRODUCTOS SE ENCUENTRA VACIO
if (empty($_GET['idproducto'])) {
	header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=redirecciones-sistema-CrediAgil');
}
// NO PERMITIR INGRESO SI NO EXISTE INFORMACION QUE MOSTRAR
if (empty($Gestiones->getNombreProductos())) {
	header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=redirecciones-sistema-CrediAgil');
}
// SI LOS USUARIOS INICIAN POR PRIMERA VEZ, MOSTRAR PAGINA DONDE DEBERAN REALIZAR EL CAMBIO OBLIGATORIO DE SU CONTRASE�A GENERADA AUTOMATICAMENTE
if ($_SESSION['comprobar_iniciosesion_primeravez'] == "si") {
	header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=gestiones-nuevos-usuarios-registrados');
	// CASO CONTRARIO, MOSTRAR PORTAL DE USUARIOS -> SEGUN ROL DE USUARIO ASIGNADO
} else {
?>
	<!-- 

���������������������������������������������������������
���������������������������������������������������������
��=======================================================
��              CrediAgil S.A DE C.V                                                  
��          SISTEMA FINANCIERO / BANCARIO 
��=======================================================                      
��                                                                               
�� -> AUTOR: DANIEL RIVERA                                                               
�� -> PHP 8.1, MYSQL, MVC, JAVASCRIPT, AJAX, JQUERY                       
�� -> GITHUB: (danielrivera03)                                             
�� -> TODOS LOS DERECHOS RESERVADOS                           
��     � 2021 - 2022    
��                                                      
�� -> POR FAVOR TOMAR EN CUENTA TODOS LOS COMENTARIOS
��    Y REALIZAR LOS AJUSTES PERTINENTES ANTES DE INICIAR
��
��          ?? HECHO CON MUCHAS TAZAS DE CAFE ??
��                                                                               
����������������������������������������������������������
����������������������������������������������������������

-->
	<!DOCTYPE html>
	<html lang="ES-SV">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>CrediAgil | Modificar Producto <?php echo $Gestiones->getNombreProductos(); ?></title>
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
<a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=inicioadministradores" class="brand-logo">
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
							<li class="breadcrumb-item"><a href="javascript:void(0)">Productos</a></li>
							<li class="breadcrumb-item active"><a href="javascript:void(0)">Registrar Productos</a></li>
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
										<div class="accordion__body--text">
											<i class="ti-direction"></i> Estimado(a) Daniel, por favor a la hora de editar los requisitos de productos, separe por comas <strong>[ , ] </strong> los diferentes apartados. Adem&aacute;s tome en cuenta que los c&oacute;digos &uacute;nicos solamente deben llevar 10 caracteres.
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
												<h4>Modificar Productos - CrediAgil</h4><br>
												<form id="modificar-productos" class="validacion-registro-productos" method="post" autocomplete="off" enctype="multipart/form-data">
													<div class="row form-validation">
														<div class="col-lg-6 mb-2">
															<input type="hidden" name="val-idunico-producto" value="<?php echo $Gestiones->getIdProductos(); ?>">
															<div class="form-group">
																<label class="text-label">C&oacute;digo &Uacute;nico <span class="text-danger">*</span></label>
																<div class="col-lg-12">
																	<input type="text" class="form-control" id="val-codigoproducto" name="val-codigoproducto" placeholder="Ingrese el c&oacute;digo &uacute;nico del producto" onBlur="comprobarCodigoProductos()" value="<?php echo $Gestiones->getCodigoProductos(); ?>">
																	<div class="col-md-12">
																		<span id="estadocodigo"></span>
																	</div>
																	<p><img style="width: 25px; margin: 1rem 0 0 0; display:none;" src="../vista/images/Spinner.svg" id="loaderIcon" /></p>
																</div>
															</div>
														</div>
														<div class="col-lg-6 mb-2">
															<div class="form-group">
																<label class="text-label">Nombre <span class="text-danger">*</span></label>
																<div class="col-lg-12">
																	<input type="text" class="form-control" id="val-nombreproducto" name="val-nombreproducto" placeholder="Ingrese el nombre del producto" value="<?php echo $Gestiones->getNombreProductos(); ?>">
																</div>
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label">Descripci&oacute;n Completa <span class="text-danger">*</span></label>
																<div class="col-lg-12">
																	<textarea class="form-control" placeholder="Ingrese la descripci&oacute;n completa del producto a registrar" id="val-descripcion-producto" name="val-descripcion-producto" rows="3"><?php echo $Gestiones->getDescripcionProductos(); ?></textarea>
																</div>
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label">Requisitos <span class="text-danger">*</span></label>
																<div class="col-lg-12">
																	<textarea class="form-control" placeholder="Ingrese los requisitos completos de este producto" id="val-requisitos-producto" name="val-requisitos-producto" rows="3"><?php echo $Gestiones->getRequisitosProductos(); ?></textarea>
																</div>
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label">Seleccione Un Estado <span class="text-danger">*</span></label>
																<div class="col-lg-12">
																	<select class="form-control" id="val-estado-producto" name="val-estado-producto">
																		<?php if ($Gestiones->getEstadoProductos() == "activo") { ?>
																			<option value="activo">Producto Activo</option>
																			<option value="inactivo">Producto Inactivo</option>
																			<option value="expirado">Producto Expirado</option>
																		<?php } else if ($Gestiones->getEstadoProductos() == "inactivo") { ?>
																			<option value="inactivo">Producto Inactivo</option>
																			<option value="expirado">Producto Expirado</option>
																			<option value="activo">Producto Activo</option>
																		<?php } else if ($Gestiones->getEstadoProductos() == "expirado") { ?>
																			<option value="expirado">Producto Expirado</option>
																			<option value="activo">Producto Activo</option>
																			<option value="inactivo">Producto Inactivo</option>
																		<?php } ?>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<!-- ENVIO DATOS -->
													<button type="submit" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="ti-money"></i></span>Modificar Producto</button>
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
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-modificar-productos-CrediAgil.js"></script>
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

	</body>

	</html>
<?php } ?>




