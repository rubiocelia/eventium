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
$consulta = $conexion->query($sql);
$eventos = $consulta->fetch_all(MYSQLI_ASSOC);
$conexion->close();
$indexIndicator = 0;
$primerElemento=true;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi perfil</title>
    <link rel="stylesheet" type="text/css" href="css/eventos.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        #carouselExampleIndicators {
            width: 100%; 
            margin: 0 auto; 
        }
        .carousel-item img {
            max-height: 650px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            #carouselExampleIndicators {
                width: 100%; 
            }
        }
/* xjskjdkbskj */
       
    </style>
</head>
<body>
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
                    <img src="<?php echo $evento['url_img']; ?>" class="d-block w-100" alt="">
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1><?php echo $evento['nombre_evento']; ?></h1>
                            <p><?php echo $evento['descripcion_evento']; ?></p>
                            <p><a class="btn btn-lg btn-primary" href="#">Reservar</a></p>
                        </div>
                    </div>
                </div>
            <?php $primerElemento=false; ?>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</body>
</html>
