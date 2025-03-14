<?php
$host = "localhost";
$user = "root";  // Cambia si es necesario
$pass = "";
$dbname = "supermercado";  // Asegúrate de que la base de datos existe

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Leer datos de la base de datos
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT * FROM categorias";
    $result = $conn->query($sql);
    
    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
    
    echo json_encode($categorias);
    exit();
}

// Insertar una nueva categoría
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data["nombre"], $data["descripcion"], $data["correo"], $data["tipo"])) {
        $nombre = $conn->real_escape_string($data["nombre"]);
        $descripcion = $conn->real_escape_string($data["descripcion"]);
        $correo = $conn->real_escape_string($data["correo"]);
        $tipo = $conn->real_escape_string($data["tipo"]);

        $sql = "INSERT INTO categorias (nombre, descripcion, correo, tipo) VALUES ('$nombre', '$descripcion', '$correo', '$tipo')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Categoría agregada"]);
        } else {
            echo json_encode(["error" => "Error al agregar: " . $conn->error]);
        }
    }
    exit();
}

// Actualizar una categoría
if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["id"], $data["nombre"], $data["descripcion"], $data["correo"], $data["tipo"])) {
        $id = (int)$data["id"];
        $nombre = $conn->real_escape_string($data["nombre"]);
        $descripcion = $conn->real_escape_string($data["descripcion"]);
        $correo = $conn->real_escape_string($data["correo"]);
        $tipo = $conn->real_escape_string($data["tipo"]);

        $sql = "UPDATE categorias SET nombre='$nombre', descripcion='$descripcion', correo='$correo', tipo='$tipo' WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Categoría actualizada"]);
        } else {
            echo json_encode(["error" => "Error al actualizar: " . $conn->error]);
        }
    }
    exit();
}

// Eliminar una categoría
if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data["id"])) {
        $id = (int)$data["id"];
        $sql = "DELETE FROM categorias WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Categoría eliminada"]);
        } else {
            echo json_encode(["error" => "Error al eliminar: " . $conn->error]);
        }
    }
    exit();
}

$conn->close();
?>
