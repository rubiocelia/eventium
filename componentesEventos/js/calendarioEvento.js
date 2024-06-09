//Espera a que todo el contenido del documento esté completamente cargado
document.addEventListener("DOMContentLoaded", function() {
    const calendario = document.querySelector('.contenido-calendario');
    const items = calendario.querySelectorAll('.item-calendario');

    //comprueba si hay mas de 3 elementos en el calendario
    if (items.length > 3) {
        //si hay más de 3 elementos, habilita el desplazamiento vertical en el contenedor del calendario
        calendario.style.overflowY = 'scroll';
    }
});
