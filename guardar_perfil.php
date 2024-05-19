<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: formulario_inicio_sesion.php");
    exit();
}

require_once("conecta.php");
$conexion = getConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación y saneamiento
    $nombre = isset($_POST['nombre']) ? $conexion->real_escape_string($_POST['nombre']) : null;
    $apellidos = isset($_POST['apellidos']) ? $conexion->real_escape_string($_POST['apellidos']) : null;
    $email = isset($_POST['email']) ? $conexion->real_escape_string($_POST['email']) : null;
    $telefono = isset($_POST['telefono']) ? $conexion->real_escape_string($_POST['telefono']) : null;
    $fecha_nacimiento = isset($_POST['fechaNacimiento']) ? $conexion->real_escape_string($_POST['fechaNacimiento']) : null;
    $username = isset($_POST['username']) ? $conexion->real_escape_string($_POST['username']) : null;

    // Verificar que todos los campos estén presentes
    if ($nombre && $apellidos && $email && $telefono && $fecha_nacimiento && $username) {
        $id_usuario = $_SESSION['id_usuario'];

        // Iniciar una transacción
        $conexion->begin_transaction();

        try {
            // SQL para actualizar los datos del usuario en la tabla Usuarios
            $sqlUpdateUsuario = "UPDATE usuario SET nombre_usuario=?, apellidos_usuario=?, mail_usuario=?, telefono_usuario=?, fecha_nacimiento=?, username=? WHERE id=?";
            $stmtUpdateUsuario = $conexion->prepare($sqlUpdateUsuario);
            if ($stmtUpdateUsuario === false) {
                throw new Exception('Error de preparación SQL para actualizar Usuarios: ' . $conexion->error);
            }

            // Bind de parámetros por referencia
            $stmtUpdateUsuario->bind_param("ssssssi", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $username, $id_usuario);

            // Ejecutar la consulta
            if (!$stmtUpdateUsuario->execute()) {
                throw new Exception('Error al actualizar datos en Usuarios: ' . $stmtUpdateUsuario->error);
            }

            // Manejar la carga de la imagen si existe
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                // Ruta donde se guardarán las imágenes
                $rutaImagenes = './archivos/fotosPerfil/';
                $archivoFoto = $rutaImagenes . basename($_FILES['foto']['name']);
                
                // Obtén la extensión del archivo para verificar si es una imagen
                $tipoArchivo = strtolower(pathinfo($archivoFoto, PATHINFO_EXTENSION));
                
                // Lista de extensiones permitidas
                $extensionesPermitidas = array("jpg", "jpeg", "png", "gif");
                
                if (in_array($tipoArchivo, $extensionesPermitidas)) {
                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $archivoFoto)) {
                        // Actualizar la ruta de la foto en la base de datos
                        $sqlUpdateFoto = "UPDATE usuario SET foto_usuario=? WHERE id=?";
                        $stmtUpdateFoto = $conexion->prepare($sqlUpdateFoto);
                        if ($stmtUpdateFoto === false) {
                            throw new Exception('Error de preparación SQL para actualizar la foto: ' . $conexion->error);
                        }

                        $stmtUpdateFoto->bind_param("si", $archivoFoto, $id_usuario);

                        if (!$stmtUpdateFoto->execute()) {
                            throw new Exception('Error al actualizar la foto en Usuarios: ' . $stmtUpdateFoto->error);
                        }
                        $stmtUpdateFoto->close();
                    } else {
                        throw new Exception('Error al subir el archivo de imagen.');
                    }
                } else {
                    throw new Exception('Formato de archivo no permitido. Solo se permiten imágenes JPG, JPEG, PNG, y GIF.');
                }
            }

            // Confirmar la transacción
            $conexion->commit();
            echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente']);

            // Cerrar las declaraciones preparadas
            $stmtUpdateUsuario->close();
        } catch (Exception $e) {
            $conexion->rollback(); // Si hay un error, deshacer la transacción
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        // Cerrar la conexión
        $conexion->close();
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos.']);
        exit;
    }
}
?>