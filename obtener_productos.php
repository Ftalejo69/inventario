<?php
$host = "localhost";   
$usuario = "root";     
$password = "";        
$base_datos = "supermercado";  

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

// Obtener los productos con sus categorías y proveedores
$sql = "SELECT productos.id, productos.nombre, productos.descripcion, productos.precio, productos.stock, productos.imagen, 
               categorias.nombre AS categoria, proveedores.nombre AS proveedor 
        FROM productos
        JOIN categorias ON productos.categoria_id = categorias.id
        JOIN proveedores ON productos.proveedor_id = proveedores.id";

$result = $conexion->query($sql);

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Devolver los productos en JSON
echo json_encode($productos);

$conexion->close();
?>
