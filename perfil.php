<?php
   session_start();

   if (!isset($_SESSION['id_usuario'])) {
       header("Location: formulario_inicio_sesion.php");
       exit;
   }
   
   $idUsuario = $_SESSION['id_usuario'];
   
   require_once("conecta.php");
   $conexion = getConexion();
   
   // Obtener datos del usuario
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
   
   // Obtener eventos comprados por el usuario
   $sql_tickets = "
   SELECT e.nombre_evento, ce.fecha, ce.hora, e.url_img, e.ubicacion_evento
   FROM reservaUsuario ru
   JOIN calendarioEvento ce ON ru.id_calendarioEvento = ce.id
   JOIN evento e ON ce.id_evento = e.id_evento
   WHERE ru.usuario_id = ?
   ORDER BY ce.fecha ASC";  // Cambiado de DESC a ASC para ordenar de más cercano a más lejano
   $stmt_tickets = $conexion->prepare($sql_tickets);
   $stmt_tickets->bind_param("i", $idUsuario);
   $stmt_tickets->execute();
   $tickets_resultado = $stmt_tickets->get_result();

   $tickets = [];
   while ($row = $tickets_resultado->fetch_assoc()) {
       $tickets[] = $row;
   }
   
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="miCuenta">
<?php
    // Inicia o continua una sesión existente
    if (session_status() == PHP_SESSION_NONE) {
        // Si no hay sesión activa, iniciar una nueva sesión
        session_start();
    }

    // Verifica si la sesión está iniciada y si $id_usuario está definido
    if (isset($_SESSION['id'])) {
        include('menu_sesion_iniciada.php');
    } else {
        include('menu.php');
    }
    ?>
    <h1 class="bienvenido">Bienvenid@,
        <?php echo htmlspecialchars($usuario['nombre_usuario']); ?>
    </h1>
    <main>
        <div id="menu2">
            <ul>
                <li onclick="mostrarSeccion('perfil')"><i class="fas fa-user icon"></i> Mi perfil</li>
                <li onclick="mostrarSeccion('tickets')"><i class="fas fa-ticket-alt icon"></i> Mis tickets</li>
                <li onclick="mostrarSeccion('calendario')"><i class="fas fa-calendar-alt icon"></i> Mi calendario</li>
                <li onclick="confirmarCerrarSesion()"><img src="./archivos/fotosPerfil/cerrar-sesion.png"
                        alt="Icono de cerrar sesion" class="iconoMenu">Cerrar sesión</li>
            </ul>
        </div>
        <div id="contenido">
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

                            <div class="fila2">
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
                        <!-- mensaje de error -->
                        <div id="errorGeneral" class="error" style="display:none; color: red;"></div>

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
                <div class="filter-buttons">
                    <button onclick="mostrarTickets('futuros')">Ver futuros</button>
                    <button onclick="mostrarTickets('pasados')">Ver pasados</button>
                </div>
                <div class="tickets-container" id="tickets-futuros">
                    <?php
                    foreach ($tickets as $ticket) {
                        $fechaEvento = strtotime($ticket['fecha']);
                        $hoy = time();
                        $diferencia = ($fechaEvento - $hoy) / 86400;
                        if ($fechaEvento >= $hoy) {
                            echo '<div class="ticket">';
                            echo '<img src="' . htmlspecialchars($ticket['url_img']) . '" alt="' . htmlspecialchars($ticket['nombre_evento']) . '" class="ticket-img">';
                            echo '<div class="ticket-info">';
                            echo '<h2>' . htmlspecialchars($ticket['nombre_evento']) . '</h2>';
                            echo '<p>📆 Fecha: ' . htmlspecialchars($ticket['fecha']) . '</p>';
                            echo '<p>🕑 Hora: ' . htmlspecialchars($ticket['hora']) . '</p>';
                            echo '<p>📍 Ubicación: ' . htmlspecialchars($ticket['ubicacion_evento']) . '</p>';
                            if ($diferencia <= 15) {
                                echo '<form action="mostrar_entradas.php" method="GET">';
                                echo '<input type="hidden" name="nombre_evento" value="' . htmlspecialchars($ticket['nombre_evento']) . '">';
                                echo '<input type="hidden" name="fecha" value="' . htmlspecialchars($ticket['fecha']) . '">';
                                echo '<input type="hidden" name="hora" value="' . htmlspecialchars($ticket['hora']) . '">';
                                echo '<input type="hidden" name="ubicacion" value="' . htmlspecialchars($ticket['ubicacion_evento']) . '">';
                                echo '<input type="hidden" name="url_img" value="' . htmlspecialchars($ticket['url_img']) . '">';
                                echo '<button class="btnVer" type="submit">Mostrar tickets</button>';
                                echo '</form>';
                            } else {
                                echo '<p>Entradas disponibles 15 días antes del evento</p>';
                            }
                            echo '</div></div>';
                        }
                    }
                    ?>
                </div>
                <div class="tickets-container" id="tickets-pasados" style="display:none;">
                    <?php
                    foreach ($tickets as $ticket) {
                        $fechaEvento = strtotime($ticket['fecha']);
                        if ($fechaEvento < $hoy) {
                            echo '<div class="ticket ticket-pasado">';
                            echo '<img src="' . htmlspecialchars($ticket['url_img']) . '" alt="' . htmlspecialchars($ticket['nombre_evento']) . '" class="ticket-img">';
                            echo '<div class="ticket-info">';
                            echo '<h2>' . htmlspecialchars($ticket['nombre_evento']) . '</h2>';
                            echo '<p>📆 Fecha: ' . htmlspecialchars($ticket['fecha']) . '</p>';
                            echo '<p>🕑 Hora: ' . htmlspecialchars($ticket['hora']) . '</p>';
                            echo '<p>📍 Ubicación: ' . htmlspecialchars($ticket['ubicacion_evento']) . '</p>';
                            echo '<button class="btnVer" disabled>Mostrar tickets</button>';
                            echo '</div></div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <div id="calendario" class="seccion">
                <h1>Mi calendario</h1>
                <div id="calendar"></div>
            </div>
        </div>
    </main>
    <script src="scripts/scriptPopUp.js"></script>
    <script src="scripts/menuLateral.js"></script>
    <script src="scripts/perfil.js"></script>
    <script src="scripts/botonesPerfil.js"></script>
    <script src="scripts/cerrarSesion.js"></script>
    <?php include('footer.php'); ?>
</body>

</html>