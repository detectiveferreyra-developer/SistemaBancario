<?php
$directory = new RecursiveDirectoryIterator('CrediAgil/vista');
$iterator = new RecursiveIteratorIterator($directory);
$files = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    $filePath = $file[0];
    $content = file_get_contents($filePath);

    // Remove require lines
    $content = preg_replace("/require\('\.\.\/modelo\/mConteoMensajesBandejaEntrada_MensajeriaInterna(_Secundario)?\.php'\);/", "", $content);
    $content = preg_replace("/require\(\"\.\.\/modelo\/mConteoMensajesBandejaEntrada_MensajeriaInterna(_Secundario)?\.php\"\);/", "", $content);

    // Remove messaging bell li block
    $content = preg_replace('/<li class="nav-item dropdown notification_dropdown">\s*<a class="nav-link bell bell-link" href="[^"]*mensajeria-CrediAgil-usuarios[^"]*">.*?<\/a>\s*<\/li>/s', '', $content);

    // Remove Inbox link block
    $content = preg_replace('/<a href="[^"]*mensajeria-CrediAgil-usuarios[^"]*" class="dropdown-item ai-icon">.*?<\/a>/s', '', $content);

    file_put_contents($filePath, $content);
    echo "Processed: $filePath\n";
}
?>