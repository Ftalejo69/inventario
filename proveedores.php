<?php
$conexion = new mysqli("localhost", "root", "", "supermercado");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$metodo = $_SERVER["REQUEST_METHOD"];

if ($metodo == "GET") {
    $resultado = $conexion->query("SELECT * FROM proveedores");
    $proveedores = [];
    while ($fila = $resultado->fetch_assoc()) {
        $proveedores[] = $fila;
    }
    echo json_encode($proveedores);
}

if ($metodo == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $conexion->query("INSERT INTO proveedores (nombre, contacto, telefono) VALUES ('{$data["nombre"]}', '{$data["contacto"]}', '{$data["telefono"]}')");
    echo json_encode(["mensaje" => "Proveedor agregado"]);
}

if ($metodo == "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);
    $conexion->query("UPDATE proveedores SET nombre='{$data["nombre"]}', contacto='{$data["contacto"]}', telefono='{$data["telefono"]}' WHERE id={$data["id"]}");
    echo json_encode(["mensaje" => "Proveedor actualizado"]);
}

if ($metodo == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    $conexion->query("DELETE FROM proveedores WHERE id={$data["id"]}");
    echo json_encode(["mensaje" => "Proveedor eliminado"]);
}
?>
