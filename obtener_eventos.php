<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: formulario_inicio_sesion.php");
    exit;
}

require_once("conecta.php");
$conexion = getConexion();

$idUsuario = $_SESSION['id_usuario'];

$sql = "SELECT e.id_evento AS id, e.nombre_evento AS title, ce.fecha AS start_date, ce.hora AS start_time, e.ubicacion_evento AS location
        FROM calendarioEvento ce
        INNER JOIN evento e ON ce.id_evento = e.id_evento
        INNER JOIN reservaUsuario ru ON ce.id = ru.id_calendarioEvento
        WHERE ru.usuario_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

$eventos = [];

while ($fila = $resultado->fetch_assoc()) {
    $eventos[] = [
        'id' => $fila['id'],
        'title' => $fila['title'],
        'start' => $fila['start_date'] . 'T' . $fila['start_time'],
        'location' => $fila['location']
    ];
}

$conexion->close();

header('Content-Type: application/json');
echo json_encode($eventos);
?>