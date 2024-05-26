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
