const etiquetaDias = document.querySelector(".days"),
fechaActual = document.querySelector(".current-date"),
iconoPrevSig = document.querySelectorAll(".icons span");

// obteniendo nueva fecha, año actual y mes actual
let fecha = new Date(),
añoActual = fecha.getFullYear(),
mesActual = fecha.getMonth();

// almacenando el nombre completo de todos los meses en un array
const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
              "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

const renderizarCalendario = () => {
    let primerDiaDelMes = new Date(añoActual, mesActual, 1).getDay(), // obteniendo el primer día del mes
    ultimaFechaDelMes = new Date(añoActual, mesActual + 1, 0).getDate(), // obteniendo la última fecha del mes
    ultimoDiaDelMes = new Date(añoActual, mesActual, ultimaFechaDelMes).getDay(), // obteniendo el último día del mes
    ultimaFechaDelMesPasado = new Date(añoActual, mesActual, 0).getDate(); // obteniendo la última fecha del mes anterior
    let etiquetasLi = "";

    for (let i = primerDiaDelMes; i > 0; i--) { // creando li de los últimos días del mes anterior
        etiquetasLi += `<li class="inactive">${ultimaFechaDelMesPasado - i +1 }</li>`;
    }

    for (let i = 1; i <= ultimaFechaDelMes; i++) { // creando li de todos los días del mes actual
        // añadiendo clase activa a li si el día, mes y año actuales coinciden
        let esHoy = i === fecha.getDate() && mesActual === new Date().getMonth() 
                     && añoActual === new Date().getFullYear() ? "active" : "";
        etiquetasLi += `<li class="${esHoy}">${i}</li>`;
    }

    for (let i = ultimoDiaDelMes; i < 6; i++) { // creando li de los primeros días del próximo mes
        etiquetasLi += `<li class="inactive">${i - ultimoDiaDelMes + 1}</li>`
    }
    fechaActual.innerText = `${meses[mesActual]} ${añoActual}`; // pasando el mes y año actual como texto de fechaActual
    etiquetaDias.innerHTML = etiquetasLi;
}
renderizarCalendario();

iconoPrevSig.forEach(icono => { // obteniendo íconos de anterior y siguiente
    icono.addEventListener("click", () => { // añadiendo evento de clic en ambos íconos
        // si el ícono clicado es el ícono anterior, decrementa el mes actual en 1, sino lo incrementa en 1
        mesActual = icono.id === "prev" ? mesActual - 1 : mesActual + 1;

        if(mesActual < 0 || mesActual > 11) { // si el mes actual es menor que 0 o mayor que 11
            // creando una nueva fecha del año y mes actuales y pasándola como valor de fecha
            fecha = new Date(añoActual, mesActual, new Date().getDate());
            añoActual = fecha.getFullYear(); // actualizando el año actual con el año de la nueva fecha
            mesActual = fecha.getMonth(); // actualizando el mes actual con el mes de la nueva fecha
        } else {
            fecha = new Date(); // pasar la fecha actual como valor de fecha
        }
        renderizarCalendario(); // llamando a la función renderizarCalendario
    });
});
