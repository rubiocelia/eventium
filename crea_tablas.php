<?php
require_once("conecta.php");

$conexion = getConexion();

//fución para crear las tablas y bbdd
function crearTablas($conexion) {
    
    // Verificar si la base de datos existe
    $verificarBD = $conexion->query("SHOW DATABASES LIKE 'Eventium'");
    if ($verificarBD->num_rows <= 0) {
        // Crear la base de datos si no existe
        if (!$conexion->query("CREATE DATABASE Eventium")) {
            die("Error al crear la base de datos: " . $conexion->error);
        }
        //agrega la conexión a la base de datos
        $conexion->select_db("Eventium");
    } else {
        $conexion->query("DROP DATABASE Eventium");
        $conexion->query("CREATE DATABASE Eventium");
        $conexion->select_db("Eventium");
    }
}
crearTablas($conexion);
// Creamos tablas si no existen
$sql_createUsuario = "CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    nombre_usuario VARCHAR(255)  NULL,
    apellidos_usuario VARCHAR(255) NULL,
    mail_usuario VARCHAR(255) NULL,
    telefono_usuario VARCHAR(255) NULL,
    fecha_nacimiento DATE NULL,
    password_usuario VARCHAR(500) NULL,
    foto_usuario VARCHAR(255)
)";
// Crear TipoEvento
$sql_createTipoEvento = "CREATE TABLE IF NOT EXISTS tipoEvento (
    id INT PRIMARY KEY,
    nombre_tipoEvento VARCHAR(255)  NULL
)";

//Crear CategoriaEvento
$sql_createCategoriaEvento = "CREATE TABLE IF NOT EXISTS categoriaEvento (
    id INT PRIMARY KEY,
    nombre_categoriaEvento VARCHAR(255)  NULL
)";

// Crear Evento
$sql_createEvento = "CREATE TABLE IF NOT EXISTS evento (
    id_evento INT PRIMARY KEY,
    nombre_evento VARCHAR(255)  NULL,
    descripcion_evento VARCHAR(1000) NULL,
    url_maps VARCHAR(1500) NULL,
    ubicacion_evento  VARCHAR(255) NULL,
    edad_evento  VARCHAR(255) NULL,
    duracion_evento  VARCHAR(255) NULL,
    id_tipoEvento INT NOT NULL,
    url_img VARCHAR(1500) NULL,
    FOREIGN KEY (id_tipoEvento) REFERENCES tipoEvento(id)
)";

// Crear Relacion Categoria Evento
$sql_createRelCatEve = "CREATE TABLE IF NOT EXISTS relacionCatEven (
    id INT PRIMARY KEY,
    id_categoriaEvento INT NOT NULL,
    id_evento INT NOT NULL,
    FOREIGN KEY (id_categoriaEvento) REFERENCES categoriaEvento(id),
    FOREIGN KEY (id_evento) REFERENCES evento(id_evento)
)";

// Crear Calendario Evento
$sql_createCalendarioEvento = "CREATE TABLE IF NOT EXISTS calendarioEvento (
    id INT PRIMARY KEY,
    id_evento INT NOT NULL,
    fecha DATE NULL,
    hora VARCHAR(255) NULL,
    totalPlazas int null,
    plazasOcupadas int null,
    precio VARCHAR(255) NULL,
    FOREIGN KEY (id_evento) REFERENCES evento(id_evento)
)";

// Crear Reserva Usuario
$sql_createReservaUsuario = "CREATE TABLE IF NOT EXISTS reservaUsuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    id_calendarioEvento INT NULL,
    usuario_id INT NOT NULL,
    FOREIGN KEY (id_evento) REFERENCES evento(id_evento),
    FOREIGN KEY (id_calendarioEvento) REFERENCES calendarioEvento(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
)";

// Crear Opiniones Evento
$sql_createOpinionEvento = "CREATE TABLE IF NOT EXISTS opinionEvento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    usuario_id INT NOT NULL,
    fecha DATE NULL,
    numPuntuacion INT NULL,
    txt_opinion varchar(1000) NULL,
    FOREIGN KEY (id_evento) REFERENCES evento(id_evento),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
)";


