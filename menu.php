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
    $urlDestino = isset($_POST['sendTo']) ? $_POST['sendTo'] : ''; // Verificamos si 'sendTo' está definido
    // Validamos que llamada al metodo POST venga del boton login para realizar el inicio de sesión
    if (isset($_POST['Login'])) {
        // Obtenemos los datos del formulario
        $nombre_usuario = $_POST["usuario"];
        $password_usuario = $_POST["contrasena"];

        // Consultamos la base de datos para verificar el inicio de sesión
        $sql_verificar_usuario = "SELECT * FROM usuario WHERE username = ?";
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
                                <input type="text" class="inputLogin" name="usuario" placeholder="Nombre de usuario">
                            </div>
                            <div class="password">
                                <input type="password" class="inputLogin" name="contrasena" id="password_usuario" placeholder="**********">
                                <img src="./img/ojo_cerrado.png" onclick="togglePassword()" class="pass-icon"
                                    id="pass-icon">
                            </div>
                            <div class="boton">
                                <button class="botonAcceder" type="submit">Acceder</button>
                            </div>
                            <div class="mensajeError" style="color: red; font-weight: bold;"></div>
                        </form>
                    </div>
                </div>
                <span class="close">&times;</span>
            </div>
        </div>
        <!-- Registro -->
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
                            <a id="loginRedireccion"> ¡Inicia sesión aquí!</a>
                        </div>
                    </div>
                    <div class="CuerpoSign">
                        <h1 class="tituloUnete">¡Prepárate para la aventura!</h1>
                        <h3 class="Subtitulo">Regístrate ahora y empieza a explorar un mundo de eventos</h3>
                        <form class="FormularioRegistro" action="insertar_datos_registro.php" method="POST" enctype="multipart/form-data">
                            <div class="formularioRegistroFlex">
                                <div class="columnaPrimeraFormularioRegistro">
                                    <input type="text" class="inputLogin" name="nombre_usuario" placeholder="Nombre">
                                    <input type="text" class="inputLogin" name="apellidos_usuario"
                                        placeholder="Apellidos">
                                    <input type="email" class="inputLogin" name="mail_usuario" id="mail_usuario"
                                        placeholder="example@email.es">
                                </div>
                                <div class="columnaSegundaFormularioRegistro">
                                    <input type="tel" class="inputLogin" name="telefono_usuario" id="telefono_usuario" placeholder="Teléfono">
                                    <input type="text" class="inputLogin" name="username" id="username"
                                        placeholder="Nombre de usuario">
                                        <div class="password">
                                            <input type="password" class="inputLogin" name="contrasena" id="passwordRegistro" placeholder="**********">
                                            <img src="./img/ojo_cerrado.png" onclick="togglePasswordRegistro()" class="pass-icon-registro"
                                                id="pass-icon-registro">
                                        </div>
                                </div>
                            </div>
                            <div class="boton">
                                <button class="botonAccederRegistro" type="submit">Acceder</button>
                            </div>
                        </form>
                    </div>
                </div>
                <span class="close">&times;</span>
            </div>
        </div>
        <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password_usuario");
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
        var passwordInput = document.getElementById("passwordRegistro");
        var passIcon = document.getElementById("pass-icon-registro");

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
    <script src="../eventium/scripts/validar_registro.js"></script>
    <script src="../eventium/scripts/validar_inicio_sesion.js"></script>
    <script src="../eventium/scripts/hamburguesa.js"></script>
</header>
</header>