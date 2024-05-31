<?php
    require_once("conecta.php");

    // Comprobar si los datos esperados están presentes en el cuerpo de la solicitud POST
    if(isset($_POST['idEvento'], $_POST['idCalendario'], $_POST['idUsuario'], $_POST['numEntradas'])) {
        $idEvento = $_POST['idEvento'];
        $idCalendario = $_POST['idCalendario'];
        $idUsuario = $_POST['idUsuario'];
        $numEntradas = $_POST['numEntradas'];

        $conexion = getConexion();
        $sql_insert_reservas = "INSERT INTO reservausuario (id_evento, id_calendarioEvento, usuario_id, numero_entradas) 
            VALUES ('$idEvento', '$idCalendario', '$idUsuario', '$numEntradas')";
        $sql_update_calendario = "UPDATE calendarioevento SET plazasOcupadas = plazasOcupadas + '$numEntradas' WHERE id = '$idCalendario'";
        
        if ($conexion->query($sql_insert_reservas) === TRUE) {
            // La reserva se ha insertado correctamente
            if ($conexion->query($sql_update_calendario) === TRUE) {
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "message" => "Error al actualizar el calendario: " . $conexion->error));
            }
        } else {
            // Ocurrió un error al insertar la reserva
            echo json_encode(array("success" => false, "message" => "Error al realizar la reserva: " . $conexion->error));
        }
        // Cerrar la conexión a la base de datos
        $conexion->close();
    } else {
        // Datos faltantes en la solicitud POST
        echo json_encode(array("success" => false, "message" => "Faltan datos en la solicitud POST."));
    }
?>
