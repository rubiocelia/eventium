<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Equipo</title>
    <link rel="stylesheet" type="text/css" href="css/nosotros.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
</head>

<body>

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

    <section class="nosotros">
        <div class="hero">
            <div class="hero-text">
                <h1>¡Descubre lo que nos hace únicos!</h1>
                <p>La pasión detrás de cada evento inolvidable</p>
            </div>
        </div>

        <div class="MVV">
            <h1>Misión-Visión-Valores</h1>
            <div class="mision-vision-valores">
                <div class="mision">
                    <img src="archivos/nosotros/mision.png" class="logoMisVisVal">
                    <p>Nuestra misión es proporcionar servicios excepcionales de organización de eventos, creando
                        experiencias únicas y memorables para nuestros clientes.

                    </p>
                </div>
                <div class="vision">
                    <img src="archivos/nosotros/vision.png" class="logoMisVisVal">
                    <p>Ser reconocidos como líderes en la industria de eventos, innovando continuamente y superando las
                        expectativas de nuestros clientes.</p>
                </div>
                <div class="valores">
                    <img src="archivos/nosotros/valor.png" class="logoMisVisVal">
                    <p>Nuestros valores fundamentales son la innovación, la creatividad, el compromiso, la pasión y la
                        excelencia en todo lo que hacemos.
                    </p>
                </div>
            </div>
        </div>

        <div class="datos-interactivos">
            <h1>Lo que hemos logrado</h1>
            <div class="infografia">
                <div class="dato">
                    <h3 class="count" data-target="136">0 +</h3>
                    <p>Eventos organizados</p>
                </div>
                <div class="dato">
                    <h3 class="count" data-target="128">0</h3>
                    <p>Clientes satisfechos</p>
                </div>
                <div class="dato">
                    <h3 class="count" data-target="21">0</h3>
                    <p>Años de experiencia</p>
                </div>
                <div class="dato">
                    <h3 class="count" data-target="6569">0</h3>
                    <p>Asistentes felices</p>
                </div>
                <div class="dato">
                    <h3 class="count" data-target="7">0</h3>
                    <p>Sectores diferentes</p>
                </div>
            </div>
        </div>

        <div class="llamado-accion">
            <h1 class="titulo-accion">Deja que nuestro equipo cree momentos inolvidables para ti</h1>
            <p class="subtitulo-accion">¡No esperes más! Haz que tu próximo evento sea épico.</p>
            <a href="contacto.php" class="btn-accion">Contáctanos</a>
        </div>


        <div class="video-promocional">
            <h1>Prepárate para la diversión</h1>
            <div class="videoYtexto">
                <iframe class="videoyt" src="https://www.youtube.com/embed/WEH_QkdjKVc?si=3vk95S9yqtTBhe4H&amp;start=85"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe>

                <div class="txtVideo">

                    <p>Somos tu puerta de entrada a los eventos más increíbles.
                        <br><br>

                        Conciertos, teatros, excursiones... ¡lo tenemos todo! Cada evento es una experiencia única, y
                        estamos aquí para hacerla inolvidable.
                        <br><br>

                        Reserva con nosotros y prepárate para la diversión.
                        <br><br>
                        ¡Únete a la acción y vive momentos espectaculares con Eventium!

                    </p>
                    <a href="eventos.php">Ver eventos...</a>
                </div>
            </div>
        </div>


    </section>

    <?php include('footer.php'); ?>

    <!-- js -->
    <script src="scripts/scriptPopUp.js"></script>
    <script src="scripts/validacionRegistro.js"></script>
    <script src="scripts/nosotros.js"></script>


</body>

</html>