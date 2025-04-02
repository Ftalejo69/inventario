document.addEventListener("DOMContentLoaded", () => {
    console.log("Archivo JS cargado correctamente.");
    cargarProveedores();
});

// Función para cargar proveedores desde la base de datos
async function cargarProveedores() {
    try {
        console.log("Intentando cargar proveedores...");
        const respuesta = await fetch("../controllers/proveedores.php"); // Verifica esta ruta
        if (!respuesta.ok) {
            throw new Error(`Error en la respuesta: ${respuesta.status}`);
        }
        const proveedores = await respuesta.json();
        console.log("Proveedores cargados:", proveedores);
        renderizarProveedores(proveedores);
    } catch (error) {
        console.error("Error cargando proveedores:", error);
        alert("No se pudieron cargar los proveedores. Revisa la consola para más detalles.");
    }
}

// Función para mostrar las tarjetas de proveedores
function renderizarProveedores(proveedores) {
    const contenedor = document.getElementById("contenedorProveedores");
    if (!contenedor) {
        console.error("No se encontró el contenedor con ID 'contenedorProveedores'. Verifica el HTML.");
        return;
    }

    contenedor.innerHTML = "";

    proveedores.forEach((p) => {
        const tarjeta = document.createElement("div");
        tarjeta.className = "tarjeta";
        tarjeta.innerHTML = `
            <h3><i class="fas fa-user-tie"></i> ${p.nombre}</h3>
            <p><i class="fas fa-envelope"></i> ${p.contacto}</p>
            <p><i class="fas fa-phone"></i> ${p.telefono}</p>
            <div class="botones">
                <button class="boton boton-editar" onclick="editarProveedor(${p.id})">Editar</button>
                <button class="boton boton-eliminar" onclick="eliminarProveedor(${p.id})">Eliminar</button>
            </div>
        `;
        contenedor.appendChild(tarjeta);
    });
}

// Función para agregar un proveedor
async function agregarProveedor() {
    const nombre = document.getElementById("nombre").value;
    const contacto = document.getElementById("contacto").value;
    const telefono = document.getElementById("telefono").value;

    if (!nombre || !contacto || !telefono) {
        alert("Por favor, completa todos los campos.");
        return;
    }

    try {
        console.log("Intentando agregar proveedor...");
        const respuesta = await fetch("../controllers/proveedores.php", { // Verifica esta ruta
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nombre, contacto, telefono })
        });
        if (!respuesta.ok) {
            throw new Error(`Error en la respuesta: ${respuesta.status}`);
        }
        console.log("Proveedor agregado correctamente.");
        document.getElementById("nombre").value = "";
        document.getElementById("contacto").value = "";
        document.getElementById("telefono").value = "";
        cargarProveedores();
    } catch (error) {
        console.error("Error agregando proveedor:", error);
        alert("No se pudo agregar el proveedor. Revisa la consola para más detalles.");
    }
}

// Función para editar un proveedor
async function editarProveedor(id) {
    const nuevoNombre = prompt("Editar nombre del proveedor:");
    if (nuevoNombre) {
        try {
            console.log(`Intentando editar proveedor con ID: ${id}`);
            const respuesta = await fetch("../controllers/proveedores.php", { // Verifica esta ruta
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id, nombre: nuevoNombre })
            });
            if (!respuesta.ok) {
                throw new Error(`Error en la respuesta: ${respuesta.status}`);
            }
            console.log("Proveedor editado correctamente.");
            cargarProveedores();
        } catch (error) {
            console.error("Error editando proveedor:", error);
            alert("No se pudo editar el proveedor. Revisa la consola para más detalles.");
        }
    }
}

// Función para eliminar un proveedor
async function eliminarProveedor(id) {
    if (confirm("¿Seguro que quieres eliminar este proveedor?")) {
        try {
            console.log(`Intentando eliminar proveedor con ID: ${id}`);
            const respuesta = await fetch("../controllers/proveedores.php", { // Verifica esta ruta
                method: "DELETE",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id })
            });
            if (!respuesta.ok) {
                const errorData = await respuesta.json();
                console.error("Error del servidor:", errorData);
                if (errorData.error.includes("foreign key constraint")) {
                    alert("No se puede eliminar este proveedor porque tiene productos asociados. Elimina los productos primero.");
                } else {
                    alert(errorData.error || "No se pudo eliminar el proveedor.");
                }
                return;
            }
            const resultado = await respuesta.json();
            console.log("Proveedor eliminado:", resultado);
            alert(resultado.mensaje || "Proveedor eliminado correctamente.");
            cargarProveedores();
        } catch (error) {
            console.error("Error eliminando proveedor:", error);
            alert("No se pudo eliminar el proveedor. Revisa la consola para más detalles.");
        }
    }
}