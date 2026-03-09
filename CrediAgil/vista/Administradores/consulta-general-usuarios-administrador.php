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

	<!DOCTYPE html>
	<html lang="ES-SV">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>CrediAgil | Consulta General de Usuarios</title>
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
		<!-- Datatable -->
		<link href="<?php echo $UrlGlobal; ?>vista/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
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
							<li class="breadcrumb-item active"><a href="javascript:void(0)">Consultar Usuarios</a></li>
						</ol>
					</div>
					<div class="row">
						<div class="col-xl-12">
							<div id="accordion-six" class="accordion accordion-with-icon accordion-danger-solid">
								<div class="accordion__item">
									<div class="accordion__header collapsed" data-toggle="collapse" data-target="#with-icon_collapseOne">
										<span class="accordion__header--icon"></span>
										<span class="accordion__header--text">Tomar Nota:</span>
										<span class="accordion__header--indicator indicator_bordered"></span>
									</div>
									<div id="with-icon_collapseOne" class="accordion__body collapse" data-parent="#accordion-six">
										<div class="accordion__body--text">
											<i class="ti-direction"></i> Usted podr&aacute; consultar, gestionar, bloquear y desbloquear usuarios en este apartado, en estos momentos se explica brevemente los diferentes significados de los &iacute;conos [izquierda - derecha]:
											<br>[ <i class="mdi mdi-account-check"></i> Consultar y Gestionar Usuarios Activos ]
											<br>[ <i class="mdi mdi-account-minus"></i> Consultar y Gestionar Usuarios Inactivos ]
											<br>[ <i class="mdi mdi-account-off"></i> Consultar y Gestionar Usuarios Bloqueados ]
										</div>
									</div>
								</div>
								<div class="card-body">
									<!-- Nav tabs -->
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#home8">
												<span>
													<i class="mdi mdi-account-check"></i>
												</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#profile8">
												<span>
													<i class="mdi mdi-account-minus"></i>
												</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#profile9">
												<span>
													<i class="mdi mdi-account-off"></i>
												</span>
											</a>
										</li>
									</ul>
									<!-- Tab panes -->
									<div class="tab-content tabcontent-border">
										<div class="tab-pane fade show active" id="home8" role="tabpanel">
											<div class="pt-4">
												<h4>Consultar, Gestionar Usuario / Cliente CrediAgil</h4><br>
												<p>Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
																$PrimerNombre = explode(' ', $Nombre, 2);
																print_r($PrimerNombre[0]); ?>, en este apartado encontrar&aacute;s el listado completo de todos los usuarios registrados, sin ning&uacute;n filtro seg&uacute;n el rol asignado dentro del sistema. <strong>Por favor toma en cuenta que aqu&iacute; solamente se muestran todos los usuarios activos &uacute;nicamente.</strong></p>
												<div class="table-responsive">
													<table style="width: 100%;" id="example5" class="display min-w850">
														<thead>
															<tr>
																<th></th>
																<th>Nombres</th>
																<th>Apellidos</th>
																<th>C&oacute;digo &Uacute;nico</th>
																<th>Rol</th>
																<th>Correo</th>
																<th>Estado</th>
																<th></th>
															</tr>
														</thead>
														<tbody>
															<?php
															while ($filas = mysqli_fetch_array($consulta)) {
																echo ' 
													<tr>
													<td><img class="rounded-circle" width="35" src="';
																echo $UrlGlobal;
																echo 'vista/images/fotoperfil/';
																echo $filas['fotoperfil'];
																echo '" alt=""></td>
													<td>';
																echo $filas['nombres'];
																echo '</td>
													<td>';
																echo $filas['apellidos'];
																echo '</td>
													<td>';
																echo $filas['codigousuario'];
																echo '</td>
													<td><a href="javascript:void()" class="badge badge-rounded badge-primary">';
																if ($filas['idrol'] == 1) {
																	echo "Administrador";
																} else if ($filas['idrol'] == 2) {
																	echo "Presidencia";
																} else if ($filas['idrol'] == 3) {
																	echo "Gerencia";
																} else if ($filas['idrol'] == 4) {
																	echo "Atenci&oacute;n al Cliente";
																} else if ($filas['idrol'] == 5) {
																	echo "Clientes";
																}
																echo '</a></td>
													<td>';
																echo $filas['correo'];
																echo '</td>
                                                    <td><a href="javascript:void()" class="badge badge-rounded badge-success">Activo</a></td>	
													<td>
														<div class="dropdown">
														<button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
															<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
														</button>
														<div class="dropdown-menu">
														<a class="dropdown-item" href="';
																echo $UrlGlobal;
																echo 'controlador/cGestionesCrediAgil.php?CrediAgilgestion=consulta-completa-usuarios-clientes&idusuario=';
																echo $filas['idusuarios'];
																echo '"><i class="ti ti-eye"></i> Ver Detalles Usuario</a>
													<a class="dropdown-item" href="';
																echo $UrlGlobal;
																echo 'controlador/cGestionesCrediAgil.php?CrediAgilgestion=modificar-usuarios-administrador&idusuario=';
																echo $filas['idusuarios'];
																echo '"><i class="ti-pencil-alt2"></i> Modificar Usuario</a>
													<a style="cursor: pointer;" data-id="';
																echo $filas['idusuarios'];
																echo '" id="desactivar-usuarios" class="dropdown-item"><i class="ti-unlink"></i> Desactivar Usuario</a>
													<a style="cursor: pointer;" data-id="';
																echo $filas['idusuarios'];
																echo '" id="bloquear-usuarios" class="dropdown-item"><i class="ti-na"></i> Bloquear Usuario</a>
														</div>
													</div>
															
														</div>
													</div>
												</td>									
												</tr>
													';
															}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="profile8" role="tabpanel">
											<div class="pt-4">
												<h4>Consulta Usuarios Inactivos</h4><br>
												<p>Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
																$PrimerNombre = explode(' ', $Nombre, 2);
																print_r($PrimerNombre[0]); ?>, en este apartado encontrar&aacute;s el listado completo de todos los usuarios registrados <strong> que se encuentran inactivos hasta este momento en el sistema.</strong></p>
												<div class="col-lg-12 mb-2">
													<div class="table-responsive">
														<table style="width: 100%;" id="example5" class="display min-w850">
															<thead>
																<tr>
																	<th></th>
																	<th>Nombres</th>
																	<th>Apellidos</th>
																	<th>C&oacute;digo &Uacute;nico</th>
																	<th>Rol</th>
																	<th>Correo</th>
																	<th>Estado</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<?php
																while ($filas = mysqli_fetch_array($consulta1)) {
																	echo ' 
													<tr>
													<td><img class="rounded-circle" width="35" src="';
																	echo $UrlGlobal;
																	echo 'vista/images/fotoperfil/';
																	echo $filas['fotoperfil'];
																	echo '" alt=""></td>
													<td>';
																	echo $filas['nombres'];
																	echo '</td>
													<td>';
																	echo $filas['apellidos'];
																	echo '</td>
													<td>';
																	echo $filas['codigousuario'];
																	echo '</td>
													<td><a href="javascript:void()" class="badge badge-rounded badge-primary">';
																	if ($filas['idrol'] == 1) {
																		echo "Administrador";
																	} else if ($filas['idrol'] == 2) {
																		echo "Presidencia";
																	} else if ($filas['idrol'] == 3) {
																		echo "Gerencia";
																	} else if ($filas['idrol'] == 4) {
																		echo "Atenci&oacute;n al Cliente";
																	} else if ($filas['idrol'] == 5) {
																		echo "Clientes";
																	}
																	echo '</a></td>
													<td>';
																	echo $filas['correo'];
																	echo '</td>
                                                    <td><a href="javascript:void()" class="badge badge-rounded badge-warning">Inactivo</a></td>	
													<td>
													<div class="dropdown">
														<button type="button" class="btn btn-primary light sharp" data-toggle="dropdown">
															<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
														</button>
														<div class="dropdown-menu">
														<a class="dropdown-item" href="';
																	echo $UrlGlobal;
																	echo 'controlador/cGestionesCrediAgil.php?CrediAgilgestion=consulta-completa-usuarios-clientes&idusuario=';
																	echo $filas['idusuarios'];
																	echo '"><i class="ti ti-eye"></i> Ver Detalles Usuario</a>
												<a class="dropdown-item" href="';
																	echo $UrlGlobal;
																	echo 'controlador/cGestionesCrediAgil.php?CrediAgilgestion=modificar-usuarios-administrador&idusuario=';
																	echo $filas['idusuarios'];
																	echo '"><i class="ti-pencil-alt2"></i> Modificar Usuario</a>
												<a style="cursor: pointer;" data-id="';
																	echo $filas['idusuarios'];
																	echo '" id="reactivar-usuarios"  class="dropdown-item"><i class="ti-stats-up"></i> Activar Usuario</a>
														</div>
													</div>
														</div>
													</div>
												</td>									
												</tr>
													';
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="profile10" role="tabpanel">
											<div class="pt-4">
												<h4>Imprimir informe datos nuevo usuario</h4><br>
												<div class="col-xl-12">

												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="profile9" role="tabpanel">
											<div class="pt-4">
												<h4>Consulta Usuarios Bloqueados</h4><br>
												<p>Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
																$PrimerNombre = explode(' ', $Nombre, 2);
																print_r($PrimerNombre[0]); ?>, en este apartado encontrar&aacute;s el listado completo de todos los usuarios registrados <strong> que se encuentran bloqueados hasta este momento en el sistema.</strong></p>
												<div class="col-xl-12">
													<div class="table-responsive">
														<table style="width: 100%;" id="example5" class="display min-w850">
															<thead>
																<tr>
																	<th></th>
																	<th>Nombres</th>
																	<th>Apellidos</th>
																	<th>C&oacute;digo &Uacute;nico</th>
																	<th>Rol</th>
																	<th>Correo</th>
																	<th>Estado</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<?php
																while ($filas = mysqli_fetch_array($consulta2)) {
																	echo ' 
													<tr>
													<td><img class="rounded-circle" width="35" src="';
																	echo $UrlGlobal;
																	echo 'vista/images/fotoperfil/';
																	echo $filas['fotoperfil'];
																	echo '" alt=""></td>
													<td>';
																	echo $filas['nombres'];
																	echo '</td>
													<td>';
																	echo $filas['apellidos'];
																	echo '</td>
													<td>';
																	echo $filas['codigousuario'];
																	echo '</td>
													<td><a href="javascript:void()" class="badge badge-rounded badge-primary">';
																	if ($filas['idrol'] == 1) {
																		echo "Administrador";
																	} else if ($filas['idrol'] == 2) {
																		echo "Presidencia";
																	} else if ($filas['idrol'] == 3) {
																		echo "Gerencia";
																	} else if ($filas['idrol'] == 4) {
																		echo "Atenci&oacute;n al Cliente";
																	} else if ($filas['idrol'] == 5) {
																		echo "Clientes";
																	}
																	echo '</a></td>
													<td>';
																	echo $filas['correo'];
																	echo '</td>
                                                    <td><a href="javascript:void()" class="badge badge-rounded badge-danger">Bloqueado</a></td>	
													<td>
													<div class="dropdown">
														<button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
															<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
														</button>
														<div class="dropdown-menu">
														<a class="dropdown-item" href="';
																	echo $UrlGlobal;
																	echo 'controlador/cGestionesCrediAgil.php?CrediAgilgestion=consulta-completa-usuarios-clientes&idusuario=';
																	echo $filas['idusuarios'];
																	echo '"><i class="ti ti-eye"></i> Ver Detalles Usuario</a>
												<a class="dropdown-item" href="';
																	echo $UrlGlobal;
																	echo 'controlador/cGestionesCrediAgil.php?CrediAgilgestion=modificar-usuarios-administrador&idusuario=';
																	echo $filas['idusuarios'];
																	echo '"><i class="ti-pencil-alt2"></i> Modificar Usuario</a>
												<a style="cursor: pointer;" data-id="';
																	echo $filas['idusuarios'];
																	echo '" id="reactivar-usuarios"  class="dropdown-item"><i class="ti-stats-up"></i> Desbloquear Usuario</a>
														</div>
													</div>
														</div>
													</div>
												</td>									
												</tr>
													';
																}
																?>
															</tbody>
														</table>
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
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-ingreso-nuevos-usuarios-administradores.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-desactivar-usuarios-administrador.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-bloquear-usuarios-administrador.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-reactivar-usuarios-administrador.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/comprobarcontrasenia.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/comprobarUsuarioUnico.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/comprobarCorreoPerfilUsuarios.js"></script>
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




