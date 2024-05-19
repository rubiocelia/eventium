<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Equipo</title>
    <link rel="stylesheet" type="text/css" href="css/nosotros.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
</head>

<body>

    <?php include('menu.php'); ?>

    <section class="nosotros">
        <div class="hero">
            <div class="hero-text">
                <h1>Conoce a Nuestro Equipo</h1>
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
            <h2>Lo que hemos logrado</h2>
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

        <!-- <div class="video-promocional">
            <h2>Descubre Más</h2>
            <video controls>
                <source src="video/eventium.mp4" type="video/mp4">
                Tu navegador no soporta el elemento de video.
            </video>
        </div> -->

        <div class="llamado-accion">
            <p>Deja que nuestro equipo cree momentos inolvidables para ti</p>
            <a href="contacto.html" class="btn-accion">Contáctanos</a>
        </div>
    </section>

    <?php include('footer.php'); ?>

    <!-- js -->
    <script src="scripts/scriptPopUp.js"></script>
    <script src="scripts/validacionRegistro.js"></script>
    <script src="scripts/nosotros.js"></script>


</body>

</html>