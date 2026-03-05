<?php
// SI USUARIO NO TIENE SESION ACTIVA, MOSTRAR FORMULARIO DE INICIO DE SESION
if (empty($_SESSION['id_usuario'])) {
    ?>

    <!DOCTYPE html>
    <html lang="ES-SV" class="h-100">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>CrediAgil | Portal Financiero</title>
        <!-- Favicon icon - CrediAgil -->
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <link rel="shortcut icon" href="<?php echo $UrlGlobal; ?>images/CrediAgil.png" type="image/png">
        <link rel="manifest" href="<?php echo $UrlGlobal; ?>vista/images/manifest.json">
        <meta name="msapplication-TileColor" content="#001F5C">
        <meta name="msapplication-TileImage" content="<?php echo $UrlGlobal; ?>images/CrediAgil.png">
        <meta name="theme-color" content="#001F5C">
        <link href="<?php echo $UrlGlobal; ?>vista/css/style.css" rel="stylesheet">
        <!-- CrediAgil Corporate Theme -->
        <link href="<?php echo $UrlGlobal; ?>vista/css/crediagil-theme.css" rel="stylesheet">
        <!-- Alerts -->
        <!-- Alerts -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Asap:wght@400;500;700&display=swap');

            body {
                background-color: #001F5C !important;
                font-family: 'Asap', sans-serif !important;
                margin: 0;
                min-height: 100vh;
            }

            .authincation {
                background-color: #001F5C !important;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
            }

            /* Contenedor principal con animacion de olas */
            .login-wave-wrapper {
                overflow: hidden;
                background-color: #f0f4f8;
                /* Fondo suave para que resalte el logo */
                padding: 40px 30px 30px 30px;
                border-radius: 10px;
                position: relative;
                width: 500px;
                transition: transform 300ms, box-shadow 300ms;
                box-shadow: 5px 10px 10px rgba(2, 128, 144, 0.2);
                z-index: 1;
            }

            .login-wave-wrapper:hover {
                transform: translateY(-5px);
                box-shadow: 10px 20px 25px rgba(2, 128, 144, 0.3);
            }

            /* Olas animadas (::before y ::after) */
            .login-wave-wrapper::before,
            .login-wave-wrapper::after {
                content: '';
                position: absolute;
                width: 700px;
                height: 700px;
                border-top-left-radius: 40%;
                border-top-right-radius: 45%;
                border-bottom-left-radius: 35%;
                border-bottom-right-radius: 40%;
                z-index: 0;
                pointer-events: none;
            }

            .login-wave-wrapper::before {
                left: 30%;
                bottom: -55%;
                background-color: rgba(69, 105, 144, 0.25);
                /* $blueQueen */
                animation: wawes 6s infinite linear;
            }

            .login-wave-wrapper::after {
                left: 25%;
                bottom: -45%;
                background-color: rgba(2, 128, 144, 0.3);
                /* $greenSeaweed */
                animation: wawes 7s infinite linear;
            }

            @keyframes wawes {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            /* Contenido del formulario */
            .auth-form {
                position: relative;
                z-index: 1;
                background-color: transparent !important;
                padding: 0 !important;
                box-shadow: none !important;
            }

            /* Logo wrapper con color de fondo del sistema bancario */
            .logo-login-box {
                background-color: #001F5C;
                border-radius: 12px;
                padding: 14px;
                display: inline-block;
                box-shadow: 0 4px 12px rgba(0, 31, 92, 0.25);
                margin-bottom: 80px;
            }

            .auth-form .text-label {
                color: #333 !important;
                font-family: 'Asap', sans-serif;
                font-weight: 500;
            }

            /* Layout Horizontal para campos */
            .user-row {
                display: flex;
                align-items: center;
                margin-bottom: 18px;
            }

            .user-row label {
                flex: 0 0 100px;
                margin-bottom: 0 !important;
                text-align: left;
                font-size: 15px;
                color: #333;
            }

            .user-row .input-group {
                flex: 1;
            }

            .auth-form .form-control {
                font-family: 'Asap', sans-serif;
                border-radius: 5px !important;
                background: white;
                border: 1px solid #ddd;
            }

            .btn-primary {
                background-color: #F45B69 !important;
                /* $redFire */
                border: 0 !important;
                color: #fff;
                font-family: 'Asap', sans-serif;
                font-size: 16px;
                text-transform: uppercase;
                height: 45px;
                transition: background-color 300ms;
                border-radius: 5px !important;
                margin-top: 10px;
            }

            .btn-primary:hover {
                background-color: #e54a5a !important;
            }

            .auth-form a {
                text-decoration: none;
                color: #456990 !important;
                /* $blueQueen */
                font-size: 12px;
            }

            .auth-form a:hover {
                color: #001F5C !important;
            }
        </style>

    </head>

    <body class="h-100">
        <div class="authincation h-100">
            <div class="container h-100">
                <div class="row justify-content-center h-100 align-items-center">
                    <div class="col-md-auto">
                        <div class="login-wave-wrapper">
                            <div class="auth-form">
                                <div style="text-align:center;">
                                    <div class="logo-login-box">
                                        <img class="logo-abbr logo-formulario"
                                            src="<?php echo $UrlGlobal; ?>images/CrediAgil.png" alt="logo-simple"
                                            style="max-width: 120px; display: block;">
                                    </div>
                                </div>
                                <form id="accesos-usuarios" class="form-valide-with-icon" method="POST"
                                    action="<?php echo $UrlGlobal; ?>controlador/cIniciosSesionesUsuarios.php?CrediAgil=validar-sesiones"
                                    autocomplete="off">
                                    <div class="user-row">
                                        <label class="text-label">Usuario</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                            </div>
                                            <input type="text" class="form-control" id="val-username1" name="val-username"
                                                placeholder="Usuario" value="<?php if (!empty($_COOKIE['val-username'])) {
                                                    echo $_COOKIE['val-username'];
                                                } ?>">
                                        </div>
                                    </div>
                                    <div class="user-row">
                                        <label class="text-label">Contrase&ntilde;a </label>
                                        <div class="input-group transparent-append">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                            </div>
                                            <input type="password" class="form-control" id="val-password1"
                                                name="val-password" placeholder="Contrase&ntilde;a">
                                        </div>
                                    </div>
                                    <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                        <div class="form-group">
                                            <?php if (empty($_COOKIE['val-username'])) {
                                                // MOSTRAR UNICAMENTE SI COOKIE NO HA SIDO GUARDADA 
                                                ?>
                                                <div class="custom-control custom-checkbox ml-1">
                                                    <input type="checkbox" name="recordar" class="custom-control-input"
                                                        id="basic_checkbox_1" checked>
                                                    <label class="custom-control-label" for="basic_checkbox_1">Recordar
                                                        Usuario</label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <a style="cursor: help;"
                                                href="<?php echo $UrlGlobal; ?>controlador/cIniciosSesionesUsuarios.php?CrediAgil=reestablecer-contrasena">¿Olvide
                                                mi contrase&ntilde;a?</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Iniciar
                                            Sesi&oacute;n</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
        <script src="<?php echo $UrlGlobal; ?>vista/js/comprobarcontrasenia.js"></script>
    </body>

    </html>
    <?php
    // SI USUARIO POSEE SESION ACTIVA, REDIRIGIR A INICIOS DE LA APLICACION SEGUN SUS ROLES DE USUARIOS
} else {
    // USUARIOS ADMINISTRADORES
    if ($_SESSION['id_rol'] == 1) {
        header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales');
        // USUARIOS PRESIDENCIA
    } else if ($_SESSION['id_rol'] == 2) {
        header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=iniciopresidencia');
        // USUARIOS GERENCIA
    } else if ($_SESSION['id_rol'] == 3) {
        header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=iniciogerencia');
        // USUARIOS ATENCION AL CLIENTE
    } else if ($_SESSION['id_rol'] == 4) {
        header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=inicioatencionclientes');
        // USUARIOS CLIENTES
    } else if ($_SESSION['id_rol'] == 5) {
        header('location:../controlador/cGestionesCrediAgil.php?CrediAgilgestion=inicioclientes');
    }
}
?>
