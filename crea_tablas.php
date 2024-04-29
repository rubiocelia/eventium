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
    NIF VARCHAR(255) PRIMARY KEY,
    nombre_usuario VARCHAR(255)  NULL,
    apellidos_usuario VARCHAR(255) NULL,
    mail_usuario VARCHAR(255) NULL,
    telefono_usuario VARCHAR(255) NULL,
    fecha_nacimiento DATE NULL,
    password_usuario VARCHAR(500) NULL
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
    usuario varchar(255) NOT NULL,
    FOREIGN KEY (id_evento) REFERENCES evento(id_evento),
    FOREIGN KEY (id_calendarioEvento) REFERENCES calendarioEvento(id),
    FOREIGN KEY (usuario) REFERENCES usuario(nif)
)";

// Crear Opiniones Evento
$sql_createOpinionEvento = "CREATE TABLE IF NOT EXISTS opinionEvento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    usuario varchar(255) NOT NULL,
    fecha DATE NULL,
    numPuntuacion INT NULL,
    txt_opinion varchar(1000) NULL,
    FOREIGN KEY (id_evento) REFERENCES evento(id_evento),
    FOREIGN KEY (usuario) REFERENCES usuario(nif)
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
$passUser1= password_hash('asdf1234', PASSWORD_DEFAULT);
$passUser2= password_hash('asdf1234', PASSWORD_DEFAULT);
$passUser3= password_hash('asdf1234', PASSWORD_DEFAULT);
$passUser4= password_hash('asdf1234', PASSWORD_DEFAULT);
$passUser5= password_hash('asdf1234', PASSWORD_DEFAULT);
$passUser6= password_hash('asdf1234', PASSWORD_DEFAULT);

