<?php
    require_once("conecta.php");
    require_once("./eventos.php");
    //obtenemso la conexion a la bbdd
    $conexion = getConexion();

    $sql="";
    //se verifica si al filtrar por tipos se selecciona eventos filtrados por id_tipoEvento
    //o por el contrario se filtra por id_categoria para las categorias
    if($filtrar==true){
        if($filtrarPor=="Tipo"){
            $sql="SELECT * FROM evento WHERE id_tipoEvento='$idFiltro'";    
        } else {
            $sql="SELECT 
                evento.*
            FROM 
                evento
                JOIN relacioncateven as rel ON evento.id_evento=rel.id_evento AND rel.id_categoriaEvento='$idFiltro'";
        }
    } else {
        $sql="SELECT * FROM evento";
    }
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
    <link rel="stylesheet" type="text/css" href="./componentesEventos/Style/albumEventos.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

    
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <!-- foreach sobre cada eventos obtenido de la bbdd -->
                <?php foreach ($eventos as $evento) : ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <!-- mostrar img del evento -->
                            <img src="<?php echo $evento['url_img']; ?>" style="object-fit: cover; max-height: 200px;" loading="lazy" alt="">
                            <div class="card-body">
                                <h6><?php echo $evento['nombre_evento']; ?></h6>
                                <!--<p class="card-text"><?php //echo $evento['descripcion_evento']; ?></p>-->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <!-- Enlace para mas informacion del evento -->
                                        <a href="infoEvento.php?evento=<?php echo $evento['id_evento']; ?>" class="btn btn-sm btn-outline-secondary">MÁS INFO</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</html>
