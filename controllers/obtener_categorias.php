<?php
include __DIR__ . "/conexion.php";


header("Content-Type: application/json");

$sql = "SELECT * FROM categorias";
$result = $conexion->query($sql);

$categorias = [];
while ($fila = $result->fetch_assoc()) {
    $categorias[] = $fila;
}

echo json_encode($categorias);
?>
