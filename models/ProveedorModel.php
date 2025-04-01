<?php
$conexion = new mysqli("localhost", "root", "", "supermercado");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$metodo = $_SERVER["REQUEST_METHOD"];

if ($metodo == "GET") {
    // Obtener proveedores
    // ...existing code...
}

if ($metodo == "POST") {
    // Crear proveedor
    // ...existing code...
}

if ($metodo == "PUT") {
    // Actualizar proveedor
    // ...existing code...
}

if ($metodo == "DELETE") {
    // Eliminar proveedor
    // ...existing code...
}
