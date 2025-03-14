function cargarProductos() {
    const action = "cargarProductos";
    fetch('/Boostrap/php/productos', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action }) 
    })
    .then(response => response.json()) 
    .then(data => {
        let tbody = document.getElementById('ListaProductos'); 
        tbody.innerHTML = ''; 
        data.forEach(producto => {
            let tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${producto.ID_Producto}</td>
                <td><img src="${producto.imagen}" width="50" height="50"></td>
                <td>${producto.Nombre}</td>
                <td>${producto.Descripcion}</td>
                <td>${producto.Precio}</td>
                <td>${producto.Stock}</td>
                <td>${producto.Categoria}</td>
                <td>${producto.Proveededor}</td>
                <td>
                    <button class="btn btn-warning" onclick="abrirModalEditar(${producto.ID_Producto})">Editar</button>
                    <button class="btn btn-danger" onclick="eliminarProducto(${producto.ID_Producto})">Eliminar</button>
                </td>
            `;
            tbody.appendChild(tr); 
        });
    })
    .catch(error => {
        console.error('Error al cargar los productos:', error);
    });
}