// Ejecutamos consultas
if ($conexion->query($sql_createUsuario) === TRUE) {
    echo "Tabla 'usuario' creada con éxito.<br>";
} else {
    echo "Error al crear la tabla 'usuario': " . $conexion->error . "<br>";
}

if ($conexion->query($sql_createTipoEvento) === TRUE) {
    echo "Tabla 'tipoEvento' creada con éxito.<br>";
} else {
    echo "Error al crear la tabla 'tipoEvento': " . $conexion->error . "<br>";
}

if ($conexion->query($sql_createCategoriaEvento) === TRUE) {
    echo "Tabla 'categoriaEvento' creada con éxito.<br>";
} else {
    echo "Error al crear la tabla 'categoriaEvento': " . $conexion->error . "<br>";
}

if ($conexion->query($sql_createEvento) === TRUE) {
    echo "Tabla 'evento' creada con éxito.<br>";
} else {
    echo "Error al crear la tabla 'evento': " . $conexion->error . "<br>";
}

if ($conexion->query($sql_createRelCatEve) === TRUE) {
    echo "Tabla 'relacionCatEven' creada con éxito.<br>";
} else {
    echo "Error al crear la tabla 'relacionCatEven': " . $conexion->error . "<br>";
}

if ($conexion->query($sql_createCalendarioEvento) === TRUE) {
    echo "Tabla 'calendarioEvento' creada con éxito.<br>";
} else {
    echo "Error al crear la tabla 'calendarioEvento': " . $conexion->error . "<br>";
}

if ($conexion->query($sql_createReservaUsuario) === TRUE) {
    echo "Tabla 'reservaUsuario' creada con éxito.<br>";
} else {
    echo "Error al crear la tabla 'reservaUsuario': " . $conexion->error . "<br>";
}

if ($conexion->query($sql_createOpinionEvento) === TRUE) {
    echo "Tabla 'opinionEvento' creada con éxito.<br>";
} else {
    echo "Error al crear la tabla 'opinionEvento': " . $conexion->error . "<br>";
}

// Insertamos datos iniciales
echo "--------------------------------------------------------------------------<br>";

// *** Preparamos los HASH de las contraseñas de los usuario de prueba
$passUser1= password_hash('12345678', PASSWORD_DEFAULT);
$passUser2= password_hash('12345678', PASSWORD_DEFAULT);
$passUser3= password_hash('12345678', PASSWORD_DEFAULT);
$passUser4= password_hash('12345678', PASSWORD_DEFAULT);
$passUser5= password_hash('12345678', PASSWORD_DEFAULT);
$passUser6= password_hash('12345678', PASSWORD_DEFAULT);

// Sentencia INSERT - Tabla [usuario]
$sql_ins_usuario = "INSERT INTO usuario (username, nombre_usuario, apellidos_usuario, mail_usuario, telefono_usuario, fecha_nacimiento, password_usuario, foto_usuario) VALUES
( 'juanpg', 'Juan', 'González Pérez', 'juan.gonzalez@gmail.com', '654123456', '1990-05-15', '$passUser1','./archivos/fotosPerfil/foto1.jpg' ),
( 'mariaml', 'María', 'Martínez López', 'maria.martinez@hotmail.com', '612345678', '1985-08-22', '$passUser2','./archivos/fotosPerfil/foto1.jpg' ),
( 'pedroSanchez', 'Pedro', 'Sánchez García', 'pedro.sanchez@outlook.es', '634567891', '1993-02-10', '$passUser3','./archivos/fotosPerfil/foto1.jpg' ),
( 'aanarodrig', 'Ana', 'Rodríguez Martín', 'ana.rodriguez@gmail.com', '678912345', '1988-11-30', '$passUser4','./archivos/fotosPerfil/foto1.jpg' ),
( 'lauFern', 'Laura', 'Fernández Ruiz', 'laura.fernandez@hotmail.com', '678345678', '1997-07-05', '$passUser5' ,'./archivos/fotosPerfil/foto1.jpg'),
( 'carlopz', 'Carlos', 'López Hernández', 'carlos.lopez@outlook.es', '612345678', '1983-04-18', '$passUser6','./archivos/fotosPerfil/foto1.jpg' )";
// Sentencia INSERT - Tabla [tipoEvento]
$sql_ins_tipoEvento = "INSERT INTO tipoEvento (id,nombre_tipoEvento) VALUES
( 1, 'Musical' ),
( 2, 'Concierto' ),
( 3, 'Teatro' ),
( 4, 'Festival' ),
( 5, 'Exposición' ),
( 6, 'Conferencia' )";

