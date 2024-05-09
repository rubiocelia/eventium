<?php
require_once("conecta.php");

$conexion = getConexion();
$telefono_usuario = $_POST['telefono_usuario'];
$mail_usuario = $_POST['mail_usuario'];
$username = $_POST['username'];

$response = ['telefono_usuario' => false, 'mail_usuario' => false, 'username' => false];

// Verificación del teléfono
$result = $conexion->query("SELECT id FROM usuario WHERE telefono_usuario = '$telefono_usuario'");
if ($result->num_rows > 0) {
    $response['telefono_usuario'] = true;
}

// Verificación del correo
$result = $conexion->query("SELECT id FROM usuario WHERE mail_usuario = '$mail_usuario'");
if ($result->num_rows > 0) {
    $response['mail_usuario'] = true;
}

// Verificación del usuario
$result = $conexion->query("SELECT id FROM usuario WHERE username = '$username'");
if ($result->num_rows > 0) {
    $response['username'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>