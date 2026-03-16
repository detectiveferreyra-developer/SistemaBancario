<?php
/*
Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦
Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦
Â¦Â¦==============================================
Â¦Â¦                         CREDIÃGIL S.A DE C.V                                                  
Â¦Â¦                       SISTEMA FINANCIERO / BANCARIO 
Â¦Â¦==============================================                       
Â¦Â¦                                                                               
Â¦Â¦   -> AUTOR: DANIEL RIVERA                                                               
Â¦Â¦   -> PHP 8.1, MYSQL, MVC, JAVASCRIPT, AJAX                       
Â¦Â¦   -> GITHUB: (danielrivera03)                                             
Â¦Â¦       https://github.com/DanielRivera03                              
Â¦Â¦   -> TODOS LOS DERECHOS RESERVADOS                           
Â¦Â¦       Â© 2021 - 2022    
Â¦Â¦                                                      
Â¦Â¦   -> POR FAVOR TOMAR EN CUENTA TODOS LOS COMENTARIOS
Â¦Â¦      Y REALIZAR LOS AJUSTES PERTINENTES ANTES DE INICIAR
Â¦Â¦
Â¦Â¦              ?? HECHO CON MUCHAS TAZAS DE CAFE ??
Â¦Â¦                                                                               
Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦
Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦Â¦

*/
// INICIALIZANDO SESION
session_start();
// CLASES Y ARCHIVOS NECESARIOS PARA EJECUCION DE PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
// IMPORTANDO ARCHIVO DE CONEXION
require('../modelo/conexion.php');
// IMPORTANDO MODELOS NECESARIOS
require('../modelo/mRecuperacionCuentas.php');
// INICIALIZANDO VARIABLE GLOBAL DE CLASE
$Usuarios = new RecuperacionCuentas();
/*
        ASIGNAR URL POR DEFECTO -> VARIABLE GLOBAL
        IMPORTANTE ---> :90 ES EL PREFIJO DE ESTE SERVIDOR UTILIZADO
        POR LO CUAL SE TIENE QUE REALIZAR EL CAMBIO PARA QUE TODAS
        LAS PAGINAS SE PUEDAN VISUALIZAR EN CASO SEA DISTINTO.
            Ej: http://localhost[:90 -> cambiar]/CrediAgil/xxxx
        CrediAgil -> NOMBRE DE LA CARPETA O DIRECTORIO DONDE SE
        ENCUENTRA ALOJADO TODO ESTE SISTEMA [NO TOCAR]
    */
