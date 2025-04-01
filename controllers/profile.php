<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conexion = new mysqli("localhost", "root", "", "supermercado");

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "No has iniciado sesión"]);
    exit();
}

$user_id = $_SESSION["user_id"];

// Si la solicitud es POST, actualiza los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $direccion = htmlspecialchars($_POST["direccion"], ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars($_POST["telefono"], ENT_QUOTES, 'UTF-8');

    $sql = "UPDATE usuarios SET email = ?, direccion = ?, telefono = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $email, $direccion, $telefono, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error al actualizar los datos"]);
    }

    $stmt->close();
    $conexion->close();
    exit();
}

// Si la solicitud es GET, obtiene los datos del usuario
$sql = "SELECT nombre, email, direccion, telefono FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nombre, $email, $direccion, $telefono);
$stmt->fetch();
$stmt->close();
$conexion->close();

if (!$nombre) {
    echo json_encode(["error" => "Usuario no encontrado"]);
    exit();
}

// Enviar los datos en formato JSON
echo json_encode([
    "nombre" => $nombre,
    "email" => $email,
    "direccion" => $direccion,
    "telefono" => $telefono
]);
?>
