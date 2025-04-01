document.addEventListener("DOMContentLoaded", function () {
    // Mostrar perfil
    document.getElementById("ver-perfil").addEventListener("click", function () {
        fetch("profile.php")
            .then(response => response.json())
            .then(data => {
                document.querySelector("#perfil .modal-contenido").innerHTML = `
                    <h2>Mi Perfil</h2>
                    <p>Nombre: ${data.nombre}</p>
                    <p>Email: <input type="email" id="perfil-email" value="${data.email}"></p>
                    <p>Dirección: <input type="text" id="perfil-direccion" value="${data.direccion}"></p>
                    <p>Teléfono: <input type="text" id="perfil-telefono" value="${data.telefono}"></p>
                    <button id="modificar-perfil">Modificar</button>
                    <button class="cerrar-modal">Cerrar</button>
                `;
                document.getElementById("perfil").style.display = "flex";

                // Evento para cerrar modal de perfil
                document.querySelector("#perfil .cerrar-modal").addEventListener("click", function () {
                    cerrarModal("perfil");
                });

                // Evento para modificar los datos del perfil
                document.getElementById("modificar-perfil").addEventListener("click", function () {
                    const email = document.getElementById("perfil-email").value;
                    const direccion = document.getElementById("perfil-direccion").value;
                    const telefono = document.getElementById("perfil-telefono").value;

                    fetch("profile.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `email=${email}&direccion=${direccion}&telefono=${telefono}`
                    })
                     .then(response => response.json())
                    .then(data => {
                        alert(data.success ? "Datos actualizados correctamente" : "Error al actualizar los datos");
                        cerrarModal("perfil");
                    });
                });
            });
    });

    // Funciones de carrito
    window.mostrarCarrito = function () {
        document.getElementById("carrito-modal").style.display = "flex";
    };

    window.cerrarCarrito = function () {
        document.getElementById("carrito-modal").style.display = "none";
    };

    window.vaciarCarrito = function () {
        document.getElementById("productos-carrito").innerHTML = "";
    };

    window.agregarAlCarrito = function (productId) {
        console.log(`Producto con ID ${productId} agregado al carrito.`);
    };

    // Abrir los modales al hacer clic en los submenús
    document.querySelectorAll("[data-modal]").forEach(boton => {
        boton.addEventListener("click", function (event) {
            event.preventDefault();
            abrirModal(this.getAttribute("data-modal"));
        });
    });

    // Cerrar el modal al hacer clic en el botón "Cerrar"
    document.querySelectorAll(".cerrar-modal").forEach(boton => {
        boton.addEventListener("click", function () {
            cerrarModal(this.closest(".modal").id);
        });
    });

    // Cerrar el modal al hacer clic fuera del contenido
    window.addEventListener("click", function (event) {
        document.querySelectorAll(".modal").forEach(modal => {
            if (event.target === modal) {
                cerrarModal(modal.id);
            }
        });
    });

    // enviar formularios de creación a crear.php
    ["form-categoria", "form-producto", "form-proveedor"].forEach(id => {
        const form = document.getElementById(id);
        if (form) {
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                enviarFormulario(this);
            });
        }
    });
});

// Función para abrir un modal
function abrirModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = "flex";
    }
}

// Función para cerrar un modal
function cerrarModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = "none";
    }
}

// Función para enviar formularios con fetch
function enviarFormulario(form) {
    const formData = new FormData(form);
    fetch("crear.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.success || data.error);
        if (data.success) {
            cerrarModal(form.closest(".modal").id);
            form.reset();
        }
    })
    .catch(error => console.error("Error:", error));
}
function showLogin() {
    document.getElementById("login-form").style.display = "block";
    document.getElementById("register-form").style.display = "none";
}

function showRegister() {
    document.getElementById("login-form").style.display = "none";
    document.getElementById("register-form").style.display = "block";
}
