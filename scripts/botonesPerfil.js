document.addEventListener("DOMContentLoaded", function () {
  const btnModificar = document.getElementById("btnModificar");
  const btnGuardar = document.getElementById("btnGuardar");
  const btnCancelar = document.getElementById("btnCancelar");
  const btnSeleccionarFoto = document.getElementById("btnSeleccionarFoto");
  const fotoInput = document.getElementById("foto");
  const inputs = document.querySelectorAll(".perfil input, .perfil #foto");
  const fotoPerfil = document.querySelector(".fotoPerfil");
  const fotoOriginal = fotoPerfil.src; // Guarda el src original de la imagen al cargar la página
  const errorGeneral = document.getElementById("errorGeneral");

  btnModificar.addEventListener("click", function () {
    inputs.forEach((input) => {
      if (input.type !== "file") input.readOnly = false;
      input.disabled = false;
    });

    btnGuardar.style.display = "inline-block";
    btnCancelar.style.display = "inline-block";
    btnModificar.style.display = "none";
    btnSeleccionarFoto.style.display = "inline-block";
  });

  btnSeleccionarFoto.addEventListener("click", function () {
    fotoInput.click();
  });

  fotoInput.addEventListener("change", function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        fotoPerfil.src = e.target.result;
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

  btnCancelar.addEventListener("click", function () {
    inputs.forEach((input) => {
      input.readOnly = true;
      input.disabled = input.type === "file";
    });

    document.getElementById("perfilForm").reset();
    fotoPerfil.src = fotoOriginal;
    errorGeneral.style.display = "none"; // Ocultar mensajes de error al cancelar

    btnGuardar.style.display = "none";
    btnModificar.style.display = "inline-block";
    btnCancelar.style.display = "none";
    btnSeleccionarFoto.style.display = "none";
  });

  btnGuardar.addEventListener("click", function (event) {
    event.preventDefault();

    let valid = true;
    let errorMessage = "";

    const nombre = document.getElementById("nombre").value.trim();
    const apellidos = document.getElementById("apellidos").value.trim();
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const fechaNacimiento = document
      .getElementById("fechaNacimiento")
      .value.trim();

    const nombreValido = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombre);
    const apellidosValido = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(apellidos);
    const emailValido = /^\S+@\S+\.\S+$/.test(email);
    const telefonoValido = /^\d{9}$/.test(telefono);
    const fechaNacimientoValida = new Date(fechaNacimiento) < new Date();

    if (!nombre || !nombreValido) {
      valid = false;
      errorMessage += "El nombre no puede estar vacío ni contener números. ";
    }
    if (!apellidos || !apellidosValido) {
      valid = false;
      errorMessage +=
        "Los apellidos no pueden estar vacíos ni contener números. ";
    }
    if (!username) {
      valid = false;
      errorMessage += "El nombre de usuario no puede estar vacío. ";
    }
    if (!email || !emailValido) {
      valid = false;
      errorMessage += "El correo electrónico no es válido. ";
    }
    if (!telefono || !telefonoValido) {
      valid = false;
      errorMessage +=
        "El número de teléfono debe tener 9 dígitos y no puede contener letras. ";
    }
    if (!fechaNacimiento || !fechaNacimientoValida) {
      valid = false;
      errorMessage += "La fecha de nacimiento debe ser anterior a hoy. ";
    }

    if (!valid) {
      errorGeneral.textContent = errorMessage;
      errorGeneral.style.display = "block";
      return;
    }

    const formData = new FormData(document.getElementById("perfilForm"));

    fetch("guardar_perfil.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        console.log("Success:", data);
        if (data.success) {
          inputs.forEach((input) => {
            input.readOnly = true;
            input.disabled = input.type === "file";
          });

          errorGeneral.style.display = "none"; // Ocultar mensajes de error en caso de éxito
          btnGuardar.style.display = "none";
          btnModificar.style.display = "inline-block";
          btnCancelar.style.display = "none";
          btnSeleccionarFoto.style.display = "none";
        } else {
          alert(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert(
          "Hubo un error al guardar los cambios. Por favor, intenta nuevamente."
        );
      });
  });
});
