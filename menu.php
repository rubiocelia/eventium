    <!-- menu.php -->
    <?php echo '<link rel="stylesheet" type="text/css" href="css/menufooter.css">';
    echo '<link rel="stylesheet" type="text/css" href="css/PopUpLoginSignUp.css">';
    ?>
    <header class="header">
        <a href="index.php">
            <img class="logo" src="img/EventiumPNG.png" alt="logo Eventium">
        </a>

        <nav>

            <button class="hamburger" aria-label="Abrir menú">☰</button>

            <ul class="menu">
                <li> <a href="index.php">Inicio</a></li>

                <li> <a href="nosotros.php">Nosotros</a></li>

                <li> <a href="eventos.php">Eventos</a></li>

                <li> <a href="perfil.php">Contacto</a></li>
            </ul>

            <!-- Botones -->
            <div class="inicioRegistro">
                <li class="iniciarSesion" id="loginBtn"><a>Iniciar sesión</a></li>
                <li class="registro" id="registerBtn"><a>Registrarse</a></li>
            </div>

        </nav>

        <!-- Inicio de sesión -->
        <div id="loginPopup" class="popup">
            <div class="popup-content">
                <div class="PanelIzquierdo"><img src="img/FondoLogin.jpg" alt="Fondo del Login"></div>
                <div class="PanelDerecho">
                    <div class="linksReedireccion">
                        <div class="Loginvolver">
                            <a id="volverBtn">
                                ← Atrás</a>
                        </div>
                        <div class="loginJoin"><a id="JoinNow">¡Únete a nosotros!</a></div>
                    </div>
                    <div class="CuerpoLogin">
                        <h2 class="tituloBienvenido">¡BIENVENIDO DE VUELTA!</h2>
                        <h3 class="Subtitulo">Explora y reserva eventos ahora</h3>
                        <form class="FormularioLogin" action="/submit-your-form-handler" method="POST"
                            enctype="multipart/form-data">
                            <div>
                                <input type="text" class="inputLogin" name="Nombre de usuario"
                                    placeholder="Nombre de usuario" required>
                            </div>
                            <div>
                                <input type="password" class="inputLogin" name="contrasena" placeholder="**********"
                                    required>
                            </div>
                            <div class="boton">
                                <button class="botonAcceder" type="submit">Acceder</button>
                            </div>
                        </form>
                    </div>
                </div>
                <span class="close">&times;</span>
            </div>
        </div>

        <!-- Registrarse -->
        <div id="registerPopup" class="popup">
            <div class="popup-content">
                <div class="PanelIzquierdo"><img src="img/FondoLogin.jpg" alt="Fondo del Login"></div>
                <div class="PanelDerecho">
                    <div class="linksReedireccion">
                        <div class="Loginvolver">
                            <a id="volverBtn">
                                ← Atrás</a>
                        </div>
                        <div class="loginJoin">
                            <a id="volverRegistrar"> Inicia sesión aquí si ya tienes una cuenta</a>
                        </div>
                    </div>
                    <div class="CuerpoSign">
                        <h1 class="tituloUnete">¡Prepárate para la aventura!</h1>
                        <h3 class="Subtitulo">Regístrate ahora y empieza a explorar un mundo de eventos</h3>
                        <form class="FormularioRegistro" action="/submit-your-form-handler" method="POST"
                            enctype="multipart/form-data">
                            <div class="formularioRegistroFlex">
                                <div class="columnaPrimeraFormularioRegistro">
                                    <input type="text" class="inputLogin" name="Nombre" placeholder="Nombre" required>
                                    <input type="text" class="inputLogin" name="Apellidos" placeholder="Apellidos"
                                        required>
                                    <input type="email" class="inputLogin" name="correo_electronico"
                                        placeholder="example@email.es" required>
                                </div>
                                <div class="columnaSegundaFormularioRegistro">
                                    <input type="tel" class="inputLogin" name="NumTel" placeholder="Teléfono" required>
                                    <input type="text" class="inputLogin" name="Nombre de usuario"
                                        placeholder="Nombre de usuario" required>
                                    <input type="password" class="inputLogin" name="contrasena" placeholder="Contraseña"
                                        required>

                                </div>
                            </div>
                            <div class="boton">
                                <button class="botonAcceder" type="submit">Acceder</button>
                            </div>
                        </form>
                    </div>
                </div>
                <span class="close">&times;</span>
            </div>
        </div>



    </header>
    </header>