// Sentencia INSERT - Tabla [categoriaEvento]
$sql_ins_categoriaEvento = "INSERT INTO categoriaEvento (id,nombre_categoriaEvento) VALUES
( 1, 'Planes en Familia' ),
( 2, 'Fiestas de Verano' ),
( 3, 'Noches Culturales' ),
( 4, 'Eventos al Aire Libre' ),
( 5, 'Conciertos y Espectáculos' ),
( 6, 'Planes de Pareja' )";
// Sentencia INSERT - Tabla [evento]
$sql_ins_evento = "INSERT INTO evento (id_evento,nombre_evento,descripcion_evento,url_maps,ubicacion_evento,edad_evento,duracion_evento,id_tipoEvento, url_img) VALUES
( 1, 'Concierto en el Parque', 'Disfruta de una tarde llena de música en vivo con artistas locales.', 'https://maps.google.com/?q=Parque+Central', 'Parque Central', 'Todas las edades', '3 horas', 1, 'img/imgEventos/conciertoenelparqe.jpg'),
( 2, 'Explosión de Rock', 'Un concierto lleno de energía con bandas locales de rock.', 'https://maps.google.com/?q=Teatro+Municipal', 'Teatro Municipal', 'Mayores de 18 años', '4 horas', 2, 'img/imgEventos/explosionderock.jpg'),
( 3, 'Romeo y Julieta', 'Una representación conmovedora de la clásica obra de Shakespeare.', 'https://maps.google.com/?q=Teatro+Nacional', 'Teatro Nacional', 'Todas las edades', '2 horas', 3, 'img/imgEventos/romeoyjulieta.jpg'),
( 4, 'Jazz en el Parque', 'Disfruta de una noche mágica de jazz bajo las estrellas.', 'https://maps.google.com/?q=Parque+de+la+Ciudad', 'Parque de la Ciudad', 'Todas las edades', '5 horas', 1, 'img/imgEventos/jazzenelparque.jpg'),
( 5, 'Caliente Latino', 'Una fiesta de ritmos latinos con artistas internacionales.', 'https://maps.google.com/?q=Estadio+Municipal', 'Estadio Municipal', 'Mayores de 21 años', '6 horas', 2, 'img/imgEventos/calientelatino.jpg'),
( 6, 'Noche de Risas', 'Una noche llena de humor con los mejores comediantes de la ciudad.', 'https://maps.google.com/?q=Club+de+la+Comedia', 'Club de la Comedia', 'Mayores de 16 años', '2 horas', 3, 'img/imgEventos/nochederisas.jpg'),
( 7, 'Sunset Rave', 'Vive una experiencia única con DJs internacionales en la playa al atardecer.', 'https://maps.google.com/?q=Playa+Principal', 'Playa Principal', 'Mayores de 18 años', '8 horas', 1, 'img/imgEventos/sunsetrave.jpg'),
( 8, 'Sinfonía en Do Mayor', 'Disfruta de la majestuosidad de la música clásica interpretada por una orquesta sinfónica.', 'https://maps.google.com/?q=Auditorio+Nacional', 'Auditorio Nacional', 'Todas las edades', '3 horas', 2, 'img/imgEventos/sinfoniaendomayor.jpg'),
( 9, 'Travesía Fantástica', 'Una obra de teatro que desafía los límites de la realidad y la imaginación.', 'https://maps.google.com/?q=Centro+Cultural', 'Centro Cultural', 'Mayores de 12 años', '2 horas', 3, 'img/imgEventos/traveisafantastica.jpg'),
( 10, 'Reggae Roots', 'Sumérgete en el ambiente relajado y los ritmos contagiosos del reggae en medio del bosque.', 'https://maps.google.com/?q=Bosque+Nacional', 'Bosque Nacional', 'Mayores de 18 años', '7 horas', 1, 'img/imgEventos/reggaeroots.jpg'),
( 11, 'Festival de Verano', 'Un festival lleno de actividades, música y diversión para toda la familia.', 'https://maps.google.com/?q=Plaza+Mayor', 'Plaza Mayor', 'Todas las edades', '8 horas', 4, 'img/imgEventos/festivaldeverano.jpg'),
( 12, 'Exposición de Arte Moderno', 'Explora las obras de los artistas modernos más influyentes.', 'https://maps.google.com/?q=Museo+de+Arte+Moderno', 'Museo de Arte Moderno', 'Todas las edades', '5 horas', 5, 'img/imgEventos/exposiciondeartemoderno.jpg'),
( 13, 'Conferencia sobre Tecnología', 'Un evento para conocer las últimas tendencias en tecnología.', 'https://maps.google.com/?q=Centro+de+Convenciones', 'Centro de Convenciones', 'Mayores de 18 años', '4 horas', 6, 'img/imgEventos/conferenciasobretecnologia.jpg'),
( 14, 'Noche de Magia', 'Déjate sorprender por los mejores ilusionistas del país.', 'https://maps.google.com/?q=Teatro+Magico', 'Teatro Mágico', 'Todas las edades', '2.5 horas', 3, 'img/imgEventos/nochedemagia.jpg'),
( 15, 'Danza Contemporánea', 'Una espectacular presentación de danza moderna.', 'https://maps.google.com/?q=Centro+de+Artes+Escenicas', 'Centro de Artes Escénicas', 'Todas las edades', '2 horas', 1, 'img/imgEventos/danzaconteporanea.jpg'),
( 16, 'Cine al Aire Libre', 'Disfruta de tus películas favoritas bajo las estrellas.', 'https://maps.google.com/?q=Parque+Cine', 'Parque Cine', 'Todas las edades', '3 horas', 4, 'img/imgEventos/cinealairelibre.jpg'),
( 17, 'Feria de Libros', 'Una feria con las últimas novedades literarias y encuentros con autores.', 'https://maps.google.com/?q=Feria+del+Libro', 'Feria del Libro', 'Todas las edades', '6 horas', 5, 'img/imgEventos/feriadelibros.webp'),
( 18, 'Cena Romántica en el Lago', 'Disfruta de una cena exclusiva con tu pareja junto al lago.', 'https://maps.google.com/?q=Restaurante+Lago', 'Restaurante Lago', 'Mayores de 18 años', '3 horas', 4, 'img/imgEventos/cenaromanticaenellago.jpg'),
( 19, 'Paseo en Globo al Atardecer', 'Vive una experiencia inolvidable con un paseo en globo al atardecer.', 'https://maps.google.com/?q=Campo+Abierto', 'Campo Abierto', 'Todas las edades', '2 horas', 4, 'img/imgEventos/paseoenglobo.jpg'),
( 20, 'Spa y Relajación para Parejas', 'Un día de relajación en un spa de lujo para parejas.', 'https://maps.google.com/?q=Spa+Centro', 'Spa Centro', 'Mayores de 18 años', '5 horas', 5, 'img/imgEventos/spayrelajacionparaprejas.jpg')";

