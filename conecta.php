<?php
function getConexion() {
    $host = "sql109.infinityfree.com"; // Cambia esto al servidor de tu base de datos
    $usuario = "si0_36685265"; // Tu nombre de usuario de la base de datos
    $contrasena = "EventiumMuditos"; // Tu contraseña de la base de datos
    $dbname = "if0_36685265_Eventium"; // El nombre de tu base de datos

    // Realizamos la conexión a MySQL server
    $conexion = new mysqli($host, $usuario, $contrasena);
    // Validamos que la conexión haya salido como esperamos
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Conectamos con la base de datos
    if (!$conexion->select_db($dbname)) {
        die("Error al seleccionar la base de datos: " . $conexion->error);
    }

    return $conexion;
}
?>