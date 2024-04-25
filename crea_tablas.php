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
    contrasena_usuario VARCHAR(500) NULL
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

$sql_insert_profesionales = "INSERT INTO profesionales (nombre_profesionales, apellidos_profesionales, telefono_profesionales, especialidad) VALUES
    ('Mara', 'Sánchez Moreno', '689321579', 'Psicologia'),
    ('Sofía', 'Sepúlveda Rivera', '648931586','Asistencia a personas mayores'),
    ('Martín', 'Cañadas Carriedo', '647553056', 'Asistencia a personas mayores'),
    ('Fernando', 'Rodríguez Bellido', '689321579', 'Asistencia a niños'),
    ('Ana', 'Gómez Rodríguez', ' 648931586','Psicologia'),
    ('Beatriz', 'Rodrigo Marquínez', '647553057', 'Asistencia a niños')";

// Laura1995
$passLaura= password_hash('Laura1995', PASSWORD_DEFAULT);
// AnaH1994
$passAna= password_hash('AnaH1994', PASSWORD_DEFAULT);
// Humberto1943
$passHumberto= password_hash('Humberto1943', PASSWORD_DEFAULT);
// Mario1999
$passMario= password_hash('Mario1999', PASSWORD_DEFAULT);
// David1994
$passDavid= password_hash('David1994', PASSWORD_DEFAULT);
// Daniel1989
$passDaniel= password_hash('Daniel1989', PASSWORD_DEFAULT);

$sql_insert_pacientes = "INSERT INTO pacientes (nombre_pacientes, apellidos_pacientes, telefono_paciente, genero, fecha_nacimiento, usuario_pacientes, contrasena_pacientes, mail_pacientes) VALUES
    ( 'Laura', 'Escanes Villar', '623456789', 'F', '1995-04-05', 'lauraescanes', '$passLaura', 'lauraescanes@gmail.com'),
    ( 'Ana', 'Herrero Sánchez', '687654321', 'F', '1994-03-16', 'anaherrero' , '$passAna', 'anaherrero@gmail.com'),
    ( 'Humberto', 'Fernández Serrano', '656789123', 'M', '1943-08-07', 'humbertofernandez', '$passHumberto', 'humbertofernandez@hotmail.com'),
    ( 'Mario', 'Fernández García', '654341495', 'M', '1999-06-05', 'mariofernandez', '$passMario', 'mariofernandez@gmail.com'),
    ( 'David', 'Del Pino Romero', '687654321', 'F', '1994-03-16', 'daviddelpino', '$passDavid', 'daviddelpino@gmail.com'),
    ( 'Daniel', 'Herrero Martínez', '628196324', 'M', '1989-08-07', 'danielherrero', '$passDaniel', 'danielherrero@gmail.com')";



$sql_insert_eventos = "INSERT INTO eventos (nombre_evento, descripcion_evento, fechas_evento, precio_evento, instructor_evento, tipo_evento) VALUES
    ('Taller de autoestima', 'Aprenderás sobre autoestima', '2024-02-20', '60,00€', 'Amelia','Taller'),
    ('Taller de autoestima', 'Aprenderás sobre autoestima', '2024-03-15', '60,00€', 'Amelia','Taller'),
    ('Taller mejora tus habiladades sociales', 'Aprenderás a mejorar tus habilidades sociales', '2024-03-09', '50,00€', 'Aaron','Taller'),
    ('Taller mejora tus habiladades sociales', 'Aprenderás a mejorar tus habilidades sociales', '2024-05-10', '50,00€', 'Aaron','Taller'),
    ('Taller de gestion de la ansiedad', 'Aprederás a gestionar la ansiedad', '2024-05-04', '30,00€', 'Celia','Taller'),
    ('Taller de gestion de la ansiedad', 'Aprederás a gestionar la ansiedad', '2024-08-21', '30,00€', 'Celia','Taller'),
    ('Taller autoexigencia y perfeccionismo', 'Aprederás sobre autoexigencia y perfeccionismo', '2024-01-09', '70,00€', 'Elena','Taller'),
    ('Taller autoexigencia y perfeccionismo', 'Aprederás sobre autoexigencia y perfeccionismo', '2025-01-09', '70,00€', 'Elena','Taller'),
    ('Curso de autoestima', 'Aprende a gestionar tu autoestima', '2024-04-01', '40,00€', 'Javier','Curso'),
    ('Curso de autoestima', 'Aprende a gestionar tu autoestima', '2025-02-10', '40,00€', 'Javier','Curso'),
    ('Curso de dependencia emocional', 'Aprende a saber llevar tu dependencia emocional', '2024-02-08', '80,00€', 'Juan','Curso'),
    ('Curso de dependencia emocional', 'Aprende a saber llevar tu dependencia emocional', '2024-12-11', '80,00€', 'Juan','Curso'),
    ('Curos de ansiedad online', 'Aprende a gestionar tu ansiedad', '2024-03-17', '45,00€', 'Alejandro','Curso'),
    ('Curos de ansiedad online', 'Aprende a gestionar tu ansiedad', '2024-11-08', '45,00€', 'Alejandro','Curso'),
    ('Curso para parejas', 'Curso específico de parejas', '2024-07-12', '60,00€', 'Álvaro','Curso'),
    ('Curso para parejas', 'Curso específico de parejas', '2024-10-29', '60,00€', 'Álvaro','Curso'),
    ('Retiros de verano', 'Retiros de verano', '2024-08-21', '80,00€', 'Lucca','Retiro'),
    ('Retiros de invierno', 'Retiros de invierno', '2024-02-28', '80,00€', 'Ismael','Retiro')";

$sql_insert_cita_psicologica = "INSERT INTO cita_psicologica (id_pacientes, id_profesionales,fechas_cita,hora_cita) VALUES
('1', '1', '2024-03-10','17:00'),
('3', '5','2024-04-11','19:00'),
('4', '5','2024-05-21','18:00'),
('2', '1','2024-03-20','20:00')";

$sql_insert_reserva_eventos = "INSERT INTO reserva_eventos (id_paciente, id_evento) VALUES
('1', '1'),
('1', '7'),
('1', '3'),
('3', '4'),
('4', '11'),
('5', '18'),
('6', '12'),
('2', '6'),
('2', '17'),
('2', '15')";


/*
if ($conexion->query($sql_insert_profesionales) === TRUE) {
    echo "Datos iniciales de profesionales insertados con éxito.<br>";
} else {
    echo "Error al insertar datos iniciales de profesionales: " . $conexion->error . "<br>";
}



if ($conexion->query($sql_insert_pacientes) === TRUE) {
    echo "Datos iniciales de pacientes insertados con éxito.<br>";
} else {
    echo "Error al insertar datos iniciales de pacientes: " . $conexion->error . "<br>";
}

if ($conexion->query($sql_insert_eventos) === TRUE) {
    echo "Datos iniciales de eventos insertados con éxito.<br>";
} else {
    echo "Error al insertar datos iniciales de eventos: " . $conexion->error . "<br>";
}

if ($conexion->query($sql_insert_cita_psicologica) === TRUE) {
    echo "Datos iniciales de cita psicológica insertados con éxito.<br>";
} else {
    echo "Error al insertar datos iniciales de cita psicológica: " . $conexion->error . "<br>";
}
if ($conexion->query($sql_insert_reserva_eventos) === TRUE) {
    echo "Datos iniciales de reserva eventos insertados con éxito.<br>";
} else {
    echo "Error al insertar datos iniciales de reserva eventos: " . $conexion->error . "<br>";
}
*/

// Cerramos conexión
mysqli_close($conexion);
?>