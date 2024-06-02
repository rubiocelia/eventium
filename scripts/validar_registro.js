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

      //Validacion del usuario, mail y telefono para que no se repitan.
    // Verificación con la base de datos
    //Creamos la instancia "FormData" para complilar los valores y enviarlos mediante fetch.

    var datos = new FormData();

    //Añadimos al objeto "Formdata" los valores que no queremos que se repitan en la base de datos

    datos.append("telefono_usuario", telefono_usuario.value);
    datos.append("mail_usuario", mail_usuario.value);
    datos.append("username", username.value);

    //Utilizamos fetch para enviar la solicitud post al formulario y el archivo validar_duplicados.php
    //será el que manejará la solicitud

    fetch("validar_duplicados.php", {
      method: "POST",
      body: datos, // Usando FormData

      //Manejamos la respuesta del servidor una vez la solicitud este enviada, para que cuando
      //el servidor responda la respuesta sea recibida como un objeto response que a su vez es procesado
      //para convertirlo a formato json.
    })
      .then((response) => response.json())

      //Aqui verificamos que ninguno de los campos de telefono_usuario, mail_usuario y username
      //se pueda repetir y que en caso de que ya este en la base de datos salte un error mediante un showModal

      .then((data) => {
        var error = false;
        if (data.telefono_usuario) {
          mostrarError(
            telefono_usuario, "Este teléfono ya está registrado, por favor introduzca otro número de teléfono válido."
          );
          error = true;
        }
        if (data.mail_usuario) {
          mostrarError(
            mail_usuario, "Este correo electrónico ya está registrado, por favor introduzca otro correo válido."
          );
          error = true;
        }
        if (data.username) {
          mostrarError(
            username, "Este nombre de usuario ya está registrado, por favor introduzca otro nombre de usuario."
          );
          error = true;
        }

        if (!error) {
          form.submit(); // Envía el formulario si no hay errores
        }
        //En que caso de que la consulta fetch falle saldra un error mediante un showModal
      })

      // Si no hay campos con errores, enviar el formulario
      const camposConError = formulario.querySelectorAll(".error");
      if (camposConError.length === 0) {
          formulario.submit();
      }
  });
});
