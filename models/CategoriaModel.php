<?php
include __DIR__ . "/../conexion.php";

$metodo = $_SERVER["REQUEST_METHOD"];

if ($metodo == "POST") {
    // Crear o actualizar categoría
    // Código existente para crear o actualizar categoría
}

if ($metodo == "GET") {
    // Obtener categorías
    // Código existente para obtener categorías
}

if ($metodo == "DELETE") {
    // Eliminar categoría
    // Código existente para eliminar categoría
}

$conexion->close();
