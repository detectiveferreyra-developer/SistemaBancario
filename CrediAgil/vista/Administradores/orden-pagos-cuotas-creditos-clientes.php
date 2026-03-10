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
// NO PERMITIR INGRESO SI PARAMETRO NO HA SIDO ESPECIFICADO
if (empty($_GET['idusuario'])) {
	header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=error-404');
}
// NO PERMITIR INGRESO SI CUOTA SELECCIONADA ES DIFERENTE A LA CONSULTADA
if ($_GET['idcuota'] != $Gestiones->getIdCuotasClientes()) {
	header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=error-404');
}
// VALIDACION -> CONVERSION DE PLAZO SEGUN PRODUCTO SELECCIONADO POR CLIENTE [ESTRICTAMENTE DATO EN MESES]
// VALIDACION SI EXISTE UN MONTO DE FINANCIAMIENTO A MOSTRAR -> SI NO EXISTE INDICA QUE NO EXISTE CLIENTE ASIGNADO O SU CREDITO HA CAMBIADO DE ESTADO
if ($Gestiones->getMontoFinanciamientoCreditos() > 0) {
	if ($Gestiones->getNombreProductos() == "Pr?stamos Hipotecarios") {
		$CalculoCuotaMensualCapital = $Gestiones->getMontoFinanciamientoCreditos() / ($Gestiones->getTiempoPlazoCreditos() * 12);
	} else {
		$CalculoCuotaMensualCapital = $Gestiones->getMontoFinanciamientoCreditos() / ($Gestiones->getTiempoPlazoCreditos());
	}
} else {
	// MOSTRAR PAGINA DE ERROR 404 SI NO EXISTE INFORMACION QUE MOSTRAR
	header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=error-404');
} // CIERRE if ($Gestiones->getMontoFinanciamientoCreditos() > 0) 
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
		<title>CrediAgil | Orden de Pago <?php echo $Gestiones->getNombresUsuarios(); ?> <?php echo $Gestiones->getApellidosUsuarios(); ?> </title>
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
		<style>
			table.dataTable thead {
				background-color: #a29bfe
			}
		</style>

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
						<div class="col-lg-12">
							<?php
							// COMPROBADOR DE CUOTAS CANCELADAS Y NO CANCELADAS
							if ($Gestiones->getEstadoCuotaClientes() == "pendiente") {

							?>
								<div class="col-xl-12">
									<div class="alert alert-primary left-icon-big alert-dismissible fade show">
										<div class="media">
											<div class="alert-left-icon-big">
												<span><i class="mdi mdi-help-circle-outline"></i></span>
											</div>
											<div class="media-body">
												<h5 class="mt-1 mb-2">Estimado(a) <?php $Nombre = $_SESSION['nombre_usuario'];
																					$PrimerNombre = explode(' ', $Nombre, 2);
																					print_r($PrimerNombre[0]); ?>: </h5>
												<p class="mb-0"><i class="fa fa-random"></i> Por favor no olvide imprimir y entregar el comprobante del pago efectuado al cliente.<br><br><i class="fa fa-random"></i> Consideraciones: No es posible registrar pagos menores a lo que el sistema indica a cancelar, la fecha de pago no es posible modificar. <strong>Si el cliente insiste en dar una cantidad menor a la solicitada. Por favor ori&eacute;ntelo a que revise su portal de clientes.</strong></p>
											</div>
										</div>
									</div>
								</div>
								<?php
								if ($Gestiones->getComprobarIncumplimientoCuotasClientes() == "SI") {
									echo '<div class="alert alert-danger solid alert-right-icon alert-dismissible fade show">
                            <span><i class="mdi mdi-account-convert"></i></span>
                            <strong>?Atenci&oacute;n!</strong> Estimado(a) ';
									$Nombre = $_SESSION['nombre_usuario'];
									$PrimerNombre = explode(' ', $Nombre, 2);
									print_r($PrimerNombre[0]);
									echo ', esta cuota presenta un cargo por incumplimiento.
                        </div>
                        ';
								} else if ($Gestiones->getComprobarIncumplimientoCuotasClientes() == "NO") {
									echo '<div class="alert alert-success solid alert-right-icon alert-dismissible fade show">
                            <span><i class="mdi mdi-account-heart"></i></span>
                            <strong>?Enhorabuena. Esta cuota no posee cargos por incumplimiento!</strong> 
                            </div>
                        ';
								}
								?>
								<div class="col-xl-12 col-lg-12 col-sm-12 text-center">
									<div class="widget-stat card bg-dark ">
										<div class="card-body p-4">
											<div class="media">
												<span class="mr-3">
													<svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
														<line x1="12" y1="1" x2="12" y2="23"></line>
														<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
													</svg>
												</span>
												<div class="media-body text-white">
													<p class="mb-1">Cuota Mensual Asignada</p>
													<h3 class="text-white">$ <?php echo number_format($Gestiones->getCuotaMensualCreditos(), 2); ?> USD</h3>
													<div class="progress mb-2 bg-secondary">
														<div class="progress-bar progress-animated bg-light" style="width: <?php $ContadorCuotas = $_GET['numcuotacliente'];
																															if ($Gestiones->getNombreProductos() == "Pr?stamos Hipotecarios") {
																																$CalculoMeses = $Gestiones->getTiempoPlazoCreditos() * 12;
																															} else {
																																$CalculoMeses = $Gestiones->getTiempoPlazoCreditos();
																															}
																															echo number_format($CalcularAvanceCuotas = ($ContadorCuotas * 100) / $CalculoMeses, 2); ?>%"></div>
													</div>
													<small>Cuota <?php echo $_GET['numcuotacliente']; ?> de <?php if ($Gestiones->getNombreProductos() == "Pr?stamos Hipotecarios") {
																												echo $Gestiones->getTiempoPlazoCreditos() * 12;
																											} else {
																												echo $Gestiones->getTiempoPlazoCreditos();
																											} ?></small>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card mt-3">
									<div class="card-header"> Orden de Pago No. #<?php echo $Gestiones->getIdCuotasClientes(); ?> <strong>Vencimiento: <?php $FechaVencimientoCuotas = date_create($Gestiones->getFechaVencimientoCuotasClientes());
																																						echo date_format($FechaVencimientoCuotas, "d-m-Y");  ?></strong> <span class="float-right">
											<strong>Estado:</strong> <?php if ($Gestiones->getEstadoCuotaClientes() == "pendiente") {
																			echo '<span class="badge badge-pill badge-danger">';
																			echo $Gestiones->getEstadoCuotaClientes();
																			echo '</span>';
																		} else if ($Gestiones->getEstadoCuotaClientes() == "cancelado") {
																			echo '<span class="badge badge-pill badge-success">';
																			echo $Gestiones->getEstadoCuotaClientes();
																			echo '</span>';
																		} ?></span>
									</div>
									<div class="table-responsive">
										<table class="table table-striped">
											<thead>
												<tr>
													<th class="center">#</th>
													<th>Producto</th>
													<th>Cuota</th>
													<th>Estado</th>
													<th class="right">Mora</th>
													<th class="center">D&iacute;as Atraso</th>
													<th class="right">Total</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="center">Bol. <?php echo $Gestiones->getIdCuotasClientes(); ?></td>
													<td class="left strong"><?php echo $Gestiones->getNombreProductos(); ?></td>
													<td class="left strong">$ <?php echo number_format($Gestiones->getCuotaMensualCreditos(), 2); ?></td>
													<td class="left"><?php echo $Gestiones->getEstadoCuotaClientes(); ?></td>
													<td class="right">$ <?php if ($Gestiones->getDiasIncumplimientoCuotasClientes() > 0) {
																			echo number_format($Gestiones->getDiasIncumplimientoCuotasClientes() * 5.99, 2);
																		} else {
																			echo '0.00';
																		} ?></td>
													<td class="center"><?php if ($Gestiones->getDiasIncumplimientoCuotasClientes() > 0) {
																			echo '<strong><span class="badge badge-danger">';
																			echo $Gestiones->getDiasIncumplimientoCuotasClientes();
																			echo ' d&iacute;as';
																		} else {
																			echo '<strong><span class="badge badge-success"> 0 d&iacute;as';
																		} ?></td>
													<td class="right">$ <?php echo number_format($Gestiones->getMontoCuotaCancelar(), 2) ?></td>
												</tr>

											</tbody>
										</table>
									</div>
									<div class="row">
										<div class="col-lg-4 col-sm-5"> </div>
										<div class="col-lg-4 col-sm-5 ml-auto">
											<table class="table table-clear">
												<tbody>
													<tr>
														<td class="left"><strong>Subtotal</strong></td>
														<td class="right">
															<div class="input-group mb-3  input-light">
																<div class="input-group-prepend">
																	<span style="height: 20px;" class="input-group-text">
																		<svg style="width: 14px;" id="icon-revenue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
																			<line x1="12" y1="1" x2="12" y2="23"></line>
																			<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
																		</svg>
																	</span>
																</div>
																<input style="height: 20px;" type="text" value="<?php echo number_format($Gestiones->getCuotaMensualCreditos(), 2) ?>" disabled class="form-control">
															</div>
														</td>
													</tr>
													<tr>
														<td class="left"><strong>Mora</strong></td>
														<td class="right">
															<div class="input-group mb-3  input-light">
																<div class="input-group-prepend">
																	<span style="height: 20px;" class="input-group-text">
																		<svg style="width: 14px;" id="icon-revenue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
																			<line x1="12" y1="1" x2="12" y2="23"></line>
																			<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
																		</svg>
																	</span>
																</div>
																<input style="height: 20px;" type="text" value="<?php if ($Gestiones->getDiasIncumplimientoCuotasClientes() > 0) {
																													echo number_format($Gestiones->getDiasIncumplimientoCuotasClientes() * 5.99, 2);
																												} else {
																													echo '0.00';
																												} ?>" disabled class="form-control">
															</div>
														</td>
													</tr>

													<form id="pago-cuotas-clientes-creditos" name="calculadora" method="post">
														<input type="hidden" name="idusuarioscuotas" value="<?php echo $Gestiones->getIdUsuarios(); ?>">
														<input type="hidden" name="idproductoscuotas" value="<?php echo $Gestiones->getIdProductos(); ?>">
														<input type="hidden" name="idcreditoscuotas" value="<?php echo $Gestiones->getIdCreditos(); ?>">
														<input type="hidden" name="idcuotas" value="<?php echo $Gestiones->getIdCuotasClientes(); ?>">
														<input type="hidden" name="val-pagorequeridocuotacredito" id="pagorequeridoclientes" value="<?php echo $Gestiones->getMontoCuotaCancelar(); ?>">
														<input type="hidden" name="diasincumplimientocuotas" value="<?php if ($Gestiones->getDiasIncumplimientoCuotasClientes() > 0) {
																														echo $Gestiones->getDiasIncumplimientoCuotasClientes();
																													} else {
																														echo '0';
																													} ?>">
														<tr>
															<td class="left"><strong>Total</strong></td>
															<td class="right">
																<div class="input-group mb-3  input-light">
																	<div class="input-group-prepend">
																		<span style="height: 20px;" class="input-group-text">
																			<svg style="width: 14px;" id="icon-revenue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
																				<line x1="12" y1="1" x2="12" y2="23"></line>
																				<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
																			</svg>
																		</span>
																	</div>
																	<input style="height: 20px;" type="text" name="cuotacancelarcliente" id="val-pagorequerido" onKeyUp="CalculoClientes()" value="<?php echo $Gestiones->getMontoCuotaCancelar(); ?>" disabled class="form-control">
																</div>
															</td>
														</tr>
														<tr>
															<td class="left"><strong>Recibido</strong></td>
															<td class="right">
																<div class="input-group mb-3  input-light">
																	<div class="input-group-prepend">
																		<span style="height: 20px;" class="input-group-text">
																			<svg style="width: 14px;" id="icon-revenue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
																				<line x1="12" y1="1" x2="12" y2="23"></line>
																				<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
																			</svg>
																		</span>
																	</div>
																	<input style="height: 20px;" type="text" class="form-control" name="montoentregadocliente" id="val-pagoclientescuotas" onKeyUp="CalculoClientes()" onInput="ValidarCuotaCliente()" required>
																</div>
															</td>
														</tr>
														<tr>
															<td class="left"><strong>Cambio</td>
															<td class="right">
																<div class="input-group mb-3  input-light">
																	<div class="input-group-prepend">
																		<span style="height: 20px;" class="input-group-text">
																			<svg style="width: 14px;" id="icon-revenue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
																				<line x1="12" y1="1" x2="12" y2="23"></line>
																				<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
																			</svg>
																		</span>
																	</div>
																	<input style="height: 20px;" type="text" name="resultado" disabled class="form-control">
															</td>
														</tr>
														<tr>
															<td class="left">

															</td>
															<td class="right">
																<!-- ENVIO DATOS -->
																<button id="pagarcuotas" type="submit" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="ti-wallet"></i></span>Registrar Pago</button>
															</td>
														</tr>
													</form>

												</tbody>
											</table>
										</div>
									<?php } else if ($Gestiones->getEstadoCuotaClientes() == "cancelado") { ?>
										<div class="col-xl-12">
											<div class="alert alert-primary solid alert-dismissible fade show">
												<div class="media">
													<div class="media-body">
														<h5 class="mt-1 mb-2 text-white">?Atenci&oacute;n!</h5>
														<p class="mb-0">Lo sentimos, no es posible completar su solicitud de pago. Esta orden de pago ya ha sido cancelada.</p>
													</div>
												</div>
											</div>
										</div>
										<div class="card mt-3">
											<div class="card-header"> Orden de Pago No. #<?php echo $Gestiones->getIdCuotasClientes(); ?> <strong>Vencimiento: <?php $FechaVencimientoCuotas = date_create($Gestiones->getFechaVencimientoCuotasClientes());
																																								echo date_format($FechaVencimientoCuotas, "d-m-Y");  ?></strong> <span class="float-right">
													<strong>Estado:</strong> <?php if ($Gestiones->getEstadoCuotaClientes() == "pendiente") {
																					echo '<span class="badge badge-pill badge-danger">';
																					echo $Gestiones->getEstadoCuotaClientes();
																					echo '</span>';
																				} else if ($Gestiones->getEstadoCuotaClientes() == "cancelado") {
																					echo '<span class="badge badge-pill badge-success">';
																					echo $Gestiones->getEstadoCuotaClientes();
																					echo '</span>';
																				} ?></span>
											</div>
											<div class="table-responsive">
												<table class="table table-striped">
													<thead>
														<tr>
															<th class="center">#</th>
															<th>Producto</th>
															<th>Estado</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="center">Bol. <?php echo $Gestiones->getIdCuotasClientes(); ?></td>
															<td class="left strong"><?php echo $Gestiones->getNombreProductos(); ?></td>
															<td class="left"><?php echo $Gestiones->getEstadoCuotaClientes(); ?></td>
														</tr>
													</tbody>
												</table>
											</div>
											<h4 class="text-center">?Deseas visualizar la factura final de la transacci&oacute;n?</h4>
											<a style="width: 20%; margin: auto; display: block" href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=facturacion-pago-ordenes-pago-cuotas-clientes&idcuota=<?php echo $Gestiones->getIdCuotasClientes(); ?>&idusuario=<?php echo $Gestiones->getIdUsuarios(); ?>" class="btn btn-info">Ver Comprobante<span class="btn-icon-right"><i class="fa fa-print"></i></span></a>
										<?php } ?>
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
		<script src="<?php echo $UrlGlobal; ?>vista/js/alerta-ingreso-pago-cuotas-clientes-sistema-pagos-CrediAgil.js"></script>
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
		<script>
			// COMPROBAR SI CANTIDAD RECIBIDA ES IGUAL O MAYOR A LA REQUERIDA. CANTIDADES MENORES NO SON POSIBLES DE PROCESAR
			$('#pagarcuotas').prop('disabled', true); // BLOQUEAR BOTON DE ENVIO POR DEFECTO
			function ValidarCuotaCliente() {
				var $PagoRequeridoClientes = $('#pagorequeridoclientes').val(); // COMPROBACION CONTRASE�A GENERADA
				let PagoRecibidoClientes = $('#val-pagoclientescuotas').val(); // COMPROBACION DE CUOTA REQUERIDA
				$('#pagarcuotas').prop('disabled', true); // BLOQUEAR BOTON DE ENVIO POR DEFECTO
				let activador = document.getElementById("val-pagoclientescuotas")
				activador.addEventListener("keyup", () => {
					if (activador.value >= PagoRequeridoClientes) {
						// SI EL MONTO INGRESADO ES MENOR AL QUE SE REQUIERE, NO SE PODRA PROCESAR LA SOLICITUD DE PAGOS DE CLIENTES
						$('#pagarcuotas').prop('disabled', true);
						// CASO CONTRARIO, PERMITIR PROCESAR LOS PAGOS DE CLIENTES
					} else {
						$('#pagarcuotas').prop('disabled', false);
					}
				}) // CIERRE activador.addEventListener("keyup", () => 
			}

			function CalculoClientes() {
				var cuotacancelarcliente = document.calculadora.cuotacancelarcliente.value;
				var montoentregadocliente = document.calculadora.montoentregadocliente.value;
				try {
					// CUOTA REQUERIDA A CANCELAR
					cuotacancelarcliente = (isNaN(parseFloat(cuotacancelarcliente))) ? 0 : parseFloat(cuotacancelarcliente);
					// MONTO ENTREGADO POR EL CLIENTE
					montoentregadocliente = (isNaN(parseFloat(montoentregadocliente))) ? 0 : parseFloat(montoentregadocliente);
					// CALCULO DE CAMBIO SI ES REQUERIDO. CASO CONTRARIO 0.00
					CalculoCambioClientes = montoentregadocliente - cuotacancelarcliente;
					// SETEO DE CALCULO CAMBIO CLIENTES -> NO MONTOS NEGATIVOS
					if (CalculoCambioClientes < 0) {
						CalculoCambioClientes = 0;
					} else {
						$('#pagarcuotas').prop('disabled', false);
					}
					// IMPRESION DEL RESULTADO FINAL
					document.calculadora.resultado.value = CalculoCambioClientes.toFixed(2);
				} catch (e) {}
			}
		</script>
	</body>

	</html>

<?php } ?>




