<?php
    require_once('./eventos.php');
    require_once('./conecta.php');
    //establecer conexión con la bbdd
    $conexion = getConexion();

    //obteber todos los tipos de eventos desde la bbdd
    $sql = "SELECT * FROM tipoevento";
    $consulta = $conexion->query($sql);
    $tiposEventos = $consulta->fetch_all(MYSQLI_ASSOC);

    //obtener todas las categorias de la bbdd
    $sql = "SELECT * FROM categoriaevento";
    $consulta = $conexion->query($sql);
    $categoriasEventos = $consulta->fetch_all(MYSQLI_ASSOC);
    //cerrar la conexión
    $conexion->close();
?>
<link rel="stylesheet" type="text/css" href="./componentesEventos/Style/menuLateralFiltros.css">
<div class="contenedor-prinpical">
  
    <h3>Encuentra tu evento</h3>
      <!-- filtro por tipo de eventos -->
    <div class="item-filtros">
        <button class="boton-colapsar">Filtrar por tipo</button>
        <!-- lista de opciones de filtro por tipo, se muestra si se está filtrando por tipo -->
        <div class="lista-opciones-filtros" style="<?php echo ($filtrar && $filtrarPor == 'Tipo') ? 'display: block;' : ''; ?>">
            <ul>
                <?php foreach ($tiposEventos as $item) : ?>
                    <li><a href="?filtrarPor=Tipo&idFiltro=<?php echo $item['id']; ?>#filtro" class="<?php echo ($filtrar && $filtrarPor == 'Tipo' && $idFiltro == $item['id']) ? 'selected' : ''; ?>"><?php echo $item['nombre_tipoEvento']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Filtro por categoria de evento -->
    <div class="item-filtros">
        <button class="boton-colapsar">Filtrar por categoria</button>
        <!-- lista de opciones de filtro por categoria, se muestra si se está filtrando por categoria -->
        <div class="lista-opciones-filtros" style="<?php echo ($filtrar && $filtrarPor == 'Categoria') ? 'display: block;' : ''; ?>">
            <ul>
                <?php foreach ($categoriasEventos as $item) : ?>
                    <li><a href="?filtrarPor=Categoria&idFiltro=<?php echo $item['id']; ?>#filtro" class="<?php echo ($filtrar && $filtrarPor == 'Categoria' && $idFiltro == $item['id']) ? 'selected' : ''; ?>"><?php echo $item['nombre_categoriaEvento']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Sección para eliminar los filtros, se muestra solo si hay filtros aplicados -->
    <?php if ($filtrar==true) : ?>
        <div class="seccion-boton-quitar-filtros">
            <a href="eventos.php#filtro" class="btn-accion">Quitar Filtros</a>
        </div>
    <?php endif; ?>
    <script src="./componentesEventos/js/menuLateralFiltros.js"></script>
</div>