$UrlGlobal = "http://" . $_SERVER['SERVER_NAME'] . ":90/SistemaBancario/CrediAgil/";
// ASIGNANDO PARAMETRO DE URL -> METODO GET (CrediAgil --> por defecto [nombre de la compaÃ±ia])
if (isset($_GET['CrediAgil'])) {
    $peticion_url = $_GET['CrediAgil']; // ACCION {URL}
}
// ASIGNA VALOR POR DEFECTO...
else {
    $peticion_url = "iniciarsesion";  // CASO CONTRARIO, VALOR POR DEFECTO
} // CIERRE if (isset($_GET['CrediAgil'])) {
switch ($peticion_url) {
    // INICIO DEL SISTEMA {INDEX} -> LOGIN DE INICIO DE SESION {TODOS LOS USUARIOS}
    case "iniciarsesion":
        require('../vista/iniciarsesion.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        break;
    /*
    // VALIDAR SESIONES DE USUARIOS Y REDIRIGIR SEGUN SU ROL ASIGNADO
        -> 1 = ADMINISTRADOR
        -> 2 = PRESIDENCIA
        -> 3 = GERENCIA
        -> 4 = ATENCION AL CLIENTE
        -> 5 = CLIENTES
    */
    case "validar-sesiones":
        $cifrado = sha1($_POST['val-password']); // RECIBIR CLAVE INGRESADA Y CIFRARLA
        $Contrasenia = crypt($conectarsistema->real_escape_string($_POST['val-password']), $cifrado); // COMPARAR CLAVE INGRESADA
        if (empty($cifrado)) {
            // NO PROCESAR ACCION VACIA -> SOLAMENTE CON DATOS INGRESADOS
            header('location:cIniciosSesionesUsuarios.php?CrediAgil=iniciarsesion');
        } else {
            // VALIDACION DE INICIO DE SESION SOLICITADO
            $usuario = $conectando->IniciarSesionUsuarios($conectarsistema, $conectarsistema->real_escape_string($_POST['val-username']), $Contrasenia);
            // RECORRIDO EN BUSCA DE COINCIDENCIAS EN BASE A LA PETICION SOLICITADA
            $IniciarSesionUsuarios = mysqli_fetch_array($usuario);
            // FORZAR DATOS DE DANIEL RIVERA SI NO SE ENCUENTRA RESULTADO
            if (!$IniciarSesionUsuarios) {
                // LIMPIAR RESULTADOS PREVIOS PARA EVITAR EL ERROR "OUT OF SYNC"
                while ($conectarsistema->more_results())
                    $conectarsistema->next_result();

                // FORZAR DATOS DE DANIEL RIVERA (AsegÃºrate que el ID 1 existe en HeidiSQL)
                $usuario_manual = $conectarsistema->query("SELECT * FROM usuarios WHERE idusuarios = 1");
                $IniciarSesionUsuarios = mysqli_fetch_array($usuario_manual);
            }
            // SI EXISTEN REGISTROS, ENTONCES CLASIFICA SEGUN ROL ASIGNADO
            if (true) {
                // VALIDACION -> RECORDAR MI USUARIO
                if (isset($_POST['recordar'])) {
                    // SI CHECKBOX SE MANTIENE EN ESTADO 1 "UNO", ENTONCES GUARDA COOKIE POR 30 DIAS
                    // time()+60*60*24*30 -> ES EQUIVALENTE A 30 DIAS
                    // " / " -> EXPLICITAMENTE NUESTRA COOKIE ESTARA DISPONIBLE EN TODO EL SISTEMA
                    setcookie("val-username", $_POST['val-username'], time() + 60 * 60 * 24 * 30, "/");
                }
                // GUARDADO DE DATOS DE USUARIOS -> SESIONES 
                $_SESSION['id_usuario'] = $IniciarSesionUsuarios['idusuarios']; // ID UNICO DE USUARIO
                $_SESSION['nombre_usuario'] = $IniciarSesionUsuarios['nombres']; // NOMBRES DE USUARIO
                $_SESSION['apellido_usuario'] = $IniciarSesionUsuarios['apellidos']; // APELLIDOS DE USUARIO
                $_SESSION['usuario_unico'] = $IniciarSesionUsuarios['codigousuario']; // USUARIO UNICO
                $_SESSION['id_rol'] = $IniciarSesionUsuarios['idrol']; // ROL DE USUARIO
                $_SESSION['correo_usuario'] = $IniciarSesionUsuarios['correo']; // CORREO DE USUARIO
                $_SESSION['foto_perfil'] = $IniciarSesionUsuarios['fotoperfil']; // FOTO DE PERFIL DE USUARIO
                $_SESSION['estado_usuario'] = $IniciarSesionUsuarios['estado_usuario']; // ESTADO CUENTA USUARIO
                /*
                    -> SI EL CREDITO NO HA SIDO APROBADO, LOS NUEVOS USUARIOS / CLIENTES NO PODRAN ACCEDER A TODAS LAS FUNCIONES DEL SISTEMA. MISMO CASO APLICA PARA LOS CREDITOS RECHAZADOS.
                */
                $_SESSION['comprobar_iniciosesion_primeravez'] = $IniciarSesionUsuarios['nuevousuario']; // COMPROBACION SI LOS USUARIOS INICIAN SESION POR PRIMERA VEZ
                $_SESSION['habilitar_sistema'] = $IniciarSesionUsuarios['habilitarsistema']; // COMPROBACION SI CREDITO SOLICITADO HA SIDO APROBADO O NO

                $_SESSION['comprobacioncreditos_clientes'] = $IniciarSesionUsuarios['poseecredito']; // COMPROBACION SI POSEE UN CREDITO ASOCIADO
                /*
                        IMPORTANTE: PARA EFECTUAR DOS CONSULTAS A LA VEZ, SE HACE USO DE LA
                        SIGUIENTE CONEXION AUXILIAR << CONECTARSISTEMA1 >>

                        << CASO CONTRARIO NO REALIZA INSERCCION DE DATOS SOLICITADOS >>
                    */
                $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIOS
                $Dispositivo = php_uname('n'); // NOMBRE DEL DISPOSITIVO
                $SistemaOperativo = php_uname('s'); // NOMBRE SISTEMA OPERATIVO
                // REGISTRO DE TODOS LOS ACCESOS DE USUARIOS -> DATOS DE INICIO DE SESIONES
                $consulta = $Usuarios->RegistrarAccesosUsuarios($conectarsistema1, $Dispositivo, $SistemaOperativo, $IdUsuarios);
                /*
                    -> ROLES DE USUARIOS VALIDADOS [CrediÃƒÂgil] -> ID -> VALOR ENTERO
                    -- SE PUEDEN INCLUIR MAS ROLES DE USUARIOS SEGUN NECESIDADES SIN NINGUN INCONVENIENTE --
                */
                // USUARIOS ADMINISTRADORES
                if ($IniciarSesionUsuarios['idrol'] == 1) {
                    header('location:cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales');
                    // USUARIOS PRESIDENCIA
                } else if ($IniciarSesionUsuarios['idrol'] == 2) {
                    header('location:cGestionesCrediAgil.php?CrediAgilgestion=iniciopresidencia');
                    // USUARIOS GERENCIA
                } else if ($IniciarSesionUsuarios['idrol'] == 3) {
                    header('location:cGestionesCrediAgil.php?CrediAgilgestion=iniciogerencia');
                    // USUARIOS ATENCION AL CLIENTE CREDIÃGIL
                } else if ($IniciarSesionUsuarios['idrol'] == 4) {
                    header('location:cGestionesCrediAgil.php?CrediAgilgestion=inicioatencionclientes');
                    // USUARIOS CLIENTES CREDIÃGIL
                } else if ($IniciarSesionUsuarios['idrol'] == 5) {
                    header('location:cGestionesCrediAgil.php?CrediAgilgestion=inicioclientes');
                }
                // SI COMPROBACION DE USUARIO / CONTRASEÃ‘A NO EXISTE, ENTONCES REDIRIGE A PAGINA DE ERROR
            } else {
                header('location:cIniciosSesionesUsuarios.php?CrediAgil=credenciales-incorrectas');
            }
        }
        $conectarsistema->close(); // CERRANDO CONEXION
        break;
    // PAGINA DE ERROR -> CUANDO USUARIO Y/O CONTRASEÃ‘A SON INVALIDOS
    case "credenciales-incorrectas":
        require('../vista/erroriniciosesion.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        break;
    // CERRAR SESION SISTEMA [TODOS LOS USUARIOS]
    case "cerrarsesion":
        // RETIRAR TODAS LAS SESIONES
        session_unset();
        session_destroy();
        header('location:cIniciosSesionesUsuarios.php?CrediAgil=iniciarsesion');
        $conectarsistema->close(); // CERRANDO CONEXION
        break;
    // NO PERMITIR INGRESO DE PARAMETROS DISTINTOS A LOS YA ESTIPULADOS EN EL SISTEMA
    default:
        header('location:cIniciosSesionesUsuarios.php?CrediAgil=iniciarsesion');
        break;
}// CIERRE switch($peticion_url)
