// Inicializar el mapa
var map = L.map("map").setView([40.416775, -3.70379], 6); // Vista inicial centrada en España

// Añadir el mapa base desde OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "© OpenStreetMap contributors",
}).addTo(map);

// Array de eventos con sus coordenadas y URL
var eventos = [
  {
    lat: 40.616331,
    lng: -0.127759,
    nombre: "Concierto en el Parque",
    url: "pagina_evento_1.html",
  }, // Alcañiz
  {
    lat: 37.884752,
    lng: -4.422075,
    nombre: "Explosión de Rock",
    url: "pagina_evento_2.html",
  }, // Córdoba
  {
    lat: 41.658633,
    lng: -1.661481,
    nombre: "Romeo y Julieta",
    url: "pagina_evento_3.html",
  }, // Zaragoza
  {
    lat: 40.418541,
    lng: -3.71204,
    nombre: "Jazz en el Parque",
    url: "pagina_evento_4.html",
  }, // Madrid
  {
    lat: 39.865351,
    lng: -3.703583,
    nombre: "Caliente Latino",
    url: "pagina_evento_5.html",
  }, // Toledo
  {
    lat: 41.655931,
    lng: -4.71135,
    nombre: "Noche de Risas",
    url: "pagina_evento_6.html",
  }, // Valladolid
  {
    lat: 43.369776,
    lng: -8.406365,
    nombre: "Sunset Rave",
    url: "pagina_evento_7.html",
  }, // A Coruña
  {
    lat: 41.658633,
    lng: -1.661481,
    nombre: "Sinfonía en Do Mayor",
    url: "pagina_evento_8.html",
  }, // Zaragoza
  {
    lat: 41.655931,
    lng: -4.71135,
    nombre: "Travesía Fantástica",
    url: "pagina_evento_9.html",
  }, // Valladolid
  {
    lat: 41.125609,
    lng: 1.28721,
    nombre: "Reggae Roots",
    url: "pagina_evento_10.html",
  }, // Tarragona
  {
    lat: 38.87824,
    lng: -6.94658,
    nombre: "Festival de Verano",
    url: "pagina_evento_11.html",
  }, // Mérida
  {
    lat: 37.890816,
    lng: -4.777896,
    nombre: "Exposición de Arte Moderno",
    url: "pagina_evento_12.html",
  }, // Córdoba
  {
    lat: 40.431968,
    lng: -3.704024,
    nombre: "Conferencia sobre Tecnología",
    url: "pagina_evento_13.html",
  }, // Madrid
  {
    lat: 43.361632,
    lng: -6.945239,
    nombre: "Noche de Magia",
    url: "pagina_evento_14.html",
  }, // Gijón
  {
    lat: 43.366477,
    lng: -4.772472,
    nombre: "Danza Contemporánea",
    url: "pagina_evento_15.html",
  }, // Torrelavega
  {
    lat: 43.366477,
    lng: -4.772472,
    nombre: "Cine al Aire Libre",
    url: "pagina_evento_16.html",
  }, // Torrelavega
  {
    lat: 40.418541,
    lng: -3.71204,
    nombre: "Feria de Libros",
    url: "pagina_evento_17.html",
  }, // Madrid
  {
    lat: 40.391425,
    lng: -4.021707,
    nombre: "Cena Romántica en el Lago",
    url: "pagina_evento_18.html",
  }, // Getafe
  {
    lat: 40.997559,
    lng: -1.646117,
    nombre: "Paseo en Globo al Atardecer",
    url: "pagina_evento_19.html",
  }, // Teruel
  {
    lat: 43.360868,
    lng: -8.411442,
    nombre: "Spa y Relajación para Parejas",
    url: "pagina_evento_20.html",
  }, // Isla de la Toja
];

// Añadir los marcadores en el mapa
eventos.forEach(function (evento) {
  var marker = L.marker([evento.lat, evento.lng])
    .addTo(map)
    .bindPopup(
      `<b>${evento.nombre}</b><br><a href="${evento.url}">Más información</a>`
    );
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
