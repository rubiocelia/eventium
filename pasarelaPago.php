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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/pasarelaPago.css">
    <title>Formulario de Pago</title>
</head>
<body>

<div class="container">
    <h2>Formulario de Pago</h2>
    <div class="distribucion-principal">
        <div class="seccion-resumen">
            <div class="info-evento">
                <h3><?php echo $infoCalendario['nombre_evento'];?></h3>
                <span>Fecha: <?php echo $infoCalendario['dia_evento'].'-'.$infoCalendario['nom_mes'].'-'.$infoCalendario['year_evento'];?></span><br>
                <span>Hora: <?php echo $infoCalendario['hora'];?></span>
            </div>
            <div class="info-usuario">
                <h3>Información Titular reserva</h3>
                <span>UserName: <?php echo $infoUsuario['username'];?></span><br>
                <span>Nombre: <?php echo $infoUsuario['nombre_usuario'].' '.$infoUsuario['apellidos_usuario'];?></span><br>
                <span>Email: <?php echo $infoUsuario['mail_usuario'];?></span><br>
                <span>Telefono: <?php echo $infoUsuario['telefono_usuario'];?></span><br>
            </div>
            <div class="datos-tareja">
            </div>
        </div>
        <div class="seccion-pago">
        <?php echo $id_calendario; ?>
        </div>
    </div>
    <form action="#" method="post">
        <div class="form-group">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="telefono">Número de Teléfono</label>
            <input type="tel" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección de Envío</label>
            <input type="text" id="direccion" name="direccion" required>
        </div>
        <div class="form-group">
            <label for="tarjeta">Número de Tarjeta de Crédito</label>
            <input type="text" id="tarjeta" name="tarjeta" required>
        </div>
        <div class="form-group">
            <label for="expiracion">Fecha de Expiración (MM/AA)</label>
            <input type="text" id="expiracion" name="expiracion" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="number" id="cvv" name="cvv" required>
        </div>
        <input type="submit" value="Pagar">
    </form>
</div>

</body>
</html>
