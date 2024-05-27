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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
</head>

<body class="miCuenta">
    <?php include('menu.php'); ?>
    <h1 class="bienvenido">Bienvenid@,
        <?php echo htmlspecialchars($usuario['nombre_usuario']); ?>
    </h1>
    <main>
        <div id="menu2">
            <ul>
                <li onclick="mostrarSeccion('perfil')"><i class="fas fa-user icon"></i> Mi perfil</li>
                <li onclick="mostrarSeccion('tickets')"><i class="fas fa-ticket-alt icon"></i> Mis tickets</li>
                <li onclick="mostrarSeccion('calendario')"><i class="fas fa-calendar-alt icon"></i> Mi calendario</li>
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
            <div id="tickets" class="seccion">
                <h1>Mis tickets</h1>
            </div>

            <div id="calendario" class="seccion">
                <h1>Mi calendario</h1>
                <div id="calendar"></div>
            </div>


        </div>
    </main>
    <script src="./scripts/scriptPopUp.js"></script>
    <script src="scripts/menuLateral.js"></script>
    <script src="scripts/perfil.js"></script>
    <script src="scripts/botonesPerfil.js"></script>
    <?php include('footer.php'); ?>
</body>

</html>