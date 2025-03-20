<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "supermercado"); // Cambiar el nombre de la base de datos si es necesario

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $rol = $_POST["rol"];

    // Buscar usuario en la base de datos
    $sql = "SELECT id, contrasena, rol FROM usuarios WHERE email = ? AND rol = ?"; // Asegúrate de que el nombre de la columna de la contraseña sea correcto
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
                header("Location: main.html");
            } elseif ($rol == 'Vendedor') {
                header("Location: main_vendedor.html");
            } else {
                header("Location: main_comprador.html");
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
