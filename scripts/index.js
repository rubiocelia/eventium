// Inicializar el mapa
var map = L.map("map").setView([40.416775, -3.70379], 6); // Coordenadas de España

// Añadir la capa de mapa de OpenStreetMap en español
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?lang=es", {
  attribution:
    'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  maxZoom: 19,
}).addTo(map);

// Marcadores de ejemplo
var events = [
  {
    name: "Evento 1",
    lat: 40.416775,
    lng: -3.70379,
    description: "Descripción del Evento 1",
  },
  {
    name: "Evento 2",
    lat: 41.385064,
    lng: 2.173404,
    description: "Descripción del Evento 2",
  },
  {
    name: "Evento 3",
    lat: 39.469907,
    lng: -0.376288,
    description: "Descripción del Evento 3",
  },
];

events.forEach(function (event) {
  L.marker([event.lat, event.lng])
    .addTo(map)
    .bindPopup("<b>" + event.name + "</b><br>" + event.description);
});

// lupita
document.addEventListener("DOMContentLoaded", function () {
  // Obtener elementos del DOM para la entrada de búsqueda y los resultados
  const searchInput = document.getElementById("searchQuery");
  const searchResults = document.getElementById("searchResults");

  // Agregar un evento al campo de búsqueda para detectar cambios en la entrada
  searchInput.addEventListener("input", function () {
    const query = searchInput.value.trim(); // Obtener el valor de búsqueda y eliminar espacios en blanco
    if (query.length > 0) {
      // Si hay una consulta válida, realizar una solicitud fetch
      fetch(`liveSearch.php?query=${encodeURIComponent(query)}`)
        .then((response) => response.json()) // Convertir la respuesta a JSON
        .then((data) => {
          searchResults.innerHTML = ""; // Limpiar resultados anteriores
          if (data.length > 0) {
            // Si hay resultados, crear una lista para mostrarlos
            const resultList = document.createElement("ul");
            data.forEach((event) => {
              const listItem = document.createElement("li"); // Crear un elemento de lista para cada resultado
              listItem.innerHTML = `<a href="infoEvento.php?evento=${event.id_evento}">${event.nombre_evento}</a>`; // Crear enlace para cada evento
              resultList.appendChild(listItem); // Agregar el elemento de lista a la lista de resultados
            });
            searchResults.appendChild(resultList); // Mostrar la lista de resultados
          } else {
            searchResults.innerHTML = "<p>No se encontraron resultados.</p>"; // Mostrar mensaje si no hay resultados
          }
        });
    } else {
      searchResults.innerHTML = ""; // Limpiar resultados si la consulta está vacía
    }
  });
});
