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
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
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
                no dudes en escribirnos, ¡somos todo oídos!
                <br><br>
                También puedes encontrar tu solución en nuestra sección de <a href="contacto.php#faqs">preguntas
                    frecuentes</a>.
            </p>
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
                    <textarea id="mensaje" name="mensaje" rows="5" placeholder="Cuéntanos en que podemos ayudarte..."
                        required></textarea>
                </div>
                <button class="btnContacto" type="submit">Enviar</button>
            </form>
        </section>


        <section id="faqs" class="logosFAQS">
            <div class="category" data-category="musical">
                <ion-icon name="musical-notes-outline"></ion-icon>
                <p>Musical</p>
            </div>
            <div class="category" data-category="concierto">
                <img src="path/to/concierto_logo.png" alt="Concierto Logo">
                <p>Concierto</p>
            </div>
            <div class="category" data-category="teatro">
                <img src="path/to/teatro_logo.png" alt="Teatro Logo">
                <p>Teatro</p>
            </div>
            <div class="category" data-category="festival">
                <img src="path/to/festival_logo.png" alt="Festival Logo">
                <p>Festival</p>
            </div>
            <div class="category" data-category="exposicion">
                <img src="path/to/exposicion_logo.png" alt="Exposicion Logo">
                <p>Exposición</p>
            </div>
            <div class="category" data-category="conferencia">
                <img src="path/to/conferencia_logo.png" alt="Conferencia Logo">
                <p>Conferencia</p>
            </div>

            <div id="faqsContent" class="faqs-content" style="display: none;">
                <button id="backToCategories">Volver atrás</button>
                <div id="musical" class="faq-category">
                    <h2>FAQs - Musical</h2>
                    <p>Preguntas frecuentes sobre Musical</p>
                    <!-- Añade aquí las preguntas frecuentes sobre Musical -->
                </div>
                <div id="concierto" class="faq-category">
                    <h2>FAQs - Concierto</h2>
                    <p>Preguntas frecuentes sobre Concierto</p>
                    <!-- Añade aquí las preguntas frecuentes sobre Concierto -->
                </div>
                <div id="teatro" class="faq-category">
                    <h2>FAQs - Teatro</h2>
                    <p>Preguntas frecuentes sobre Teatro</p>
                    <!-- Añade aquí las preguntas frecuentes sobre Teatro -->
                </div>
                <div id="festival" class="faq-category">
                    <h2>FAQs - Festival</h2>
                    <p>Preguntas frecuentes sobre Festival</p>
                    <!-- Añade aquí las preguntas frecuentes sobre Festival -->
                </div>
                <div id="exposicion" class="faq-category">
                    <h2>FAQs - Exposición</h2>
                    <p>Preguntas frecuentes sobre Exposición</p>
                    <!-- Añade aquí las preguntas frecuentes sobre Exposición -->
                </div>
                <div id="conferencia" class="faq-category">
                    <h2>FAQs - Conferencia</h2>
                    <p>Preguntas frecuentes sobre Conferencia</p>
                    <!-- Añade aquí las preguntas frecuentes sobre Conferencia -->
                </div>
            </div>
        </section>

    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
    <script src="./scripts/scriptPopUp.js"></script>
    <script src="./scripts/contacto.js"></script>

</body>

</html>