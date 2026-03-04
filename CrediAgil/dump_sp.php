<?php
require_once("modelo/conexion.php");
$query = "SHOW CREATE VIEW vista_consultaclientesmorosos_detallescompletos";
$res = mysqli_query($conectarsistema, $query);
if ($res) {
    if ($row = mysqli_fetch_assoc($res)) {
        echo $row['Create View'];
    } else {
        echo "Not found";
    }
} else {
    echo "Error: " . mysqli_error($conectarsistema);
}
?>