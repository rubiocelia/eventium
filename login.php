<?php
session_start();
require_once("conecta.php");

$conexion = getConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['usuario']) ? mysqli_real_escape_string($conexion, $_POST['usuario']) : null;
    $password = isset($_POST['contrasena']) ? mysqli_real_escape_string($conexion, $_POST['contrasena']) : null;

    if ($username && $password) {
        // Cambio aquí: Usamos 'username' en lugar de 'nombre_usuario'
        $sql = "SELECT id, password_usuario FROM usuario WHERE username = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password_usuario'])) {
                $_SESSION['id_usuario'] = $row['id'];  // Almacenamos el ID del usuario en la sesión
                header("Location: perfil.php");
                exit;
            } else {
                // Mensaje de error por contraseña incorrecta
                echo "<script>alert('La contraseña no es correcta.'); window.location.href = 'index.php';</script>";
            }
        } else {
            // Mensaje de error por no encontrar el usuario
            echo "<script>alert('No se encontró ningún usuario con ese nombre.'); window.location.href = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('Por favor complete ambos campos.'); window.location.href = 'index.php';</script>";
    }
    $conexion->close();
} else {
    echo "<script>alert('Acceso no autorizado.'); window.location.href = 'index.php';</script>";
}

?>