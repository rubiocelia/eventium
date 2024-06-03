document.addEventListener("DOMContentLoaded", function() {
    const calendario = document.querySelector('.contenido-calendario');
    const items = calendario.querySelectorAll('.item-calendario');

    if (items.length > 3) {
        calendario.style.overflowY = 'scroll';
    }
});
