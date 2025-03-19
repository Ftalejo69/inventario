<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conexion = new mysqli("localhost", "root", "", "chimbadesupermercado");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $rol = $_POST["rol"];

    $sql = "INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $email, $password, $direccion, $telefono, $rol);

    if ($stmt->execute()) {
        echo "Registro exitoso. <a href='index.html'>Iniciar sesión</a>";
    } else {
        echo "Error en el registro: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>
