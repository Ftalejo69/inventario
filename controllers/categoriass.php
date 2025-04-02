<?php
include __DIR__ . "/../conexion.php"; // Cambiado para usar una ruta relativa más robusta

$metodo = $_SERVER["REQUEST_METHOD"];
file_put_contents("debug.txt", print_r($_POST, true));

if ($metodo == "POST") { // Crear nueva categoría o Editar
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;
    $nombre = $conexion->real_escape_string(trim($_POST["nombre"]));
    $descripcion = $conexion->real_escape_string(trim($_POST["descripcion"]));
    $correo = filter_var($_POST["correo"], FILTER_VALIDATE_EMAIL) ? $_POST["correo"] : "";
    $tipo = $conexion->real_escape_string(trim($_POST["tipo"]));

    // Procesar imagen si se subió
    $imagenRuta = "";
    if (!empty($_FILES["imagen"]["name"])) {
        $directorio = "uploads/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $imagenNombre = time() . "_" . basename($_FILES["imagen"]["name"]);
        $imagenRuta = $directorio . $imagenNombre;
        
        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagenRuta)) {
            $imagenRuta = ""; // Si falla la subida, dejar vacío
        }
    }

    if ($id) {
        // Actualizar categoría existente
        $sql = "UPDATE categorias SET nombre='$nombre', descripcion='$descripcion', correo='$correo', tipo='$tipo'";
        if ($imagenRuta !== "") {
            $sql .= ", imagen='$imagenRuta'";
        }
        $sql .= " WHERE id=$id";
    } else {
        // Insertar nueva categoría
        $sql = "INSERT INTO categorias (nombre, descripcion, correo, tipo, imagen) 
                VALUES ('$nombre', '$descripcion', '$correo', '$tipo', '$imagenRuta')";
    }

    if ($conexion->query($sql) === TRUE) {
        echo json_encode(["mensaje" => $id ? "Categoría actualizada" : "Categoría agregada con éxito"]);
    } else {
        echo json_encode(["error" => $conexion->error]);
    }
}

// Obtener todas las categorías (GET)
if ($metodo == "GET") {
    $sql = "SELECT * FROM categorias";
    $result = $conexion->query($sql);

    $categorias = [];
    while ($fila = $result->fetch_assoc()) {
        $categorias[] = $fila;
    }

    echo json_encode($categorias);
}

// Eliminar categoría (DELETE)
if ($metodo == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];
    file_put_contents("debug.txt", "ID a eliminar: " . $id . "\n", FILE_APPEND);

    // Obtener la imagen antes de eliminar
    $sql = "SELECT imagen FROM categorias WHERE id=$id";
    $result = $conexion->query($sql);
    $fila = $result->fetch_assoc();
    
    if (!empty($fila["imagen"]) && file_exists($fila["imagen"])) {
        unlink($fila["imagen"]); // Eliminar la imagen del servidor
    }

    $sql = "DELETE FROM categorias WHERE id=$id";
    if ($conexion->query($sql) === TRUE) {
        echo json_encode(["mensaje" => "Categoría eliminada"]);
    } else {
        echo json_encode(["error" => $conexion->error]);
    }
}

$conexion->close();
?>

