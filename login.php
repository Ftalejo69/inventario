<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "chimbadesupermercado");


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Buscar usuario en la base de datos
    $sql = "SELECT id, password FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verificar contraseña
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            header("Location: main.html");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "El correo no está registrado.";
    }

    $stmt->close();
}

$conexion->close();
?>
