document.addEventListener("DOMContentLoaded", function () {
  const btnModificar = document.getElementById("btnModificar");
  const btnGuardar = document.getElementById("btnGuardar");
  const btnCancelar = document.getElementById("btnCancelar");
  const btnSeleccionarFoto = document.getElementById("btnSeleccionarFoto");
  const fotoInput = document.getElementById("foto");
  const inputs = document.querySelectorAll(".perfil input, .perfil #foto");
  const fotoPerfil = document.querySelector(".fotoPerfil");
  const fotoOriginal = fotoPerfil.src; // Guarda el src original de la imagen al cargar la página

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

    btnGuardar.style.display = "none";
    btnModificar.style.display = "inline-block";
    btnCancelar.style.display = "none";
    btnSeleccionarFoto.style.display = "none";
  });

  btnGuardar.addEventListener("click", function (event) {
    event.preventDefault();

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
