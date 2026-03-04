<?php
// IMPORTANDO MODELO DE CLIMA EN TIEMPO REAL -> API CLIMA OPENWEATHERMAP
require('../modelo/mAPIClima_Openweathermap.php');
// IMPORTANDO MODELO DE CONTEO NUMERO DE NOTIFICACIONES RECIBIDAS
require('../modelo/mConteoNotificacionesRecibidasUsuarios.php');

// DATOS DE LOCALIZACION -> IDIOMA ESPA�OL -> ZONA HORARIA EL SALVADOR (UTC-6)
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/El_Salvador');
// OBTENER HORA LOCAL
$hora = new DateTime("now");
/*
	-> VALIDACION DE PARAMETROS PRINCIPALES DEL SISTEMA
*/
// VALIDACION DE PARAMETRO CrediAgilgestion -> SI NO EXISTE MOSTRAR PAGINA 404 ERROR
if (!isset($_GET['CrediAgilgestion'])) {
	header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=error-404');
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
		<title>CrediAgil | Inicio</title>
		<!-- Favicon icon -->
		<link rel="apple-touch-icon" sizes="57x57"
			href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60"
			href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72"
			href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76"
			href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114"
			href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120"
			href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144"
			href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152"
			href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180"
			href="<?php echo $UrlGlobal; ?>vista/images/crediagil-crediagil-apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"
			href="<?php echo $UrlGlobal; ?>vista/images/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
		<link rel="manifest" href="<?php echo $UrlGlobal; ?>vista/images/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo $UrlGlobal; ?>vista/images/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<link href="<?php echo $UrlGlobal; ?>vista/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $UrlGlobal; ?>vista/vendor/chartist/css/chartist.min.css">
		<link href="<?php echo $UrlGlobal; ?>vista/vendor/bootstrap-select/dist/css/bootstrap-select.min.css"
			rel="stylesheet">
		<link href="<?php echo $UrlGlobal; ?>vista/css/style.css" rel="stylesheet">
		<!-- CrediAgil Corporate Theme -->
		<link href="<?php echo $UrlGlobal; ?>vista/css/crediagil-theme.css" rel="stylesheet">
		<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
		<link href="<?php echo $UrlGlobal; ?>vista/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
		<style>
			@media (max-width: 700px) {
				.right-panel img {
					display: none;
				}
			}

			@media (min-width: 701px) and (max-width: 1100px) {
				.right-panel img {
					padding: 1.2rem;
				}
			}
		</style>
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
				<!-- row -->
				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-lg-12 col-sm-12">
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<h4 style="font-size: .9rem;" class="card-title">
											<?php if ($hora->format('G') >= 7 && $hora->format('G') < 16) {
												echo '<img style="width: 30px;" class="img-fluid" src="';
												echo $UrlGlobal;
												echo 'vista/images/sun.gif">';
											} else if ($hora->format('G') >= 16 && $hora->format('G') < 18) {
												echo '<img style="width: 30px;" class="img-fluid" src="';
												echo $UrlGlobal;
												echo 'vista/images/sunrise.gif">';
											} else if ($hora->format('G') >= 18 && $hora->format('G') <= 23) {
												echo '<img style="width: 30px;" class="img-fluid" src="';
												echo $UrlGlobal;
												echo 'vista/images/night.gif">';
											} else if ($hora->format('G') >= 0 && $hora->format('G') < 6) {
												echo '<img style="width: 30px;" class="img-fluid" src="';
												echo $UrlGlobal;
												echo 'vista/images/night.gif">';
											} else if ($hora->format('G') >= 5 && $hora->format('G') < 7) {
												echo '<img style="width: 30px;" class="img-fluid" src="';
												echo $UrlGlobal;
												echo 'vista/images/sunrise.gif">';
											} ?>
											<?php if ($hora->format('G') >= 0 && $hora->format('G') <= 4) {
												echo "Buenas Noches";
											} else if ($hora->format('G') >= 5 && $hora->format('G') < 12) {
												echo "Buenos D&iacute;as";
											} else if ($hora->format('G') >= 12 && $hora->format('G') < 18) {
												echo "Buenas Tardes";
											} else if ($hora->format('G') >= 18 && $hora->format('G') <= 23) {
												echo "Buenas Noches";
											} ?>, <strong><?php $Nombre = $_SESSION['nombre_usuario'];
											 $PrimerNombre = explode(' ', $Nombre, 2);
											 print_r($PrimerNombre[0]); ?></strong>
										</h4>
									</div>
									<div class="card-body">
										<div class="bootstrap-media">
											<div class="media">
												<div class="left-panel panel">
													<div class="dateweather">
														<h4><?php echo formatearFechaReal(); ?></h4>
													</div>
													<div class="city">
														<h2>Lima, Per&uacute;</h2>
													</div>
													<div class="temp">
														<?php
														// RANGO DE HORAS DESDE 06:00 HASTA 18:00 [A.M -> P.M -> [[DIA]]]
														if ($hora->format('G') >= 6 && $hora->format('G') < 18) {
															if (strtolower(ucwords($data->weather[0]->description)) == "broken clouds") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/cloudy.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "clear sky") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/clear-day.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "few clouds") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-day.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "scattered clouds") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/haze-day.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-day-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with light rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-day-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-day-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with heavy rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-day-extreme.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light thunderstorm") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-day.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy thunderstorm") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-day-extreme.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "ragged thunderstorm") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-day.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with light drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with heavy drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light intensity drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light intensity drizzle rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/partly-cloudy-day-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "drizzle rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity drizzle rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "shower rain and drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy shower rain and drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "shower drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "moderate rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "very heavy rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "extreme rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light intensity shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "ragged shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "overcast clouds") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/partly-cloudy-day.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "mist") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/mist.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "smoke") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-day-smoke.svg" alt="icono-clima-dia"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "haze") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-day-haze.svg" alt="icono-clima-dia"/>';
															}
															// RANGO DE HORAS DESDE 18:00 HASTA 5:00 [P.M -> A.M -> [[NOCHE]]]
														} else if ($hora->format('G') >= 0 && $hora->format('G') <= 5 || $hora->format('G') >= 18 && $hora->format('G') <= 23) {
															if (strtolower(ucwords($data->weather[0]->description)) == "broken clouds") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/cloudy.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "clear sky") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/clear-night.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "few clouds") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-night.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "scattered clouds") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/haze-night.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity rain") {
																echo '<img src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-night-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with light rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-night-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-night-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with heavy rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-night-extreme.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light thunderstorm") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-night.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy thunderstorm") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-night-extreme.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "ragged thunderstorm") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-night.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with light drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "thunderstorm with heavy drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/thunderstorms-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light intensity drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light intensity drizzle rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/partly-cloudy-night-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "drizzle rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity drizzle rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "shower rain and drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy shower rain and drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "shower drizzle") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "moderate rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "very heavy rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "extreme rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "light intensity shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/overcast-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "heavy intensity shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "ragged shower rain") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-rain.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "overcast clouds") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/partly-cloudy-night.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "mist") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/mist.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "smoke") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-night-smoke.svg" alt="icono-clima-noche"/>';
															} else if (strtolower(ucwords($data->weather[0]->description)) == "haze") {
																echo '<img style="width: 9rem" src="';
																echo $UrlGlobal;
																echo 'vista/images/icon-weather/extreme-night-haze.svg" alt="icono-clima-noche"/>';
															}
														}
														?><span style="font-size: 4.2rem;
													font-weight: 100; color: #000;"><?php echo number_format($data->main->temp, 1) ?>&deg;C</span>
													</div>
												</div>
												<div class="media-body">
													<div class="right-panel panel">
														<?php
														// MAPPING GIFS TO REAL WEATHER CONDITIONS
														$weatherMain = $data->weather[0]->main;
														$hour = (int) $hora->format('G');

														// Determine time suffix
														$suffix = 'day';
														if ($hour >= 18 || $hour < 6) {
															$suffix = 'night';
														} else if (($hour >= 17 && $hour < 18) || ($hour >= 6 && $hour < 8)) {
															$suffix = 'sunset';
														}

														// Determine landscape based on weather
														$landscape = 'Mt.FujiJapan'; // Default / Clear
														if ($weatherMain == 'Clouds' || $weatherMain == 'Mist' || $weatherMain == 'Haze') {
															$landscape = 'Valley';
														} else if ($weatherMain == 'Rain' || $weatherMain == 'Drizzle' || $weatherMain == 'Thunderstorm') {
															$landscape = 'Philippines';
														} else if ($weatherMain == 'Snow') {
															$landscape = 'France';
														}

														echo '<img class="img-fluid" style="width: 100%; max-width: 620px; height: 300px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);" src="';
														echo $UrlGlobal;
														echo 'vista/images/' . $landscape . '-' . $suffix . '.gif" alt="Clima en Vivo" >';
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-12 col-lg-12">
							<div class="card">
								<div class="card-header pb-0 border-0">
									<h4 class="mb-0 text-black fs-20">Detalles T&eacute;cnicos Plataforma</h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 mb-3">
											<div class="card-tech-detail tech-users">
												<div class="info">
													<span>Usuarios Registrados</span>
													<h2><?php echo $Gestiones->getNumeroUsuariosRegistrados(); ?></h2>
												</div>
												<div class="icon-box">
													<img src="<?php echo $UrlGlobal; ?>vista/images/social-care.gif" alt="">
												</div>
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<div class="card-tech-detail tech-products">
												<div class="info">
													<span>Productos Registrados</span>
													<h2><?php echo $Gestiones->getNumeroProductosRegistrados(); ?></h2>
												</div>
												<div class="icon-box">
													<img src="<?php echo $UrlGlobal; ?>vista/images/money-bag.gif" alt="">
												</div>
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<div class="card-tech-detail tech-errors">
												<div class="info">
													<span>Reportes Fallos Registrados</span>
													<h2><?php echo $Gestiones->getNumeroReportesFallosPlataformaRegistrados(); ?>
													</h2>
												</div>
												<div class="icon-box">
													<img src="<?php echo $UrlGlobal; ?>vista/images/workplace.gif" alt="">
												</div>
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<div class="card-tech-detail tech-recovery">
												<div class="info">
													<span>Solicitudes Recuperaci&oacute;n Solicitadas</span>
													<h2><?php echo $Gestiones->getNumeroSolicitudesRecuperacionesRegistrados(); ?>
													</h2>
												</div>
												<div class="icon-box">
													<img src="<?php echo $UrlGlobal; ?>vista/images/user.gif" alt="">
												</div>
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<div class="card-tech-detail tech-installments">
												<div class="info">
													<span>Cuotas Clientes Registradas</span>
													<h2><?php echo $Gestiones->getNumeroCuotasClientesRegistradas(); ?></h2>
												</div>
												<div class="icon-box">
													<img src="<?php echo $UrlGlobal; ?>vista/images/note.gif" alt="">
												</div>
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<div class="card-tech-detail tech-transactions">
												<div class="info">
													<span>Transacciones Clientes Registradas</span>
													<h2><?php echo $Gestiones->getNumeroTransaccionesClientesRegistradas(); ?>
													</h2>
												</div>
												<div class="icon-box">
													<img src="<?php echo $UrlGlobal; ?>vista/images/save-money.gif" alt="">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-12 col-xxl-12 col-lg-12">
							<div class="card">
								<div class="card-header d-block d-sm-flex border-0">
									<div>
										<h4 class="fs-20 text-black">&Uacute;ltimas Transacciones Procesadas</h4>
										<p class="mb-0 fs-13">Detalle de las &uacute;ltimas 200 transacciones procesadas en
											la plataforma</p>
									</div>
									<div class="card-action card-tabs mt-3 mt-sm-0">
										<ul class="nav nav-tabs" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#monthly" role="tab">
													Transacciones Procesadas [200 m&aacute;ximo]
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="card-body tab-content p-0">
									<div class="tab-pane active show fade" id="monthly" role="tabpanel">
										<div class="table-responsive">
											<table class="table shadow-hover card-table">
												<tbody>
													<?php
													$ComprobarConsultaTransacciones = 0;
													while ($filas = mysqli_fetch_array($consulta2)) {
														if ($ComprobarConsultaTransacciones == 0)
															$ComprobarConsultaTransacciones = 1;
														echo '
															<tr>
															<td>
															<span class="bgl-success p-3 d-inline-block">
																<svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M23.6186 15.7207L23.6186 15.7207L23.6353 22.6289C23.6354 22.6328 23.6354 22.6363 23.6353 22.6396M23.6186 15.7207L23.1353 22.6341L23.6353 22.635C23.6353 22.6481 23.6347 22.6583 23.6345 22.6627L23.6344 22.6642C23.6346 22.6609 23.6351 22.652 23.6353 22.6407C23.6353 22.6403 23.6353 22.64 23.6353 22.6396M23.6186 15.7207C23.6167 14.9268 22.9717 14.2847 22.1777 14.2866C21.3838 14.2885 20.7417 14.9336 20.7436 15.7275L20.7436 15.7275L20.7519 19.1563M23.6186 15.7207L20.7519 19.1563M23.6353 22.6396C23.6329 23.4282 22.9931 24.0705 22.2017 24.0726C22.2 24.0726 22.1983 24.0727 22.1965 24.0727L22.1944 24.0727L22.1773 24.0726L15.2834 24.056L15.2846 23.556L15.2834 24.056C14.4897 24.054 13.8474 23.4091 13.8494 22.615C13.8513 21.8211 14.4964 21.179 15.2903 21.1809L15.2903 21.1809L18.719 21.1892L5.53639 8.0066C4.975 7.44521 4.975 6.53505 5.53639 5.97367C6.09778 5.41228 7.00793 5.41228 7.56932 5.97367L20.7519 19.1563M23.6353 22.6396C23.6353 22.6376 23.6353 22.6356 23.6353 22.6336L20.7519 19.1563M22.1964 24.0726C22.1957 24.0726 22.1951 24.0726 22.1944 24.0726L22.1964 24.0726Z" fill="#2BC155" stroke="#2BC155"/>
																</svg>
															</span>
														</td>
														<td>
															<div class="font-w600 wspace-no">
																<span class="mr-1">
																	<img style="width: 100%; max-width: 28px;" src="';
														echo $UrlGlobal;
														echo 'vista/images/shopping-basket.gif">
																</span>
																Pago Cuota Mensual [';
														echo $filas['nombres'];
														echo ' ';
														echo $filas['apellidos'];
														echo ']<br>Bol.->';
														echo $filas['idcuotas'];
														echo ' - Referencia: ';
														echo $filas['referencia'];
														echo '
															</div>
														</td>
														<td class="font-w500">$';
														echo number_format($filas['monto'], 2);
														echo '</td>
														<td class="font-w600 text-center"><a href="javascript:void()" class="badge badge-circle badge-outline-dark">';
														$FechaTransaccion = date_create($filas['fecha']);
														echo date_format($FechaTransaccion, "d-m-Y H:i:s");
														echo '</a></td>
														<td><a class="btn-link text-success float-right" href="javascript:void(0);">Completada</a></td>
														</tr>
															';
													}
													// SI NO EXISTEN REGISTROS, NO HAY CONSULTA QUE MOSTRAR
													if ($ComprobarConsultaTransacciones == 0) {
														echo '
													<div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
													<div class="card">
														<div class="card-body text-center ai-icon  text-primary">
															<img style="width: 80px" class="img-fluid" src="';
														echo $UrlGlobal;
														echo 'vista/images/coffee-cup.gif">
															<h4 class="my-2">No existen  transacciones procesadas hasta ahora...</h4>
														</div>
													</div>
												</div>
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
		<script src="<?php echo $UrlGlobal; ?>vista/vendor/chart.js/Chart.bundle.min.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/custom.min.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/deznav-init.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/vendor/owl-carousel/owl.carousel.js"></script>



		<!-- Chart piety plugin files -->
		<script src="<?php echo $UrlGlobal; ?>vista/vendor/peity/jquery.peity.min.js"></script>


		<!-- Dashboard 1 -->
		<script src="<?php echo $UrlGlobal; ?>vista/js/dashboard/dashboard-1.js"></script>
		<!-- Time ago -->
		<script src="<?php echo $UrlGlobal; ?>vista/js/jquery.timeago.js"></script>
		<script src="<?php echo $UrlGlobal; ?>vista/js/control_tiempo.js"></script>

	</body>

	</html>
<?php } ?>




