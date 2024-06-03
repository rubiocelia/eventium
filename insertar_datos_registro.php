<?php
// Incluir archivo de conexión a la base de datos
require_once 'conecta.php';
$conexion = getConexion();

// Obtenemos datos del formulario
$username = $_POST['username'];
$password_usuario = $_POST['contrasena']; // Contraseña en texto plano
$nombre_usuario = $_POST['nombre_usuario'];
$apellidos_usuario = $_POST['apellidos_usuario'];
$telefono_usuario = $_POST['telefono_usuario'];
$mail_usuario = $_POST['mail_usuario'];

// Hashing de la contraseña
$password_usuario_hash = password_hash($password_usuario, PASSWORD_DEFAULT);

// Preparamos la consulta SQL para insertar el hash de la contraseña y otros datos
$sql_insert_usuario = "INSERT INTO usuario (username, password_usuario, nombre_usuario, apellidos_usuario, telefono_usuario, mail_usuario) 
                        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql_insert_usuario); // Preparar la sentencia

// Vincular los parámetros a la sentencia
$stmt->bind_param("ssssss", $username, $password_usuario_hash, $nombre_usuario, $apellidos_usuario, $telefono_usuario, $mail_usuario);

// Ejecutar la consulta preparada
if ($stmt->execute()) {
    // Obtenemos el ID del usuario recién insertado
    $id_usuario = $conexion->insert_id;
    
    // Inicio de sesión (si es necesario)
    session_start();
    $_SESSION['id_usuario'] = $id_usuario; // Establecemos el ID del usuario en la sesión

    // Redirigir al usuario a su cuenta
    header("Location: perfil.php");
    exit(); // Finalizar el script para evitar ejecución adicional
} else {
    // Error al insertar en Usuarios
    echo "Error al insertar en Usuarios: " . $stmt->error;
}

// Cerrar sentencia
$stmt->close();

// Cerrar conexión
$conexion->close();
?>
