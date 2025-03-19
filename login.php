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
    $rol = $_POST["rol"];

    // Buscar usuario en la base de datos
    $sql = "SELECT id, password, rol FROM usuarios WHERE email = ? AND rol = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $email, $rol);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $rol);
        $stmt->fetch();

        // Verificar contraseña
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["rol"] = $rol;
            if ($rol == 'Administrador') {
                header("Location: admin_dashboard.php");
            } elseif ($rol == 'Vendedor') {
                header("Location: vendedor_dashboard.php");
            } else {
                header("Location: comprador_dashboard.php");
            }
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
