<?php
$f = 'C:/laragon/www/SistemaBancario/CrediAgil/vista/Administradores/proximos-a-vencer.php';
$c = file_get_contents($f);
$c = mb_convert_encoding($c, 'UTF-8', 'ISO-8859-1');
file_put_contents($f, $c);
echo "Done";
