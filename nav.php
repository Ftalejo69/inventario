

<link rel="stylesheet" href="menus.css">
<nav>
      <ul>
          <li class="submenu">
              <a href="#">Productos</a>
              <ul class="submenu-items">
                  <li><a href="#" onclick="abrirModal('modal-crear-producto')">Crear Producto</a></li>
                  <li><a href="#" onclick="abrirModal('modal-editar-producto')">Editar/Eliminar Producto</a></li>
              </ul>
          </li>
          <li class="submenu">
              <a href="proveedores.html">Proveedor</a>
              <ul class="submenu-items">
                  <li><a href="#" onclick="abrirModal('modal-crear-proveedor')">Crear Proveedor</a></li>
                  <li><a href="#" onclick="abrirModal('modal-editar-proveedor')">Editar/Eliminar Proveedor</a></li>
              </ul>
          </li>
          <li class="submenu">
              <a href="categorias.html">Categoría</a>
              <ul class="submenu-items">
                  <li><a href="#" onclick="abrirModal('modal-crear-categoria')">Crear Categoría</a></li>
                  <li><a href="#" onclick="abrirModal('modal-editar-categoria')">Editar/Eliminar Categoría</a></li>
              </ul>
          </li>
          <li><a href="#" id="ver-perfil">Ver Perfil</a></li>
      </ul>
      <div id="carrito" onclick="mostrarCarrito()">
          <span id="carrito-count">0</span> Productos en el carrito
      </div>
  </nav>
 
  <script src="script.js" defer></script>