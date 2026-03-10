<?php
$output = shell_exec('git show 3d4ec13:CrediAgil/vista/MenuNavegacion/menu-administradores.php');
// The output might be utf-16le because of powershell, but shell_exec in php might get it directly.
file_put_contents('vista/MenuNavegacion/menu-administradores-old-2.php', $output);
echo "Done";