// Sentencia INSERT - Tabla [relacionCatEven]
$sql_ins_relacionCatEven = "INSERT INTO relacionCatEven (id,id_categoriaEvento,id_evento) VALUES
( 1, 1, 1),
( 2, 4, 1),
( 3, 2, 2),
( 4, 5, 2),
( 5, 3, 3),
( 6, 1, 4),
( 7, 4, 4),
( 8, 5, 5),
( 9, 2, 5),
( 10, 3, 6),
( 11, 1, 6),
( 12, 4, 7),
( 13, 5, 7),
( 14, 2, 8),
( 15, 3, 8),
( 16, 3, 9),
( 17, 5, 10),
( 18, 4, 10),
( 19, 1, 11),
( 20, 2, 12),
( 21, 3, 12),
( 22, 4, 13),
( 23, 5, 13),
( 24, 1, 14),
( 25, 4, 15),
( 26, 3, 15),
( 27, 1, 16),
( 28, 4, 16),
( 29, 5, 17),
( 30, 3, 17),
( 31, 6, 18),
( 32, 6, 19),
( 33, 6, 20)";
// Sentencia INSERT - Tabla [calendarioEvento]
$sql_ins_calendarioEvento = "INSERT INTO calendarioEvento (id,id_evento,fecha,hora,totalPlazas,plazasOcupadas,precio) VALUES
( 1, 1, '2024-05-15', '18:00', 100, 80, '20.00' ),
( 2, 1, '2024-05-15', '20:00', 100, 90, '20.00' ),
( 3, 1, '2024-05-22', '18:00', 100, 70, '20.00' ),
( 4, 1, '2024-05-22', '20:00', 100, 60, '20.00' ),
( 5, 1, '2024-05-29', '18:00', 100, 90, '20.00' ),
( 6, 1, '2024-05-29', '20:00', 100, 85, '20.00' ),
( 7, 2, '2024-06-05', '19:00', 150, 120, '25.00' ),
( 8, 2, '2024-06-05', '21:00', 150, 130, '25.00' ),
( 9, 2, '2024-06-12', '19:00', 150, 130, '25.00' ),
( 10, 2, '2024-06-12', '21:00', 150, 140, '25.00' ),
( 11, 3, '2024-06-19', '19:30', 80, 60, '15.00' ),
( 12, 3, '2024-06-19', '21:30', 80, 50, '15.00' ),
( 13, 3, '2024-06-26', '19:30', 80, 70, '15.00' ),
( 14, 3, '2024-06-26', '21:30', 80, 60, '15.00' ),
( 15, 4, '2024-07-03', '19:00', 120, 100, '18.00' ),
( 16, 4, '2024-07-03', '21:00', 120, 95, '18.00' ),
( 17, 4, '2024-07-10', '19:00', 120, 110, '18.00' ),
( 18, 4, '2024-07-10', '21:00', 120, 105, '18.00' ),
( 19, 5, '2024-07-17', '20:00', 200, 180, '30.00' ),
( 20, 5, '2024-07-17', '22:00', 200, 190, '30.00' ),
( 21, 5, '2024-07-24', '20:00', 200, 190, '30.00' ),
( 22, 5, '2024-07-24', '22:00', 200, 195, '30.00' ),
( 23, 6, '2024-07-31', '20:30', 80, 70, '22.00' ),
( 24, 6, '2024-07-31', '22:30', 80, 60, '22.00' ),
( 25, 6, '2024-08-07', '20:30', 80, 60, '22.00' ),
( 26, 6, '2024-08-07', '22:30', 80, 55, '22.00' ),
( 27, 7, '2024-08-14', '18:30', 150, 140, '35.00' ),
( 28, 7, '2024-08-14', '20:30', 150, 135, '35.00' ),
( 29, 7, '2024-08-21', '18:30', 150, 130, '35.00' ),
( 30, 7, '2024-08-21', '20:30', 150, 125, '35.00' ),
( 31, 8, '2024-08-28', '19:00', 100, 90, '28.00' ),
( 32, 8, '2024-08-28', '21:00', 100, 85, '28.00' ),
( 33, 8, '2024-09-04', '19:00', 100, 80, '28.00' ),
( 34, 8, '2024-09-04', '21:00', 100, 75, '28.00' ),
( 35, 9, '2024-09-11', '20:00', 90, 80, '20.00' ),
( 36, 9, '2024-09-11', '22:00', 90, 70, '20.00' ),
( 37, 9, '2024-09-18', '20:00', 90, 70, '20.00' ),
( 38, 9, '2024-09-18', '22:00', 90, 65, '20.00' ),
( 39, 10, '2024-09-25', '22:00', 150, 130, '25.00' ),
( 40, 10, '2024-09-25', '00:00', 150, 135, '25.00' ),
( 41, 10, '2024-10-02', '22:00', 150, 140, '25.00' ),
( 42, 10, '2024-10-02', '00:00', 150, 145, '25.00' ),
( 43, 11, '2024-10-09', '10:00', 300, 250, '50.00' ),
( 44, 11, '2024-10-09', '12:00', 300, 260, '50.00' ),
( 45, 12, '2024-10-16', '10:00', 200, 180, '15.00' ),
( 46, 12, '2024-10-16', '12:00', 200, 170, '15.00' ),
( 47, 13, '2024-10-23', '09:00', 100, 80, '45.00' ),
( 48, 13, '2024-10-23', '11:00', 100, 85, '45.00' ),
( 49, 14, '2024-11-01', '18:00', 120, 100, '20.00' ),
( 50, 14, '2024-11-01', '20:00', 120, 105, '20.00' ),
( 51, 14, '2024-11-08', '18:00', 120, 110, '20.00' ),
( 52, 14, '2024-11-08', '20:00', 120, 115, '20.00' ),
( 53, 15, '2024-11-15', '19:00', 150, 140, '25.00' ),
( 54, 15, '2024-11-15', '21:00', 150, 135, '25.00' ),
( 55, 15, '2024-11-22', '19:00', 150, 130, '25.00' ),
( 56, 15, '2024-11-22', '21:00', 150, 125, '25.00' ),
( 57, 16, '2024-11-29', '20:00', 200, 180, '15.00' ),
( 58, 16, '2024-11-29', '22:00', 200, 170, '15.00' ),
( 59, 16, '2024-12-06', '20:00', 200, 160, '15.00' ),
( 60, 16, '2024-12-06', '22:00', 200, 150, '15.00' ),
( 61, 17, '2024-12-13', '10:00', 500, 450, '10.00' ),
( 62, 17, '2024-12-13', '12:00', 500, 460, '10.00' ),
( 63, 17, '2024-12-20', '10:00', 500, 470, '10.00' ),
( 64, 17, '2024-12-20', '12:00', 500, 480, '10.00' ),
( 65, 18, '2024-12-27', '19:00', 50, 40, '100.00'),
( 66, 18, '2024-12-27', '21:00', 50, 35, '100.00'),
( 67, 19, '2024-12-30', '18:00', 30, 25, '200.00'),
( 68, 19, '2024-12-30', '20:00', 30, 20, '200.00'),
( 69, 20, '2024-12-31', '09:00', 40, 35, '150.00'),
( 70, 20, '2024-12-31', '13:00', 40, 30, '150.00')";
// Sentencia INSERT - Tabla [opinionEvento]
$sql_ins_opinionEvento = "INSERT INTO opinionEvento (id_evento,usuario_id,fecha,numPuntuacion,txt_opinion) VALUES
( 1, '2', '2023-04-01', 4, '¡Gran concierto, lo disfruté mucho!' ),
( 1, '6', '2023-05-03', 5, 'Increíble experiencia, definitivamente volvería.' ),
( 1, '1', '2023-06-05', 4, 'Muy buen ambiente y excelente música.' ),
( 1, '3', '2023-07-07', 4, 'Me gustó mucho, pero esperaba un poco más de variedad en el repertorio.' ),
( 2, '4', '2023-08-10', 3, 'Buen concierto, aunque hubo problemas de sonido.' ),
( 2, '5', '2023-09-12', 4, 'Me lo pasé bien, pero el lugar estaba un poco abarrotado.' ),
( 2, '2', '2023-10-15', 5, '¡Fantástico evento! La organización fue impecable.' ),
( 3, '6', '2023-11-20', 3, 'El teatro era encantador, pero la obra no me convenció del todo.' ),
( 3, '1', '2023-12-25', 4, 'Buena interpretación de los actores, pero la trama me dejó un poco indiferente.' ),
( 3, '3', '2023-01-27', 5, '¡Increíble! Me emocionó de principio a fin.' ),
( 3, '4', '2023-02-01', 4, 'Me encantó, pero creo que la duración podría haber sido un poco más corta.' ),
( 6, '5', '2023-03-20', 5, '¡Espectacular! Me encantó cada momento.' ),
( 6, '2', '2023-04-22', 4, 'Una experiencia maravillosa.' ),
( 6, '6', '2023-05-25', 5, 'Increíble actuación y una historia cautivadora.' ),
( 4, '4', '2023-06-27', 2, 'No fue lo que esperaba, me decepcionó.' ),
( 5, '3', '2023-07-01', 1, 'Muy malo, no lo recomendaría a nadie.' )";
// Sentencia INSERT - Tabla [reservaUsuario]
$sql_ins_reservaUsuario = "INSERT INTO reservaUsuario (id_evento,id_calendarioEvento,usuario_id) VALUES
( 1, 1, '2' ),
( 2, 8, '6' ),
( 3, 11, '1' ),
( 4, 15, '3' ),
( 5, 19, '4' ),
( 6, 23, '5' ),
( 1, 4, '2' )";

