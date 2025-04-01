<?php
session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "Administrador") {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Bienvenido, Administrador</h1>
    <!-- Admin content here -->
</body>
</html>
