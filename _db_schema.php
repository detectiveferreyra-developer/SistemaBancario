<?php
$c = new mysqli('localhost', 'root', '', 'crediagil');
$tables = ['creditos', 'cuotas', 'productos', 'usuarios', 'transacciones', 'historicocreditos', 'historicocuotascreditos', 'datosvehiculoscreditos'];
foreach ($tables as $t) {
    $r2 = $c->query("DESCRIBE $t");
    if ($r2) {
        echo "--- $t ---\n";
        while ($row2 = $r2->fetch_assoc()) {
            echo $row2['Field'] . ' | ' . $row2['Type'] . ' | ' . $row2['Key'] . "\n";
        }
        echo "\n";
    }
}
// Also get some sample data counts
echo "--- DATA COUNTS ---\n";
$counts = ['creditos', 'cuotas', 'productos', 'usuarios', 'transacciones'];
foreach ($counts as $t) {
    $r = $c->query("SELECT COUNT(*) as cnt FROM $t");
    $row = $r->fetch_assoc();
    echo "$t: " . $row['cnt'] . "\n";
}
$c->close();
