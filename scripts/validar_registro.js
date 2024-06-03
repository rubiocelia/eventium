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

      // Eliminar errores existentes
      eliminarErrores();

      // Validaciones de los campos
      let error = false;
      const nombre_usuario = formulario.querySelector("[name='nombre_usuario']");
      const apellidos_usuario = formulario.querySelector("[name='apellidos_usuario']");
      const mail_usuario = formulario.querySelector("[name='mail_usuario']");
      const telefono_usuario = formulario.querySelector("[name='telefono_usuario']");
      const contrasena = formulario.querySelector("[name='contrasena']");
      const username = formulario.querySelector("[name='username']");
      const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const regexContrasena = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

      if (nombre_usuario.value.trim() === "") {
          mostrarError(nombre_usuario, "El campo nombre es obligatorio.");
          error = true;
      }
      if (apellidos_usuario.value.trim() === "") {
          mostrarError(apellidos_usuario, "El campo apellidos es obligatorio.");
          error = true;
      }
      if (!regexCorreo.test(mail_usuario.value)) {
          mostrarError(mail_usuario, "Introduzca un correo electrónico válido.");
          error = true;
      }
      if (telefono_usuario.value.trim() === "") {
          mostrarError(telefono_usuario, "El campo teléfono es obligatorio.");
          error = true;
      }
      if (!regexContrasena.test(contrasena.value)) {
          mostrarError(contrasena, "La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.");
          error = true;
      }

      // Verificación con la base de datos solo si no hay errores iniciales
      if (!error) {
          var datos = new FormData(formulario);

          fetch("validar_duplicados.php", {
            method: "POST",
            body: datos
          })
          .then((response) => response.json())
          .then((data) => {
              if (data.telefono_usuario) {
                mostrarError(telefono_usuario, "Este teléfono ya está registrado.");
                error = true;
              }
              if (data.mail_usuario) {
                mostrarError(mail_usuario, "Este correo electrónico ya está registrado.");
                error = true;
              }
              if (data.username) {
                mostrarError(username, "Este nombre de usuario ya está registrado.");
                error = true;
              }

              // Envía el formulario solo si no hay errores después de todas las validaciones
              if (!error) {
                formulario.submit();
              }
          })
          .catch((error) => {
              console.error('Error al procesar la solicitud: ', error);
          });
      }
  });
});
