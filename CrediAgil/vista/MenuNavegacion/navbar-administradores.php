<?php
// NAVBAR SUPERIOR — REEMPLAZA EL HEADER ORIGINAL
// Solo para ROL ADMINISTRADOR
if ($_SESSION['id_rol'] == 1) {
    $gestion_actual = isset($_GET['CrediAgilgestion']) ? $_GET['CrediAgilgestion'] : '';

    $nav_items = [
        'inicio' => ['inicioadministradores', 'perfiladministradores'],
        'estadisticas' => ['estadisticas-generales'],
        'nuevo_cliente' => ['nuevo-cliente'],
        'creditos_pagados' => ['listado-general-creditos-cancelados'],
        'pagos' => ['listado-general-creditos-aprobados-activos', 'orden-pago-creditos-CrediAgil-clientes'],
        'recuperaciones' => ['consulta-listado-cuotas-clientes-morosos', 'proximos_vencer'],
        'problemas' => ['registrar-ticket-problema-plataforma', 'consulta-listado-tickets-reportes-plataforma'],
        'notificaciones' => ['visualizar-mis-notificaciones-usuarios'],
    ];

    function ca_nav_li_active($key, $gestion, $items)
    {
        return in_array($gestion, $items[$key]) ? 'mm-active active' : '';
    }

    function ca_nav_a_active($key, $gestion, $items)
    {
        return in_array($gestion, $items[$key]) ? 'active' : '';
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

    <div class="header">
        <div class="header-content h-100">
            <nav class="navbar navbar-expand h-100 p-0">
                <div class="collapse navbar-collapse justify-content-between h-100 w-100">
                    
                    <!-- Izquierda: links de navegación compactos -->
                    <div class="header-left d-flex align-items-center h-100 p-0" style="overflow-x: auto; margin-left: 0;">
                        <ul class="navbar-nav flex-row align-items-center h-100" style="padding-left: 10px; gap: 5px;">

                            <!-- Inicio -->
                            <li class="nav-item dropdown <?php echo ca_nav_li_active('inicio', $gestion_actual, $nav_items); ?>">
                                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center <?php echo ca_nav_a_active('inicio', $gestion_actual, $nav_items); ?>" data-toggle="dropdown" style="color: white; padding: 0.5rem 1rem;">
                                    <svg class="mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    Inicio
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=inicioadministradores" class="dropdown-item <?php echo ($gestion_actual == 'inicioadministradores') ? 'active' : ''; ?>">Mi Inicio</a>
                                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=perfiladministradores" class="dropdown-item <?php echo ($gestion_actual == 'perfiladministradores') ? 'active' : ''; ?>">Mi Perfil</a>
                                </div>
                            </li>

                            <!-- Estadísticas -->
                            <li class="nav-item <?php echo ca_nav_li_active('estadisticas', $gestion_actual, $nav_items); ?>">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales" class="nav-link d-flex align-items-center <?php echo ca_nav_a_active('estadisticas', $gestion_actual, $nav_items); ?>" style="color: white; padding: 0.5rem 1rem;">
                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z" /><path fill="currentColor" d="M2 13h6v8H2v-8zm14-5h6v13h-6V8zM9 3h6v18H9V3zM4 15v4h2v-4H4zm7-10v14h2V5h-2zm7 5v9h2v-9h-2z" /></svg>
                                    Estadísticas
                                </a>
                            </li>

                            <!-- Nuevo Cliente -->
                            <li class="nav-item <?php echo ca_nav_li_active('nuevo_cliente', $gestion_actual, $nav_items); ?>">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=nuevo-cliente" class="nav-link d-flex align-items-center <?php echo ca_nav_a_active('nuevo_cliente', $gestion_actual, $nav_items); ?>" style="color: white; padding: 0.5rem 1rem;">
                                    <svg class="mr-2" viewBox="0 0 24 24" width="20" height="20" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z" /><path stroke="currentColor" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" /></svg>
                                    Nuevo Cliente
                                </a>
                            </li>

                            <!-- Pagos Dropdown -->
                            <li class="nav-item dropdown <?php echo ca_nav_li_active('pagos', $gestion_actual, $nav_items); ?>">
                                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center <?php echo ca_nav_a_active('pagos', $gestion_actual, $nav_items); ?>" data-toggle="dropdown" style="color: white; padding: 0.5rem 1rem;">
                                    <svg class="mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z" /><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-6.383-2.302l-.244-.209.902-1.902a8 8 0 1 0-2.27-5.837l-.005.25h2.5l-2.706 5.716A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2zm1 4v2h2.5v2H10a.5.5 0 0 0-.09.992L10 11h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2H14a.5.5 0 0 0 .09-.992L14 13h-4a2.5 2.5 0 1 1 0-5h1V6h2z" /></svg>
                                    Pagos
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado-general-creditos-aprobados-activos" class="dropdown-item <?php echo ($gestion_actual == 'listado-general-creditos-aprobados-activos') ? 'active' : ''; ?>">Listado de Clientes</a>
                                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=orden-pago-creditos-CrediAgil-clientes" class="dropdown-item <?php echo ($gestion_actual == 'orden-pago-creditos-CrediAgil-clientes') ? 'active' : ''; ?>">Cobro Orden de Pago</a>
                                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado-general-creditos-cancelados" class="dropdown-item <?php echo ($gestion_actual == 'listado-general-creditos-cancelados') ? 'active' : ''; ?>">Créditos Pagados</a>
                                </div>
                            </li>

                            <!-- Recuperaciones Dropdown -->
                            <li class="nav-item dropdown <?php echo ca_nav_li_active('recuperaciones', $gestion_actual, $nav_items); ?>">
                                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center <?php echo ca_nav_a_active('recuperaciones', $gestion_actual, $nav_items); ?>" data-toggle="dropdown" style="color: white; padding: 0.5rem 1rem;">
                                    <svg class="mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z" /><path d="M14 20v2H2v-2h12zM14.586.686l7.778 7.778L20.95 9.88l-1.06-.354L17.413 12l5.657 5.657-1.414 1.414L16 13.414l-2.404 2.404.283 1.132-1.415 1.414-7.778-7.778 1.415-1.414 1.13.282 6.294-6.293-.353-1.06L14.586.686z" /></svg>
                                    Recuperaciones
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=consulta-listado-cuotas-clientes-morosos" class="dropdown-item <?php echo ($gestion_actual == 'consulta-listado-cuotas-clientes-morosos') ? 'active' : ''; ?>">Créditos Vencidos</a>
                                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=proximos_vencer" class="dropdown-item <?php echo ($gestion_actual == 'proximos_vencer') ? 'active' : ''; ?>">Próximos a Vencer</a>
                                </div>
                            </li>

                            <!-- Problemas Dropdown -->
                            <li class="nav-item dropdown <?php echo ca_nav_li_active('problemas', $gestion_actual, $nav_items); ?>">
                                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center <?php echo ca_nav_a_active('problemas', $gestion_actual, $nav_items); ?>" data-toggle="dropdown" style="color: white; padding: 0.5rem 1rem;">
                                    <svg class="mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z" /><path d="M4 20v-6a8 8 0 1 1 16 0v6h1v2H3v-2h1zm2 0h12v-6a6 6 0 1 0-12 0v6zm5-18h2v3h-2V2zm8.778 2.808l1.414 1.414-2.12 2.121-1.415-1.414 2.121-2.121zM2.808 6.222l1.414-1.414 2.121 2.12L4.93 8.344 2.808 6.222zM7 14a5 5 0 0 1 5-5v2a3 3 0 0 0-3 3H7z" /></svg>
                                    Problemas / Soporte
                                </a>
                                <div class="dropdown-menu">
                                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=registrar-ticket-problema-plataforma" class="dropdown-item <?php echo ($gestion_actual == 'registrar-ticket-problema-plataforma') ? 'active' : ''; ?>">Registrar Reportes Problemas</a>
                                    <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=consulta-listado-tickets-reportes-plataforma" class="dropdown-item <?php echo ($gestion_actual == 'consulta-listado-tickets-reportes-plataforma') ? 'active' : ''; ?>">Listado Reportes Problemas</a>
                                </div>
                            </li>

                        </ul>
                    </div>

                    <!-- Derecha: perfil usuario + hamburger UNIFICADOS -->
                    <ul class="navbar-nav header-right pr-3 h-100" style="display:flex;align-items:center;gap:0;">
                         <!-- Notificaciones Bell Icon como en dashboard original -->
                        <li class="nav-item dropdown notification_dropdown" style="margin-right: 15px;">
                            <a class="nav-link  ai-icon" href="#" role="button" data-toggle="dropdown" style="padding: 0;">
                                <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path d="M22 20H2v-2h1v-6.969C3 6.043 7.03 2 12 2s9 4.043 9 9.031V18h1v2zM5 18h14v-6.969C19 7.148 15.866 4 12 4s-7 3.148-7 7.031V18zm4.5 3h5a2.5 2.5 0 1 1-5 0z" />
                                </svg>
                                <span class="badge light text-white bg-primary" style="position:absolute; top:-5px; right:-10px; font-size:10px; border-radius:50%; padding:3px 6px;">0</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="all-notification" href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=visualizar-mis-notificaciones-usuarios">Ver Mis Notificaciones <i class="ti-arrow-right"></i></a>
                            </div>
                        </li>

                        <li class="nav-item dropdown header-profile h-100 d-flex align-items-center" style="padding: 0 15px;">
                            <a class="nav-link p-2 d-flex align-items-center" href="#" role="button" data-toggle="dropdown"
                                style="background: rgba(255,255,255,0.06) !important; border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 40px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important; gap:12px !important; display:flex !important; transition: all 0.3s ease;">
                                <div class="header-info" style="text-align:right; display:block !important; margin-left:8px;">
                                    <span class="text-white" style="font-size:0.9rem; line-height:1; display:block !important; margin-bottom:4px;"><strong><?php echo htmlspecialchars($NombreCorto); ?></strong></span>
                                    <small class="text-white" style="font-size:0.75rem; opacity:0.7; display:block !important;">Administrador</small>
                                </div>
                                <img src="<?php echo $UrlGlobal; ?>vista/images/fotoperfil/<?php echo isset($_SESSION['foto_perfil']) ? htmlspecialchars($_SESSION['foto_perfil']) : 'no_disponible.png'; ?>"
                                    width="38" height="38" style="border-radius:50%; object-fit:cover; border: 2px solid var(--crediagil-orange);" alt="Avatar" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=perfiladministradores" class="dropdown-item ai-icon">
                                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    <span class="ml-2">Mi Perfil</span>
                                </a>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=mensajeria-CrediAgil-usuarios" class="dropdown-item ai-icon">
                                    <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                    <span class="ml-2">Inbox</span>
                                </a>
                                <a href="<?php echo $UrlGlobal; ?>controlador/cIniciosSesionesUsuarios.php?CrediAgil=cerrarsesion" class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                    <span class="ml-2">Cerrar Sesi&oacute;n</span>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item d-flex align-items-center" style="padding-left: 10px;">
                            <div class="nav-control" style="position:static; padding:0; height:auto; margin:0; display:flex !important; align-items:center;">
                                <div class="hamburger" style="cursor:pointer; width:44px; height:44px; border-radius:12px; background: rgba(255,255,255,0.08); display:flex; flex-direction:column; justify-content:center; align-items:center; gap:5px; border: 1px solid rgba(255,255,255,0.15); transition: background 0.3s ease;">
                                    <span class="line" style="height:2px; width:22px; background:#fff; display:block; border-radius:2px;"></span>
                                    <span class="line" style="height:2px; width:22px; background:#fff; display:block; border-radius:2px;"></span>
                                    <span class="line" style="height:2px; width:22px; background:#fff; display:block; border-radius:2px;"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
<?php } ?>