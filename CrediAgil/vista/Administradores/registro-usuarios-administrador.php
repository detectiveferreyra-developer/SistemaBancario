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
					
					<div class="row">
						<div class="col-xl-12">
							<div id="accordion-six" class="accordion accordion-with-icon accordion-danger-solid">
								<div class="accordion__item">
									<div class="accordion__header collapsed" data-toggle="collapse" data-target="#with-icon_collapseOne">
										<span class="accordion__header--icon"></span>
										<span class="accordion__header--text">Por favor leer las instrucciones</span>
										<span class="accordion__header--indicator indicator_bordered"></span>
									</div>
									<div id="with-icon_collapseOne" class="accordion__body collapse" data-parent="#accordion-six">
										<div class="accordion__body--text">
											<i class="ti-direction"></i> Para todos los nuevos usuarios, es de estricta obligaci&oacute;n generar una contrase&ntilde;a aleatoria. Para ello primero haga clic en el siguiente &iacute;cono <strong>[ <i class="ti-unlock"></i> ]</strong> y siga las instrucciones ah&iacute; descritas.
											<br><br><i class="ti-direction"></i> Posteriormente realizada la acci&oacute;n anterior, por favor haga clic en el bot&oacute;n <strong> [ Copiar al Portapapeles ]</strong> que aparecer&aacute; justo abajo de este mensaje. <strong>No ingrese usted manualmente esa informaci&oacute;n para as&iacute; evitar errores de digitaci&oacute;n.</strong>
											<br><br><i class="ti-direction"></i> Cumpliendo lo anterior, primero pegue la contrase&ntilde;a generada en el campo <strong>[ Ingrese su nueva contrase&ntilde;a ]</strong>, s&iacute; la contrase&ntilde;a ingresada es igual a la que se genero autom&aacute;ticamente, podr&aacute; seguir con el llenado de informaci&oacute;n de los siguientes campos. <strong>Caso contrario, no ser&aacute; posible habilitar los otros campos sin que usted cumpla con la condici&oacute;n anterior.</strong>
											<br><br><i class="ti-direction"></i> Finalizado el proceso, usted podr&aacute; generar el respectivo comprobante que le debe ser entregado al usuario final, para obtenerlo usted debe hacer clic en el siguiente &iacute;cono <strong>[ <i class="ti-printer"></i> ]</strong> y seguir las indicaciones ah&iacute; descritas. <strong>Le recordamos que usted no podr&aacute; eliminar los datos del usuario que usted ha gestionado sin imprimir el respectivo informe. Una vez impreso el mismo, ser&aacute; habilitada la respectiva petici&oacute;n.</strong>
										</div>
									</div>
								</div>
								<?php
								// GENERAR CONTRASE?A DINAMICA 10 CARACTERES
								if (isset($_POST['generar-clave-usuarios'])) {
									// CADENA DE CARACTERES DISPONIBLES PARA CONTRASE?A
									$Cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
									$ContraseniaAutomatica = "";
									// GENERAR CONTRASE?A SEGUN CADENA Y LONGITUD DESEADA
									for ($i = 0; $i < 11; $i++) {
										// SE OBTIENEN CARACTERES ALEATORIOS DE LA CADENA DISPONIBLE
										$ContraseniaAutomatica .= substr($Cadena, rand(0, 62), 1);
									}
									echo '
                            <div class="alert alert-dark alert-dismissible alert-alt solid fade show">
                            <span><i class="mdi mdi-settings"></i></span>
                            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
                            La contrase&ntilde;a generada autom&aacute;ticamente es la siguiente: <strong><p style="display: inline;" id="clave-generada">';
									echo $ContraseniaAutomatica;
									echo '</p></strong> No ingrese manualmente esta informaci&oacute;n.<br><br>
                        '; ?><button style="width: 80%; margin: auto; display: block;" type="button" class="btn btn-rounded btn-success" id="toastr-info-top-right" onclick="copyToClipboard('#clave-generada')"><span class="btn-icon-left text-success"><i class="ti-write color-success"></i></span>Copiar Contrase&ntilde;a al Portapapeles</button> <?php echo '
                        </div>
                        ';
																																																																																						}
																																																																																							?>
								<script>
									function copyToClipboard(elemento) {
										var $temp = $("<input>")
										$("body").append($temp);
										$temp.val($(elemento).text()).select();
										document.execCommand("copy");
										$temp.remove();
									}
								</script>
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
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#profile9">
												<span>
													<i class="ti-unlock"></i>
												</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#profile10">
												<span>
													<i class="ti-printer"></i>
												</span>
											</a>
										</li>
									</ul>
									<!-- Tab panes -->
									<div class="tab-content tabcontent-border">
										<div class="tab-pane fade show active" id="home8" role="tabpanel">
											<div class="pt-4">
												<h4>Registrar Nuevo Usuario / Cliente CrediAgil</h4><br>
												<?php
												// EVALUAR SI CODIGO UNICO DE USUARIO SE ENCUENTRA DISPONIBLE
												// SI ES VACIO, ADMITE INGRESO DE NUEVOS USUARIOS
												if (empty($_SESSION['CodigoUsuarioCliente'])) {
												?>
													<form id="registro-usuarios-administradores" class="validacion-registro-usuarios" method="post" autocomplete="off" enctype="multipart/form-data">
														<div class="row form-validation">
															<div class="col-lg-6 mb-2">
																<div class="form-group">
																	<label class="text-label">Nombres <span class="text-danger">*</span></label>
																	<input type="hidden" id="claves-generadas" value="<?php if (!empty($ContraseniaAutomatica)) {
																															echo $ContraseniaAutomatica;
																														}
																														// VERIFICAMOS SI CONTRASE?A GENERADA ES IGUAL A LA INGRESADA EN CAMPO INDICADO, SI CUMPLE CONDICION, SE PROCEDE A DESBLOQUEAR LOS DEMAS CAMPOS
																														?>">
																	<div class="col-lg-12">
																		<input <?php if (empty($ContraseniaAutomatica)) {
																					echo "style='cursor: no-drop;'";
																				} ?> type="text" class="form-control" id="val-nombreusuario" name="val-nombreusuario" placeholder="Ingrese sus nombres completos">
																	</div>
																</div>
															</div>
															<div class="col-lg-6 mb-2">
																<div class="form-group">
																	<label class="text-label">Apellidos <span class="text-danger">*</span></label>
																	<div class="col-lg-12">
																		<input <?php if (empty($ContraseniaAutomatica)) {
																					echo "style='cursor: no-drop;'";
																				} ?> type="text" class="form-control" id="val-apellidousuario" name="val-apellidousuario" placeholder="Ingrese sus apellidos completos">
																	</div>
																</div>
															</div>
															<div class="col-lg-6 mb-2">
																<div class="form-group">
																	<label class="text-label">Usuario &Uacute;nico <span class="text-danger">*</span></label>
																	<div class="col-lg-12">
																		<input <?php if (empty($ContraseniaAutomatica)) {
																					echo "style='cursor: no-drop;'";
																				} ?> type="text" class="form-control" id="val-usuariounico" name="val-usuariounico" placeholder="Ingrese su usuario &uacute;nico" onBlur="comprobarUsuario()">
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
																		<input <?php if (empty($ContraseniaAutomatica)) {
																					echo "style='cursor: no-drop;'";
																				} ?> type="email" class="form-control" id="val-correo" name="val-correo" placeholder="Ingrese su correo electr&oacute;nico v&aacute;lido" onBlur="comprobarCorreoPerfilUsuario()">
																		<div class="col-md-12">
																			<span id="estadocorreo"></span>
																		</div>
																		<p><img style="width: 25px; margin: 1rem 0 0 0; display:none;" src="../vista/images/Spinner.svg" id="loaderIcon1" /></p>
																	</div>
																</div>
															</div>
															<div class="col-lg-12 mb-2">
																<div class="form-group">
																	<label class="text-label">Seleccione Un Rol de Usuario <span class="text-danger">*</span></label>
																	<div class="col-lg-12">
																		<select class="form-control" id="val-rol-usuarios" name="val-rol-usuarios">
																			<option value="">Seleccione una opci&oacute;n...</option>
																			<option value="1">Administrador de Sistemas</option>
																			<option value="2">Presidencia CrediAgil</option>
																			<option value="3">Gerencia CrediAgil</option>
																			<option value="4">Atenci&oacute;n Al Cliente CrediAgil</option>
																			<option value="5">Clientes CrediAgil</option>
																		</select>
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
																		<input <?php if (empty($ContraseniaAutomatica)) {
																					echo "style='cursor: no-drop;'";
																				} ?> type="password" class="form-control" id="val-confirmar-contrasenia" name="val-confirmar-contrasenia" placeholder="Repita nuevamente su contrase&ntilde;a">
																	</div>
																</div>
															</div>
														</div>
														<!-- ENVIO DATOS -->
														<button type="submit" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="ti-user"></i></span>Registrar Usuario</button>
													</form>
												<?php } else {
													// SI EL CODIGO UNICO DE USUARIO HA SIDO SETEADO, INDICA QUE EXISTE UN PROCESO ANTERIOR REGISTRADO Y DEBE PROCEDER A ELIMINAR DICHOS DATOS ALMACENADOS PARA CONTINUAR CON POSTERIORES REGISTROS	

													// SI LA VARIABLE DE CONTROL ES IGUAL A IMPRIMIR, DE ACCESO A QUE EL INFORME PUEDA IMPRIMIRSE, CON UN SOLO ACCESO UNICO, CASO CONTRARIO NO PODRA ELIMINAR LOS DATOS DE USUARIOS PREVIAMENTE REGISTRADOS HASTA CUMPLIR ESTA CONDICION
												?>
													<div class="col-xl-12">
														<div class="alert alert-danger left-icon-big alert-dismissible fade show">
															<div class="media">
																<div class="alert-left-icon-big">
																	<span><i class="mdi mdi-alert"></i></span>
																</div>
																<div class="media-body">
																	<h5 class="mt-1 mb-2">?Alerta! Datos de cliente - usuario anterior activos</h5>
																	<p class="mb-0">Para poder seguir procesando nuevos usuarios y clientes, usted debe eliminar los datos del &uacute;ltimo registro procesado. Por favor haga clic en el bot&oacute;n abajo de este aviso para desbloquear nuevamente su petici&oacute;n.</p><br>
																	<form action="../controlador/cGestionesCrediAgil.php?CrediAgilgestion=eliminar-datos-clientes-usuarios-anteriores" method="post">
																		<button <?php if ($_SESSION['control-eliminar-datos'] == "IMPRIMIR") {
																					echo "disabled";
																				} ?> style="margin: auto; display: block" type="submit" class="btn btn-danger">Eliminar Datos Usuario Anterior <span class="btn-icon-right"><i class="fa fa-close"></i></span></button>
																	</form>
																</div>
															</div>
														</div>
													</div>
												<?php } // CIERRE if(empty($_SESSION['CodigoUsuarioCliente'])){ 
												?>
											</div>
										</div>
										<div class="tab-pane fade" id="profile8" role="tabpanel">
											<div class="pt-4">
												<h4>Completar Perfil de Usuarios</h4><br>
												<div class="col-lg-12 mb-2">
													<p>Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
																	$PrimerNombre = explode(' ', $Nombre, 2);
																	print_r($PrimerNombre[0]); ?> a continuaci&oacute;n se muestra el listado de usuarios que usted ha procesado que necesitan completar sus detalles de usuarios.<strong> Por favor haga clic en el &iacute;cono <i class="fa fa-pencil btn btn-primary shadow btn-xs sharp mr-1""></i> e ingrese la informaci&oacute;n solicitada en los campos</strong>. Haga uso de buscador si el listado es extenso para filtrar resultados, digitando el c&oacute;digo &uacute;nico de usuario. <br><br> Para visualizar e imprimir el informe con los datos de los nuevos usuarios a nuestro sistema, por favor haga clic en el &iacute;cono <i class=" mdi mdi-plus-box btn btn-info shadow btn-xs sharp mr-1"></i> y su informe se desplegar&aacute; en una nueva pesta&ntilde;a.</p>
													<div class="table-responsive">
														<table style="width: 100%;" id="example3" class="display min-w850">
															<thead>
																<tr>
																	<th></th>
																	<th>Nombres</th>
																	<th>Apellidos</th>
																	<th>C&oacute;digo &Uacute;nico</th>
																	<th>Rol</th>
																	<th>?Completo Perfil?</th>
																	<th>Completar</th>
																</tr>
															</thead>
															<tbody>
																<?php
																// IMPRESION DE USUARIOS CON PERFIL [NO COMPLETO]
																// FILTRADO SEGUN USUARIO QUE REGISTRO
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
													<td><a href="javascript:void()" class="badge badge-rounded badge-danger">';
																	if ($filas['completoperfil'] == "no") {
																		echo "No";
																	}
																	echo '</a></td>
													<td>
														<div class="d-flex">
															<a href="';
																	echo $UrlGlobal;
																	echo 'controlador/cGestionesCrediAgil.php?CrediAgilgestion=registro-detalles-usuarios-administrador&codigounicousuario=';
																	echo $filas['idusuarios'];
																	echo '" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
															';
																	// MOSTRAR OPCION DE VER INFORME MIENTRAS SE ENCUENTRE DISPONIBLE, SI EL ACCESO HA SIDO BLOQUEADO EN LA SECCION PRINCIPAL DE ESTE APARTADO
																	if (!empty($_SESSION['CodigoUsuarioCliente'])) {
																		if ($_SESSION['CodigoUsuarioCliente'] == $filas['codigousuario']) {
																			echo '
																	<a href="';
																			echo $UrlGlobal;
																			echo 'controlador/cGestionesCrediAgil.php?CrediAgilgestion=mostrar-informe-nuevos-clientes-administrador" target="_blank" class="btn btn-info shadow btn-xs sharp mr-1"><i class="mdi mdi-plus-box"></i></a>
																	';
																		}
																	}
																	echo '
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
													<?php
													// VARIABLE CONTROL DE IMPRESION DE INFORMES

													// SI ES VACIA O NO -> IMPIDE ACCESO A INFORMES
													// SI ES IGUAL A IMPRIMIR -> PUEDE ACCEDER A INFORME
													if (empty($_SESSION['control-eliminar-datos'])) {
													?>
														<div class="alert alert-danger left-icon-big alert-dismissible fade show">
															<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
															</button>
															<div class="media">
																<div class="alert-left-icon-big">
																	<span><i class="mdi mdi-check-circle-outline"></i></span>
																</div>
																<div class="media-body">
																	<h5 class="mt-1 mb-2">?Imprimir Informe!</h5>
																	<p class="mb-0">Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
																								$PrimerNombre = explode(' ', $Nombre, 2);
																								print_r($PrimerNombre[0]); ?>. Lo sentimos, pero en estos momentos no esta disponible el informe. Esta opci&oacute;n estar&aacute; disponible cuando gestiones y registres un nuevo usuario.</p><br>
																	<a href style="margin: auto; display: block;" class="btn btn-rounded btn-danger"><span class="btn-icon-left text-danger"><i class="fa fa-download color-danger"></i></span>Lo Sentimos, No Disponible...</a>
																<?php
															} else if ($_SESSION['control-eliminar-datos'] == "NO") {
																?>
																	<div class="alert alert-danger left-icon-big alert-dismissible fade show">
																		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
																		</button>
																		<div class="media">
																			<div class="alert-left-icon-big">
																				<span><i class="mdi mdi-check-circle-outline"></i></span>
																			</div>
																			<div class="media-body">
																				<h5 class="mt-1 mb-2">?Imprimir Informe!</h5>
																				<p class="mb-0">Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
																											$PrimerNombre = explode(' ', $Nombre, 2);
																											print_r($PrimerNombre[0]); ?>. Lo sentimos, pero en estos momentos no esta disponible el informe. Esta opci&oacute;n estar&aacute; disponible cuando gestiones y registres un nuevo usuario.</p><br>
																				<a href style="margin: auto; display: block;" class="btn btn-rounded btn-danger"><span class="btn-icon-left text-danger"><i class="fa fa-download color-danger"></i></span>Lo Sentimos, No Disponible...</a>
																			<?php
																		} else if ($_SESSION['control-eliminar-datos'] == "IMPRIMIR") {
																			?>
																				<div class="alert alert-success left-icon-big alert-dismissible fade show">
																					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
																					</button>
																					<div class="media">
																						<div class="alert-left-icon-big">
																							<span><i class="mdi mdi-check-circle-outline"></i></span>
																						</div>
																						<div class="media-body">
																							<h5 class="mt-1 mb-2">?Imprimir Informe!</h5>
																							<p class="mb-0">Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
																														$PrimerNombre = explode(' ', $Nombre, 2);
																														print_r($PrimerNombre[0]); ?>. El informe de registro del nuevo usuario procesado se encuentra listo para su impresi&oacute;n. Por favor haga clic en el bot&oacute;n abajo de este aviso. <strong>Tome en cuenta que solo puede acceder a este informe una vez por motivos de seguridad</strong></p><br>
																							<a target="_blank" style="margin: auto; display: block;" href="<?php echo $UrlGlobal ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=mostrar-informe-nuevos-clientes-administrador" class="btn btn-rounded btn-success"><span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i></span>Imprimir Informe Nuevo Usuario</a>
																						<?php } // CIERRE if(empty($_SESSION['control-eliminar-datos'])){ 
																						?>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="tab-pane fade" id="profile9" role="tabpanel">
																		<div class="pt-4">
																			<div class="col-xl-12">
																				<div class="alert alert-info left-icon-big alert-dismissible fade show">
																					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
																					</button>
																					<div class="media">
																						<div class="alert-left-icon-big">
																							<span><i class="mdi mdi-check-circle-outline"></i></span>
																						</div>
																						<div class="media-body">
																							<h5 class="mt-1 mb-2">Generar Nueva Contrase&ntilde;a</h5>
																							<?php
																							if (empty($_SESSION['CodigoUsuarioCliente'])) {
																							?>
																								<p class="mb-0">Por favor haga clic en el bot&oacute;n y su contrase&ntilde;a se crear&aacute; autom&aacute;ticamente, y ser&aacute; redirigido a completar todos los campos del nuevo usuario a registrar.</p><br>
																								<!-- GENERAR CONTRASE?A -->
																								<form id="confirmar-usuario" method="post">
																									<button style="width: 90%; margin: auto; display: block;" type="submit" name="generar-clave-usuarios" id="generar-clave-usuarios" class="btn btn-rounded btn-info"><span class="btn-icon-left text-info"><i class="ti-key"></i></span>Generar Contrase&ntilde;a</button>
																								</form>
																							<?php } else { ?>
																								<div class="col-xl-12">
																									<div class="alert alert-danger left-icon-big alert-dismissible fade show">
																										<div class="media">
																											<div class="alert-left-icon-big">
																												<span><i class="mdi mdi-alert"></i></span>
																											</div>
																											<div class="media-body">
																												<h5 class="mt-1 mb-2">?Alerta! Datos de cliente - usuario anterior activos</h5>
																												<p class="mb-0">Para poder seguir procesando nuevos usuarios y clientes, usted debe eliminar los datos del &uacute;ltimo registro procesado. Por favor haga clic en el bot&oacute;n abajo de este aviso para desbloquear nuevamente su petici&oacute;n.</p><br>
																												<form action="../controlador/cGestionesCrediAgil.php?CrediAgilgestion=eliminar-datos-clientes-usuarios-anteriores" method="post">
																													<button <?php if ($_SESSION['control-eliminar-datos'] == "IMPRIMIR") {
																																echo "disabled";
																															} ?> style="margin: auto; display: block" type="submit" class="btn btn-danger">Eliminar Datos Usuario Anterior <span class="btn-icon-right"><i class="fa fa-close"></i></span>
																													</button>
																												</form>
																											</div>
																										</div>
																									</div>
																								</div>
																							<?php } ?>
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




