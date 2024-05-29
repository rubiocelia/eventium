document.addEventListener("DOMContentLoaded", function() {
  const formulario = document.querySelector(".FormularioRegistro");

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

      // Variables para los campos del formulario
      const nombre_usuario = formulario.querySelector("[name='nombre_usuario']");
      const apellidos_usuario = formulario.querySelector("[name='apellidos_usuario']");
      const mail_usuario = formulario.querySelector("[name='mail_usuario']");
      const telefono_usuario = formulario.querySelector("[name='telefono_usuario']");
      const contrasena = formulario.querySelector("[name='contrasena']");
      const username = formulario.querySelector("[name='username']");

      // Expresiones regulares para validar el correo electrónico y la contraseña
      const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const regexContrasena = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

      // Eliminar errores existentes
      eliminarErrores();

      // Validar Nombre
      if (nombre_usuario.value.trim() === "") {
          mostrarError(nombre_usuario, "El campo nombre es obligatorio.");
      }

      // Validar Apellidos
      if (apellidos_usuario.value.trim() === "") {
          mostrarError(apellidos_usuario, "El campo apellidos es obligatorio.");
      }

      // Validar Correo electrónico
      if (!regexCorreo.test(mail_usuario.value)) {
          mostrarError(mail_usuario, "Introduzca un correo electrónico válido.");
      }

      // Validar Teléfono
      if (telefono_usuario.value.trim() === "") {
          mostrarError(telefono_usuario, "El campo teléfono es obligatorio.");
      }

      // Validar Contraseña
      if (!regexContrasena.test(contrasena.value)) {
          mostrarError(contrasena, "La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.");
      }

      // Si no hay campos con errores, enviar el formulario
      const camposConError = formulario.querySelectorAll(".error");
      if (camposConError.length === 0) {
          formulario.submit();
      }
  });
});
