<?php
session_start();
require_once("conecta.php");

$conexion = getConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['usuario']) ? mysqli_real_escape_string($conexion, $_POST['usuario']) : null;
    $password = isset($_POST['contrasena']) ? mysqli_real_escape_string($conexion, $_POST['contrasena']) : null;

    if ($username && $password) {
        $sql = "SELECT password_usuario FROM usuario WHERE nombre_usuario = '$username'";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password_usuario'])) {
                $_SESSION['usuario'] = $username;
                echo "La contraseña es correcta, bienvenido.";
                exit;
            } else {
                echo "La contraseña no es correcta.";
            }
        } else {
            echo "No se encontró ningún usuario con ese nombre.";
        }
    } else {
        echo "Por favor complete ambos campos.";
    }
    $conexion->close();
} else {
    echo "Acceso no autorizado.";
}
?>