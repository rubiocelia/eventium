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
    <title>Eventos</title>
    <link rel="stylesheet" type="text/css" href="css/infoEvento.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
</head>
<body>
    <?php include('menu.php'); ?>
    <div class="container">
        <!-- Cabcera de la pagina -->
        <div class="cabecera">
        <!-- Imagen -->
        <div>
            <img src="<?php echo $evento['url_img']; ?>" alt=""></img>
        </div>
        <!-- nombre -->
        <div>
            <h1><?php echo $evento['nombre_evento']; ?></h1>
        </div>
        </div>
        <!-- Descripción -->
        <div>
            <h2>Descripción</h2>
            <p><?php echo $evento['descripcion_evento']; ?></p>
        </div>
        <br/><hr><br>
        <!-- Sección de más informacion -->
        <div>
            <h2>Información adicional </h2>
            <p><strong>👨‍👩‍👧‍👧Edad recomendada:</strong> <?php echo $evento['edad_evento']; ?></p>
            <p><strong>🕛Duracion estimada:</strong> <?php echo $evento['duracion_evento']; ?></p>
            <p><strong>🗺️Ubicación:</strong> <?php echo $evento['ubicacion_evento']; ?></p><br>
            <iframe
                src="<?php echo $evento['url_maps']; ?>"
                width="600"
                height="450"
                style="border:0;"
                allowfullscreen=""
                aria-hidden="false"
                tabindex="0">
            </iframe>
        </div>
    </div>


    <?php include('footer.php'); ?>
</body>

</html>
