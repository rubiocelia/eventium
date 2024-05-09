<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>QQ Servicios</title>
    <link rel="stylesheet" type="text/css" href="css/eventos.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="index">
    <?php include('menu.php'); ?>
    <?php include('carouselEventos.php'); ?>
    <div class="busquedaEventos">
        <div><?php include('menuFiltrosEventos.php'); ?></div>
        <div><?php include('albumEventos.php'); ?></div>
    <div>
    
    <?php include('footer.php'); ?>
</body>

</html>