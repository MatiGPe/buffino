<?php
$conexion = new mysqli("localhost", "root", "", "buffino_db");

if ($conexion->connect_errno) {
    die("La conexión ha fallado: " . $conexion->connect_error);
}
?>
