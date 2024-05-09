document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector("form");
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevenir el envío del formulario
  
        // Definición de variables y funciones
        var nombre_usuario = document.getElementById("nombre_usuario");
        var apellidos_usuario = document.getElementById("apellidos_usuario");
        var telefono_usuario = document.getElementById("telefono_usuario");
        var mail_usuario = document.getElementById("mail_usuario");
        var username = document.getElementById("username");
        var password_usuario = document.getElementById("password_usuario");
  
        function showModal(message) {
            document.getElementById('modal-message').innerText = message;
            document.getElementById('modal').style.display = 'block';
            document.getElementById('modal-backdrop').style.display = 'block';
        }
  
        // Añade un evento al botón de cerrar del modal
        document.querySelector('.modal-close').addEventListener('click', function() {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('modal-backdrop').style.display = 'none';
        });
  
        // Coloca aquí la validación modificada, utilizando showModal para mostrar errores
        // Ejemplo:
        if (!nombre_usuario.value.trim()) {
            showModal("Por favor, ingrese su nombre.");
            nombre.focus();
            return;
        } else if (/[^a-zA-Z áéíóúÁÉÍÓÚñÑ]/.test(nombre_usuario.value)) {
        // Añadiendo la comprobación de que no contenga números
        showModal("El nombre no debe contener números.");
        nombre_usuario.focus();
        event.preventDefault();
        return;
      }
      
      // Validación de apellidos
      if (!apellidos_usuario.value.trim()) {
        showModal("Por favor, ingrese sus apellidos.");
        apellidos_usuario.focus();
        event.preventDefault();
        return;
      } else if (/[^a-zA-Z áéíóúÁÉÍÓÚñÑ]/.test(apellidos_usuario.value)) {
        // Añadiendo la comprobación de que no contenga números
        showModal("Los apellidos no deben contener números.");
        apellidos_usuario.focus();
        event.preventDefault();
        return;
      }
  
      // Validación del número de teléfono
      var patronTelefono = /^[0-9]{9}$/;
      if (!patronTelefono.test(telefono_usuario.value)) {
        showModal("Ingrese un número de teléfono válido (9 dígitos).");
        telefono_usuario.focus();
        event.preventDefault();
        return;
      }
  
      // Validación del correo electrónico
      var patronCorreo = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      if (!patronCorreo.test(mail_usuario.value)) {
        showModal("Ingrese un correo electrónico válido.");
        mail_usuario.focus();
        event.preventDefault();
        return;
      }
  
      // Validación del nombre de usuario
      var patronUsuario = /^[a-zA-Z0-9_]+$/; // Letras, números y guiones bajos
      if (username.value.trim() === "" || !patronUsuario.test(username.value)) {
        showModal(
          "Ingrese un nombre de usuario válido (solo letras, números y guiones bajos)."
        );
        username.focus();
        event.preventDefault();
        return;
      }
  
      // Validación de la contraseña
      // La contraseña debe tener al menos 8 caracteres, al menos una letra y un número
      var patronContrasena = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
      if (!patronContrasena.test(password_usuario.value)) {
        showModal(
          "La contraseña debe tener al menos 8 caracteres, incluyendo letras y números."
        );
        password_usuario.focus();
        event.preventDefault();
        return;
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
          showModal(
            "Este teléfono ya está registrado, por favor introduzca otro número de teléfono válido."
          );
          error = true;
        }
        if (data.mail_usuario) {
          showModal(
            "Este correo electrónico ya está registrado, por favor introduzca otro correo válido."
          );
          error = true;
        }
        if (data.username) {
          showModal(
            "Este nombre de usuario ya está registrado, por favor introduzca otro nombre de usuario."
          );
          error = true;
        }

        if (!error) {
          form.submit(); // Envía el formulario si no hay errores
        }
        //En que caso de que la consulta fetch falle saldra un error mediante un showModal
      })
      .catch((error) => {
        console.error("Error:", error);
        showModal("Error al verificar los datos.");
      });
  });
});