// Sentencia INSERT - Tabla [usuario]
$sql_ins_usuario = "INSERT INTO usuario (NIF,nombre_usuario,apellidos_usuario,mail_usuario,telefono_usuario,fecha_nacimiento,password_usuario) VALUES
( '12345678A', 'Juan', 'González Pérez', 'juan.gonzalez@gmail.com', '654123456', '1990-05-15', '$passUser1' ),
( '87654321A', 'María', 'Martínez López', 'maria.martinez@hotmail.com', '612345678', '1985-08-22', '$passUser2' ),
( '11111111A', 'Pedro', 'Sánchez García', 'pedro.sanchez@outlook.es', '634567891', '1993-02-10', '$passUser3' ),
( '22222222A', 'Ana', 'Rodríguez Martín', 'ana.rodriguez@gmail.com', '678912345', '1988-11-30', '$passUser4' ),
( '33333333A', 'Laura', 'Fernández Ruiz', 'laura.fernandez@hotmail.com', '678345678', '1997-07-05', '$passUser5' ),
( '44444444A', 'Carlos', 'López Hernández', 'carlos.lopez@outlook.es', '612345678', '1983-04-18', '$passUser6' )";
// Sentencia INSERT - Tabla [tipoEvento]
$sql_ins_tipoEvento = "INSERT INTO tipoEvento (id,nombre_tipoEvento) VALUES
( 1, 'Musical' ),
( 2, 'Concierto' ),
( 3, 'Teatro' )";
// Sentencia INSERT - Tabla [categoriaEvento]
$sql_ins_categoriaEvento = "INSERT INTO categoriaEvento (id,nombre_categoriaEvento) VALUES
( 1, 'Planes en Familia' ),
( 2, 'Fiestas de Verano' ),
( 3, 'Noches Culturales' ),
( 4, 'Eventos al Aire Libre' ),
( 5, 'Conciertos y Espectáculos' )";
// Sentencia INSERT - Tabla [evento]
$sql_ins_evento = "INSERT INTO evento (id_evento,nombre_evento,descripcion_evento,url_maps,ubicacion_evento,edad_evento,duracion_evento,id_tipoEvento) VALUES
( 1, 'Concierto en el Parque', 'Disfruta de una tarde llena de música en vivo con artistas locales.', 'https://maps.google.com/?q=Parque+Central', 'Parque Central', 'Todas las edades', '3 horas', 1 ),
( 2, 'Explosión de Rock', 'Un concierto lleno de energía con bandas locales de rock.', 'https://maps.google.com/?q=Teatro+Municipal', 'Teatro Municipal', 'Mayores de 18 años', '4 horas', 2 ),
( 3, 'Romeo y Julieta', 'Una representación conmovedora de la clásica obra de Shakespeare.', 'https://maps.google.com/?q=Teatro+Nacional', 'Teatro Nacional', 'Todas las edades', '2 horas', 3 ),
( 4, 'Jazz en el Parque', 'Disfruta de una noche mágica de jazz bajo las estrellas.', 'https://maps.google.com/?q=Parque+de+la+Ciudad', 'Parque de la Ciudad', 'Todas las edades', '5 horas', 1 ),
( 5, 'Caliente Latino', 'Una fiesta de ritmos latinos con artistas internacionales.', 'https://maps.google.com/?q=Estadio+Municipal', 'Estadio Municipal', 'Mayores de 21 años', '6 horas', 2 ),
( 6, 'Noche de Risas', 'Una noche llena de humor con los mejores comediantes de la ciudad.', 'https://maps.google.com/?q=Club+de+la+Comedia', 'Club de la Comedia', 'Mayores de 16 años', '2 horas', 3 ),
( 7, 'Sunset Rave', 'Vive una experiencia única con DJs internacionales en la playa al atardecer.', 'https://maps.google.com/?q=Playa+Principal', 'Playa Principal', 'Mayores de 18 años', '8 horas', 1 ),
( 8, 'Sinfonía en Do Mayor', 'Disfruta de la majestuosidad de la música clásica interpretada por una orquesta sinfónica.', 'https://maps.google.com/?q=Auditorio+Nacional', 'Auditorio Nacional', 'Todas las edades', '3 horas', 2 ),
( 9, 'Travesía Fantástica', 'Una obra de teatro que desafía los límites de la realidad y la imaginación.', 'https://maps.google.com/?q=Centro+Cultural', 'Centro Cultural', 'Mayores de 12 años', '2 horas', 3 ),
( 10, 'Reggae Roots', 'Sumérgete en el ambiente relajado y los ritmos contagiosos del reggae en medio del bosque.', 'https://maps.google.com/?q=Bosque+Nacional', 'Bosque Nacional', 'Mayores de 18 años', '7 horas', 1 )";
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
( 18, 4, 10)";
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
( 42, 10, '2024-10-02', '00:00', 150, 145, '25.00' )";
// Sentencia INSERT - Tabla [opinionEvento]
$sql_ins_opinionEvento = "INSERT INTO opinionEvento (id_evento,usuario,fecha,numPuntuacion,txt_opinion) VALUES
( 1, '12345678A', '2023-04-01', 4, '¡Gran concierto, lo disfruté mucho!' ),
( 1, '87654321A', '2023-05-03', 5, 'Increíble experiencia, definitivamente volvería.' ),
( 1, '11111111A', '2023-06-05', 4, 'Muy buen ambiente y excelente música.' ),
( 1, '22222222A', '2023-07-07', 4, 'Me gustó mucho, pero esperaba un poco más de variedad en el repertorio.' ),
( 2, '33333333A', '2023-08-10', 3, 'Buen concierto, aunque hubo problemas de sonido.' ),
( 2, '44444444A', '2023-09-12', 4, 'Me lo pasé bien, pero el lugar estaba un poco abarrotado.' ),
( 2, '12345678A', '2023-10-15', 5, '¡Fantástico evento! La organización fue impecable.' ),
( 3, '87654321A', '2023-11-20', 3, 'El teatro era encantador, pero la obra no me convenció del todo.' ),
( 3, '11111111A', '2023-12-25', 4, 'Buena interpretación de los actores, pero la trama me dejó un poco indiferente.' ),
( 3, '22222222A', '2023-01-27', 5, '¡Increíble! Me emocionó de principio a fin.' ),
( 3, '33333333A', '2023-02-01', 4, 'Me encantó, pero creo que la duración podría haber sido un poco más corta.' ),
( 6, '44444444A', '2023-03-20', 5, '¡Espectacular! Me encantó cada momento.' ),
( 6, '12345678A', '2023-04-22', 4, 'Una experiencia maravillosa.' ),
( 6, '87654321A', '2023-05-25', 5, 'Increíble actuación y una historia cautivadora.' ),
( 4, '33333333A', '2023-06-27', 2, 'No fue lo que esperaba, me decepcionó.' ),
( 5, '22222222A', '2023-07-01', 1, 'Muy malo, no lo recomendaría a nadie.' )";
// Sentencia INSERT - Tabla [reservaUsuario]
$sql_ins_reservaUsuario = "INSERT INTO reservaUsuario (id_evento,id_calendarioEvento,usuario) VALUES
( 1, 1, '12345678A' ),
( 2, 8, '87654321A' ),
( 3, 11, '11111111A' ),
( 4, 15, '22222222A' ),
( 5, 19, '33333333A' ),
( 6, 23, '44444444A' ),
( 1, 4, '12345678A' )";

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