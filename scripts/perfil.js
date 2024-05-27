document.addEventListener("DOMContentLoaded", function () {
  $("#calendar").fullCalendar({
    locale: "es", // Configura el calendario en español
    firstDay: 1, // Configura el primer día de la semana como lunes
    height: 500, // Ajusta la altura del calendario
    header: {
      left: "prev,next today",
      center: "title",
      right: "month", // Solo muestra la vista de mes
    },
    navLinks: true,
    editable: true,
    eventLimit: true,
    events: {
      url: "obtener_eventos.php",
      method: "GET",
      error: function () {
        alert("No se pudieron cargar los eventos.");
      },
    },
    buttonText: {
      today: "hoy",
      month: "mes",
    },
    eventTimeFormat: "HH:mm", // Formato de 24 horas para la visualización de los eventos
    eventRender: function (event, element) {
      // Añadir tooltip con el nombre, la hora y la ubicación del evento
      const startTime = moment(event.start).format("HH:mm");
      element.attr("title", `${event.title}\n${startTime}\n${event.location}`);
    },
    dayClick: function (date, jsEvent, view) {
      // Prevenir cualquier acción al hacer clic en los días
      jsEvent.preventDefault();
    },
  });
});
