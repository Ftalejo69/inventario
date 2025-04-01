<?php
session_start();
if ($_SESSION["rol"] != "Comprador") {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprador Dashboard</title>
</head>
<body>
    <h1>Bienvenido, Comprador</h1>
    <!-- Buyer content here -->
</body>
</html>
