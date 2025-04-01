let carrito = [];
let carritoCount = document.getElementById("carrito-count");

function agregarAlCarrito(id) {
    carrito.push(id);
    carritoCount.textContent = carrito.length;
    mostrarCarrito();
}

function mostrarCarrito() {
    let carritoModal = document.getElementById("carrito-modal");
    let productosCarrito = document.getElementById("productos-carrito");
    productosCarrito.innerHTML = ''; // Limpiar lista actual

    carrito.forEach((id, index) => {
        let li = document.createElement("li");
        li.textContent = `Producto ${id}`;
        let eliminarBtn = document.createElement("button");
        eliminarBtn.textContent = "Eliminar";
        eliminarBtn.onclick = () => eliminarDelCarrito(index);
        li.appendChild(eliminarBtn);
        productosCarrito.appendChild(li);
    });

    carritoModal.style.display = "flex";
}

function eliminarDelCarrito(index) {
    carrito.splice(index, 1);
    carritoCount.textContent = carrito.length;
    mostrarCarrito();
}

function vaciarCarrito() {
    carrito = [];
    carritoCount.textContent = 0;
    mostrarCarrito();
}

function cerrarCarrito() {
    let carritoModal = document.getElementById("carrito-modal");
    carritoModal.style.display = "none";
}

document.getElementById("ver-perfil").addEventListener("click", function () {
    fetch("../controllers/profile.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                const modalPerfil = document.getElementById("perfil");
                modalPerfil.innerHTML = `
                    <div class="modal-contenido">
                        <span class="close" onclick="cerrarPerfil()">&times;</span>
                        <h2>Mi Perfil</h2>
                        <form id="perfil-form">
                            <label><strong>Nombre:</strong></label>
                            <input type="text" id="nombre" value="${data.nombre}" disabled><br>
                            
                            <label><strong>Email:</strong></label>
                            <input type="email" id="email" value="${data.email}"><br>
                            
                            <label><strong>Dirección:</strong></label>
                            <input type="text" id="direccion" value="${data.direccion}"><br>
                            
                            <label><strong>Teléfono:</strong></label>
                            <input type="text" id="telefono" value="${data.telefono}"><br>

                            <button type="button" onclick="guardarPerfil()">Guardar Cambios</button>
                            <button type="button" onclick="cerrarPerfil()">Cerrar</button>
                        </form>
                    </div>
                `;
                modalPerfil.style.display = "flex";
            }
        })
        .catch(error => console.error("Error al obtener el perfil:", error));
});

function cerrarPerfil() {
    document.getElementById("perfil").style.display = "none";
}

function guardarPerfil() {
    const email = document.getElementById("email").value;
    const direccion = document.getElementById("direccion").value;
    const telefono = document.getElementById("telefono").value;

    fetch("../controllers/profile.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `email=${email}&direccion=${direccion}&telefono=${telefono}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Datos actualizados correctamente.");
            cerrarPerfil();
        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(error => console.error("Error al actualizar perfil:", error));
}
