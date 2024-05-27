<?php
// Iniciar sesión
session_start();

// Inicializar variables para los datos del usuario
$nombre = "";
$apellidos = "";
$email = "";
$telefono = "";

// Verificar si el ID de usuario está almacenado en la sesión
if (isset($_SESSION['idUsuarioLogin'])) {
    // El ID de usuario está definido en la sesión
    $idUsuario = $_SESSION['idUsuarioLogin'];

    // Obtener los datos del usuario
    require_once("conecta.php");
    $conexion = getConexion();
    $sql = "SELECT * FROM usuario WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idUsuario); // 'i' para indicar que es un entero (ID)
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Obtener los datos del usuario
        $usuario = $resultado->fetch_assoc();
        $nombre = htmlspecialchars($usuario['nombre_usuario']);
        $apellidos = htmlspecialchars($usuario['apellidos_usuario']);
        $email = htmlspecialchars($usuario['mail_usuario']);
        $telefono = htmlspecialchars($usuario['telefono_usuario']);
    } else {
        // No se encontraron resultados, posible manejo de error o redirección
        echo "No se encontró información para el usuario con el ID proporcionado.";
        $conexion->close();
        exit();
    }

    $conexion->close();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="icon" href="./archivos/QQAzul.ico" type="image/x-icon">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="css/contacto.css">
</head>

<body class="contacto">
    <header>
        <?php
        if (isset($_SESSION['idUsuarioLogin'])) {
            include('menu_sesion_iniciada.php');
        } else {
            include('menu.php');
        }
        ?>
    </header>

    <main class="contacto-main">
        <section class="contacto-hero">
            <img src="./archivos/contacto/llamar.png" alt="Logo contacto" class="logoContacto">
            <h1>¡ Contacta con nosotros !</h1>
            <p>Si tienes alguna duda en relación a la plataforma, nuestros servicios o quieres lanzarnos una propuesta,
                no dudes en escribirnos, ¡somos todo oídos!</p>
        </section>


        </section>

        <section class="contacto-formulario">
            <form action="procesar_contacto.php" method="post">
                <div class="form-group">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre..." value="<?php echo $nombre; ?>"
                        required>
                </div>
                <div class="form-group">
                    <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos..."
                        value="<?php echo $apellidos; ?>" required>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Correo electrónico..."
                        value="<?php echo $email; ?>" required>
                </div>
                <div class="form-group">
                    <input type="tel" id="telefono" name="telefono" placeholder="Teléfono..."
                        value="<?php echo $telefono; ?>" required>
                </div>
                <div class="form-group">
                    <textarea id="mensaje" name="mensaje" rows="5" placeholder="¿En qué podemos ayudarte?"
                        required></textarea>
                </div>
                <button class="btnContacto" type="submit">Enviar</button>
            </form>
        </section>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
    <script src="./scripts/scriptPopUp.js"></script>
</body>

</html>