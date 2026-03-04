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
		<title>CrediAgil | Mi Perfil</title>
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
		<link rel="stylesheet" href="<?php echo $UrlGlobal; ?>vista/dist/mc-calendar.min.css" />
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
							<li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
							<li class="breadcrumb-item active"><a href="javascript:void(0)">Mi Perfil</a></li>
						</ol>
					</div>
					<!-- row -->
					<div class="row">
						<div class="col-lg-12">
							<div class="profile card card-body px-3 pt-3 pb-0">
								<div class="profile-head">
									<div class="photo-content">
										<div class="cover-photo"></div>
									</div>
									<div class="profile-info">
										<div class="profile-photo">
											<img src="<?php echo $UrlGlobal; ?>vista/images/fotoperfil/<?php echo $Gestiones->getFotoUsuarios(); ?>" class="img-fluid rounded-circle" alt="">
										</div>
										<div class="profile-details">
											<div class="profile-name px-3 pt-2">
												<h4 class="text-primary mb-0"><?php echo $Gestiones->getNombresUsuarios();
																				echo " ";
																				echo $Gestiones->getApellidosUsuarios() ?></h4>
												<p><span><i class="mdi mdi-coffee-to-go"></i></span> Rol: Administrador </p>
											</div>
											<div class="profile-email px-2 pt-2">
												<h4 class="text-muted mb-0"><?php echo $Gestiones->getCodigoUsuarios() ?></h4>
												<p><span><i class="mdi mdi-lan-pending"></i></span> Usuario</p>
											</div>
											<div class="profile-email px-2 pt-2">
												<h4 class="text-muted mb-0"><?php if ($Gestiones->getEstadoUsuarios() == "activo") {
																				echo '<span style="color: #00b894;">usuario ';
																				echo $Gestiones->getEstadoUsuarios();
																				echo '</span>';
																			} else if ($Gestiones->getEstadoUsuarios() == "bloqueado") {
																				echo '<span style="color: #d63031;">usuario ';
																				echo $Gestiones->getEstadoUsuarios();
																				echo '</span>';
																			} else if ($Gestiones->getEstadoUsuarios() == "inactivo") {
																				echo '<span style="color: #fdcb6e;">usuario ';
																				echo $Gestiones->getEstadoUsuarios();
																				echo '</span>';
																			}  ?></h4>
												<p><span><i class="mdi mdi-file-account"></i></span> Estado</p>
											</div>
											<div class="dropdown ml-auto">
												<a href="#" class="btn btn-primary light sharp" data-toggle="dropdown" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<circle fill="#000000" cx="5" cy="12" r="2"></circle>
															<circle fill="#000000" cx="12" cy="12" r="2"></circle>
															<circle fill="#000000" cx="19" cy="12" r="2"></circle>
														</g>
													</svg></a>
												<ul class="dropdown-menu dropdown-menu-right">
													<li class="dropdown-item"><i class="fa fa-user-circle text-primary mr-2"></i> Preguntas Frecuentes</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-12">
						<div class="card">
							<div class="card-body">
								<div class="profile-tab">
									<div class="custom-tab-1">
										<ul class="nav nav-tabs">
											<li class="nav-item"><a href="#about-me" data-toggle="tab" class="nav-link active show">Sobre M&iacute;</a>
											</li>
											<li class="nav-item"><a href="#configuration" data-toggle="tab" class="nav-link">Configuraci&oacute;n cuenta</a>
											</li>
											<li class="nav-item"><a href="#profile-details" data-toggle="tab" class="nav-link">Detalles de usuario</a>
											</li>
											<li class="nav-item"><a href="#session-details" data-toggle="tab" class="nav-link">Detalles de Sesi&oacute;n</a>
											</li>
										</ul>
										<div class="tab-content">
											<div id="about-me" class="tab-pane fade active show"><br>
												<div class="profile-personal-info">
													<h4 class="text-primary mb-4">Informaci&oacute;n Personal</h4>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Nombres <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo $Gestiones->getNombresUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Apellidos <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo  $Gestiones->getApellidosUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Correo Electr&oacute;nico <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo $Gestiones->getCorreoUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Dui <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo $Gestiones->getDuiUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Nit <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo $Gestiones->getNitUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Tel&eacute;fono Principal <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php if ($Gestiones->getTelefonoUsuarios() == "") {
																						echo "No Disponible";
																					} else {
																						echo $Gestiones->getTelefonoUsuarios();
																					} ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Celular <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php if ($Gestiones->getCelularUsuarios() == "") {
																						echo "No Disponible";
																					} else {
																						echo $Gestiones->getCelularUsuarios();
																					} ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Estado Civil <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo $Gestiones->getEstadoCivilUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">G&eacute;nero <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php if ($Gestiones->getGeneroUsuarios() == "m") {
																						echo "Hombre";
																					} else if ($Gestiones->getGeneroUsuarios() == "f") {
																						echo "Mujer";
																					} ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Direcci&oacute;n Completa <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo $Gestiones->getDireccionUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Empresa d&oacute;nde labora <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo $Gestiones->getEmpresaUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Cargo <span class="pull-right">:</span></h5>
														</div>
														<div class="col-9"><span><?php echo $Gestiones->getCargoEmpresaUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Direcci&oacute;n Trabajo <span class="pull-right">:</span></h5>
														</div>
														<div class="col-9"><span><?php echo $Gestiones->getDireccionTrabajoUsuarios(); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Tel&eacute;fono Trabajo <span class="pull-right">:</span></h5>
														</div>
														<div class="col-9"><span><?php if ($Gestiones->getTelefonoTrabajoUsuarios() == "") {
																						echo "No disponible";
																					} else {
																						echo $Gestiones->getTelefonoTrabajoUsuarios();
																					} ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Fecha Nacimiento <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php $Fecha = $Gestiones->getFechaNacimientoUsuarios();
																					$FechaCompleta = strtotime($Fecha);
																					$ObtenerMes = date("m", $FechaCompleta);
																					$ObtenerDia = date("d", $FechaCompleta);
																					echo $ObtenerDia;
																					echo " de ";
																					// VALIDACIONES SEGUN MES OBTENIDO
																					if ($ObtenerMes == 1) {
																						echo "Enero";
																					} else if ($ObtenerMes == 2) {
																						echo "Febrero";
																					} else if ($ObtenerMes == 3) {
																						echo "Marzo";
																					} else if ($ObtenerMes == 4) {
																						echo "Abril";
																					} else if ($ObtenerMes == 5) {
																						echo "Mayo";
																					} else if ($ObtenerMes == 6) {
																						echo "Junio";
																					} else if ($ObtenerMes == 7) {
																						echo "Julio";
																					} else if ($ObtenerMes == 8) {
																						echo "Agosto";
																					} else if ($ObtenerMes == 9) {
																						echo "Septiembre";
																					} else if ($ObtenerMes == 10) {
																						echo "Octubre";
																					} else if ($ObtenerMes == 11) {
																						echo "Noviembre";
																					} else if ($ObtenerMes == 12) {
																						echo "Diciembre";
																					}
																					$ObtenerAnio = date("Y", $FechaCompleta);
																					echo " ";
																					echo $ObtenerAnio;
																					?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Edad <span class="pull-right">:</span></h5>
														</div>
														<div class="col-9"><span><?php // OBTENER FECHA COMPLETA REGISTRADA
																					$Fecha = $Gestiones->getFechaNacimientoUsuarios();
																					// CALCULAR EDAD ANTES DE CUMPLEA�OS
																					$FechaCumpleanos = new DateTime($Fecha);
																					$Ahora = new DateTime();
																					// COMPRUEBA SEGUN A�O -> MES -> DIA
																					$CalcularEdad = $Ahora->diff($FechaCumpleanos);
																					echo $CalcularEdad->y;
																					echo " A&ntilde;os";
																					?></span>
														</div>
													</div>
												</div>
											</div>
											<div id="session-details" class="tab-pane fade"><br>
												<div class="profile-personal-info">
													<h4 class="text-primary mb-4">Detalles de Sesi&oacute;n Activa de Usuarios</h4>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Nombre del Equipo <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo php_uname('n'); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Sistema Operativo <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo php_uname('s'); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Versi&oacute;n <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo php_uname('v'); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Especificaci&oacute;n Completa <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo php_uname('a'); ?></span>
														</div>
													</div>
													<div class="row mb-2">
														<div class="col-3">
															<h5 class="f-w-500">Direcci&oacute;n IP <span class="pull-right">:</span>
															</h5>
														</div>
														<div class="col-9"><span><?php echo $_SERVER['REMOTE_ADDR']; ?></span>
														</div>
													</div>
													<br>
													<h4 class="text-primary mb-4">Detalle completo inicios de sesi&oacute;n asociados a su cuenta</h4>
													<div class="table-responsive">
														<table style="width: 100%" id="example4">
															<thead>
																<tr>
																	<th># Acceso</th>
																	<th>Dia</th>
																	<th>Mes</th>
																	<th>A&ntilde;o </th>
																	<th>Dispositivo </th>
																	<th>Sistema Operativo </th>
																	<th>&Uacute;lt. vez activo</th>
																</tr>
															</thead>
															<tbody>
																<?php
																$NumeroSesion = 1;
																while ($filas = mysqli_fetch_array($consulta2)) {
																	echo '
																			<tr>
																			<td><span class="badge badge-circle badge-outline-primary">';
																	echo $NumeroSesion;
																	echo '</span></td>
																			<td>';
																	$Fecha = $filas['fechaacceso'];
																	$FechaCompleta = strtotime($Fecha);
																	$ObtenerDia = date("d", $FechaCompleta);
																	echo $ObtenerDia;
																	echo '</td>
																			<td>';
																	$Fecha = $filas['fechaacceso'];
																	$FechaCompleta = strtotime($Fecha);
																	$ObtenerMes = date("m", $FechaCompleta);
																	if ($ObtenerMes == 1) {
																		echo "Enero";
																	} else if ($ObtenerMes == 2) {
																		echo "Febrero";
																	} else if ($ObtenerMes == 3) {
																		echo "Marzo";
																	} else if ($ObtenerMes == 4) {
																		echo "Abril";
																	} else if ($ObtenerMes == 5) {
																		echo "Mayo";
																	} else if ($ObtenerMes == 6) {
																		echo "Junio";
																	} else if ($ObtenerMes == 7) {
																		echo "Julio";
																	} else if ($ObtenerMes == 8) {
																		echo "Agosto";
																	} else if ($ObtenerMes == 9) {
																		echo "Septiembre";
																	} else if ($ObtenerMes == 10) {
																		echo "Octubre";
																	} else if ($ObtenerMes == 11) {
																		echo "Noviembre";
																	} else if ($ObtenerMes == 12) {
																		echo "Diciembre";
																	}
																	echo '</td>
																			<td>';
																	$Fecha = $filas['fechaacceso'];
																	$FechaCompleta = strtotime($Fecha);
																	$ObtenerAnio = date("Y", $FechaCompleta);
																	echo $ObtenerAnio;
																	echo '</td>
																			<td>';
																	echo $filas['dispositivo'];
																	echo '</td>
																			<td>';
																	echo $filas['sistemaoperativo'];
																	echo '</td>
																			<td><span class="badge badge-circle badge-outline-danger">';
																	$FechaCompleta = strtotime($filas['fechaacceso']);
																	$ObtenerHora = date("h:i:a", $FechaCompleta);
																	echo $ObtenerHora;
																	'</span></td>
																			</tr>
																			';
																	$NumeroSesion++;
																} ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div id="configuration" class="tab-pane fade"><br>
												<div class="pt-3">
													<div class="settings-form">
														<div class="alert alert-light alert-dismissible alert-alt solid fade show">
															<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
															<strong>Tomar Nota: </strong> Estimado(a) <?php echo $Gestiones->getNombresUsuarios(); ?> no es obligatorio cambiar su fotograf&iacute;a de perfil. <br>S&iacute; decide hacerlo por favor tome en cuenta los requisitos de subidas de archivos.
														</div>
														<h4 class="text-primary">Configuraci&oacute;n principal de su cuenta</h4><br>
														<form id="actualizar-configuracion-cuenta" class="form-valide1" method="post" autocomplete="off" enctype="multipart/form-data">
															<div class="row form-validation">
																<div class="col-lg-6 mb-2">
																	<div class="form-group">
																		<label class="text-label">Nombres <span class="text-danger">*</span></label>
																		<div class="col-lg-12">
																			<input type="text" class="form-control" id="val-nombreusuario" name="val-nombreusuario" placeholder="Ingrese sus nombres completos" value="<?php echo $Gestiones->getNombresUsuarios(); ?>">
																		</div>
																	</div>
																</div>
																<div class="col-lg-6 mb-2">
																	<div class="form-group">
																		<label class="text-label">Apellidos <span class="text-danger">*</span></label>
																		<div class="col-lg-12">
																			<input type="text" class="form-control" id="val-apellidousuario" name="val-apellidousuario" placeholder="Ingrese sus apellidos completos" value="<?php echo $Gestiones->getApellidosUsuarios(); ?>">
																		</div>
																	</div>
																</div>
																<div class="col-lg-6 mb-2">
																	<div class="form-group">
																		<label class="text-label">Usuario &Uacute;nico <span class="text-danger">*</span></label>
																		<div class="col-lg-12">
																			<input type="text" class="form-control" id="val-usuariounico" name="val-usuariounico" placeholder="Ingrese su usuario &uacute;nico" value="<?php echo $Gestiones->getCodigoUsuarios(); ?>" onBlur="comprobarUsuario()">
																			<div class="col-md-12">
																				<span id="estadousuario"></span>
																			</div>
																			<p><img style="width: 25px; margin: 1rem 0 0 0; display:none;" src="../vista/images/Spinner.svg" id="loaderIcon" /></p>
																		</div>
																	</div>
																</div>
																<div class="col-lg-6 mb-2">
																	<div class="form-group">
																		<label class="text-label">Correo Electr&oacute;nico <span class="text-danger">*</span></label>
																		<div class="col-lg-12">
																			<input type="email" class="form-control" id="val-correo" name="val-correo" placeholder="Ingrese su correo electr&oacute;nico v&aacute;lido" value="<?php echo $Gestiones->getCorreoUsuarios(); ?>" onBlur="comprobarCorreoPerfilUsuario()">
																			<div class="col-md-12">
																				<span id="estadocorreo"></span>
																			</div>
																			<p><img style="width: 25px; margin: 1rem 0 0 0; display:none;" src="../vista/images/Spinner.svg" id="loaderIcon1" /></p>
																		</div>
																	</div>
																</div>
																<div class="col-lg-6 mb-2">
																	<div class="form-group">
																		<label class="text-label">Ingrese su nueva contrase&ntilde;a <span class="text-danger">*</span></label>
																		<div class="col-lg-12">
																			<input type="password" class="form-control" id="val-contrasenia" name="val-contrasenia" placeholder="Ingrese su contrase&ntilde;a">
																			<span id="passstrength"></span>
																		</div>
																	</div>
																</div>
																<div class="col-lg-6 mb-2">
																	<div class="form-group">
																		<label class="text-label">Repita su nueva contrase&ntilde;a <span class="text-danger">*</span></label>
																		<div class="col-lg-12">
																			<input type="password" class="form-control" id="val-confirmar-contrasenia" name="val-confirmar-contrasenia" placeholder="Repita nuevamente su contrase&ntilde;a">
																		</div>
																	</div>
																</div>
																<div class="col-lg-12 mb-2">
																	<div class="form-group">
																		<label class="text-label">Fotograf&iacute;a de Perfil <span class="text-danger"></span></label>
																		<div class="col-lg-12">
																			<input type="file" name="fotoperfilusuarios" id="input-file-max-fs" class="dropify" data-max-file-size="1M" data-max-width="800" data-min-width="400" data-max-height="800" data-min-height="400" accept="image/x-png,image/jpeg,image/jpg,image/gif" data-allowed-file-extensions='["png", "jpeg","jpg","gif"]' data-default-file="<?php echo $UrlGlobal ?>vista/images/fotoperfil/<?php echo $Gestiones->getFotoUsuarios(); ?>" />
																		</div>
																	</div>
																</div>
															</div>
															<button class="btn btn-primary" type="submit">Cambiar Configuraci&oacute;n</button>
														</form>
													</div>
												</div>
											</div>
											<div id="profile-details" class="tab-pane fade">
												<div class="my-post-content pt-3">
													<div class="alert alert-light alert-dismissible alert-alt solid fade show">
														<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
														<strong>Tomar Nota: </strong> Estimado(a) <?php echo $Gestiones->getNombresUsuarios(); ?> los campos de tel&eacute;fono principal, celular y trabajo no son obligatorios.
													</div>
													<div class="settings-form"><br>
														<h4 class="text-primary">Detalles de su usuario</h4><br>
														<div class="form-validation">
															<form id="actualizar-perfil-detalles-usuarios" class="form-valide" method="post" autocomplete="off">
																<div class="row form-validation">
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">Dui <span class="text-danger">*</span></label>
																			<div class="col-lg-12">
																				<input type="text" class="form-control" id="val-dui" name="val-dui" placeholder="XXXXXXXX-X" value="<?php echo $Gestiones->getDuiUsuarios(); ?>" onkeypress="return (event.charCode <= 57)">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">Nit <span class="text-danger">*</span></label>
																			<div class="col-lg-12">
																				<input type="text" class="form-control" id="val-nit" name="val-nit" placeholder="XXXX-XXXXXX-XXX-X" value="<?php echo $Gestiones->getNitUsuarios(); ?>" onkeypress="return (event.charCode <= 57)">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">Tel&eacute;fono </label>
																			<div class="col-lg-12">
																				<input type="text" class="form-control" id="val-telefono1" name="val-telefono1" placeholder="XXXX-XXXX" value="<?php echo $Gestiones->getTelefonoUsuarios(); ?>" onkeypress="return (event.charCode <= 57)">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">Celular</label>
																			<div class="col-lg-12">
																				<input type="text" class="form-control" id="val-telefono2" name="val-telefono2" placeholder="XXXX-XXXX" value="<?php echo $Gestiones->getCelularUsuarios(); ?>" onkeypress="return (event.charCode <= 57)">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-12 mb-2">
																		<div class="form-group">
																			<label class="text-label">Direcci&oacute;n Residencia Completa <span class="text-danger">*</span></label>
																			<div class="col-lg-12">
																				<textarea class="form-control" placeholder="Ingrese su direcci&oacute;n de residencia completa" id="val-direccion1" name="val-direccion1" rows="3"><?php echo $Gestiones->getDireccionUsuarios(); ?></textarea>
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">Nombre empresa donde labora <span class="text-danger">*</span></label>
																			<div class="col-lg-12">
																				<input type="text" class="form-control" id="val-nombreempresa" name="val-nombreempresa" placeholder="Ingrese nombre de empresa d&oacute;nde labora" value="<?php echo $Gestiones->getEmpresaUsuarios(); ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">Cargo que desempe&ntilde;a <span class="text-danger">*</span></label>
																			<div class="col-lg-12">
																				<input type="text" class="form-control" id="val-cargoempresa" name="val-cargoempresa" placeholder="Ingrese el cargo que desempe&ntilde;a" value="<?php echo $Gestiones->getCargoEmpresaUsuarios(); ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-12 mb-2">
																		<div class="form-group">
																			<label class="text-label">Direcci&oacute;n donde trabaja completa <span class="text-danger">*</span></label>
																			<div class="col-lg-12">
																				<textarea class="form-control" placeholder="Ingrese direcci&oacute;n completa d&oacute;nde labora" id="val-direccion2" name="val-direccion2" rows="3"><?php echo $Gestiones->getDireccionTrabajoUsuarios(); ?></textarea>
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">Tel&eacute;fono empresa donde labora </label>
																			<div class="col-lg-12">
																				<input type="text" class="form-control" id="val-telefono3" name="val-telefono3" placeholder="XXXX-XXXX" value="<?php echo $Gestiones->getTelefonoTrabajoUsuarios(); ?>" onkeypress="return (event.charCode <= 57)">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
																			<div class="col-lg-12">
																				<input type="text" class=" form-control" id="val-fechanacimiento" name="val-fechanacimiento" placeholder="Ingrese su fecha de nacimiento" value="<?php echo $Gestiones->getFechaNacimientoUsuarios(); ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">G&eacute;nero <span class="text-danger">*</span></label>
																			<div class="col-lg-12">
																				<select class="form-control" id="val-genero" name="val-genero">
																					<?php
																					if ($Gestiones->getGeneroUsuarios() == "m") {
																					?>
																						<option value="m">Masculino</option>
																						<option value="f">Femenino</option>
																					<?php } else if ($Gestiones->getGeneroUsuarios() == "f") { ?>
																						<option value="f">Femenino</option>
																						<option value="m">Masculino</option>
																					<?php } ?>
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-6 mb-2">
																		<div class="form-group">
																			<label class="text-label">Estado Civil <span class="text-danger">*</span></label>
																			<div class="col-lg-12">
																				<select class="form-control" id="val-estadocivil" name="val-estadocivil">
																					<?php
																					if ($Gestiones->getGeneroUsuarios() == "m") {
																					?>
																						<?php
																						if ($Gestiones->getEstadoCivilUsuarios() == "Soltero") {
																						?>
																							<option value="Soltero">Soltero</option>
																							<option value="Casado">Casado</option>
																							<option value="Divorciado">Divorciado</option>
																							<option value="Comprometido">Comprometido</option>
																							<option value="Viudo">Viudo</option>
																						<?php
																						} else if ($Gestiones->getEstadoCivilUsuarios() == "Casado") {
																						?>
																							<option value="Casado">Casado</option>
																							<option value="Divorciado">Divorciado</option>
																							<option value="Comprometido">Comprometido</option>
																							<option value="Viudo">Viudo</option>
																							<option value="Soltero">Soltero</option>
																						<?php
																						} else if ($Gestiones->getEstadoCivilUsuarios() == "Divorciado") {
																						?>
																							<option value="Divorciado">Divorciado</option>
																							<option value="Comprometido">Comprometido</option>
																							<option value="Viudo">Viudo</option>
																							<option value="Soltero">Soltero</option>
																							<option value="Casado">Casado</option>
																						<?php
																						} else if ($Gestiones->getEstadoCivilUsuarios() == "Comprometido") {
																						?>
																							<option value="Comprometido">Comprometido</option>
																							<option value="Viudo">Viudo</option>
																							<option value="Soltero">Soltero</option>
																							<option value="Casado">Casado</option>
																							<option value="Divorciado">Divorciado</option>
																						<?php
																						} else if ($Gestiones->getEstadoCivilUsuarios() == "Viudo") {
																						?>
																							<option value="Viudo">Viudo</option>
																							<option value="Soltero">Soltero</option>
																							<option value="Casado">Casado</option>
																							<option value="Divorciado">Divorciado</option>
																							<option value="Comprometido">Comprometido</option>
																						<?php } ?>
																					<?php } else if ($Gestiones->getGeneroUsuarios() == "f") { ?>
																						<?php
																						if ($Gestiones->getEstadoCivilUsuarios() == "Soltera") {
																						?>
																							<option value="Soltera">Soltera</option>
																							<option value="Casada">Casada</option>
																							<option value="Divorciada">Divorciada</option>
																							<option value="Comprometida">Comprometida</option>
																							<option value="Viuda">Viuda</option>
																						<?php
																						} else if ($Gestiones->getEstadoCivilUsuarios() == "Casada") {
																						?>
																							<option value="Casada">Casada</option>
																							<option value="Divorciada">Divorciada</option>
																							<option value="Comprometida">Comprometida</option>
																							<option value="Viuda">Viuda</option>
																							<option value="Soltera">Soltera</option>
																						<?php
																						} else if ($Gestiones->getEstadoCivilUsuarios() == "Divorciada") {
																						?>
																							<option value="Divorciada">Divorciada</option>
																							<option value="Comprometida">Comprometida</option>
																							<option value="Viuda">Viuda</option>
																							<option value="Soltera">Soltera</option>
																							<option value="Casada">Casada</option>
																						<?php
																						} else if ($Gestiones->getEstadoCivilUsuarios() == "Comprometida") {
																						?>
																							<option value="Comprometida">Comprometida</option>
																							<option value="Viuda">Viuda</option>
																							<option value="Soltera">Soltera</option>
																							<option value="Casada">Casada</option>
																							<option value="Divorciada">Divorciada</option>
																						<?php
																						} else if ($Gestiones->getEstadoCivilUsuarios() == "Viuda") {
																						?>
																							<option value="Viuda">Viuda</option>
																							<option value="Soltera">Soltera</option>
																							<option value="Casada">Casada</option>
																							<option value="Divorciada">Divorciada</option>
																							<option value="Comprometida">Comprometida</option>
																					<?php }
																					} ?>
																				</select>
																			</div>
																		</div>
																	</div>
																</div>
																<button class="btn btn-primary" type="submit">Actualizar Datos</button>
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

		<!--removeIf(production)-->

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
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-actualizacion-perfil-administrador.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-actualizacion-detalles-perfil.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/comprobarcontrasenia.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/comprobarUsuarioUnico.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/comprobarCorreoPerfilUsuarios.js"></script>
		<!-- Datatable -->
		<script src="<?php echo $UrlGlobal; ?>vista/vendor/datatables/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/plugins-init/datatables.init.js"></script>
		<!-- Time ago -->
		<script src="<?php echo $UrlGlobal; ?>vista/js/jquery.timeago.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/control_tiempo.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/dist/mc-calendar.min.js"></script>
		<script>
			const firstCalendar = MCDatepicker.create({
				el: '#val-fechanacimiento',
				customMonths: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				customWeekDays: ['Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'Sabado'],
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




