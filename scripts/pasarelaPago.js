document.addEventListener('DOMContentLoaded', function() {
    const contadorElemento = document.getElementById('contador');
    const decrementarBtn = document.getElementById('decrementar');
    const incrementarBtn = document.getElementById('incrementar');
    const maxEntradas = parseInt(contadorElemento.getAttribute('max'));
    const precioPorEntrada = parseFloat(document.getElementById('precioEvento').textContent);
  
    let contador = 1;

    function mostrarError(campo, mensaje) {
        const errorMensaje = document.createElement("div");
        errorMensaje.classList.add("errorMensaje");
        errorMensaje.style.color = 'red'; // Establecer el color rojo para el mensaje de error
        errorMensaje.textContent = mensaje;
        campo.parentNode.insertBefore(errorMensaje, campo.nextSibling);
        campo.classList.add("error");
    }

    function limpiarErrores() {
        const errores = document.querySelectorAll(".errorMensaje");
        errores.forEach(error => error.parentNode.removeChild(error));
        const camposError = document.querySelectorAll(".error");
        camposError.forEach(campo => campo.classList.remove("error"));
    }
  
    function actualizarContador() {
        limpiarErrores();
        contadorElemento.textContent = contador;
        if (contador >= maxEntradas) {
            incrementarBtn.disabled = true;
        } else {
            incrementarBtn.disabled = false;
        }

        if (contador === 1) {
            decrementarBtn.disabled = true;
        } else {
            decrementarBtn.disabled = false;
        }
  
        // Calcular y mostrar el total a pagar
        const totalPagar = contador * precioPorEntrada;
        document.getElementById('totalPagar').textContent = totalPagar.toFixed(2) + ' €';
    }
  
    decrementarBtn.addEventListener('mousedown', function() {
        if (contador > 1) {
            contador--;
            actualizarContador();
        }
    });
  
    incrementarBtn.addEventListener('mousedown', function() {
        if (contador < maxEntradas) {
            contador++;
            actualizarContador();
        }
    });
  
    // Actualizar el total a pagar al cargar la página
    actualizarContador();

    // Validar la tarjeta al hacer clic en el botón de pagar
    const btnPagar = document.getElementById('btnPagar');
    btnPagar.addEventListener('click', function() {
        limpiarErrores();
        const idEvento = document.getElementById('id_evento').value;
        const usuarioID = document.getElementById('usuario_id').value;
        const idCalendario = document.getElementById('id_calendario').value;
        const nombreTitular = document.getElementById('nombreTitular').value;
        const numeroTarjeta = document.getElementById('tarjeta').value;
        const fechaCaducidad = document.getElementById('caducidad').value;
        const cvv = document.getElementById('cvv').value;

        let hayErrores = false;

        if (nombreTitular.trim() === '') {
            mostrarError(document.getElementById('nombreTitular'), 'Por favor ingrese el nombre del titular de la tarjeta.');
            hayErrores = true;
        }

        if (numeroTarjeta.trim() === '' || !(/^\d{16}$/).test(numeroTarjeta)) {
            mostrarError(document.getElementById('tarjeta'), 'Por favor ingrese un número de tarjeta válido.');
            hayErrores = true;
        }

        if (fechaCaducidad.trim() === '') {
            mostrarError(document.getElementById('caducidad'), 'Por favor seleccione la fecha de caducidad de la tarjeta.');
            hayErrores = true;
        }

        if (cvv.trim() === '' || !(/^\d{3}$/).test(cvv)) {
            mostrarError(document.getElementById('cvv'), 'Por favor ingrese un CVV válido.');
            hayErrores = true;
        }

        if (hayErrores) {
            return;
        }

        // Hacer la solicitud AJAX para procesar la reserva
        fetch("procesarPago.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "idCalendario=" + encodeURIComponent(idCalendario) + "&idEvento=" + encodeURIComponent(idEvento) + "&idUsuario=" + encodeURIComponent(usuarioID) + "&numEntradas=" + encodeURIComponent(contador)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Pago exitoso!',
                    text: 'Gracias por tu compra.',
                    confirmButtonText: 'Cerrar',
                    didClose: () => {
                        window.location.href = "perfil.php"; // Redireccionar a perfil.php
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al procesar la reserva. Por favor, inténtalo de nuevo más tarde.'+data.message,
                    confirmButtonText: 'Cerrar'
                });
            }
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al procesar la reserva. Por favor, inténtalo de nuevo más tarde.',
                confirmButtonText: 'Cerrar'
            });
        });
    });
});
