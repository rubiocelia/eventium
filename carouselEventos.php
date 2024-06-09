<?php
require_once("conecta.php");
$conexion = getConexion();

// Consulta para recuperar los eventos populares (Solo 10)
$sql = "SELECT
        reservausuario.id_evento,
        evento.nombre_evento,
        evento.descripcion_evento,
        evento.url_img,
        COUNT(reservausuario.id_evento) AS TOTAL
    FROM `reservausuario`
        JOIN evento ON reservausuario.id_evento=evento.id_evento
    GROUP BY
        reservausuario.id_evento, evento.nombre_evento, evento.descripcion_evento, evento.url_img
    ORDER BY COUNT(reservausuario.id_evento) DESC
    LIMIT 10";
$consulta = $conexion->query($sql); // Ejecuta la consulta en la base de datos
$eventos = $consulta->fetch_all(MYSQLI_ASSOC);
$conexion->close();
$indexIndicator = 0; // Inicializa el índice del indicador del carrusel
$primerElemento=true; //determina el primer elemento del carrusel
?>
<div>
    <link rel="stylesheet" type="text/css" href="css/carousel.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <!-- Inicio del componente carrusel de Bootstrap -->
    <div id="carouselExampleIndicators" class="carousel slide mb-2">
        <div class="carousel-indicators">
        <?php foreach ($eventos as $evento) : ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $indexIndicator; ?>" class="<?= $indexIndicator === 0 ? 'active' : ''; ?>" aria-current="<?= $indexIndicator === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?= $indexIndicator + 1; ?>"></button>
            <?php $indexIndicator++; ?>
        <?php endforeach; ?>
        </div>
        <div class="carousel-inner">
            <?php foreach ($eventos as $evento) : ?>
                <div class="<?= $primerElemento === true ? 'carousel-item active' : 'carousel-item'; ?>">
                    <img src="<?php echo $evento['url_img']; ?>" class="d-block w-100" style="height: 70vh;" alt=""> <!-- Imagen del evento -->
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1><?php echo $evento['nombre_evento']; ?></h1>
                            <p><a href="infoEvento.php?evento=<?php echo $evento['id_evento']; ?>" class="btn btn-lg btn-primary mi-boton-personalizado">Más info</a></p>
                        </div>
                    </div>
                </div>
            <?php $primerElemento=false; ?>
            <?php endforeach; ?>
        </div>
        <!-- Controles del carrusel para navegar entre los elementos -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
