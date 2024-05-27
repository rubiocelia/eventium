<?php
require_once("conecta.php");

function getFeaturedEvents($limit = 5) {
    $conexion = getConexion();
    $sql = "SELECT id_evento, nombre_evento, descripcion_evento, url_img FROM evento ORDER BY id_evento ASC LIMIT ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = array();
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    $stmt->close();
    $conexion->close();
    return $events;
}

function shortenDescription($description, $id) {
    $maxLength = 100; // Máximo número de caracteres antes de truncar
    if (strlen($description) > $maxLength) {
        $shortDescription = substr($description, 0, $maxLength) . "...";
        $shortDescription .= " <a href='infoEvento.php?evento=" . $id . "'>Leer más</a>";
        return $shortDescription;
    } else {
        return $description;
    }
}

$featuredEvents = getFeaturedEvents();
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eventium</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>

<body class="index">
    <?php include('menu.php'); ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Descubre y Reserva Eventos Únicos con Eventium</h1>
            <p>Desde cines hasta excursiones, encuentra lo que te apasiona.</p>
            <div class="search-bar">
                <input type="text" placeholder="¿Qué evento buscas?">
                <button>Encuentra tu Evento</button>
            </div>
        </div>
    </section>

    <!-- Featured Events -->
    <section class="featured-events">
        <h2>Top 5 eventos</h2>
        <div class="carousel">
            <?php foreach ($featuredEvents as $index => $event): ?>
            <div class="event-card">
                <div class="event-number"><?php echo $index + 1; ?></div>
                <a href="infoEvento.php?evento=<?php echo $event['id_evento']; ?>">
                    <img src="<?php echo $event['url_img']; ?>"
                        alt="<?php echo htmlspecialchars($event['nombre_evento']); ?>">
                </a>
                <h3><?php echo htmlspecialchars($event['nombre_evento']); ?></h3>
                <p><?php echo shortenDescription($event['descripcion_evento'], $event['id_evento']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <a href="eventos.php" class="view-all-link">Ver todos los eventos</a>
    </section>

    <section class="categories">
        <h2>Explora por categorías</h2>
        <div class="category-icons">
            <div class="category" id="cine">
                <p>Cine</p>
            </div>
            <div class="category" id="conciertos">
                <p>Conciertos</p>
            </div>
            <div class="category" id="excursiones">
                <p>Excursiones</p>
            </div>
            <div class="category" id="viajes">
                <p>Viajes</p>
            </div>
            <div class="category" id="teatro">
                <p>Teatro</p>
            </div>
        </div>
    </section>



    <!-- Sección del Mapa Interactivo -->
    <section class="interactive-map">
        <h2>Encuentra eventos cerca de ti</h2>
        <div id="map"></div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <h2>Suscríbete a Nuestro Boletín</h2>
        <p>Recibe las últimas actualizaciones y ofertas exclusivas.</p>
        <div class="subscription-form">
            <input type="email" placeholder="Tu correo electrónico">
            <button>Suscribirse</button>
        </div>
    </section>

    <?php include('footer.php'); ?>

    <!-- js -->
    <script src="scripts/scriptPopUp.js"></script>
    <script src="scripts/index.js"></script>
    <script src="scripts/validacionRegistro.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>