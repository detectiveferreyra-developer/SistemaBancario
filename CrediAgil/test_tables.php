<?php
require __DIR__ . '/modelo/conexion.php';
$Conexion = new conexion();
$Conexion->conectar('crediagil');
$conectarsistema = $Conexion->establecerconexion;

$res = $conectarsistema->query("SHOW TABLES");
if($res) {
    while($row = $res->fetch_array()) {
        echo $row[0] . "\n";
    }
}
$conectarsistema->close();
?>
