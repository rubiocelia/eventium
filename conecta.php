<?php
function getConexion() {
    $host = "localhost";
    $usuario = "root";
    $contrasena = "rootroot";

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