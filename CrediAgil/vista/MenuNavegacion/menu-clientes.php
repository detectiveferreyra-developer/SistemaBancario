<?php
// SOLO  USUARIOS CLIENTES
if ($_SESSION['id_rol'] == 5) {
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
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=inicioclientes">Mi
                                Inicio</a></li>
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=perfilclientes">Mi
                                Perfil</a></li>
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
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=impresion-estado-cuenta-cuotas-nuevos-creditos-portal-clientes">Estado
                                de Cuenta</a></li>
                        <li><a
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=listado-general-creditos-historicos-portalclientes">Cr&eacute;ditos
                                Hist&oacute;ricos</a></li>
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
                                href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=registrar-ticket-problema-plataforma-clientes">Registrar
                                Reportes Problemas</a></li>
                    </ul>
                </li>

                <li><a class="ai-icon"
                        href="<?php echo $UrlGlobal; ?>controlador/cGestionesCrediAgil.php?CrediAgilgestion=visualizar-mis-notificaciones-usuarios-clientes"
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

            <div class="copyright">

            </div>
        </div>
    </div>
<?php } ?>