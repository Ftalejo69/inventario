<?php
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "supermercado";

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

// Manejar productos
