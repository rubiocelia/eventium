document.addEventListener("DOMContentLoaded", function () {
  $("#calendar").fullCalendar({
    locale: "es", // Configura el calendario en español
    firstDay: 1, // Configura el primer día de la semana como lunes
    header: {
      left: "prev,next today",
      center: "title",
      right: "month,agendaWeek,agendaDay",
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
      week: "semana",
      day: "día",
    },
  });
});
