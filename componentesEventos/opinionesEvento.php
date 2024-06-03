<?php
    require_once('infoEvento.php');
    $conexion = getConexion();
    // Consulta para recuperar todas las opiniones del evento
    $sql_Opiniones="SELECT 
            opinion.txt_opinion, 
            opinion.numPuntuacion, 
            usu.id as id_usuario,  
            usu.nombre_usuario, 
            usu.apellidos_usuario
        FROM 
            opinionevento as opinion 
            JOIN usuario as usu on usu.id=opinion.usuario_id 
        WHERE 
            opinion.id_evento='$idEvento'";
    // Consulta para calcular la media de opiniones
    $sql_Media ="SELECT 
            id_evento, FORMAT(AVG(numPuntuacion), 2) as media 
        FROM 
            opinionevento 
        WHERE 
            id_evento = '$idEvento' 
        GROUP BY id_evento";
    // Ejecutamos la consulta para calcular la media
    $consulta = $conexion->query($sql_Media);
    $mediaOpiniones = $consulta->fetch_assoc();
    // Ejecutamos la consulta para recuperar opiniones
    $consulta = $conexion->query($sql_Opiniones);
    $listaOpiniones = $consulta->fetch_all(MYSQLI_ASSOC);
    $conexion->close();
    $primerElemento = true;
?>
<!-- Incluye CSS de Bootstrap -->
<?php echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">'; ?>
<!-- Incluye Font Awesome -->
<?php echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">'; ?>
<?php if (!empty($listaOpiniones)) : ?>
<div class="bodyOpiniones">
    
    <div id="TestC" class="carousel slide" data-ride="carousel">
        <div class="redz">
            <h1>Testimonios <?php echo ' - '.$mediaOpiniones['media'].'/5'; ?> ⭐</h1>
            <!--Contenedor slides -->
            <div class="carousel-inner" role="listbox">
                <?php foreach ($listaOpiniones as $opinion) : ?>
                    <div class="<?= $primerElemento === true ? 'item active' : 'item'; ?>">
                        <div class="quote-section">
                            <i class="fa fa-quote-left" id="ql"></i><?php echo $opinion['txt_opinion']; ?><i class="fa fa-quote-right" id="qr"></i>
                        </div>
                        <div class="autor-section">
                            <i class="fa fa-user"></i><?php echo ' '.$opinion['nombre_usuario'].' '.$opinion['apellidos_usuario']; ?> || <?php echo $opinion['numPuntuacion']; ?> <i class="fa fa-star"></i>
                        </div>
                    </div>
                    <?php $primerElemento=false; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <!--Fin Contenedor slides -->
        <!-- Controles -->
        <a class="control-carrusel control-carrusel-izquierda" href="#TestC" data-slide="prev">
            <i class="fa fa-chevron-circle-left"></i>
        </a>
        <a class="control-carrusel control-carrusel-derecha" href="#TestC" data-slide="next">
            <i class="fa fa-chevron-circle-right"></i>
        </a>
        <!-- Fin Controles -->
    </div>
    <!-- Incluye jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Incluye JS de Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Incluye tu propio JS -->
    <script src="../componentesEventos/js/opinionesEvento.js"></script>
</div>
<?php endif; ?>
