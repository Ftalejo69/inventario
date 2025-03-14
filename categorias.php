<?php
include 'nav.php'; // Incluye el menú de navegación
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías</title>
    <link rel="stylesheet" href="estloszz.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <h1><i class="fas fa-tags"></i> Categorías de Productos</h1>
    </header>

    <!-- Formulario para agregar o editar categorías -->
    <div class="formulario">
        <h2 id="formTitulo">Añadir Nueva Categoría</h2>
        <form id="formCategoria">
            <input type="hidden" id="categoriaId"> <!-- Para edición -->
            <input type="text" id="nombreCategoria" placeholder="Nombre de la categoría" required />
            <input type="text" id="descripcionCategoria" placeholder="Descripción" required />
            <input type="email" id="correoCategoria" placeholder="Correo de contacto" required />
            <select id="tipoCategoria" required>
                <option value="">Selecciona un tipo</option>
                <option value="Alimentos">Alimentos</option>
                <option value="Electrónica">Electrónica</option>
                <option value="Ropa">Ropa</option>
            </select>
            <button type="submit">Guardar Categoría</button>
            <button type="button" id="cancelarEdicion" style="display:none;">Cancelar</button>
        </form>
    </div>

    <!-- Contenedor de tarjetas de categorías -->
    <div class="contenedor-tarjetas" id="contenedorCategorias"></div>

    <script src="categorias.js"></script>
</body>
</html>
