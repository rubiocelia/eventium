<?php
require_once("conecta.php");
$conexion = getConexion();

// Iniciar sesión si no está ya iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
$isLoggedIn = isset($_SESSION['id_usuario']);

// Consulta para recuperar el calendario del evento
$idEvento = $_GET['evento']; // Asumiendo que el ID del evento se pasa a través de la URL
$sql_Calendario = "SELECT 
      calen.id,
      calen.id_evento,
      DAY(calen.fecha) AS dia_evento,
      CASE 
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
      END AS nom_mes,
      YEAR(calen.fecha) AS year_evento,
      CASE
        WHEN dayofweek(calen.fecha)=1 THEN 'Domingo'
        WHEN dayofweek(calen.fecha)=2 THEN 'Lunes'
        WHEN dayofweek(calen.fecha)=3 THEN 'Martes'
        WHEN dayofweek(calen.fecha)=4 THEN 'Miercoles'
        WHEN dayofweek(calen.fecha)=5 THEN 'Jueves'
        WHEN dayofweek(calen.fecha)=6 THEN 'Viernes'
        WHEN dayofweek(calen.fecha)=7 THEN 'Sabado'
      ELSE
        '-'
      END AS nom_dia_semana,
      calen.totalPlazas-calen.plazasOcupadas AS plazas_disponibles,
      calen.hora,
      calen.precio,
      calen.fecha
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
$conexion->close();
?>
<!-- <script src="../componentesEventos/js/calendarioEvento.js" defer></script> -->
<link rel="stylesheet" href="../componentesEventos/Style/calendarioEvento.css">
<div class="mi-calendario">
    <div class="contenido-calendario">
        <?php foreach ($calendario as $item) : ?>
        <div class="item-calendario">
            <!-- Columnas donde ubicar el día y la hora -->
            <div class="column-day-hora">
                <span class="sty-dia"><?php echo $item['dia_evento'];?></span>
                <span class="sty-hora"><?php echo ' '.$item['hora'];?></span>
            </div>
            <div class="column-info-pago">
                <div class="info">
                    <span class="sty-mes"><?php echo $item['nom_mes'].' '.$item['year_evento'];?></span>
                    <ul class="lista-info-reducida">
                        <li>📅 <?php echo $item['nom_dia_semana'];?></li>
                        <li>💶 <?php echo $item['precio'];?> €</li>
                    </ul>
                    <span class="plazas-disponibles">Entradas disponibles:
                        <?php echo $item['plazas_disponibles'];?></span>
                </div>
                <div class="pago">
                    <button class="boton-pago" data-id="<?php echo $item['id']; ?>">COMPRAR</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="./componentesEventos/js/calendarioEvento.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    var botonesPago = document.querySelectorAll('.boton-pago');
    var loginPopup = document.getElementById("loginPopup");

    botonesPago.forEach(function(boton) {
        boton.addEventListener('click', function() {
            if (!isLoggedIn) {
                mostrarPopup(loginPopup);
            } else {
                var idEvento = boton.getAttribute('data-id');
                window.location.href = 'pasarelaPago.php?id=' + idEvento;
            }
        });
    });

    var formLogin = document.querySelector('.FormularioLogin');
    if (formLogin) {
        formLogin.addEventListener('submit', function(event) {
            var actionUrl = formLogin.action;
            var formData = new FormData(formLogin);
            formData.append('sendTo', 'pasarelaPago.php?id=<?php echo $idEvento; ?>');

            fetch(actionUrl, {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                .then(data => {
                    if (data.includes(
                        'success')) { // Assuming your login.php returns 'success' on successful login
                        window.location.href = 'pasarelaPago.php?id=<?php echo $idEvento; ?>';
                    } else {
                        // Handle error
                        document.querySelector('.mensajeError').innerHTML =
                            'Error en el inicio de sesión';
                    }
                });

            event.preventDefault();
        });
    }
});

function mostrarPopup(popup) {
    popup.style.display = "block";
    setTimeout(function() {
        popup.style.opacity = "1"; // Cambia la opacidad para mostrar gradualmente el popup
    }, 50); // Se agrega un pequeño retraso para asegurar que la transición se aplique correctamente
}

function ocultarPopup(popup) {
    popup.style.opacity = "0"; // Cambia la opacidad para ocultar gradualmente el popup
    setTimeout(function() {
        popup.style.display = "none";
    }, 300); // Espera 300 milisegundos para ocultar el popup después de la transición
}
</script>