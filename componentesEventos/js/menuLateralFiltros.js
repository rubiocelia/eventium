var coll = document.getElementsByClassName("boton-colapsar");
var i;

//itera sobre todos los elementos seleccionados
for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        // Selecciona el siguiente elemento hermano (el contenido que se despliega/colapsa)
        var content = this.nextElementSibling;
        // Verifica si el contenido está visible
        if (content.style.display === "block") {
             // Si está visible, lo oculta
            content.style.display = "none";
        } else {
            // Si está oculto, lo muestra
            content.style.display = "block";
        }
    });
}