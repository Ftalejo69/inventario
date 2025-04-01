<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías</title>
    <link rel="stylesheet" href="estloszz.css">
  
</head>
<body>
<nav>
        <ul>
        <li><a href="main.html">inicio</a></li>
            <li><a href="productos.html">Productos</a></li>
            <li><a href="proveedores.html">Proveedores</a></li>
            <li><a href="categorias.php">Categorías</a></li>
        </ul>
    </nav>
    <header>
        <h1>Administrar Categorías</h1>
    </header>

    <div class="formulario">
        <h2>Agregar Categoría</h2>
        <form id="formCategoria" enctype="multipart/form-data">
            <input type="hidden" id="categoriaId">
            <input type="text" id="nombre" name="nombre" placeholder="Nombre de la categoría" required>
            <input type="text" id="descripcion" name="descripcion" placeholder="Descripción">
            <input type="email" id="correo" name="correo" placeholder="Correo de contacto">
            <input type="text" id="tipo" name="tipo" placeholder="Tipo">
            <input type="file" id="imagen" name="imagen" accept="image/*">
            <button type="submit">Guardar</button>
            <button type="button" id="cancelarEdicion">Cancelar</button>
        </form>
    </div>

    <div class="contenedor-tarjetas" id="contenedorCategorias"></div>
    <script src="categorias.js" defer></script>
</body>
</html>

