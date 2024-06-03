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
    // Inicia o continua una sesión existente
    if (session_status() == PHP_SESSION_NONE) {
        // Si no hay sesión activa, iniciar una nueva sesión
        session_start();
    }

    // Verifica si la sesión está iniciada y si $id_usuario está definido
    if (isset($_SESSION['id_usuario'])) {
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

        <div class="titFaqs-container">
            <h1 class="titFaqs">Preguntas frecuentes</h1>
        </div>
        <section id="faqs" class="logosFAQS">
            <div class="category" data-category="musical">
                <ion-icon name="musical-notes-outline"></ion-icon>
                <p>Musical</p>
            </div>
            <div class="category" data-category="concierto">
                <ion-icon name="mic-outline"></ion-icon>
                <p>Concierto</p>
            </div>
            <div class="category" data-category="teatro">
                <ion-icon name="ticket-outline"></ion-icon>
                <p>Teatro</p>
            </div>
            <div class="category" data-category="festival">
                <ion-icon name="sparkles-outline"></ion-icon>
                <p>Festival</p>
            </div>
            <div class="category" data-category="exposicion">
                <ion-icon name="images-outline"></ion-icon>
                <p>Exposición</p>
            </div>
            <div class="category" data-category="conferencia">
                <ion-icon name="podium-outline"></ion-icon>
                <p>Conferencia</p>
            </div>
        </section>

        <div id="faqsContent" class="faqs-content" style="display: none;">
            <button id="backToCategories">⬅ Volver atrás</button>

            <div id="musical" class="faq-category">
                <h2>FAQs - Musical</h2>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Qué tipos de musicales hay?</div>
                    <div class="faq-answer">Hay muchos tipos de musicales, incluyendo comedias, dramas, musicales
                        románticos y más.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Necesito experiencia previa para disfrutar de
                        un musical?</div>
                    <div class="faq-answer">No, los musicales están diseñados para ser disfrutados por todo tipo de
                        audiencia.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Hay musicales para niños?</div>
                    <div class="faq-answer">Sí, hay muchos musicales diseñados específicamente para niños y familias.
                    </div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Los musicales son caros?</div>
                    <div class="faq-answer">El precio de las entradas para un musical varía dependiendo del espectáculo
                        y del lugar.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Cuál es la duración típica de un musical?</div>
                    <div class="faq-answer">La duración de los musicales suele ser de entre 2 a 3 horas, incluyendo un
                        intermedio.</div>
                </div>
            </div>

            <div id="concierto" class="faq-category">
                <h2>FAQs - Concierto</h2>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Qué debo llevar a un concierto?</div>
                    <div class="faq-answer">Es recomendable llevar ropa cómoda, dinero en efectivo, y tu entrada.
                        Consulta las normas del evento para saber qué más puedes necesitar.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿A qué hora debo llegar a un concierto?</div>
                    <div class="faq-answer">Se recomienda llegar al menos 30 minutos antes del inicio para encontrar tu
                        asiento y evitar aglomeraciones.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Puedo llevar comida y bebida a un concierto?
                    </div>
                    <div class="faq-answer">Depende del lugar del evento. Generalmente no se permite, pero muchos
                        lugares tienen puestos de comida y bebida.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Hay restricciones de edad para los conciertos?
                    </div>
                    <div class="faq-answer">Algunos conciertos tienen restricciones de edad. Revisa los detalles del
                        evento para más información.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Puedo obtener un reembolso si no puedo asistir
                        al concierto?</div>
                    <div class="faq-answer">La política de reembolsos varía según el evento y el organizador. Revisa la
                        política de reembolsos al momento de comprar tu entrada.</div>
                </div>
            </div>

            <div id="teatro" class="faq-category">
                <h2>FAQs - Teatro</h2>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Cómo debo vestir para una obra de teatro?</div>
                    <div class="faq-answer">No hay un código de vestimenta estricto, pero se recomienda vestir de manera
                        casual elegante.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Puedo llegar tarde a una obra de teatro?</div>
                    <div class="faq-answer">Es mejor llegar a tiempo, ya que llegar tarde puede interrumpir la
                        actuación. Algunos teatros no permiten la entrada una vez iniciada la obra.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Los niños pueden asistir al teatro?</div>
                    <div class="faq-answer">Sí, pero asegúrate de que la obra sea apropiada para su edad.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Puedo tomar fotos durante la obra?</div>
                    <div class="faq-answer">Generalmente no está permitido tomar fotos o grabar durante la obra.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Hay intermedios en las obras de teatro?</div>
                    <div class="faq-answer">Sí, muchas obras de teatro tienen un intermedio de 15 a 20 minutos.</div>
                </div>
            </div>

            <div id="festival" class="faq-category">
                <h2>FAQs - Festival</h2>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Qué debo llevar a un festival?</div>
                    <div class="faq-answer">Lleva ropa cómoda, protector solar, agua, y una mochila ligera. Consulta las
                        normas del festival para saber qué más puedes necesitar.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Puedo salir y volver a entrar al festival?
                    </div>
                    <div class="faq-answer">Depende de la política del festival. Algunos permiten reingreso con una
                        pulsera especial.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Hay cajeros automáticos en el festival?</div>
                    <div class="faq-answer">Muchos festivales tienen cajeros automáticos, pero es mejor llevar algo de
                        efectivo por si acaso.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Puedo llevar mi propia comida y bebida al
                        festival?</div>
                    <div class="faq-answer">Generalmente no se permite, pero muchos festivales tienen una amplia oferta
                        de comida y bebida.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Qué pasa si llueve durante el festival?</div>
                    <div class="faq-answer">La mayoría de los festivales se llevan a cabo llueva o truene. Es
                        recomendable llevar ropa adecuada para la lluvia.</div>
                </div>
            </div>

            <div id="exposicion" class="faq-category">
                <h2>FAQs - Exposición</h2>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Qué tipo de exposiciones hay?</div>
                    <div class="faq-answer">Hay exposiciones de arte, ciencia, historia, tecnología y muchas más.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Necesito comprar entradas con antelación?</div>
                    <div class="faq-answer">Es recomendable, especialmente para exposiciones populares.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Puedo tomar fotos en una exposición?</div>
                    <div class="faq-answer">Depende de la exposición. Algunas permiten fotos sin flash, otras no
                        permiten fotos en absoluto.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Las exposiciones son aptas para niños?</div>
                    <div class="faq-answer">Muchas exposiciones tienen actividades y secciones diseñadas específicamente
                        para niños.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Hay visitas guiadas disponibles?</div>
                    <div class="faq-answer">Sí, muchas exposiciones ofrecen visitas guiadas por un costo adicional.
                    </div>
                </div>
            </div>

            <div id="conferencia" class="faq-category">
                <h2>FAQs - Conferencia</h2>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Qué debo llevar a una conferencia?</div>
                    <div class="faq-answer">Lleva una libreta, un bolígrafo, y tarjetas de presentación para hacer
                        contactos.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Es necesario registrarse previamente?</div>
                    <div class="faq-answer">Sí, la mayoría de las conferencias requieren registro previo.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Hay pausas para el café durante las
                        conferencias?</div>
                    <div class="faq-answer">Sí, la mayoría de las conferencias tienen pausas para el café y el almuerzo.
                    </div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Puedo hacer preguntas durante la conferencia?
                    </div>
                    <div class="faq-answer">Sí, generalmente hay sesiones de preguntas y respuestas al final de cada
                        presentación.</div>
                </div>
                <div class="faq">
                    <div class="faq-question" onclick="toggleFaq(this)">¿Se entrega algún certificado de asistencia?
                    </div>
                    <div class="faq-answer">Muchas conferencias entregan certificados de asistencia al finalizar el
                        evento.</div>
                </div>
            </div>
        </div>


    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
    <script src="./scripts/scriptPopUp.js"></script>
    <script src="./scripts/contacto.js"></script>

</body>

</html>