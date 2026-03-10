<?php
$dir = new RecursiveDirectoryIterator('C:/laragon/www/SistemaBancario/CrediAgil/vista/');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
foreach ($files as $file) {
    $f = $file[0];
    $c = file_get_contents($f);
    if (!mb_check_encoding($c, 'UTF-8')) {
        $c = mb_convert_encoding($c, 'UTF-8', 'ISO-8859-1');
        file_put_contents($f, $c);
        echo "Converted $f\n";
        $count++;
    }
}
echo "Total converted: $count\n";
