document.addEventListener("DOMContentLoaded", function() {
    const formulario = document.querySelector(".FormularioLogin");
  
    formulario.addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe automáticamente
  
        // Función para mostrar un mensaje de error justo debajo del campo
        function mostrarError(campo, mensaje) {
            const errorMensaje = document.createElement("div");
            errorMensaje.classList.add("errorMensaje");
            errorMensaje.textContent = mensaje;
            campo.parentNode.insertBefore(errorMensaje, campo.nextSibling);
            campo.classList.add("error");
        }
  
        // Función para eliminar todos los mensajes de error
        function eliminarErrores() {
            const errores = formulario.querySelectorAll(".errorMensaje");
            errores.forEach(function(error) {
                error.parentNode.removeChild(error);
            });
  
            const camposConError = formulario.querySelectorAll(".error");
            camposConError.forEach(function(campo) {
                campo.classList.remove("error");
            });
        }

        // Eliminar errores existentes
        eliminarErrores();

        const username = formulario.querySelector("[name='usuario']");
        const contrasena = formulario.querySelector("[name='contrasena']");
        let error = false;

        // Validación del nombre de usuario y contraseña
        var patronUsuario = /^[a-zA-Z0-9_]+$/; // Letras, números y guiones bajos
        var patronContrasena = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        if (username.value.trim() === "") {
            mostrarError(username, "Rellene el campo de usuario por favor.");
            error = true;
        } else if (!patronUsuario.test(username.value)) {
            mostrarError(username, "Introduzca un usuario válido.");
            error = true;
        }

        if (contrasena.value.trim() === "") {
            mostrarError(contrasena, "Rellene el campo de contraseña por favor.");
            error = true;
        }

        // Si no hay errores, enviar el formulario
        if (!error) {
            formulario.submit();
        }
    });
});
