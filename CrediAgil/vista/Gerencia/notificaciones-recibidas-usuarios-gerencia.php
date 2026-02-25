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
// SI LOS USUARIOS INICIAN POR PRIMERA VEZ, MOSTRAR PAGINA DONDE DEBERAN REALIZAR EL CAMBIO OBLIGATORIO DE SU CONTRASEÑA GENERADA AUTOMATICAMENTE
if ($_SESSION['comprobar_iniciosesion_primeravez'] == "si") {
	header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=gestiones-nuevos-usuarios-registrados');
	// CASO CONTRARIO, MOSTRAR PORTAL DE USUARIOS -> SEGUN ROL DE USUARIO ASIGNADO
} else {
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
		<title>CrediAgil | Mis Notificaciones </title>
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
		<style>
			table.dataTable thead {
				background-color: #a29bfe
			}
		</style>

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
									<h4 style="font-weight: 600;">Mis Notificaciones</h4>
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
										<a href="<?php echo $UrlGlobal ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=perfiladministradores" class="dropdown-item ai-icon">
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
							<li class="breadcrumb-item"><a href="javascript:void(0)">Notificaciones</a></li>
						</ol>
					</div>
					<!-- row -->
					<div class="row">

						<div class="col-xl-12 col-lg-12">
							<div class="card">
								<div class="card-header  border-0 pb-0">
									<h4 class="card-title">Notificaciones</h4>
								</div>
								<div class="card-body">
									<div id="DZ_W_Todo1" class="widget-media ">
										<ul class="timeline">
											<?php
											$ComprobarConsultaNotificaciones = 0;
											while ($filas = mysqli_fetch_array($consulta)) {
												if ($ComprobarConsultaNotificaciones == 0)
													$ComprobarConsultaNotificaciones = 1;
												echo '
												<li>
												<div class="timeline-panel">
													<div class="media mr-2 media-';
												if ($filas['clasificacionnotificacion'] == "nuevomensaje") {
													echo 'info';
												}
												if ($filas['clasificacionnotificacion'] == "pagorecibido") {
													echo 'danger';
												}
												echo '">
													';
												if ($filas['clasificacionnotificacion'] == "nuevomensaje") {
													echo '<svg fill="blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4.929 19.071A9.969 9.969 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10H2l2.929-2.929zM8 13a4 4 0 1 0 8 0H8z"/></svg>';
												}
												if ($filas['clasificacionnotificacion'] == "pagorecibido") {
													echo '<svg fill="red" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-3.5-8v2H11v2h2v-2h1a2.5 2.5 0 1 0 0-5h-4a.5.5 0 1 1 0-1h5.5V8H13V6h-2v2h-1a2.5 2.5 0 0 0 0 5h4a.5.5 0 1 1 0 1H8.5z"/></svg>';
												}
												echo '</div>
													<div class="media-body">
														<h5 class="mb-1">';
												echo $filas['titulonotificacion'];
												echo ': ';
												echo $filas['descripcionnotificacion'];
												echo '</h5>
														<small class="d-block"><time class="timeago" datetime="';
												echo $filas['fechanotificacion'];
												echo '"></time></small>
													</div>
													<div class="dropdown">
														<button type="button" class="btn btn-';
												if ($filas['clasificacionnotificacion'] == "nuevomensaje") {
													echo 'info ';
												}
												if ($filas['clasificacionnotificacion'] == "pagorecibido") {
													echo 'danger ';
												}
												echo 'light sharp" data-toggle="dropdown">
															<svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
														</button>
														<div class="dropdown-menu">
															<a style="cursor: pointer;" class="dropdown-item" data-id="';
												echo $filas['idnotificacion'];
												echo '" id="ocultar-notificaciones-usuarios"><i class="fa fa-cog"></i> Ocultar Notificaci&oacute;n</a>
														</div>
													</div>
												</div>
											</li>
												';
											}
											// SI NO EXISTEN REGISTROS, NO HAY CONSULTA QUE MOSTRAR
											if ($ComprobarConsultaNotificaciones == 0) {
												echo '
												<div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
												<div class="card">
													<div class="card-body text-center ai-icon  text-primary">
														<img style="width: 80px" class="img-fluid" src="';
												echo $UrlGlobal;
												echo 'vista/images/table-lamp.gif">
														<h4 class="my-2">Upss... No has recibido ninguna notificaci&oacute;n hasta ahora...</h4>
														<span style="padding: .3rem;background: #000; color: #fff;">No te preocupes, pronto las recibir&aacute;s.</span>
													</div>
												</div>
											</div>
												';
											}
											?>
										</ul>
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
		<!-- Dropzone JavaScript -->
		<script src="<?php echo $UrlGlobal; ?>vista/dropzone/dist/dropzone.js"></script>
		<!-- Dropify JavaScript -->
		<script src="<?php echo $UrlGlobal; ?>vista/dropify/dist/js/dropify.min.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/dropzone-configuration.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-ocultar-notificaciones-usuarios.js"></script>
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





	</body>

	</html>
<?php } ?>