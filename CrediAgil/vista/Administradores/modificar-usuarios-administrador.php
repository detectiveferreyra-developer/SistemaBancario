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
// NO PERMITIR INGRESO SI PARAMETRO DE USUARIO SE ENCUENTRA VACIO
if (empty($_GET['idusuario'])) {
	header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=redirecciones-sistema-CrediAgil');
}
// NO PERMITIR INGRESO SI NO EXISTE INFORMACION QUE MOSTRAR
if (empty($Gestiones->getIdUsuarios())) {
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
		<title>CrediAgil | Modificar Usuarios</title>
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
							<li class="breadcrumb-item active"><a href="javascript:void(0)">Modificar Usuarios</a></li>
						</ol>
					</div>
					<div class="row">
						<div class="col-xl-12">
							<div id="accordion-six" class="accordion accordion-with-icon accordion-danger-solid">
								<div class="accordion__item">
									<div class="accordion__header collapsed" data-toggle="collapse" data-target="#with-icon_collapseOne">
										<span class="accordion__header--icon"></span>
										<span class="accordion__header--text">Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
																							$PrimerNombre = explode(' ', $Nombre, 2);
																							print_r($PrimerNombre[0]); ?> tome nota:</span>
										<span class="accordion__header--indicator indicator_bordered"></span>
									</div>
									<div id="with-icon_collapseOne" class="accordion__body collapse" data-parent="#accordion-six">
										<div class="accordion__body--text">
											<i class="ti-direction"></i> Usted en estos momentos se encuentra en el registro del usuario <strong> <?php echo $Gestiones->getCodigoUsuarios(); ?> </strong>. En este apartado podr&aacute; modificar la configuraci&oacute;n de la cuenta de este usuario, as&iacute; como los detalles del mismo. <strong>Le recordamos que por motivos de seguridad no es posible cambiar la contrase&ntilde;a de los usuarios.</strong>
										</div>
									</div>
								</div>
								<div class="card-body">
									<!-- Nav tabs -->
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#home8">
												<span>
													<i class="ti-user"></i>
												</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#profile8">
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
												<h4>Modificar Configuraci&oacute;n Cuenta Usuarios</h4><br>
												<form id="modificar-usuarios-administradores" class="validacion-modificar-usuarios" method="post" autocomplete="off" enctype="multipart/form-data">
													<div class="row form-validation">
														<div class="col-lg-6 mb-2">
															<div class="form-group">
																<input type="hidden" name="val-idunico-modificar" value="<?php echo $Gestiones->getIdUsuarios(); ?>">
																<label class="text-label">Nombres <span class="text-danger">*</span></label>
																<input type="hidden" id="claves-generadas" value="">
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
																	<input type="text" class="form-control" id="val-usuariounico" name="val-usuariounico" placeholder="Ingrese su usuario &uacute;nico" onBlur="comprobarUsuario()" value="<?php echo $Gestiones->getCodigoUsuarios(); ?>">
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
																	<input type="email" class="form-control" id="val-correo" name="val-correo" placeholder="Ingrese su correo electr&oacute;nico v&aacute;lido" onBlur="comprobarCorreoPerfilUsuario()" value="<?php echo $Gestiones->getCorreoUsuarios(); ?>">
																	<div class="col-md-12">
																		<span id="estadocorreo"></span>
																	</div>
																	<p><img style="width: 25px; margin: 1rem 0 0 0; display:none;" src="../vista/images/Spinner.svg" id="loaderIcon1" /></p>
																</div>
															</div>
														</div>
														<div class="col-lg-6 mb-2">
															<div class="form-group">
																<label class="text-label">Rol de Usuario <span class="text-danger">*</span></label>
																<div class="col-lg-12">
																	<select class="form-control" id="val-rol-usuarios" name="val-rol-usuarios">
																		value="<?php if ($Gestiones->getIdRolUsuarios() == 1) {
																					echo '
                                                                        <option value="1">Administrador de Sistemas</option>
                                                                        <option value="2">Presidencia CrediAgil</option>
																		<option value="3">Gerencia CrediAgil</option>
																		<option value="4">Atenci&oacute;n al Cliente CrediAgil</option>
																		<option value="5">Clientes CrediAgil</option>
                                                                        ';
																				} else if ($Gestiones->getIdRolUsuarios() == 2) {
																					echo '
                                                                        <option value="2">Presidencia CrediAgil</option>
                                                                        <option value="1">Administrador de Sistemas</option>
																		<option value="3">Atenci&oacute;n Al Cliente CrediAgil</option>
																		<option value="4">Clientes CrediAgil</option>
                                                                        ';
																				} else if ($Gestiones->getIdRolUsuarios() == 3) {
																					echo '
                                                                        <option value="3">Atenci&oacute;n Al Cliente CrediAgil</option>
                                                                        <option value="1">Administrador de Sistemas</option>
																		<option value="2">Presidencia CrediAgil</option>
																		<option value="4">Clientes CrediAgil</option>
                                                                        ';
																				} else if ($Gestiones->getIdRolUsuarios() == 4) {
																					echo '
                                                                        <option value="4">Clientes CrediAgil</option>
                                                                        <option value="1">Administrador de Sistemas</option>
																		<option value="2">Presidencia CrediAgil</option>
																		<option value="3">Atenci&oacute;n Al Cliente CrediAgil</option>
                                                                        ';
																				}
																				?>"
																	</select>
																</div>
															</div>
														</div>
														<div class="col-lg-6 mb-2">
															<div class="form-group">
																<label class="text-label">Estado de Usuario <span class="text-danger">*</span></label>
																<div class="col-lg-12">
																	<select class="form-control" id="val-estado-usuarios" name="val-estado-usuarios">
																		value="<?php if ($Gestiones->getEstadoUsuarios() == "activo") {
																					echo '
                                                                        <option value="activo">Usuario Activo</option>
                                                                        <option value="inactivo">Usuario Inactivo</option>
																		<option value="bloqueado">Usuario Bloqueado</option>
                                                                        ';
																				} else if ($Gestiones->getEstadoUsuarios() == "inactivo") {
																					echo '
                                                                        <option value="inactivo">Usuario Inactivo</option>
																		<option value="bloqueado">Usuario Bloqueado</option>
																		<option value="activo">Usuario Activo</option>
                                                                        ';
																				} else if ($Gestiones->getEstadoUsuarios() == "bloqueado") {
																					echo '
																		<option value="bloqueado">Usuario Bloqueado</option>
																		<option value="activo">Usuario Activo</option>
																		<option value="inactivo">Usuario Inactivo</option>
                                                                        ';
																				}
																				?>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<!-- ENVIO DATOS -->
													<button type="submit" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="ti-user"></i></span>Modificar Configuraci&oacute;n Cuenta Usuario</button>
												</form>
											</div>
										</div>
										<div class="tab-pane fade" id="profile8" role="tabpanel">
											<div class="pt-4">
												<div class="alert alert-info alert-dismissible fade show">
													<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
														<circle cx="12" cy="12" r="10"></circle>
														<line x1="12" y1="16" x2="12" y2="12"></line>
														<line x1="12" y1="8" x2="12.01" y2="8"></line>
													</svg>
													<strong>?Importante!</strong> Es obligatorio adjuntar nuevamente los archivos multimedia solicitados. S&iacute; este procedimiento se realiza sin la presencia del usuario en cuesti&oacute;n. <strong>Por favor consulte los detalles de este usuario y descargue los respectivos archivos para adjuntarlos nuevamente.</strong>
													<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
													</button>
												</div>
												<h4>Modificar Detalles de Usuarios Cuenta</h4><br>
												<div class="col-lg-12 mb-2">
													<form id="modificar-detalles-clientes-usuarios" class="validacion-registro-detalles-usuarios" method="post" autocomplete="off" enctype="multipart/form-data">
														<div class="row form-validation">
															<div class="col-lg-6 mb-2">
																<div class="form-group">
																	<input type="hidden" name="val-idunico-modificar" value="<?php echo $Gestiones->getIdUsuarios(); ?>">
																	<label class="text-label">Dui <span class="text-danger">*</span></label>
																	<div class="col-lg-12">
																		<input type="text" class="form-control" id="val-dui" name="val-dui" placeholder="XXXXXXXX-X" onkeypress="return (event.charCode <= 57)" value="<?php echo $Gestiones->getDuiUsuarios(); ?>">
																	</div>
																</div>
															</div>
															<div class="col-lg-6 mb-2">
																<div class="form-group">
																	<label class="text-label">Nit <span class="text-danger">*</span></label>
																	<div class="col-lg-12">
																		<input type="text" class="form-control" id="val-nit" name="val-nit" placeholder="XXXX-XXXXXX-XXX-X" onkeypress="return (event.charCode <= 57)" value="<?php echo $Gestiones->getNitUsuarios(); ?>">
																	</div>
																</div>
															</div>
															<div class="col-lg-6 mb-2">
																<div class="form-group">
																	<label class="text-label">Tel&eacute;fono </label>
																	<div class="col-lg-12">
																		<input type="text" class="form-control" id="val-telefono1" name="val-telefono1" placeholder="XXXX-XXXX" onkeypress="return (event.charCode <= 57)" value="<?php echo $Gestiones->getTelefonoUsuarios(); ?>">
																	</div>
																</div>
															</div>
															<div class="col-lg-6 mb-2">
																<div class="form-group">
																	<label class="text-label">Celular</label>
																	<div class="col-lg-12">
																		<input type="text" class="form-control" id="val-telefono2" name="val-telefono2" placeholder="XXXX-XXXX" onkeypress="return (event.charCode <= 57)" value="<?php echo $Gestiones->getCelularUsuarios(); ?>">
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
																		<input type="text" class="form-control" id="val-telefono3" name="val-telefono3" placeholder="XXXX-XXXX" onkeypress="return (event.charCode <= 57)" value="<?php echo $Gestiones->getTelefonoTrabajoUsuarios(); ?>">
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
																			<?php if ($Gestiones->getGeneroUsuarios() == "m") {
																				echo '<option value="m">Masculino</option>';
																				echo '<option value="f">Femenino</option>';
																			} else if ($Gestiones->getGeneroUsuarios() == "f") {
																				echo '<option value="f">Femenino</option>';
																				echo '<option value="m">Masculino</option>';
																			}
																			?>
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
																				if ($Gestiones->getEstadoCivilUsuarios() == "Soltero") {
																					echo '
																					<option value="Soltero">Soltero</option>
																					<option value="Casado">Casado</option>
																					<option value="Divorciado">Divorciado</option>
																					<option value="Comprometido">Comprometido</option>
																					<option value="Viudo">Viudo</option>
																					';
																				} else if ($Gestiones->getEstadoCivilUsuarios() == "Casado") {
																					echo '
																					<option value="Casado">Casado</option>
																					<option value="Divorciado">Divorciado</option>
																					<option value="Comprometido">Comprometido</option>
																					<option value="Viudo">Viudo</option>
																					<option value="Soltero">Soltero</option>
																					';
																				} else if ($Gestiones->getEstadoCivilUsuarios() == "Divorciado") {
																					echo '
																					<option value="Divorciado">Divorciado</option>
																					<option value="Comprometido">Comprometido</option>
																					<option value="Viudo">Viudo</option>
																					<option value="Soltero">Soltero</option>
																					<option value="Casado">Casado</option>
																					';
																				} else if ($Gestiones->getEstadoCivilUsuarios() == "Comprometido") {
																					echo '
																					<option value="Comprometido">Comprometido</option>
																					<option value="Viudo">Viudo</option>
																					<option value="Soltero">Soltero</option>
																					<option value="Casado">Casado</option>
																					<option value="Divorciado">Divorciado</option>
																					';
																				} else if ($Gestiones->getEstadoCivilUsuarios() == "Viudo") {
																					echo '
																					<option value="Viudo">Viudo</option>
																					<option value="Soltero">Soltero</option>
																					<option value="Casado">Casado</option>
																					<option value="Divorciado">Divorciado</option>
																					<option value="Comprometido">Comprometido</option>
																					';
																				}
																			} else if ($Gestiones->getGeneroUsuarios() == "f") {
																				if ($Gestiones->getEstadoCivilUsuarios() == "Soltera") {
																					echo '
																					<option value="Soltera">Soltera</option>
																					<option value="Casada">Casada</option>
																					<option value="Divorciada">Divorciada</option>
																					<option value="Comprometida">Comprometida</option>
																					<option value="Viuda">Viuda</option>
																					';
																				} else if ($Gestiones->getEstadoCivilUsuarios() == "Casada") {
																					echo '
																					<option value="Casada">Casada</option>
																					<option value="Divorciada">Divorciada</option>
																					<option value="Comprometida">Comprometida</option>
																					<option value="Viuda">Viuda</option>
																					<option value="Soltera">Soltera</option>
																					';
																				} else if ($Gestiones->getEstadoCivilUsuarios() == "Divorciada") {
																					echo '
																					<option value="Divorciada">Divorciada</option>
																					<option value="Comprometida">Comprometida</option>
																					<option value="Viuda">Viuda</option>
																					<option value="Soltera">Soltera</option>
																					<option value="Casada">Casada</option>
																					';
																				} else if ($Gestiones->getEstadoCivilUsuarios() == "Comprometida") {
																					echo '
																					<option value="Comprometida">Comprometida</option>
																					<option value="Viuda">Viuda</option>
																					<option value="Soltera">Soltera</option>
																					<option value="Casada">Casada</option>
																					<option value="Divorciada">Divorciada</option>
																					';
																				} else if ($Gestiones->getEstadoCivilUsuarios() == "Viuda") {
																					echo '
																					<option value="Viuda">Viuda</option>
																					<option value="Soltera">Soltera</option>
																					<option value="Casada">Casada</option>
																					<option value="Divorciada">Divorciada</option>
																					<option value="Comprometida">Comprometida</option>
																					';
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label">Documento &uacute;nico de identidad <strong>(DUI <i class="ti-hand-point-right"></i> Frontal)<span class="text-danger"> *</span></strong></label>
																<div class="col-lg-12">
																	<input type="file" name="fotoduiusuariosfrontal" id="fotoduiusuariosfrontal" class="dropify" data-max-file-size="3M" accept="image/x-png,image/jpeg,image/jpg,image/gif" data-allowed-file-extensions='["png", "jpeg","jpg","gif"]' data-default-file='<?php echo $UrlGlobal;
																																																																															echo 'vista/images/fotoduifrontal/';
																																																																															echo $Gestiones->getFotoDuiFrontalUsuarios(); ?>' required />
																</div>
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label">Documento &uacute;nico de identidad <strong>(DUI <i class="ti-hand-point-right"></i> Reverso)<span class="text-danger"> *</span></strong></label>
																<div class="col-lg-12">
																	<input type="file" name="fotoduiusuariosreverso" id="fotoduiusuariosreverso" class="dropify" data-max-file-size="3M" accept="image/x-png,image/jpeg,image/jpg,image/gif" data-allowed-file-extensions='["png", "jpeg","jpg","gif"]' data-default-file='<?php echo $UrlGlobal;
																																																																															echo 'vista/images/fotoduireverso/';
																																																																															echo $Gestiones->getFotoDuiReversoUsuarios(); ?>' required />
																</div>
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label">Documento n&uacute;mero de identificaci&oacute;n tributaria (NIT)<span class="text-danger"> *</span></label>
																<div class="col-lg-12">
																	<input type="file" name="fotonitusuarios" id="fotonitusuarios" class="dropify" data-max-file-size="3M" accept="image/x-png,image/jpeg,image/jpg,image/gif" data-allowed-file-extensions='["png", "jpeg","jpg","gif"]' data-default-file='<?php echo $UrlGlobal;
																																																																												echo 'vista/images/fotonit/';
																																																																												echo $Gestiones->getFotoNitUsuarios(); ?>' required />
																</div>
															</div>
														</div>
														<div class="col-lg-12 mb-2">
															<div class="form-group">
																<label class="text-label">Firma de Cliente<span class="text-danger"> *</span></label>
																<div class="col-lg-12">
																	<input type="file" name="fotofirmausuarios" id="fotofirmausuarios" class="dropify" data-max-file-size="3M" accept="image/x-png,image/jpeg,image/jpg,image/gif" data-allowed-file-extensions='["png", "jpeg","jpg","gif"]' data-default-file='<?php echo $UrlGlobal;
																																																																													echo 'vista/images/fotofirmas/';
																																																																													echo $Gestiones->getFotoFirmaUsuarios(); ?>' required />
																</div>
															</div>
														</div>
														<!-- ENVIO DATOS -->
														<button type="submit" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="ti-user"></i></span>Modificar Detalle de Usuario</button>
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
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-modificar-usuarios-administrador.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-modificar-detalles-usuarios-clientes.js"></script>
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




