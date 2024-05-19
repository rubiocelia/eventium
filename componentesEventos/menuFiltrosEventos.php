<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi perfil</title>
    <link rel="stylesheet" type="text/css" href="css/eventos.css">
    <link rel="stylesheet" type="text/css" href="componentesEventos/Style/menuLateral.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<div class="flex-shrink-0 p-3" style="width: 280px;" >
    <a href="#" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
      <span class="fs-5 fw-semibold">Filtrar Eventos</span>
    </a>
    <ul class="list-unstyled ps-0">
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          Tipo de evento
        </button>
        <div class="collapse" id="dashboard-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Musical</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Concierto</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Teatro</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
          Categoria
        </button>
        <div class="collapse" id="orders-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Planes en familia</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Fiestas de verano</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Noches culturales</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Eventos al aire libre</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Conciertos y Espectáculos</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</body>
</html>