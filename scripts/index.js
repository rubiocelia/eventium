// Inicializar el mapa
var map = L.map("map").setView([40.416775, -3.70379], 6); // Vista inicial centrada en España

// Añadir el mapa base desde OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "© OpenStreetMap contributors",
}).addTo(map);

// Array de eventos con sus coordenadas y URL
var eventos = [
  {
    lat: 40.390044,
    lng: -3.686416,
    nombre: "Concierto en el Parque",
    url: "infoEvento.php?evento=1",
  }, // Parque Enrique Tierno Galván, Madrid
  {
    lat: 37.88356,
    lng: -4.782478,
    nombre: "Explosión de Rock",
    url: "infoEvento.php?evento=2",
  }, // Teatro Góngora, Córdoba
  {
    lat: 41.65186,
    lng: -0.881896,
    nombre: "Romeo y Julieta",
    url: "infoEvento.php?evento=3",
  }, // Teatro Principal, Zaragoza
  {
    lat: 40.415262,
    lng: -3.686041,
    nombre: "Jazz en el Parque",
    url: "infoEvento.php?evento=4",
  }, // Parque del Retiro, Madrid
  {
    lat: 39.868981,
    lng: -4.020682,
    nombre: "Caliente Latino",
    url: "infoEvento.php?evento=5",
  }, // Estadio Salto del Caballo, Toledo
  {
    lat: 41.65162,
    lng: -4.730721,
    nombre: "Noche de Risas",
    url: "infoEvento.php?evento=6",
  }, // Teatro Zorrilla, Valladolid
  {
    lat: 43.369102,
    lng: -8.413962,
    nombre: "Sunset Rave",
    url: "infoEvento.php?evento=7",
  }, // Playa de Riazor, A Coruña
  {
    lat: 41.65186,
    lng: -0.881896,
    nombre: "Sinfonía en Do Mayor",
    url: "infoEvento.php?evento=8",
  }, // Teatro Principal, Zaragoza
  {
    lat: 41.65162,
    lng: -4.730721,
    nombre: "Travesía Fantástica",
    url: "infoEvento.php?evento=9",
  }, // Teatro Zorrilla, Valladolid
  {
    lat: 41.290385,
    lng: 0.793862,
    nombre: "Reggae Roots",
    url: "infoEvento.php?evento=10",
  }, // Parque Natural de la Sierra de Montsant, Tarragona
  {
    lat: 39.475122,
    lng: -6.376236,
    nombre: "Festival de Verano",
    url: "infoEvento.php?evento=11",
  }, // Plaza Mayor, Cáceres
  {
    lat: 37.87561,
    lng: -4.774264,
    nombre: "Exposición de Arte Moderno",
    url: "infoEvento.php?evento=12",
  }, // Museo de Arte Contemporáneo, Córdoba
  {
    lat: 40.462267,
    lng: -3.618929,
    nombre: "Conferencia sobre Tecnología",
    url: "infoEvento.php?evento=13",
  }, // Palacio Municipal de Congresos, Madrid
  {
    lat: 43.539274,
    lng: -5.663849,
    nombre: "Noche de Magia",
    url: "infoEvento.php?evento=14",
  }, // Teatro Jovellanos, Gijón
  {
    lat: 43.348228,
    lng: -4.054231,
    nombre: "Danza Contemporánea",
    url: "infoEvento.php?evento=15",
  }, // Centro de Artes Escénicas, Torrelavega
  {
    lat: 40.401951,
    lng: -3.882065,
    nombre: "Cine al Aire Libre",
    url: "infoEvento.php?evento=16",
  }, // Parque Juan Pablo II, Madrid
  {
    lat: 40.409739,
    lng: -3.698951,
    nombre: "Feria de Libros",
    url: "infoEvento.php?evento=17",
  }, // Parque del Retiro, Madrid
  {
    lat: 40.304799,
    lng: -3.746887,
    nombre: "Cena Romántica en el Lago",
    url: "infoEvento.php?evento=18",
  }, // Restaurante Lago Alhóndiga, Getafe
  {
    lat: 40.487423,
    lng: -4.054178,
    nombre: "Paseo en Globo al Atardecer",
    url: "infoEvento.php?evento=19",
  }, // Campo de Vuelo, Teruel
  {
    lat: 40.445841,
    lng: -3.871087,
    nombre: "Spa y Relajación para Parejas",
    url: "infoEvento.php?evento=20",
  }, // Forus Majadahonda Las Rejas, Majadahonda
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
