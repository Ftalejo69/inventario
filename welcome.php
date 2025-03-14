<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Sesión no iniciada. Redirigiendo a la página de login...";
    header("Refresh: 3; url=index.html");
    exit();
}

echo "¡Bienvenido, " . $_SESSION['user_name'] . "!";
?>
