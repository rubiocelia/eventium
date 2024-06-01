<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: formulario_inicio_sesion.php");
    exit;
}

require_once("conecta.php");

$idUsuario = $_SESSION['id_usuario'];
$nombreEvento = $_GET['nombre_evento'];
$fechaEvento = $_GET['fecha'];
$horaEvento = $_GET['hora'];
$ubicacionEvento = $_GET['ubicacion'];

// Obtener detalles del usuario desde la base de datos
$conexion = getConexion();
$sql = "SELECT * FROM usuario WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "No se encontró información para el usuario con el ID proporcionado.";
    $conexion->close();
    exit;
}

$usuario = $resultado->fetch_assoc();

// Obtener número de entradas compradas para el evento
$sql_tickets = "
    SELECT SUM(numero_entradas) as num_tickets 
    FROM reservaUsuario 
    WHERE usuario_id = ? 
      AND id_calendarioEvento = (
          SELECT id 
          FROM calendarioEvento 
          WHERE id_evento = (
              SELECT id_evento 
              FROM evento 
              WHERE nombre_evento = ? LIMIT 1
          ) 
          AND fecha = ? 
          AND hora = ?
    )
";
$stmt_tickets = $conexion->prepare($sql_tickets);
$stmt_tickets->bind_param("isss", $idUsuario, $nombreEvento, $fechaEvento, $horaEvento);
$stmt_tickets->execute();
$tickets_resultado = $stmt_tickets->get_result();
$tickets_data = $tickets_resultado->fetch_assoc();
$numTickets = $tickets_data['num_tickets'];

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Entradas para <?php echo htmlspecialchars($nombreEvento); ?></title>
    <link rel="stylesheet" type="text/css" href="css/mostrar_entradas.css">
</head>

<body class="ticket">
    <?php include('menu.php'); ?>
    <a href="perfil.php" class="volver">⬅ Volver</a>

    <div class="container">
        <div class="ticket-info">
            <div class="infoTicket">
                <div class="qr-code">
                    <img src="archivos/tickets/QR.png" alt="Código QR">
                </div>
                <div class="event-details">
                    <h1><?php echo htmlspecialchars($nombreEvento); ?></h1>
                    <p>📆 Fecha: <span><?php echo htmlspecialchars($fechaEvento); ?></span></p>
                    <p>🕑 Hora: <span><?php echo htmlspecialchars($horaEvento); ?></span></p>
                    <p>📍 Ubicación: <span><?php echo htmlspecialchars($ubicacionEvento); ?></span></p>
                    <p>🎟️ Número de entradas: <span><?php echo htmlspecialchars($numTickets); ?></span></p>

                </div>
            </div>
            <div class="user-info">
                <h2>Información del usuario</h2>
                <p>Nombre: <span><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></span></p>
                <p>Correo electrónico: <span><?php echo htmlspecialchars($usuario['mail_usuario']); ?></span></p>
                <p>Teléfono: <span><?php echo htmlspecialchars($usuario['telefono_usuario']); ?></span></p>
            </div>

            <div class="ticket-footer">
                <p><strong>Términos y Condiciones:</strong> La reventa de esta entrada está prohibida. La entrada es
                    válida únicamente para el evento y la fecha indicados. No se permiten cambios ni devoluciones. La
                    organización se reserva el derecho de admisión. Mantén esta entrada en un lugar seguro. No se
                    aceptarán entradas dañadas o alteradas.</p>
                <p>Para más información, visita nuestra página web o contacta con nuestro servicio de atención al
                    cliente.</p>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
    <script src="scripts/scriptPopUp.js"></script>

</body>

</html>