<?php
require_once("conecta.php");
$conexion = getConexion();

// Consulta para recuperar los eventos populares (Solo 8)
$sql = "SELECT * FROM evento";
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
            width: 100%; /* Ajusta el ancho del carousel */
            margin: 0 auto; /* Centra el carousel horizontalmente */
        }
        @media (max-width: 768px) {
            #carouselExampleIndicators {
                width: 100%; /* Si la pantalla es más pequeña que 768px, ocupa el 100% del ancho */
            }
        }

        /* Estilos adicionales si es necesario */
    </style>
</head>
<body>
    
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($eventos as $evento) : ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <img src="<?php echo $evento['url_img']; ?>" style="object-fit: cover; max-height: 200px;"  alt="">
                            <div class="card-body">
                                <h6><?php echo $evento['nombre_evento']; ?></h6>
                                <!--<p class="card-text"><?php //echo $evento['descripcion_evento']; ?></p>-->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">RESERVAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
