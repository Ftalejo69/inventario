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
    fetch("categoriass.php")
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
        <h3>${categoria.nombre}</h3>
        <p>${categoria.descripcion}</p>
        <p><strong>Correo:</strong> ${categoria.correo}</p>
        <p><strong>Tipo:</strong> ${categoria.tipo}</p>
        <button class="btn-editar" onclick="editarCategoria(${categoria.id}, '${categoria.nombre}', '${categoria.descripcion}', '${categoria.correo}', '${categoria.tipo}')">Editar</button>
        <button class="btn-eliminar" onclick="eliminarCategoria(${categoria.id})">Eliminar</button>
    `;
    document.getElementById("contenedorCategorias").appendChild(tarjeta);
}

// Guardar (insertar o actualizar) una categoría
function guardarCategoria() {
    const id = document.getElementById("categoriaId").value;
    const nombre = document.getElementById("nombreCategoria").value;
    const descripcion = document.getElementById("descripcionCategoria").value;
    const correo = document.getElementById("correoCategoria").value;
    const tipo = document.getElementById("tipoCategoria").value;

    const metodo = id ? "PUT" : "POST";
    const datos = { id, nombre, descripcion, correo, tipo };

    fetch("categoriass.php", {
        method: metodo,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(() => {
        resetFormulario();
        cargarCategorias();
    });
}

// Editar categoría
function editarCategoria(id, nombre, descripcion, correo, tipo) {
    document.getElementById("categoriaId").value = id;
    document.getElementById("nombreCategoria").value = nombre;
    document.getElementById("descripcionCategoria").value = descripcion;
    document.getElementById("correoCategoria").value = correo;
    document.getElementById("tipoCategoria").value = tipo;
}

// Eliminar categoría
function eliminarCategoria(id) {
    fetch("categoriass.php", { method: "DELETE", body: JSON.stringify({ id }) })
        .then(() => cargarCategorias());
}

// Resetear formulario
function resetFormulario() {
    document.getElementById("formCategoria").reset();
    document.getElementById("categoriaId").value = "";
}
