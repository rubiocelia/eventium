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
        <div class="cabecera">
            <!-- Imagen -->
            <div>
                <img src="<?php echo $evento['url_img']; ?>" alt=""></img>
            </div>
            <!-- Nombre -->
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
        <!-- Sección de más información -->
        <div class="seccion-info-adicional">
            <div>
                <h2>Información adicional </h2>
                <p><strong>👨‍👩‍👧‍👧Edad recomendada:</strong> <?php echo $evento['edad_evento']; ?></p>
                <p><strong>🕛Duración estimada:</strong> <?php echo $evento['duracion_evento']; ?></p>
                <p><strong>♿Accesibilidad:</strong> <?php echo $evento['accesibilidad_evento']; ?></p>
                <p><strong>🎟️Aforo:</strong> <?php echo $evento['aforo_evento']; ?></p><br>
                
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
            <div>
                <?php include('./componentesEventos/calendarioEvento.php'); ?> 
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
    <?php require_once('footer.php'); ?>
    
</body>

</html>
