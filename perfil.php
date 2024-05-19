<?php
   session_start();

   if (!isset($_SESSION['id_usuario'])) {
       header("Location: formulario_inicio_sesion.php");
       exit;
   }
   
   $idUsuario = $_SESSION['id_usuario'];
   
   require_once("conecta.php");
   $conexion = getConexion();
   $sql = "SELECT * FROM usuario WHERE id = ?";
   $stmt = $conexion->prepare($sql);
   $stmt->bind_param("i", $idUsuario);
   $stmt->execute();
   $resultado = $stmt->get_result();
   
   if ($resultado->num_rows == 0) {
       echo "No se encontró información para el usuario con el ID proporcionado.";
       $conexion->close();
       exit;
   }
   
   $usuario = $resultado->fetch_assoc();
   $conexion->close();
   
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi perfil</title>
    <link rel="stylesheet" type="text/css" href="css/perfil.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">

</head>

<body class="miCuenta">
    <?php include('menu.php'); ?>
    <h1 class="bienvenido">Bienvenid@,
        <?php echo htmlspecialchars($usuario['nombre_usuario']); ?>
    </h1>
    <main>
        <div id="menu2">
            <ul>
                <!-- <img src="./archivos/perfil/archivo.png" alt="Icono de perfil"
                        class="iconoMenu"> -->
                <li onclick="mostrarSeccion('perfil')">Mi perfil</li>
                <li onclick="mostrarSeccion('servicios')">Mis servicios</li>
                <li onclick="mostrarSeccion('archivos')">Mis archivos</li>
                <li onclick="mostrarSeccion('contacto')">Contacto</li>
            </ul>
        </div>
        <div id="contenido">
            <!-- Sección Mi Perfil -->
            <div id="perfil" class="seccion">
                <h1>Mi perfil</h1>
                <form id="perfilForm" action="guardar_perfil.php" method="post" enctype="multipart/form-data">
                    <div class="perfil">
                        <div class="foto">
                            <img src="<?php echo htmlspecialchars($usuario['foto_usuario']); ?>" alt="Foto de Perfil"
                                class="fotoPerfil">
                            <input type="file" id="foto" name="foto" style="display:none;">
                            <button type="button" id="btnSeleccionarFoto">Cambiar foto</button>
                        </div>

                        <div class="datos">
                            <div class="fila">
                                <div class="campo">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre" name="nombre"
                                        value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" readonly>
                                </div>
                                <div class="campo">
                                    <label for="apellidos">Apellidos:</label>
                                    <input type="text" id="apellidos" name="apellidos"
                                        value="<?php echo htmlspecialchars($usuario['apellidos_usuario']); ?>" readonly>
                                </div>
                                <div class="campo">
                                    <label for="username">Nombre de usuario:</label>
                                    <input type="text" id="username" name="username"
                                        value="<?php echo htmlspecialchars($usuario['username']); ?>" readonly>
                                </div>
                            </div>

                            <div class="fila">
                                <div class="campo">
                                    <label for="email">Correo electrónico:</label>
                                    <input type="email" id="email" name="email"
                                        value="<?php echo htmlspecialchars($usuario['mail_usuario']); ?>" readonly>
                                </div>
                                <div class="campo">
                                    <label for="telefono">Número de teléfono:</label>
                                    <input type="tel" id="telefono" name="telefono"
                                        value="<?php echo htmlspecialchars($usuario['telefono_usuario']); ?>" readonly>
                                </div>
                                <div class="campo">
                                    <label for="fechaNacimiento">Fecha de nacimiento:</label>
                                    <input type="date" id="fechaNacimiento" name="fechaNacimiento"
                                        value="<?php echo htmlspecialchars($usuario['fecha_nacimiento']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="acciones">
                            <button type="button" id="btnModificar">Modificar</button>
                            <button type="submit" id="btnGuardar" style="display:none;">Guardar cambios</button>
                            <button type="button" id="btnCancelar" style="display:none;">Cancelar</button>
                        </div>
                    </div>
                </form>


            </div>
            <div id="servicios" class="seccion">
                <h1>Mis servicios</h1>
            </div>

            <div id="archivos" class="seccion">
                <h1>Mis archivos</h1>
            </div>

            <div id="contacto" class="seccion">
                <h1>Contacto</h1>
                <form action="enviarContacto.php" method="post" class="campoContacto">
                    <div class="contacto">
                        <div class="campoContacto">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" name="name" placeholder="Escribe tu nombre" required>
                        </div>
                        <div class="campoContacto">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
                        </div>
                        <div class="campoContacto">
                            <label for="message">Mensaje:</label>
                            <textarea id="message" name="message" placeholder="Escribe tu mensaje aquí..."
                                required></textarea>
                        </div>
                        <button type="submit" class="btnEnviar">Enviar</button>
                    </div>
                </form>

            </div>
        </div>
    </main>
    <script src="./scripts/scriptPopUp.js"></script>
    <script src="scripts/menuLateral.js"></script>
    <script src="scripts/botonesPerfil.js"></script>
    <?php include('footer.php'); ?>
</body>

</html>