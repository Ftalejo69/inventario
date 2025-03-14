document.addEventListener("DOMContentLoaded", () => {
    cargarProveedores();
});

// Función para cargar proveedores desde la base de datos
async function cargarProveedores() {
    try {
        const respuesta = await fetch("proveedores.php");
        const proveedores = await respuesta.json();
        renderizarProveedores(proveedores);
    } catch (error) {
        console.error("Error cargando proveedores:", error);
    }
}

// Función para mostrar las tarjetas de proveedores
function renderizarProveedores(proveedores) {
    const contenedor = document.getElementById("contenedorProveedores");
    contenedor.innerHTML = "";

    proveedores.forEach((p) => {
        const tarjeta = document.createElement("div");
        tarjeta.className = "tarjeta";
        tarjeta.innerHTML = `
            <h3><i class="fas fa-user-tie"></i> ${p.nombre}</h3>
            <p><i class="fas fa-envelope"></i> ${p.contacto}</p>
            <p><i class="fas fa-phone"></i> ${p.telefono}</p>
            <div>
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
        await fetch("proveedores.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nombre, contacto, telefono })
        });
        document.getElementById("nombre").value = "";
        document.getElementById("contacto").value = "";
        document.getElementById("telefono").value = "";
        cargarProveedores();
    } catch (error) {
        console.error("Error agregando proveedor:", error);
    }
}

// Función para editar un proveedor
async function editarProveedor(id) {
    const nuevoNombre = prompt("Editar nombre del proveedor:");
    if (nuevoNombre) {
        try {
            await fetch("proveedores.php", {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id, nombre: nuevoNombre })
            });
            cargarProveedores();
        } catch (error) {
            console.error("Error editando proveedor:", error);
        }
    }
}

// Función para eliminar un proveedor
async function eliminarProveedor(id) {
    if (confirm("¿Seguro que quieres eliminar este proveedor?")) {
        try {
            await fetch("proveedores.php", {
                method: "DELETE",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id })
            });
            cargarProveedores();
        } catch (error) {
            console.error("Error eliminando proveedor:", error);
        }
    }
}
