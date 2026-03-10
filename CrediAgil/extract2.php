<?php
$output = shell_exec('git show 3d4ec13:CrediAgil/vista/MenuNavegacion/navbar-administradores.php');
file_put_contents('vista/MenuNavegacion/navbar-administradores-old-2.php', $output);
echo "Done";
