<?php
require __DIR__ . '/modelo/conexion.php';
$Conexion = new conexion();
$Conexion->conectar('crediagil');
$conectarsistema = $Conexion->establecerconexion;

$tables = ['usuarios', 'detalleusuarios', 'creditos', 'detallescreditos'];
foreach($tables as $table) {
    echo "--- $table ---\n";
    $res = $conectarsistema->query("DESCRIBE $table");
    if($res) {
        while($row = $res->fetch_assoc()) {
            echo "{$row['Field']} - {$row['Type']}\n";
        }
    }
}
$conectarsistema->close();
?>
