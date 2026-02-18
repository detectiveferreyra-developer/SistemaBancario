<?php
// SOLO  USUARIOS GERENCIA
if ($_SESSION['id_rol'] == 3) {
    ?>
    <div class="deznav">
        <div class="deznav-scroll">
            <ul class="metismenu" id="menu">
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="true">
                        <svg class="w-6 h-6" fill="none" stroke="LightSlateGrey" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="nav-text">Inicio</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=iniciogerencia">Mi
                                Inicio</a></li>
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=perfilgerencia">Mi
                                Perfil</a></li>
                    </ul>
                </li>
                <li <?php if ($_GET['CrediAgilgestion'] == "consulta-productos-especifica-CrediAgil-gerencia" || $_GET['CrediAgilgestion'] == "modificar-productos-CrediAgil-gerencia") {
                    echo "class='mm-active'";
                } ?>><a   class="has-arrow ai-icon" href="javascript:void()" aria-expanded="true">
                        <svg class="w-6 h-6" fill="none" stroke="LightSlateGrey" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span class="nav-text">Productos</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a <?php if ($_GET['CrediAgilgestion'] == "consulta-productos-especifica-CrediAgil-gerencia" || $_GET['CrediAgilgestion'] == "modificar-productos-CrediAgil-gerencia") {
                            echo "class='active-element-menu'";
                        } ?> href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=consultar-productos-CrediAgil-gerencia">Consultar
                                Productos</a></li>
                    </ul>
                </li>
                <li><a class="ai-icon"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=nuevo-cliente"
                        aria-expanded="true">
                        <svg class="w-6 h-6" fill="none" stroke="LightSlateGrey" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                        <span class="nav-text">Nuevo Cliente</span>
                    </a>
                </li>
                <li <?php if ($_GET['CrediAgilgestion'] == "sistema-pagos-creditos-CrediAgil-clientes" || $_GET['CrediAgilgestion'] == "orden-pago-creditos-CrediAgil-clientes") {
                    echo 'class="mm-active"';
                } ?>><a   class="has-arrow ai-icon" href="javascript:void()" aria-expanded="true">
                        <svg fill="LightSlateGrey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                            height="24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-6.383-2.302l-.244-.209.902-1.902a8 8 0 1 0-2.27-5.837l-.005.25h2.5l-2.706 5.716A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2zm1 4v2h2.5v2H10a.5.5 0 0 0-.09.992L10 11h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2H14a.5.5 0 0 0 .09-.992L14 13h-4a2.5 2.5 0 1 1 0-5h1V6h2z" />
                        </svg>
                        <span class="nav-text">Pagos</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a <?php if ($_GET['CrediAgilgestion'] == "sistema-pagos-creditos-CrediAgil-clientes") {
                            echo 'class="active-element-menu"';
                        } ?>   href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado-general-creditos-aprobados-activos-gerencia">Listado
                                de Clientes</a></li>
                        <li><a <?php if ($_GET['CrediAgilgestion'] == "orden-pago-creditos-CrediAgil-clientes") {
                            echo 'class="active-element-menu"';
                        } ?> href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=orden-pago-creditos-CrediAgil-clientes">Cobro
                                Orden de Pago</a></li>
                    </ul>
                </li>
                <li <?php if ($_GET['CrediAgilgestion'] == "consulta-especifica-solicitudes-creditos-aprobadas-activas-clientes") {
                    echo "class='mm-active'";
                } ?>><a class="has-arrow ai-icon" href="javascript:void()"
                        aria-expanded="true">
                        <svg class="w-6 h-6" fill="none" stroke="LightSlateGrey" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="nav-text">Cr&eacute;ditos</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=asignacion-nuevos-creditos-clientes-gerencia">Asignar
                                Nuevos Cr&eacute;ditos</a></li>
                        <li><a <?php if ($_GET['CrediAgilgestion'] == "consulta-especifica-solicitudes-creditos-aprobadas-activas-clientes") {
                            echo "class='active-element-menu'";
                        } ?> href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado-general-creditos-aprobados-activos-gerencia">Cr&eacute;ditos
                                Aprobados</a></li>
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=gestionar-solicitudes-creditos-asignados-clientes-gerencia">Consulta
                                Revisi&oacute;n Solicitudes Cr&eacute;ditos</a></li>
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado-general-reestructurar-creditos-clientes-gerencia">Reestructurar
                                Cr&eacute;ditos</a></li>
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado-general-creditos-denegados-gerencia">Cr&eacute;ditos
                                Rechazados</a></li>
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado-general-creditos-cancelados-gerencia">Cr&eacute;ditos
                                Cancelados</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="true">
                        <svg fill="LightSlateGrey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M14 20v2H2v-2h12zM14.586.686l7.778 7.778L20.95 9.88l-1.06-.354L17.413 12l5.657 5.657-1.414 1.414L16 13.414l-2.404 2.404.283 1.132-1.415 1.414-7.778-7.778 1.415-1.414 1.13.282 6.294-6.293-.353-1.06L14.586.686z" />
                        </svg>
                        <span class="nav-text">Recuperaciones</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=consulta-listado-cuotas-clientes-morosos-gerencia">Listado
                                Clientes Morosos</a></li>
                    </ul>
                </li>

                <li <?php if ($_GET['CrediAgilgestion'] == "consulta-especifica-tickets-reportes-plataforma") {
                    echo 'class="mm-active"';
                } ?>><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="true">
                        <svg fill="LightSlateGrey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                            height="24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M4 20v-6a8 8 0 1 1 16 0v6h1v2H3v-2h1zm2 0h12v-6a6 6 0 1 0-12 0v6zm5-18h2v3h-2V2zm8.778 2.808l1.414 1.414-2.12 2.121-1.415-1.414 2.121-2.121zM2.808 6.222l1.414-1.414 2.121 2.12L4.93 8.344 2.808 6.222zM7 14a5 5 0 0 1 5-5v2a3 3 0 0 0-3 3H7z" />
                        </svg>
                        <span class="nav-text">Problemas</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=registrar-ticket-problema-plataforma-gerencia">Registrar
                                Reportes Problemas</a></li>
                    </ul>
                </li>

                <li><a class="ai-icon"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=visualizar-mis-notificaciones-usuarios-gerencia"
                        aria-expanded="true">
                        <svg fill="LightSlateGrey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                            height="24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zm-2 0v-7a6 6 0 1 0-12 0v7h12zm-9 4h6v2H9v-2z" />
                        </svg>
                        <span class="nav-text">Notificaciones</span>
                    </a>
                </li>
            </ul>

            <div class="add-menu-sidebar">
                <!-- Copyright removed -->
            </div>
            <div class="copyright">

            </div>
        </div>
    </div>
<?php } ?>