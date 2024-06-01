<?php
    require_once('./conecta.php');
    $conexion = getConexion();
    $sql = "SELECT * FROM tipoevento";
    $consulta = $conexion->query($sql);
    $tiposEventos = $consulta->fetch_all(MYSQLI_ASSOC);
    $sql = "SELECT * FROM categoriaevento";
    $consulta = $conexion->query($sql);
    $categoriasEventos = $consulta->fetch_all(MYSQLI_ASSOC);
    $conexion->close();
?>
<link rel="stylesheet" type="text/css" href="./componentesEventos/Style/menuLateralFiltros.css">
<div class="contenedor-prinpical">
    <h2>Filtra según preferencia</h2>
    <div class="item-filtros">
        <button class="boton-colapsar">Filtrar por tipo</button>
        <div class="lista-opciones-filtros">
            <ul>
                <?php foreach ($tiposEventos as $item) : ?>
                    <li><a href="?filtrarPor=Tipo&idFiltro=<?php echo $item['id']; ?>#filtro"><?php echo $item['nombre_tipoEvento']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="item-filtros">
        <button class="boton-colapsar">Filtrar por categoria</button>
        <div class="lista-opciones-filtros">
            <ul>
                <?php foreach ($categoriasEventos as $item) : ?>
                    <li><a href="?filtrarPor=Categoria&idFiltro=<?php echo $item['id']; ?>#filtro"><?php echo $item['nombre_categoriaEvento']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <script src="./componentesEventos/js/menuLateralFiltros.js"></script>
</div>