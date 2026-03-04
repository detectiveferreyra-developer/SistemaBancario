<?php
// SOLO USUARIOS ADMINISTRADORES
if ($_SESSION['id_rol'] == 1) {
    // Obtener la gestión actual para marcar el active
    $gestion_actual = isset($_GET['CrediAgilgestion']) ? $_GET['CrediAgilgestion'] : '';

    // Mapa de rutas para cada item del menú
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

    function ca_sidebar_active($key, $gestion, $nav_items)
    {
        return in_array($gestion, $nav_items[$key]) ? 'mm-active' : '';
    }
    function ca_link_active($key, $gestion, $nav_items)
    {
        return in_array($gestion, $nav_items[$key]) ? 'active' : '';
    }
    ?>
    <div class="deznav">
        <div class="deznav-scroll">
            <ul class="metismenu" id="menu">



                <!-- NUEVO CLIENTE -->
                <li class="<?php echo ca_sidebar_active('nuevo_cliente', $gestion_actual, $nav_items); ?>">
                    <a class="ai-icon <?php echo ca_link_active('nuevo_cliente', $gestion_actual, $nav_items); ?>"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=nuevo-cliente">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                        <span class="nav-text">Nuevo Cliente</span>
                    </a>
                </li>

                <!-- CRÉDITOS PAGADOS -->
                <li class="<?php echo ca_sidebar_active('creditos_pagados', $gestion_actual, $nav_items); ?>">
                    <a class="ai-icon <?php echo ca_link_active('creditos_pagados', $gestion_actual, $nav_items); ?>"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado_clientes">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-6.383-2.302l-.244-.209.902-1.902a8 8 0 1 0-2.27-5.837l-.005.25h2.5l-2.706 5.716A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2zm1 4v2h2.5v2H10a.5.5 0 0 0-.09.992L10 11h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2H14a.5.5 0 0 0 .09-.992L14 13h-4a2.5 2.5 0 1 1 0-5h1V6h2z" />
                        </svg>
                        <span class="nav-text">Créditos Pagados</span>
                    </a>
                </li>

                <!-- CRÉDITOS VENCIDOS -->
                <li class="<?php echo ca_sidebar_active('creditos_vencidos', $gestion_actual, $nav_items); ?>">
                    <a class="ai-icon <?php echo ca_link_active('creditos_vencidos', $gestion_actual, $nav_items); ?>"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado_morosos">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M14 20v2H2v-2h12zM14.586.686l7.778 7.778L20.95 9.88l-1.06-.354L17.413 12l5.657 5.657-1.414 1.414L16 13.414l-2.404 2.404.283 1.132-1.415 1.414-7.778-7.778 1.415-1.414 1.13.282 6.294-6.293-.353-1.06L14.586.686z" />
                        </svg>
                        <span class="nav-text">Créditos Vencidos</span>
                    </a>
                </li>

                <!-- PRÓXIMOS A VENCER -->
                <li class="<?php echo ca_sidebar_active('proximos_vencer', $gestion_actual, $nav_items); ?>">
                    <a class="ai-icon <?php echo ca_link_active('proximos_vencer', $gestion_actual, $nav_items); ?>"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=proximos_vencer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8h4v2h-6V7h2v5z" />
                        </svg>
                        <span class="nav-text">Próximos a Vencer</span>
                    </a>
                </li>

                <!-- ESTADÍSTICAS -->
                <li class="<?php echo ca_sidebar_active('estadisticas', $gestion_actual, $nav_items); ?>">
                    <a class="ai-icon <?php echo ca_link_active('estadisticas', $gestion_actual, $nav_items); ?>"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=estadisticas-generales">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M2 13h6v8H2v-8zm14-5h6v13h-6V8zM9 3h6v18H9V3zM4 15v4h2v-4H4zm7-10v14h2V5h-2zm7 5v9h2v-9h-2z" />
                        </svg>
                        <span class="nav-text">Estadísticas</span>
                    </a>
                </li>

                <!-- SOPORTE TÉCNICO -->
                <li class="<?php echo ca_sidebar_active('soporte', $gestion_actual, $nav_items); ?>">
                    <a class="ai-icon <?php echo ca_link_active('soporte', $gestion_actual, $nav_items); ?>"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=registrar_reporte">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M4 20v-6a8 8 0 1 1 16 0v6h1v2H3v-2h1zm2 0h12v-6a6 6 0 1 0-12 0v6zm5-18h2v3h-2V2zm8.778 2.808l1.414 1.414-2.12 2.121-1.415-1.414 2.121-2.121zM2.808 6.222l1.414-1.414 2.121 2.12L4.93 8.344 2.808 6.222zM7 14a5 5 0 0 1 5-5v2a3 3 0 0 0-3 3H7z" />
                        </svg>
                        <span class="nav-text">Soporte Técnico</span>
                    </a>
                </li>

                <!-- NOTIFICACIONES -->
                <li class="<?php echo ca_sidebar_active('notificaciones', $gestion_actual, $nav_items); ?>">
                    <a class="ai-icon <?php echo ca_link_active('notificaciones', $gestion_actual, $nav_items); ?>"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=visualizar-mis-notificaciones-usuarios">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zm-2 0v-7a6 6 0 1 0-12 0v7h12zm-9 4h6v2H9v-2z" />
                        </svg>
                        <span class="nav-text">Notificaciones</span>
                    </a>
                </li>

            </ul>
            <div class="copyright"><!-- Copyright removed --></div>
        </div>
    </div>
<?php } ?>