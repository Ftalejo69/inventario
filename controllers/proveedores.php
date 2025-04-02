<?php
$conexion = new mysqli("localhost", "root", "", "supermercado");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$metodo = $_SERVER["REQUEST_METHOD"];
error_log("Método HTTP recibido: $metodo");

if ($metodo == "GET") {
    $resultado = $conexion->query("SELECT * FROM proveedores");
    $proveedores = [];
    while ($fila = $resultado->fetch_assoc()) {
        $proveedores[] = $fila;
    }
    error_log("Proveedores obtenidos: " . json_encode($proveedores));
    echo json_encode($proveedores);
}

if ($metodo == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    error_log("Datos recibidos para insertar: " . json_encode($data));
    $conexion->query("INSERT INTO proveedores (nombre, contacto, telefono) VALUES ('{$data["nombre"]}', '{$data["contacto"]}', '{$data["telefono"]}')");
    echo json_encode(["mensaje" => "Proveedor agregado"]);
}

if ($metodo == "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);
    error_log("Datos recibidos para actualizar: " . json_encode($data));
    $conexion->query("UPDATE proveedores SET nombre='{$data["nombre"]}', contacto='{$data["contacto"]}', telefono='{$data["telefono"]}' WHERE id={$data["id"]}");
    echo json_encode(["mensaje" => "Proveedor actualizado"]);
}

if ($metodo == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    error_log("Datos recibidos para eliminar: " . json_encode($data));

    if (isset($data["id"]) && is_numeric($data["id"])) { // Verifica que el ID sea numérico
        $id = intval($data["id"]);

        // Verificar si el proveedor tiene productos asociados
        $query = "SELECT COUNT(*) AS total FROM productos WHERE proveedor_id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['total'] > 0) {
            http_response_code(400);
            echo json_encode(["error" => "No se puede eliminar este proveedor porque tiene productos asociados."]);
            exit;
        }

        $resultado = $conexion->query("DELETE FROM proveedores WHERE id=$id");

        if ($resultado && $conexion->affected_rows > 0) { // Verifica si se eliminó alguna fila
            error_log("Proveedor con ID $id eliminado correctamente.");
            echo json_encode(["mensaje" => "Proveedor eliminado"]);
        } else {
            error_log("Error al eliminar proveedor con ID $id: " . $conexion->error);
            http_response_code(500);
            echo json_encode(["error" => "No se pudo eliminar el proveedor"]);
        }
    } else {
        error_log("ID no proporcionado o inválido para eliminar.");
        http_response_code(400);
        echo json_encode(["error" => "ID no proporcionado o inválido"]);
    }
}
?>