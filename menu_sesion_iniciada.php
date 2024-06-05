<!-- menu.php -->
<?php 
    echo '<link rel="stylesheet" type="text/css" href="css/menuFooter.css">';
    include_once 'conecta.php'; // Incluir archivo de conexión a la base de datos

    // Verificar si el usuario está autenticado
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['id_usuario'])) {
        // Obtener el ID del usuario autenticado
        $idUsuario = $_SESSION['id_usuario'];

        // Realizar consulta para obtener el estado de administrador del usuario
        $conexion = getConexion();
        $query = "SELECT id FROM usuario WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $stmt->bind_result($administrador);
        $stmt->fetch();
        $stmt->close();
        $conexion->close();

        // Determinar la URL de redirección basada en el estado de administrador
        $redirectURL = ($administrador == 1) ? "perfil.php" : "perfil.php";
    } else {
        // Si el usuario no está autenticado, redirigir a la página de inicio de sesión
        $redirectURL = "formulario_inicio_sesion.php";
    }
?>

<header class="header">
    <a href="index.php">
        <img class="logo" src="img/EventiumLogo.png" alt="logo Eventium">
    </a>

    <nav>

        <div class="hamburger" aria-label="Abrir menú">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <ul class="menu">
            <li> <a href="index.php">Inicio</a></li>

            <li> <a href="nosotros.php">Nosotros</a></li>

            <li> <a href="eventos.php">Eventos</a></li>

            <li> <a href="contacto.php">Contacto</a></li>
        </ul>

        <!-- Botones -->
        <div class="inicioRegistro">
            <li class="iniciarSesion" id="loginBtn"><a href="<?php echo $redirectURL; ?>">Mi Cuenta</a></li>
        </div>

    </nav>
</header>