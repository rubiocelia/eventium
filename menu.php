    <!-- menu.php -->
    <?php echo '<link rel="stylesheet" type="text/css" href="css/menufooter.css">';
    echo '<link rel="stylesheet" type="text/css" href="css/PopUpLoginSignUp.css">';
    ?>
    <?php
require_once("conecta.php");

$conexion = getConexion();

// Iniciamos sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Recuperamos la url de destino tras el inicio de sesion
$urlDestino="";
if (isset($_GET['sendTo'])) {
    $urlDestino = $_GET['sendTo'];
}

// Verificamos el inicio de sesión del paciente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperamos la url de destino al hacer login
    $urlDestino= $_POST['sendTo'];
    // Validamos que llamada al metodo POST venga del boton login para realizar el inicio de sesión
    if (isset($_POST['Login'])) {
        // Obtenemos los datos del formulario
        $nombre_usuario = $_POST["nombre_usuario"];
        $password_usuario = $_POST["password_usuario"];

        // Consultamos la base de datos para verificar el inicio de sesión
        $sql_verificar_usuario = "SELECT * FROM usuario WHERE nombre_usuario = ?";
        $stmt = $conexion->prepare($sql_verificar_usuario);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        // Valimos que se hayan devuelto resultados para incluirlos en la sesion
        if ($resultado->num_rows > 0) {
            // Recuperamos los datos del paciente encontrado.
            $datosUsuario = $resultado->fetch_assoc();
            // Verificamos la contraseña
            if (password_verify($password_usuario, $datosUsuario['password_usuario'])) {
                //Contraseña valida - Iniciamos la sesión
                // Inicio de sesión exitoso, almacenamos datos del paciente en la sesión
                $_SESSION["idUsuarioLogin"] = $datosUsuario['NIF'];
                // Redirigimos a la página de perfil incluyendo el ID del usuario en la URL
                if($urlDestino==''){
                    header("Location: index.php");
                } else {
                    header("Location: ".$urlDestino.".php");
                }
                exit();
            } else {
                //Contraseña no valida
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        validarFormularioInicio();
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    validarFormularioInicio();
                });
            </script>";
        }
    }
}

// Cerramos conexión
mysqli_close($conexion);
?>
    <header class="header">
        <a href="index.php">
            <img class="logo" src="img/EventiumLogo.png" alt="logo Eventium">
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
                        <form class="FormularioLogin" action="login.php" method="POST" enctype="multipart/form-data">
                            <div>
                                <input type="text" class="inputLogin" name="usuario" placeholder="Nombre de usuario"
                                    required>
                            </div>
                            <div class="password">
                                <input type="password" class="inputLogin" name="contrasena" placeholder="**********"
                                    required>
                                <img src="./img/ojo_cerrado.png" onclick="togglePasswordRegistro()" class="pass-icon"
                                    id="pass-icon-Registro">
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
        <?php

            $conexion = getConexion();

            // Función para recuperar el id del paciente registrado
            function obtenerIdNewUsuario($userNewUsuario){
                $conexion = getConexion();
                $sql_get_usuario= "SELECT * FROM usuario WHERE username = ?";
                $stmt = $conexion->prepare($sql_get_usuario);
                $stmt->bind_param("s", $userNewUsuario);
                $stmt->execute();
                $resultado = $stmt->get_result();
                $datosUsuario = $resultado->fetch_assoc();
                return $datosUsuario['id'];
            }

            // Verificamos si se ha enviado un formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtenemos datos del formulario
                $username = $_POST['username'];
                $password_usuario = $_POST['password_usuario']; // Contraseña en texto plano
                $nombre_usuario = $_POST['nombre_usuario'];
                $apellidos_usuario = $_POST['apellidos_usuario'];
                $telefono_usuario = $_POST['telefono_usuario'];
                $mail_usuario = $_POST['mail_usuario'];

                // Hashing de la contraseña
                $password_usuario_hash = password_hash($password_usuario, PASSWORD_DEFAULT);

                // Preparamos la consulta SQL para insertar el hash de la contraseña
                $sql_insert_usuario = "INSERT INTO usuario (username, password_usuario, nombre_usuario, apellidos_usuario, telefono_usuario, mail_usuario) 
                                        VALUES (?, ?, ?, ?, ?, ?)";

                // Preparar la sentencia
                if ($stmt = $conexion->prepare($sql_insert_usuario)) {
                    // Vinculamos los parámetros a la sentencia preparada
                    $stmt->bind_param("ssssis", $username, $password_usuario_hash, $nombre_usuario, $apellidos_usuario, $telefono_usuario, $mail_usuario);

                    // Ejecutamos la sentencia preparada
                    if ($stmt->execute()) {
                        $_SESSION["id"] = obtenerIdNewUsuario($username);
                        header("Location: perfil.php");
                        exit();
                    } else {
                        echo "Error al crear el usuario: " . $stmt->error;
                    }

                    // Cerramos la sentencia preparada
                    $stmt->close();
                } else {
                    echo "Error al preparar la consulta: " . $conexion->error;
                }

                // Cerramos conexión
                $conexion->close();
            }
            ?>
        <div id="registerPopup" class="popup">
            <div class="popup-content">
                <div class="PanelIzquierdo"><img src="img/FondoLogin.jpg" alt="Fondo del Login"></div>
                <div class="PanelDerecho">
                    <div class="linksReedireccion">
                        <div class="Loginvolver">
                            <a id="volverBtnRegistrarse">
                                ← Atrás</a>
                        </div>
                        <div class="loginJoin">
                            <a id="loginRedireccion"> Inicia sesión aquí si ya tienes una cuenta</a>
                        </div>
                    </div>
                    <div class="CuerpoSign">
                        <h1 class="tituloUnete">¡Prepárate para la aventura!</h1>
                        <h3 class="Subtitulo">Regístrate ahora y empieza a explorar un mundo de eventos</h3>
                        <form class="FormularioRegistro" action="" method="POST" enctype="multipart/form-data">
                            <div class="formularioRegistroFlex">
                                <div class="columnaPrimeraFormularioRegistro">
                                    <input type="text" class="inputLogin" name="nombre_usuario" placeholder="Nombre"
                                        required>
                                    <input type="text" class="inputLogin" name="apellidos_usuario"
                                        placeholder="Apellidos" required>
                                    <input type="email" class="inputLogin" name="mail_usuario"
                                        placeholder="example@email.es" required>
                                </div>
                                <div class="columnaSegundaFormularioRegistro">
                                    <input type="tel" class="inputLogin" name="telefono_usuario" placeholder="Teléfono"
                                        required>
                                    <input type="text" class="inputLogin" name="username"
                                        placeholder="Nombre de usuario" required>
                                    <input type="password" class="inputLogin" name="password_usuario"
                                        placeholder="Contraseña" required>

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

        <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var passIcon = document.getElementById("pass-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passIcon.src = "./img/ojo_abierto.png";
                passIcon.alt = "Ocultar Contraseña";
            } else {
                passwordInput.type = "password";
                passIcon.src = "./img/ojo_cerrado.png";
                passIcon.alt = "Mostrar Contraseña";
            }
        }

        function togglePasswordRegistro() {
            var passwordInput = document.getElementById("password-Registro");
            var passIcon = document.getElementById("pass-icon-Registro");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passIcon.src = "./img/ojo_abierto.png";
                passIcon.alt = "Ocultar Contraseña";
            } else {
                passwordInput.type = "password";
                passIcon.src = "./img/ojo_cerrado.png";
                passIcon.alt = "Mostrar Contraseña";
            }
        }
        </script>

    </header>
    </header>