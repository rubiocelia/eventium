<?php
  require_once("infoEvento.php");
  // Consulta para recuperar el calendario del evento
  $sql_Calendario = "SELECT 
      calen.id
      ,calen.id_evento
      ,DAY(calen.fecha) AS dia_evento
      ,CASE 
        WHEN MONTH(calen.fecha) = 1 THEN 'ENERO'
        WHEN MONTH(calen.fecha) = 2 THEN 'FEBRERO'
        WHEN MONTH(calen.fecha) = 3 THEN 'MARZO'
        WHEN MONTH(calen.fecha) = 4 THEN 'ABRIL'
        WHEN MONTH(calen.fecha) = 5 THEN 'MAYO'
        WHEN MONTH(calen.fecha) = 6 THEN 'JUNIO'
        WHEN MONTH(calen.fecha) = 7 THEN 'JULIO'
        WHEN MONTH(calen.fecha) = 8 THEN 'AGOSTO'
        WHEN MONTH(calen.fecha) = 9 THEN 'SEPTIEMBRE'
        WHEN MONTH(calen.fecha) = 10 THEN 'OCTUBRE'
        WHEN MONTH(calen.fecha) = 11 THEN 'NOVIEMBRE'
        WHEN MONTH(calen.fecha) = 12 THEN 'DICIEMBRE'
      ELSE
        '-'
      END AS nom_mes
      ,YEAR(calen.fecha) AS year_evento
      ,CASE
        WHEN dayofweek(calen.fecha)=1 THEN 'Domingo'
        WHEN dayofweek(calen.fecha)=2 THEN 'Lunes'
        WHEN dayofweek(calen.fecha)=3 THEN 'Martes'
        WHEN dayofweek(calen.fecha)=4 THEN 'Miercoles'
        WHEN dayofweek(calen.fecha)=5 THEN 'Jueves'
        WHEN dayofweek(calen.fecha)=6 THEN 'Viernes'
        WHEN dayofweek(calen.fecha)=7 THEN 'Sabado'
      ELSE
        '-'
      END AS nom_dia_semana
      ,calen.totalPlazas-calen.plazasOcupadas AS plazas_disponibles
      ,calen.hora
      ,calen.precio
      ,calen.fecha
    FROM 
      calendarioevento as calen 
    WHERE 
      calen.id_evento='$idEvento'
      AND (
        (calen.fecha=CURRENT_DATE() AND calen.hora>=CURRENT_TIME)
        OR
        calen.fecha>CURRENT_DATE()
      )
      AND calen.totalPlazas>calen.plazasOcupadas
    ORDER BY fecha ASC";
  $consulta = $conexion->query($sql_Calendario);
  $calendario = $consulta->fetch_all(MYSQLI_ASSOC);

?>
<script src="../componentesEventos/js/calendarioEvento.js" defer></script>
<link rel="stylesheet" href="../componentesEventos/Style/calendarioEvento.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">	
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
<div class="container-custom">
  <?php foreach ($calendario as $item) : ?>
    <div class="row row-striped">
      <div class="col-2 text-right">
        <h1 class="display-4"><span class="badge badge-secondary"><?php echo $item['dia_evento'];?></span></h1>
        <h2><?php echo $item['year_evento'];?></h2>
      </div>
        <div class="col-10">
          <h3 class="text-uppercase"><strong><?php echo $item['nom_mes'];?></strong></h3>
          <ul class="list-inline">
            <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i><?php echo ' '.$item['nom_dia_semana'];?></li>
            <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo ' '.$item['hora'];?></li>
            <li class="list-inline-item"><i class="fa fa-eur" aria-hidden="true"></i><?php echo ' '.$item['precio'];?></li>
          </ul>
          <p>Plazas disponibles: <?php echo $item['plazas_disponibles'];?></p>
        </div>
    </div>
  <?php endforeach; ?>
</div>