if ($conexion->query($sql_ins_usuario) === TRUE) {
    echo "Datos de prueba insertados con éxito [Tabla - usuario].<br>";
} else {
    echo "Error al insertar datos de prueba [Tabla - usuario]: " . $conexion->error . "<br>";
}
if ($conexion->query($sql_ins_tipoEvento) === TRUE) {
    echo "Datos de prueba insertados con éxito [Tabla - tipoEvento].<br>";
} else {
    echo "Error al insertar datos de prueba [Tabla - tipoEvento]: " . $conexion->error . "<br>";
}
if ($conexion->query($sql_ins_categoriaEvento) === TRUE) {
    echo "Datos de prueba insertados con éxito [Tabla - categoriaEvento].<br>";
} else {
    echo "Error al insertar datos de prueba [Tabla - categoriaEvento]: " . $conexion->error . "<br>";
}
if ($conexion->query($sql_ins_evento) === TRUE) {
    echo "Datos de prueba insertados con éxito [Tabla - evento].<br>";
} else {
    echo "Error al insertar datos de prueba [Tabla - evento]: " . $conexion->error . "<br>";
}
if ($conexion->query($sql_ins_relacionCatEven) === TRUE) {
    echo "Datos de prueba insertados con éxito [Tabla - relacionCatEven].<br>";
} else {
    echo "Error al insertar datos de prueba [Tabla - relacionCatEven]: " . $conexion->error . "<br>";
}
if ($conexion->query($sql_ins_calendarioEvento) === TRUE) {
    echo "Datos de prueba insertados con éxito [Tabla - calendarioEvento].<br>";
} else {
    echo "Error al insertar datos de prueba [Tabla - calendarioEvento]: " . $conexion->error . "<br>";
}
if ($conexion->query($sql_ins_opinionEvento) === TRUE) {
    echo "Datos de prueba insertados con éxito [Tabla - opinionEvento].<br>";
} else {
    echo "Error al insertar datos de prueba [Tabla - opinionEvento]: " . $conexion->error . "<br>";
}
if ($conexion->query($sql_ins_reservaUsuario) === TRUE) {
    echo "Datos de prueba insertados con éxito [Tabla - reservaUsuario].<br>";
} else {
    echo "Error al insertar datos de prueba [Tabla - reservaUsuario]: " . $conexion->error . "<br>";
}
// Cerramos conexión
mysqli_close($conexion);
?>