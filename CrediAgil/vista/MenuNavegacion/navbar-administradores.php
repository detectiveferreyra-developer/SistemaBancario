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

    // Mismas funciones del sidebar para activar la clase 'mm-active'
    function ca_nav_li_active($key, $gestion, $items)
    {
        return in_array($gestion, $items[$key]) ? 'mm-active' : '';
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

    <!--**********************************
        Header start (reemplazado por navbar idéntico al sidebar)
    ***********************************-->
    <div class="header">
        <div class="header-content h-100">
            <nav class="navbar navbar-expand h-100 p-0">

                <div class="collapse navbar-collapse justify-content-between h-100 w-100">

                    <!-- Izquierda: links de navegación compactos -->
                    <div class="header-left d-flex align-items-center h-100 p-0" style="overflow-x: auto; margin-left: 0;">
                        <ul class="metismenu metismenu-horizontal" id="menu-horizontal" style="padding-left: 0;">

                            <!-- Estadísticas -->
                            <li class="<?php echo ca_nav_li_active('estadisticas', $gestion_actual, $nav_items); ?>">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales"
                                    class="ai-icon <?php echo ca_nav_a_active('estadisticas', $gestion_actual, $nav_items); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M2 13h6v8H2v-8zm14-5h6v13h-6V8zM9 3h6v18H9V3zM4 15v4h2v-4H4zm7-10v14h2V5h-2zm7 5v9h2v-9h-2z" />
                                    </svg>
                                    <span class="nav-text">Estad&iacute;sticas</span>
                                </a>
                            </li>

                            <!-- Nuevo Cliente -->
                            <li class="<?php echo ca_nav_li_active('nuevo_cliente', $gestion_actual, $nav_items); ?>">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=nuevo-cliente"
                                    class="ai-icon <?php echo ca_nav_a_active('nuevo_cliente', $gestion_actual, $nav_items); ?>">
                                    <svg viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                    <span class="nav-text">Nuevo Cliente</span>
                                </a>
                            </li>

                            <!-- Próximos a Vencer -->
                            <li class="<?php echo ca_nav_li_active('proximos_vencer', $gestion_actual, $nav_items); ?>">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=proximos_vencer"
                                    class="ai-icon <?php echo ca_nav_a_active('proximos_vencer', $gestion_actual, $nav_items); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8h4v2h-6V7h2v5z" />
                                    </svg>
                                    <span class="nav-text">Pr&oacute;ximos a Vencer</span>
                                </a>
                            </li>

                            <!-- Créditos Pagados -->
                            <li class="<?php echo ca_nav_li_active('creditos_pagados', $gestion_actual, $nav_items); ?>">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado_clientes"
                                    class="ai-icon <?php echo ca_nav_a_active('creditos_pagados', $gestion_actual, $nav_items); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-6.383-2.302l-.244-.209.902-1.902a8 8 0 1 0-2.27-5.837l-.005.25h2.5l-2.706 5.716A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2zm1 4v2h2.5v2H10a.5.5 0 0 0-.09.992L10 11h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2H14a.5.5 0 0 0 .09-.992L14 13h-4a2.5 2.5 0 1 1 0-5h1V6h2z" />
                                    </svg>
                                    <span class="nav-text">Cr&eacute;ditos Pagados</span>
                                </a>
                            </li>

                            <!-- Créditos Vencidos -->
                            <li class="<?php echo ca_nav_li_active('creditos_vencidos', $gestion_actual, $nav_items); ?>">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado_morosos"
                                    class="ai-icon <?php echo ca_nav_a_active('creditos_vencidos', $gestion_actual, $nav_items); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M14 20v2H2v-2h12zM14.586.686l7.778 7.778L20.95 9.88l-1.06-.354L17.413 12l5.657 5.657-1.414 1.414L16 13.414l-2.404 2.404.283 1.132-1.415 1.414-7.778-7.778 1.415-1.414 1.13.282 6.294-6.293-.353-1.06L14.586.686z" />
                                    </svg>
                                    <span class="nav-text">Cr&eacute;ditos Vencidos</span>
                                </a>
                            </li>


                            <!-- Soporte Técnico -->
                            <li class="<?php echo ca_nav_li_active('soporte', $gestion_actual, $nav_items); ?>">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=registrar_reporte"
                                    class="ai-icon <?php echo ca_nav_a_active('soporte', $gestion_actual, $nav_items); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M4 20v-6a8 8 0 1 1 16 0v6h1v2H3v-2h1zm2 0h12v-6a6 6 0 1 0-12 0v6zm5-18h2v3h-2V2zm8.778 2.808l1.414 1.414-2.12 2.121-1.415-1.414 2.121-2.121zM2.808 6.222l1.414-1.414 2.121 2.12L4.93 8.344 2.808 6.222zM7 14a5 5 0 0 1 5-5v2a3 3 0 0 0-3 3H7z" />
                                    </svg>
                                    <span class="nav-text">Soporte T&eacute;cnico</span>
                                </a>
                            </li>

                            <!-- Notificaciones -->
                            <li class="<?php echo ca_nav_li_active('notificaciones', $gestion_actual, $nav_items); ?>">
                                <a href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=visualizar-mis-notificaciones-usuarios"
                                    class="ai-icon <?php echo ca_nav_a_active('notificaciones', $gestion_actual, $nav_items); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zm-2 0v-7a6 6 0 1 0-12 0v7h12zm-9 4h6v2H9v-2z" />
                                    </svg>
                                    <span class="nav-text">Notificaciones</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Derecha: perfil usuario + hamburger UNIFICADOS -->
                    <ul class="navbar-nav header-right pr-3 h-100" style="display:flex;align-items:center;gap:0;">
                        <li class="nav-item dropdown header-profile h-100 d-flex align-items-center"
                            style="padding: 0 15px;">
                            <a class="nav-link p-2 d-flex align-items-center" href="#" role="button" data-toggle="dropdown"
                                style="background: rgba(255,255,255,0.06) !important; border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 40px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important; gap:12px !important; display:flex !important; transition: all 0.3s ease;">
                                <div class="header-info"
                                    style="text-align:right; display:block !important; margin-left:8px;">
                                    <span class="text-white"
                                        style="font-size:0.9rem; line-height:1; display:block !important; margin-bottom:4px;"><strong><?php echo htmlspecialchars($NombreCorto); ?></strong></span>
                                    <small class="text-white"
                                        style="font-size:0.75rem; opacity:0.7; display:block !important;">Administrador</small>
                                </div>
                                <img src="<?php echo $UrlGlobal; ?>vista/images/fotoperfil/<?php echo isset($_SESSION['foto_perfil']) ? htmlspecialchars($_SESSION['foto_perfil']) : 'no_disponible.png'; ?>"
                                    width="38" height="38"
                                    style="border-radius:50%; object-fit:cover; border: 2px solid var(--crediagil-orange);"
                                    alt="Avatar" />
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
                                    <span class="ml-2">Cerrar Sesi&oacute;n</span>
                                </a>
                            </div>
                        </li>
                        <!-- Hamburger reconstruido -->
                        <li class="nav-item d-flex align-items-center" style="padding-left: 10px;">
                            <div class="nav-control"
                                style="position:static; padding:0; height:auto; margin:0; display:flex !important; align-items:center;">
                                <div class="hamburger"
                                    style="cursor:pointer; width:44px; height:44px; border-radius:12px; background: rgba(255,255,255,0.08); display:flex; flex-direction:column; justify-content:center; align-items:center; gap:5px; border: 1px solid rgba(255,255,255,0.15); transition: background 0.3s ease;">
                                    <span class="line"
                                        style="height:2px; width:22px; background:#fff; display:block; border-radius:2px;"></span>
                                    <span class="line"
                                        style="height:2px; width:22px; background:#fff; display:block; border-radius:2px;"></span>
                                    <span class="line"
                                        style="height:2px; width:22px; background:#fff; display:block; border-radius:2px;"></span>
                                </div>
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
    <?php
    // OBTENER TITULO PARA EL BANNER ANIMADO
    $modulos_titulos = [
        'estadisticas-generales' => 'Estadísticas Generales',
        'nuevo-cliente' => 'Nuevo Cliente',
        'listado_clientes' => 'Créditos Pagados',
        'listado-general-creditos-aprobados-activos' => 'Créditos Pagados',
        'listado_morosos' => 'Créditos Vencidos',
        'consulta-listado-cuotas-clientes-morosos' => 'Créditos Vencidos',
        'proximos_vencer' => 'Próximos a Vencer',
        'registrar_reporte' => 'Soporte Técnico',
        'registrar-ticket-problema-plataforma' => 'Soporte Técnico',
        'visualizar-mis-notificaciones-usuarios' => 'Notificaciones',
        'perfiladministradores' => 'Mi Perfil'
    ];
    $titulo_animado = isset($modulos_titulos[$gestion_actual]) ? $modulos_titulos[$gestion_actual] : 'CrediAgil';
    ?>
    <style>
    /* Ocultar los antiguos titulos feos si existen */
    .page-titles { display: none !important; }

    /* Eliminar el espacio superior e izquierdo SOLO del contenedor donde inyectamos el banner */
    .content-body .container-fluid { 
        padding-top: 0 !important; 
        padding-left: 0 !important; 
    }

    .animated-banner-wrapper {
        width: 100%;
        margin-bottom: 30px;
        overflow: hidden;
        padding: 0;
        margin-top: 0;
        margin-left: -3.75rem !important; /* Desplazado 30px más a la izquierda (-60px total) */
    }

    .animated-banner-strip {
        background: linear-gradient(90deg, #4b5259 0%, #768088 100%);
        height: 85px; /* Más grueso */
        width: 48%; 
        display: flex;
        align-items: center;
        border-bottom-right-radius: 0; /* Totalmente rectangular */
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transform: translateX(-100%);
        animation: slideInBanner 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.1) forwards;
        position: relative;
    }

    .animated-banner-strip::after {
        content: '';
        position: absolute;
        right: -6px;
        top: 0;
        height: 100%;
        width: 6px;
        background: #FF6B35;
        border-bottom-right-radius: 0; /* Totalmente rectangular */
    }

    .animated-banner-text {
        color: #ffffff;
        font-size: 1.8rem; /* Aumento de tamaño para proporciones */
        font-weight: 700;
        margin-left: 95px; /* Desplazado otros 30px más a la derecha (total 95px) */
        letter-spacing: 0.5px;
        opacity: 0;
        transform: translateX(-20px);
        animation: fadeInText 0.5s ease-out 0.6s forwards;
    }

    @keyframes slideInBanner {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(0); }
    }

    @keyframes fadeInText {
        0% { opacity: 0; transform: translateX(-20px); }
        100% { opacity: 1; transform: translateX(0); }
    }

    @media (max-width: 768px) {
        .animated-banner-strip { width: 90%; }
        .animated-banner-text { font-size: 1.2rem; }
    }
    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var bodyMsg = document.querySelector(".content-body");
        if (bodyMsg) {
            var bannerHTML = `
                <div class="animated-banner-wrapper">
                    <div class="animated-banner-strip">
                        <span class="animated-banner-text"><?php echo addslashes($titulo_animado); ?></span>
                    </div>
                </div>
            `;
            bodyMsg.insertAdjacentHTML('afterbegin', bannerHTML);
        }
    });
    </script>
<?php } ?>