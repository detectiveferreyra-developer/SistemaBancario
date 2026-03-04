<?php
// NAVBAR SUPERIOR — REEMPLAZA EL HEADER ORIGINAL (sin notificaciones, sin clima)
// Solo para ROL ADMINISTRADOR
if ($_SESSION['id_rol'] == 1) {
    $gestion_actual = isset($_GET['CrediAgilgestion']) ? $_GET['CrediAgilgestion'] : '';

    $nav_items = [
        'inicio' => ['inicioadministradores', 'perfiladministradores'],
        'nuevo_cliente' => ['nuevo-cliente'],
        'creditos_pagados' => ['listado_clientes', 'listado-general-creditos-aprobados-activos'],
        'creditos_vencidos' => ['listado_morosos', 'consulta-listado-cuotas-clientes-morosos'],
        'proximos_vencer' => ['proximos_vencer'],
        'estadisticas' => ['estadisticas-generales'],
        'soporte' => ['registrar_reporte', 'registrar-ticket-problema-plataforma'],
        'notificaciones' => ['visualizar-mis-notificaciones-usuarios'],
    ];

    function ca_nav_active($key, $gestion, $items)
    {
        return in_array($gestion, $items[$key]) ? 'ca-active' : '';
    }

    // Primer nombre del usuario
    $NombreCorto = '';
    if (isset($_SESSION['nombre_usuario'])) {
        $partes = explode(' ', $_SESSION['nombre_usuario'], 2);
        $NombreCorto = $partes[0];
    }
    ?>
    <!-- Navbar CSS -->
    <link href="<?php echo $UrlGlobal; ?>vista/css/navbar.css" rel="stylesheet">

    <!--**********************************
        Header start (reemplazado por navbar)
    ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between align-items-center">

                    <!-- Izquierda: links de navegación -->
                    <div class="header-left d-flex align-items-center">
                        <ul class="ca-header-nav">
                            <!-- Inicio -->
                            <li>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=inicioadministradores"
                                    class="ca-nav-link <?php echo ca_nav_active('inicio', $gestion_actual, $nav_items); ?>">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Inicio
                                </a>
                            </li>

                            <!-- Nuevo Cliente -->
                            <li>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=nuevo-cliente"
                                    class="ca-nav-link <?php echo ca_nav_active('nuevo_cliente', $gestion_actual, $nav_items); ?>">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    Nuevo Cliente
                                </a>
                            </li>

                            <!-- Créditos Pagados -->
                            <li>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado_clientes"
                                    class="ca-nav-link <?php echo ca_nav_active('creditos_pagados', $gestion_actual, $nav_items); ?>">
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-6.383-2.302l-.244-.209.902-1.902a8 8 0 1 0-2.27-5.837l-.005.25h2.5l-2.706 5.716A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2zm1 4v2h2.5v2H10a.5.5 0 0 0-.09.992L10 11h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2H14a.5.5 0 0 0 .09-.992L14 13h-4a2.5 2.5 0 1 1 0-5h1V6h2z" />
                                    </svg>
                                    Créditos Pagados
                                </a>
                            </li>

                            <!-- Créditos Vencidos -->
                            <li>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado_morosos"
                                    class="ca-nav-link <?php echo ca_nav_active('creditos_vencidos', $gestion_actual, $nav_items); ?>">
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M14 20v2H2v-2h12zM14.586.686l7.778 7.778L20.95 9.88l-1.06-.354L17.413 12l5.657 5.657-1.414 1.414L16 13.414l-2.404 2.404.283 1.132-1.415 1.414-7.778-7.778 1.415-1.414 1.13.282 6.294-6.293-.353-1.06L14.586.686z" />
                                    </svg>
                                    Créditos Vencidos
                                </a>
                            </li>

                            <!-- Próximos a Vencer -->
                            <li>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=proximos_vencer"
                                    class="ca-nav-link <?php echo ca_nav_active('proximos_vencer', $gestion_actual, $nav_items); ?>">
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8h4v2h-6V7h2v5z" />
                                    </svg>
                                    Próximos a Vencer
                                </a>
                            </li>

                            <!-- Estadísticas -->
                            <li>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales"
                                    class="ca-nav-link <?php echo ca_nav_active('estadisticas', $gestion_actual, $nav_items); ?>">
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M2 13h6v8H2v-8zm14-5h6v13h-6V8zM9 3h6v18H9V3zM4 15v4h2v-4H4zm7-10v14h2V5h-2zm7 5v9h2v-9h-2z" />
                                    </svg>
                                    Estadísticas
                                </a>
                            </li>

                            <!-- Soporte Técnico -->
                            <li>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=registrar_reporte"
                                    class="ca-nav-link <?php echo ca_nav_active('soporte', $gestion_actual, $nav_items); ?>">
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M4 20v-6a8 8 0 1 1 16 0v6h1v2H3v-2h1zm2 0h12v-6a6 6 0 1 0-12 0v6zm5-18h2v3h-2V2zm8.778 2.808l1.414 1.414-2.12 2.121-1.415-1.414 2.121-2.121zM2.808 6.222l1.414-1.414 2.121 2.12L4.93 8.344 2.808 6.222zM7 14a5 5 0 0 1 5-5v2a3 3 0 0 0-3 3H7z" />
                                    </svg>
                                    Soporte Técnico
                                </a>
                            </li>

                            <!-- Notificaciones -->
                            <li>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=visualizar-mis-notificaciones-usuarios"
                                    class="ca-nav-link <?php echo ca_nav_active('notificaciones', $gestion_actual, $nav_items); ?>">
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zm-2 0v-7a6 6 0 1 0-12 0v7h12zm-9 4h6v2H9v-2z" />
                                    </svg>
                                    Notificaciones
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Derecha: perfil usuario -->
                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <div class="header-info">
                                    <span
                                        class="text-white"><strong><?php echo htmlspecialchars($NombreCorto); ?></strong></span>
                                    <p class="fs-12 mb-0">Administrador</p>
                                </div>
                                <img src="<?php echo $UrlGlobal; ?>vista/images/fotoperfil/<?php echo isset($_SESSION['foto_perfil']) ? htmlspecialchars($_SESSION['foto_perfil']) : 'no_disponible.png'; ?>"
                                    width="20" alt="Avatar" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=perfiladministradores"
                                    class="dropdown-item ai-icon">
                                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18"
                                        height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    <span class="ml-2">Mi Perfil</span>
                                </a>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cIniciosSesionesUsuarios.php?CrediAgil=cerrarsesion"
                                    class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18"
                                        height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                    <span class="ml-2">Cerrar Sesión</span>
                                </a>
                            </div>
                        </li>
                    </ul>

                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end
    ***********************************-->
<?php } ?>