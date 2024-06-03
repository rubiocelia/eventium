<?php require_once("conecta.php");
    $conexion = getConexion();
    // Recuperamos el parametro del evento que queremos visualizar
    $idEvento = $conexion->real_escape_string($_GET['evento']);
    $sql = "SELECT * FROM evento WHERE id_evento = '$idEvento'";
    $consulta = $conexion->query($sql);
    $evento = $consulta->fetch_assoc();
    $conexion->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/infoEvento.css">
    <link rel="stylesheet" type="text/css" href="componentesEventos/Style/opinionesEvento.css">
    <link rel="stylesheet" href="componentesEventos/Style/calendarioEvento.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
</head>

<body class="bodyInfoEvento">
    <?php require_once('menu.php'); ?>
    <div class="custom-container">
        <!-- Cabecera de la página -->
        <a href="eventos.php" class="volver">⬅ Volver</a>
        <div class="cabecera">
            <!-- Imagen -->
            <div>
                <img src="<?php echo $evento['url_img']; ?>" alt=""></img>
            </div>
            <!-- Nombre -->
            <div class="nombre-descripcion">
                <h1><?php echo $evento['nombre_evento']; ?></h1>
                <p class="descripcion"><?php echo $evento['descripcion_evento']; ?></p>
            </div>
        </div>
        <!-- Descripción -->

        <br />
        <hr>
        <!-- Sección de más información -->
        <div class="seccion-info-adicional">
            <h2>Información adicional </h2>
            <div class="datos-info">
                <p><strong>👨‍👩‍👧‍👧Edad recomendada:</strong><br> <?php echo $evento['edad_evento']; ?></p>
                <p><strong>🕛Duración estimada:</strong><br> <?php echo $evento['duracion_evento']; ?></p>
                <p><strong>♿Accesibilidad:</strong><br> <?php echo $evento['accesibilidad_evento']; ?></p>
                <p><strong>🗺️Ubicación:</strong><br> <?php echo $evento['ubicacion_evento']; ?></p>
                <p><strong>🎟️Aforo:</strong><br> <?php echo $evento['aforo_evento']; ?></p>
            </div>
        </div>
        <div class="seccion-mapa-calendario">
            <div>
                <iframe src="<?php echo $evento['url_maps']; ?>" width="600" height="450" style="border:0;"
                    allowfullscreen="" aria-hidden="false" tabindex="0">
                </iframe>
            </div>
            <div>
                <?php require_once('./componentesEventos/calendarioEvento.php'); ?>
            </div>
        </div>
    </div>

    <?php include('./componentesEventos/opinionesEvento.php'); ?>
    <!-- Incluye jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Incluye JS de Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Incluye tu propio JS -->
    <script src="../componentesEventos/js/opinionesEvento.js"></script>
    <script src="scripts/scriptPopUp.js"></script>

    <?php require_once('footer.php'); ?>

</body>

</html>