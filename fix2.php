<?php
$files = [
    'C:/laragon/www/SistemaBancario/CrediAgil/vista/MenuNavegacion/menu-administradores.php',
    'C:/laragon/www/SistemaBancario/CrediAgil/vista/MenuNavegacion/navbar-administradores.php'
];

foreach ($files as $f) {
    if (file_exists($f)) {
        $c = file_get_contents($f);
        // Only convert if it's not valid UTF-8
        if (!mb_check_encoding($c, 'UTF-8')) {
            $c = mb_convert_encoding($c, 'UTF-8', 'ISO-8859-1');
            file_put_contents($f, $c);
            echo "Converted $f\n";
        } else {
            echo "Already UTF-8 $f\n";
        }
    }
}
