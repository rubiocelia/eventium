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
                echo json_encode(['success' => true, 'redirect' => 'perfil.php']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: Contraseña incorrecta.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: Usuario no encontrado.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: Complete todos los campos.']);
        exit;
    }
}
?>
<script src="../eventium/scripts/validar_inicio_sesion.js"></script>
