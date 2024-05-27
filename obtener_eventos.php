<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: formulario_inicio_sesion.php");
    exit;
}

require_once("conecta.php");
$conexion = getConexion();

$idUsuario = $_SESSION['id_usuario'];

$sql = "SELECT e.nombre_evento AS title, ce.fecha AS start, ce.hora AS time
        FROM calendarioEvento ce
        INNER JOIN evento e ON ce.id_evento = e.id_evento
        INNER JOIN reservaUsuario ru ON e.id_evento = ru.id_evento
        WHERE ru.usuario_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

$eventos = [];

while ($fila = $resultado->fetch_assoc()) {
    $eventos[] = [
        'title' => $fila['title'],
        'start' => $fila['start'] . 'T' . $fila['time']
    ];
}

$conexion->close();

header('Content-Type: application/json');
echo json_encode($eventos);
?>