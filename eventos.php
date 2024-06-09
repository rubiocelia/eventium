<?php

    //// Inicializa variables de filtro
    $filtrar=false;
    $filtrarPor=null;
    $idFiltro=0;
    // Verifica si los parámetros 'filtrarPor' y 'idFiltro' están establecidos en la URL
    if(isset($_GET['filtrarPor'], $_GET['idFiltro'])){
        $filtrar=true;
        $filtrarPor=$_GET['filtrarPor'];
        $idFiltro=$_GET['idFiltro'];
    } else {
        $filtrar=false;
    }

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link rel="stylesheet" type="text/css" href="css/eventos.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body class="index">
<?php
    // Inicia o continua una sesión existente
    if (session_status() == PHP_SESSION_NONE) {
        // Si no hay sesión activa, iniciar una nueva sesión
        session_start();
    }

    // Verifica si la sesión está iniciada y si $id_usuario está definido
    if (isset($_SESSION['id_usuario'])) {
        include('menu_sesion_iniciada.php');
    } else {
        include('menu.php');
    }
    ?>  
    <?php require_once('carouselEventos.php'); ?>
    <div class="busquedaEventos" id="filtro">
        <!-- Incluir el menú lateral de filtros -->
        <div><?php require_once('componentesEventos/menuLateralFiltros.php'); ?></div>
        <!-- Incluir el álbum de eventos -->
        <div><?php require_once('componentesEventos/albumEventos.php'); ?></div>
    </div>
    <?php require_once('footer.php'); ?>
       <!-- Enlace al script para manejar el popup -->
    <script src="scripts/scriptPopUp.js"></script>

</body>

</html>