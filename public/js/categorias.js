document.addEventListener("DOMContentLoaded", () => {
    cargarCategorias();

    document.getElementById("formCategoria").addEventListener("submit", (e) => {
        e.preventDefault();
        guardarCategoria();
    });

    document.getElementById("cancelarEdicion").addEventListener("click", () => {
        resetFormulario();
    });
});

// Cargar categorías
function cargarCategorias() {
    fetch("obtener_categorias.php")
        .then(response => response.json())
        .then(data => {
            const contenedor = document.getElementById("contenedorCategorias");
            contenedor.innerHTML = "";
            data.forEach(c => crearTarjeta(c));
        })
        .catch(error => console.error("Error al cargar categorías:", error));
}

// Crear tarjeta de categoría
function crearTarjeta(categoria) {
    const tarjeta = document.createElement("div");
    tarjeta.className = "tarjeta";
    tarjeta.innerHTML = `
        ${categoria.imagen ? `<img src="${categoria.imagen}" class="categoria-img">` : ""}
        <h3>${categoria.nombre}</h3>
        <p>${categoria.descripcion}</p>
        <p><strong>Correo:</strong> ${categoria.correo}</p>
        <p><strong>Tipo:</strong> ${categoria.tipo}</p>
        <div class="botones">
            <button class="boton-editar" onclick="editarCategoria(${categoria.id}, '${categoria.nombre}', '${categoria.descripcion}', '${categoria.correo}', '${categoria.tipo}')">Editar</button>
            <button class="boton-eliminar" onclick="eliminarCategoria(${categoria.id})">Eliminar</button>
        </div>
    `;
    document.getElementById("contenedorCategorias").appendChild(tarjeta);
}

// Editar categoría
function editarCategoria(id, nombre, descripcion, correo, tipo) {
    document.getElementById("categoriaId").value = id;
    document.getElementById("nombre").value = nombre;
    document.getElementById("descripcion").value = descripcion;
    document.getElementById("correo").value = correo;
    document.getElementById("tipo").value = tipo;
}

// Guardar categoría (Crear o Editar)
function guardarCategoria() {
    let id = document.getElementById("categoriaId").value;
    let formData = new FormData(document.getElementById("formCategoria"));
    
    if (id) {
        formData.append("id", id); // Asegurar que el ID se envía correctamente
    }

    fetch("categoriass.php", {
        method: "POST", // Siempre usar POST para que PHP lo reciba bien
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta del servidor:", data);
        resetFormulario();
        cargarCategorias();
    })
    .catch(error => console.error("Error al guardar categoría:", error));
}

// Eliminar categoría
function eliminarCategoria(id) {
    console.log("Eliminando categoría con ID:", id);
    fetch("categoriass.php", { 
        method: "DELETE", 
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id }) 
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta del servidor:", data);
        cargarCategorias();
    })
    .catch(error => console.error("Error al eliminar categoría:", error));
}

// Resetear formulario
function resetFormulario() {
    document.getElementById("formCategoria").reset();
    document.getElementById("categoriaId").value = "";
}
