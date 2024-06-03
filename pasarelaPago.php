<?php
    session_start();
    require_once("conecta.php");
    //Funcion para obtener información del calendario
    function obtenerInfoCalendario(int $id_calendario){
        $conexion = getConexion();
        $sql_Calendario = "SELECT 
                calen.id
                ,calen.id_evento
                ,evento.nombre_evento
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
                JOIN evento ON calen.id_evento=evento.id_evento
            WHERE 
                calen.id='$id_calendario'
            ORDER BY fecha ASC";
        $consulta = $conexion->query($sql_Calendario);
        $calendario = $consulta->fetch_assoc();
        $conexion->close();
        return $calendario;
    }
    // Funcion para obtener la informacion del usuario actual
    function obtenerInfoUsuario(int $id_usuario){
        $conexion = getConexion();
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($resultado->num_rows == 0) {
            echo "No se encontró información para el usuario con el ID proporcionado.";
            $conexion->close();
            exit;
        }
        $usuario = $resultado->fetch_assoc();
        $conexion->close();
        return $usuario;
    }
    // Controlar si has iniciado sesion antes de reservar
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: formulario_inicio_sesion.php");
        exit;
    }
    // Recuperamos de la sesion el idUsuario
    $idUsuario = $_SESSION['id_usuario'];
    // Obtenemos del GET el ID del calendario que estamos reservando
    $id_calendario=$_GET['id'];
    $infoCalendario=obtenerInfoCalendario($id_calendario);
    $infoUsuario=obtenerInfoUsuario($idUsuario);
    $entradasDisponibles=$infoCalendario['plazas_disponibles'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/pasarelaPago.css">
    <script type="text/javascript" src="./scripts/pasarelaPago.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Formulario de Pago</title>
</head>
<body>

<div class="container">
    <h1>Formulario de Pago</h1>
    <div class="distribucion-principal">
        <!-- Columna 1  -->
        <div class="seccion-resumen">
        <div class="info-evento">
            <h3><?php echo $infoCalendario['nombre_evento']; ?></h3>
                <div class="info-evento-details">
                    <span>Fecha: <?php echo $infoCalendario['dia_evento'].'-'.$infoCalendario['nom_mes'].'-'.$infoCalendario['year_evento']; ?></span>
                    <span>Hora: <?php echo $infoCalendario['hora']; ?></span>
                </div>
        </div>
            <div class="info-usuario-container">
                <h3> Información Titular reserva</h3>
                    <div class="info-usuario">
                        <span class="username">UserName: <?php echo $infoUsuario['username']; ?></span>
                        <span class="nombre">Nombre: <?php echo $infoUsuario['nombre_usuario'].' '.$infoUsuario['apellidos_usuario']; ?></span>
                        <span class="email">Email: <?php echo $infoUsuario['mail_usuario']; ?></span>
                        <span class="telefono">Telefono: <?php echo $infoUsuario['telefono_usuario']; ?></span>
                    </div>
            </div>
            <div class="formas-pago">
                <form method="post" action="">
                    <h3>Formas de Pago</h3>
                    <div class="textos-tarjeta">
                        <label>Tipo de tarjeta 💳</label>
                        <input type="radio" id="opc_Credito" name="grupo_tipo_tarjeta" value="Credito" checked> Crédito
                        <input type="radio" id="opc_Debito" name="grupo_tipo_tarjeta" value="Debito"> Débito
                    </div>
                    <div class="textos-tarjeta">
                        <!-- Titular de la tarjeta -->
                        <label for="nombreTitular">Nombre titular:</label>
                        <input type="text" id="nombreTitular" name="nombreTitular" required>
                        <!-- Numero de tarjeta -->
                        <label for="tarjeta">Número de tarjeta:</label>
                        <input type="text" id="tarjeta" name="tarjeta" inputmode="numeric" maxlength="16" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}">
                        <!-- Caducidad de tarjeta y CVV -->
                        <div class="caducidad-cvv">
                            <div>
                                <label for="caducidad">Fecha de caducidad:</label>
                                <input type="month" id="caducidad" name="caducidad">
                            </div>
                            <div>
                                <label for="cvv">CVV:</label>
                                <input type="text" id="cvv" name="cvv" inputmode="numeric" maxlength="3">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Columna 2 -->
        <div class="seccion-pago">
            <h4>Selecciona tus entradas</h4>
            <div class="contador">
                <button id="decrementar">-</button>
                    <span id="contador" max="<?php echo $entradasDisponibles; ?>">1</span>
                <button id="incrementar">+</button>
            </div>
            <div class="resumen-pago">
                <span>Precio por entrada: </span><span id="precioEvento"><?php echo $infoCalendario['precio'].'€'; ?></span><br>
                <span>Total a pagar: <span id="totalPagar"></span></span><br>
                <input type="hidden" id="id_evento" name="id_evento" value="<?php echo $infoCalendario['id_evento']; ?>">
                <input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo $idUsuario; ?>">
                <input type="hidden" id="id_calendario" name="id_calendario" value="<?php echo $infoCalendario['id']; ?>">
                <button id="btnPagar">Pagar 🛒</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
