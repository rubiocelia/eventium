<?php
session_start();
require_once("conecta.php");

$conexion = getConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['usuario']) ? mysqli_real_escape_string($conexion, $_POST['usuario']) : null;
    $password = isset($_POST['contrasena']) ? mysqli_real_escape_string($conexion, $_POST['contrasena']) : null;

    if ($username && $password) {
        $sql = "SELECT id, password_usuario FROM usuario WHERE username = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password_usuario'])) {
                $_SESSION['id_usuario'] = $row['id'];
                header("Location: perfil.php");
                exit;
            } else {
                echo "Error: Contraseña incorrecta.";
            }
        } else {
            echo "Error: Usuario no encontrado.";
        }
    } else {
        echo "Error: Complete todos los campos.";
    }
}
?>
