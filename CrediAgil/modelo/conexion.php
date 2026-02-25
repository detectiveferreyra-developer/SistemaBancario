<?php

class conexion
{
	private $servidor = "localhost"; // NOMBRE SERVIDOR
	private $usuario = "root"; // USUARIO SERVIDOR
	private $clave = ""; // CONTRASEÑA SERVIDOR (SI LO REQUIERE)
	private $base = "crediagil"; // NOMBRE DE BASE DE DATOS
	public $establecerconexion; // VARIABLE PUBLICA DE CONEXION*/
	// DATOS DE CONECTIVIDAD BD -> SISTEMA
	public function setServidor($obteniendoservidor)
	{
		$this->servidor = $obteniendoservidor;
	}
	public function getServidor()
	{
		return $this->servidor;
	}

	// CONECTAR SISTEMA Y COMPROBACION DE CONEXION
	public function conectar($bd)
	{
		$miconexion = new mysqli($this->servidor, $this->usuario, $this->clave, $bd);
		if ($miconexion->connect_errno) {
			/*echo*/
			$mensaje = "Lo sentimos, ha ocurrido un error de conexion" . $miconexion->connect_error;
		} else {
			/*echo*/
			$mensaje = "Enhorabuena, conexion exitosa";
			$this->establecerconexion = $miconexion;
		}
		return $mensaje;
	}
	// INICIO DE SESION -> TODOS LOS USUARIOS
	public function IniciarSesionUsuarios($conectarsistema, $usuario, $contrasenia)
	{
		$resultado = mysqli_query($conectarsistema, "CALL IniciarSesion('$usuario','$contrasenia');");
		return $resultado;
	}
} // CIERRE CLASE CONEXION

/**
 * Función para formatear fechas en español sin usar strftime (depreciado en PHP 8.1+)
 * @param string|null $fecha Fecha a formatear, si es null toma la fecha actual
 * @param bool $conComas Si es verdadero agrega comas (formato dashboard), si no el formato es simple
 * @return string Fecha formateada
 */
function formatearFechaReal($fecha = null, $conComas = true)
{
	if ($fecha === null) {
		$timestamp = time();
	} else {
		$timestamp = strtotime($fecha);
	}

	$dias = array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
	$meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

	$dia_semana = $dias[date('w', $timestamp)];
	$dia = date('d', $timestamp);
	$mes = $meses[date('n', $timestamp) - 1];
	$anio = date('Y', $timestamp);

	if ($conComas) {
		return "$dia_semana, $dia de $mes de $anio,";
	} else {
		return "$dia_semana $dia de $mes de $anio";
	}
}

/**
 * Función para obtener el día y mes en letras (formato finiquitos)
 * @param string|null $fecha Fecha a formatear
 * @return string Ejemplo: "12 días del mes de febrero"
 */
function obtenerDiaMesLetras($fecha = null)
{
	if ($fecha === null) {
		$timestamp = time();
	} else {
		$timestamp = strtotime($fecha);
	}
	$meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
	$dia = date('d', $timestamp);
	$mes = $meses[date('n', $timestamp) - 1];
	return "$dia días del mes de $mes";
}

/**
 * Función para obtener el mes y año (formato contratos)
 * @param string|null $fecha Fecha a formatear
 * @return string Ejemplo: "febrero del año 2026"
 */
function obtenerMesAnioRelativo($fecha = null)
{
	if ($fecha === null) {
		$timestamp = time();
	} else {
		$timestamp = strtotime($fecha);
	}
	$meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
	$mes = $meses[date('n', $timestamp) - 1];
	$anio = date('Y', $timestamp);
	return "$mes del año $anio";
}



// CONECTAR SISTEMA CON BASE DE DATOS {CONEXION PRINCIPAL TODO EL SISTEMA}
$conectando = new conexion();
$conectando->conectar("crediagil");
$conectarsistema = $conectando->establecerconexion;
/*
	-> CONEXIONES AUXILIARES -> GESTIONES ESPECIFICAS CREDIÁGIL.
	DISPONIBLES EN MULTIPLES CONSULTAS REALIZADAS EN UNA SOLA PAGINA
*/
$conectando = new conexion();
$conectando->conectar("crediagil");
$conectarsistema1 = $conectando->establecerconexion;
$conectando = new conexion();
$conectando->conectar("crediagil");
$conectarsistema2 = $conectando->establecerconexion;
$conectando = new conexion();
$conectando->conectar("crediagil");
$conectarsistema3 = $conectando->establecerconexion;
$conectando = new conexion();
$conectando->conectar("crediagil");
$conectarsistema4 = $conectando->establecerconexion;
$conectando = new conexion();
$conectando->conectar("crediagil");
$conectarsistema5 = $conectando->establecerconexion;
$conectando = new conexion();
$conectando->conectar("crediagil");
$conectarsistema6 = $conectando->establecerconexion;
$conectando = new conexion();
$conectando->conectar("crediagil");
$conectarsistema7 = $conectando->establecerconexion;
// CONEXION AUXILIAR -> MÓDULO DE ESTADÍSTICAS
$conectando = new conexion();
$conectando->conectar("crediagil");
$conectarsistemaEstadisticas = $conectando->establecerconexion;
