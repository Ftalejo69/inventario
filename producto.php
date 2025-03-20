<?php
$host = "localhost";   
$usuario = "root";     
$password = "";        
$base_datos = "supermercado";  

$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

// Crear carpeta si no existe
$upload_dir = "imagenes/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Si se reciben datos por POST, intentar guardarlos en la BD
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? "";
    $descripcion = $_POST["descripcion"] ?? "";
    $precio = $_POST["precio"] ?? 0;
    $stock = $_POST["stock"] ?? 0;
    $categoria_id = $_POST["categoria_id"] ?? 0;
    $proveedor_id = $_POST["proveedor_id"] ?? 0;
    $imagen_path = "";

    // Manejar la subida de imagen
    if (!empty($_FILES["imagen"]["name"])) {
        $imagen_nombre = basename($_FILES["imagen"]["name"]);
        $imagen_path = $upload_dir . time() . "_" . $imagen_nombre; // Para evitar nombres repetidos

        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagen_path)) {
            echo json_encode(["error" => "Error al subir la imagen."]);
            exit;
        }
    }

    // Validar que los campos sean correctos
    if (empty($nombre) || empty($descripcion) || $precio <= 0 || $stock < 0 || $categoria_id <= 0 || $proveedor_id <= 0) {
        echo json_encode(["error" => "Todos los campos son obligatorios."]);
        exit;
    }

    // Insertar en la base de datos
    $stmt = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, proveedor_id, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiiss", $nombre, $descripcion, $precio, $stock, $categoria_id, $proveedor_id, $imagen_path);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Producto guardado correctamente."]);
    } else {
        echo json_encode(["error" => "Error al guardar producto: " . $stmt->error]);
    }

    $stmt->close();
    $conexion->close();
    exit;
}

// Si es una solicitud GET, devolver categorías y proveedores
$sql_categorias = "SELECT id, nombre FROM categorias";
$result_categorias = $conexion->query($sql_categorias);

$categorias = [];
while ($row = $result_categorias->fetch_assoc()) {
    $categorias[] = $row;
}

$sql_proveedores = "SELECT id, nombre FROM proveedores";
$result_proveedores = $conexion->query($sql_proveedores);

$proveedores = [];
while ($row = $result_proveedores->fetch_assoc()) {
    $proveedores[] = $row;
}

// Devolver JSON con categorías y proveedores
echo json_encode([
    "categorias" => $categorias,
    "proveedores" => $proveedores
]);

$conexion->close();
?>
