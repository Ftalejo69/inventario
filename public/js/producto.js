document.addEventListener("DOMContentLoaded", function() {
    cargarCategoriasYProveedores();
    cargarProductos();

    document.getElementById("productoForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const nombre = this.nombre.value.trim();
        const descripcion = this.descripcion.value.trim();
        const precio = parseFloat(this.precio.value);
        const stock = parseInt(this.stock.value);

        if (!nombre || !descripcion || isNaN(precio) || isNaN(stock) || precio <= 0 || stock < 0) {
            alert("Por favor, completa todos los campos correctamente.");
            return;
        }
        
        let formData = new FormData(this);

        fetch("producto.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.success);
                this.reset();
                cargarProductos(); // Refrescar la tabla
            } else {
                alert("Error: " + result.error);
            }
        })
        .catch(error => console.error("Error al guardar producto: ", error));
    });
});

function cargarCategoriasYProveedores() {
    fetch("producto.php")
    .then(response => response.json())
    .then(data => {
        let categoriaSelect = document.getElementById("categoria");
        let proveedorSelect = document.getElementById("proveedor");

        categoriaSelect.innerHTML = '<option value="">Seleccionar Categoría</option>';
        proveedorSelect.innerHTML = '<option value="">Seleccionar Proveedor</option>';

        data.categorias.forEach(categoria => {
            let option = document.createElement("option");
            option.value = categoria.id;
            option.textContent = categoria.nombre;
            categoriaSelect.appendChild(option);
        });

        data.proveedores.forEach(proveedor => {
            let option = document.createElement("option");
            option.value = proveedor.id;
            option.textContent = proveedor.nombre;
            proveedorSelect.appendChild(option);
        });
    })
    .catch(error => console.error("Error al cargar datos: ", error));
}

function cargarProductos() {
    fetch("obtener_productos.php")
    .then(response => response.json())
    .then(productos => {
        let tabla = document.getElementById("productosTabla");
        tabla.innerHTML = ""; // Limpiar la tabla

        productos.forEach(producto => {
            let fila = document.createElement("tr");

            fila.innerHTML = `
                <td><img src="${producto.imagen}" class="img-preview"></td>
                <td>${producto.nombre}</td>
                <td>${producto.descripcion}</td>
                <td>$${producto.precio}</td>
                <td>${producto.stock}</td>
                <td>${producto.categoria}</td>
                <td>${producto.proveedor}</td>
                <td>
                    <button class="btn-edit" onclick="editarProducto(${producto.id})">Editar</button>
                    <button class="btn-delete" onclick="eliminarProducto(${producto.id})">Eliminar</button>
                </td>
            `;

            tabla.appendChild(fila);
        });
    });
}

function eliminarProducto(id) {
    if (confirm("¿Seguro que quieres eliminar este producto?")) {
        fetch(`eliminar_producto.php?id=${id}`, { method: "GET" })
        .then(response => response.json())
        .then(result => {
            alert(result.message);
            cargarProductos();
        });
    }
}

function editarProducto(id) {
    alert("Función de editar en desarrollo...");
}
