<?php
session_start();
if ($_SESSION["rol"] != "Vendedor") {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vendedor Dashboard</title>
</head>
<body>
    <h1>Bienvenido, Vendedor</h1>
    <!-- Vendor content here -->
</body>
</html>
