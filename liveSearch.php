<?php
require_once("conecta.php");

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $conexion = getConexion();

   
    // Preparar la consulta SQL para buscar eventos cuyo nombre coincida con la consulta
    $sql = "SELECT id_evento, nombre_evento FROM evento WHERE nombre_evento LIKE ?";
    $stmt = $conexion->prepare($sql); // Preparar la consulta para evitar inyecciones SQL
    $param = '%' . $query . '%'; // Añadir comodines para la búsqueda con LIKE
    $stmt->bind_param("s", $param); // Vincular el parámetro de búsqueda a la consulta
    $stmt->execute(); // Ejecutar la consulta
    $result = $stmt->get_result(); // Obtener el resultado de la consulta

    $events = array(); // Crear un array para almacenar los eventos encontrados
    // Recorrer los resultados de la consulta y añadir cada evento al array
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    $stmt->close();
    $conexion->close();

    echo json_encode($events);
}
?>