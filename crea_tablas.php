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
    username VARCHAR(255) NULL,
    nombre_usuario VARCHAR(255) NULL,
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
    accesibilidad_evento VARCHAR(255)  NULL,
    aforo_evento VARCHAR(255)  NULL,
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
    numero_entradas INT NOT NULL,
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
( 6, 'Cine' ),
( 7, 'Romántico' ),
( 8, 'Conferencia' ),
( 9, 'Otros' )";

// Sentencia INSERT - Tabla [categoriaEvento]
$sql_ins_categoriaEvento = "INSERT INTO categoriaEvento (id,nombre_categoriaEvento) VALUES
( 1, 'Planes en Familia' ),
( 2, 'Fiestas de Verano' ),
( 3, 'Noches Culturales' ),
( 4, 'Eventos al Aire Libre' ),
( 5, 'Conciertos y Espectáculos' ),
( 6, 'Planes de Pareja' )";

$sql_ins_evento = "INSERT INTO evento (id_evento, nombre_evento, url_img, url_maps, ubicacion_evento, edad_evento, duracion_evento, id_tipoEvento, descripcion_evento, accesibilidad_evento, aforo_evento) VALUES
(1, 'Concierto en el Parque', 'img/imgEventos/conciertoenelparqe.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3038.8487916339122!2d-3.6864155245183694!3d40.39004375726401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd421ebc25594ceb%3A0xc35b94645b458ce6!2sParque%20Enrique%20Tierno%20Galv%C3%A1n!5e0!3m2!1ses!2ses!4v1717431482987!5m2!1ses!2ses', 'Parque Enrique Tierno Galván, Madrid', 'Todas las edades', '3 horas', 2, 'Disfruta de una tarde llena de música en vivo con artistas locales en el emblemático Parque Central. Este evento, ideal para todas las edades, ofrece una mezcla vibrante de géneros musicales, desde pop y rock hasta jazz y música clásica. La atmósfera relajada y acogedora del parque, combinada con la energía de los músicos talentosos, crea una experiencia inolvidable para familias, amigos y parejas. Habrá áreas de picnic, puestos de comida con deliciosas opciones locales, y actividades recreativas para niños. Además, el evento contará con zonas de descanso bajo los árboles, perfectas para disfrutar de la música mientras te relajas en la naturaleza. No te pierdas la oportunidad de pasar una tarde mágica en compañía de tus seres queridos, rodeado de buena música y un ambiente festivo. ¡Te esperamos en el Parque Central!', 'Accesible con silla de ruedas', 'ilimitado'),
(2, 'Explosión de Rock', 'img/imgEventos/explosionderock.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3149.0052418643795!2d-4.782478224644735!3d37.88356010588688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6cdf62ce812b53%3A0x657e21a24f913367!2sTeatro%20G%C3%B3ngora!5e0!3m2!1ses!2ses!4v1717432029960!5m2!1ses!2ses', 'Teatro Góngora, Córdoba', 'Mayores de 18 años', '4 horas', 2, 'Prepárate para una noche electrizante con Explosión de Rock en el histórico Teatro Municipal. Este concierto está diseñado para los verdaderos amantes del rock, presentando a algunas de las mejores bandas locales que prometen una velada llena de energía y pasión. Con un repertorio que abarca desde los clásicos del rock hasta las composiciones más innovadoras, este evento garantiza una experiencia musical única. Las potentes guitarras, las baterías estruendosas y las voces apasionadas te harán vibrar en cada canción. Además, el teatro ofrecerá un impresionante espectáculo de luces y efectos visuales que complementarán la intensidad de la música. Este evento es exclusivo para mayores de 18 años y contará con una zona VIP para los fanáticos más entusiastas, así como puestos de merchandising y bebidas. Ven y únete a esta explosión de rock que sacudirá el Teatro Municipal como nunca antes. ¡No te lo puedes perder!', 'No accesible con silla de ruedas', 'limitado'),
(3, 'Romeo y Julieta', 'img/imgEventos/romeoyjulieta.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2981.179685419155!2d-0.8818962244519782!3d41.65185957954979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5914ee7c4a9089%3A0xde062b8d2b4128c0!2sTeatro%20Principal%20de%20Zaragoza!5e0!3m2!1ses!2ses!4v1717432100792!5m2!1ses!2ses', 'Teatro Principal, Zaragoza', 'Todas las edades', '2 horas', 3, 'Sumérgete en la trágica y apasionante historia de Romeo y Julieta, una representación conmovedora de la clásica obra de Shakespeare. Esta producción promete capturar la esencia del amor prohibido y el destino trágico de los jóvenes amantes en un escenario impresionante. Con una escenografía deslumbrante, vestuarios de época y un elenco talentoso, la obra te transportará a la Verona del Renacimiento. Ideal para todos los amantes del teatro y la literatura clásica, este espectáculo es una oportunidad para experimentar uno de los dramas más icónicos de todos los tiempos. No te pierdas esta puesta en escena única que revivirá la magia y el dolor de Romeo y Julieta.', 'Accesible con silla de ruedas', 'limitado'),
(4, 'Jazz en el Parque', 'img/imgEventos/jazzenelparque.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3037.7105741610103!2d-3.686040624517073!3d40.41526205572945!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd42289ff511827b%3A0x9e6c2716b524a3ae!2sParque%20de%20El%20Retiro!5e0!3m2!1ses!2ses!4v1717432140944!5m2!1ses!2ses', 'Parque del Retiro, Madrid', 'Todas las edades', '5 horas', 2, 'Disfruta de una noche mágica de jazz bajo las estrellas en el hermoso Parque de la Ciudad. Este evento reúne a algunos de los mejores músicos de jazz de la región para ofrecerte una velada inolvidable llena de melodías suaves y ritmos vibrantes. Trae tu manta y relájate en el césped mientras disfrutas de los solos improvisados y las armonías complejas que solo el jazz puede ofrecer. Con puestos de comida gourmet y bebidas, así como áreas de picnic, este evento es perfecto para una salida nocturna con amigos o una cita romántica. Déjate llevar por el ambiente relajado y sofisticado y sumérgete en el mundo del jazz.', 'Accesible con silla de ruedas', 'ilimitado'),
(5, 'Caliente Latino', 'img/imgEventos/calientelatino.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3062.234683894337!2d-4.0206820245452715!3d39.86898078879596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6a0bb29b779bdb%3A0x755528369cf6b28a!2sEstadio%20Salto%20del%20Caballo!5e0!3m2!1ses!2ses!4v1717432181754!5m2!1ses!2ses', 'Estadio Salto del Caballo, Toledo', 'Mayores de 21 años', '6 horas', 1, 'Prepárate para una noche llena de energía y pasión con Caliente Latino, la fiesta de ritmos latinos más esperada del año. En el Estadio Municipal, artistas internacionales y DJs reconocidos te harán bailar al son de salsa, reguetón, bachata y otros géneros que encenderán la pista de baile. Con un espectáculo de luces impresionante, efectos visuales y una producción de primera, esta fiesta es ideal para aquellos que aman la música y el baile latino. Además, habrá una zona VIP para quienes buscan una experiencia exclusiva, con acceso a bebidas premium y asientos preferenciales. No te pierdas esta oportunidad de vivir una noche inolvidable llena de sabor latino.', 'No accesible con silla de ruedas', 'limitado'),
(6, 'Noche de Risas', 'img/imgEventos/nochederisas.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2981.1907509225825!2d-4.730721424451958!3d41.65162047956455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd476d4d2c1f5957%3A0x639b38d0f337d8fc!2sTeatro%20Zorrilla!5e0!3m2!1ses!2ses!4v1717432211338!5m2!1ses!2ses', 'Teatro Zorrilla, Valladolid', 'Mayores de 16 años', '2 horas', 9, 'Una noche llena de humor con los mejores comediantes de la ciudad te espera en el Club de la Comedia. Déjate llevar por la risa y el buen humor en este evento que promete hacerte olvidar las preocupaciones diarias. Con un elenco de cómicos talentosos que abordan temas cotidianos, situaciones absurdas y anécdotas hilarantes, este espectáculo es perfecto para disfrutar con amigos o en pareja. Además, el club ofrece una gran selección de bebidas y aperitivos para complementar la experiencia. No te pierdas esta oportunidad de disfrutar de una noche de risas y diversión en el mejor ambiente.', 'No accesible con silla de ruedas', 'limitado'),
(7, 'Sunset Rave', 'img/imgEventos/sunsetrave.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2900.3788674474977!2d-8.41396247435862!3d43.36910157076009!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2e7c63b4fdcd33%3A0x3c2af82aaa817f66!2sPlaya%20de%20Riazor%20(La%20Coru%C3%B1a)!5e0!3m2!1ses!2ses!4v1717432244098!5m2!1ses!2ses', 'Playa de Riazor, A Coruña', 'Mayores de 18 años', '8 horas', 9, 'Vive una experiencia única con Sunset Rave, un evento espectacular que combina música electrónica de primer nivel con la belleza de la playa al atardecer. Con DJs internacionales que te harán bailar toda la noche, luces y efectos visuales impresionantes, esta rave promete ser una de las más memorables del año. Trae tus amigos y disfruta de la energía y la libertad de bailar bajo el cielo abierto. Habrá zonas de chill-out para relajarte, puestos de comida y bebida para mantenerte con energía, y muchas sorpresas más. No te pierdas esta fiesta inolvidable en un entorno natural espectacular.', 'No accesible con silla de ruedas', 'ilimitado'),
(8, 'Sinfonía en Do Mayor', 'img/imgEventos/sinfoniaendomayor.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2981.179685419155!2d-0.8818962244519782!3d41.65185957954979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5914ee7c4a9089%3A0xde062b8d2b4128c0!2sTeatro%20Principal%20de%20Zaragoza!5e0!3m2!1ses!2ses!4v1717432100792!5m2!1ses!2ses', 'Teatro Principal, Zaragoza', 'Todas las edades', '3 horas', 2, 'Disfruta de la majestuosidad de la música clásica con la Sinfonía en Do Mayor, interpretada por una orquesta sinfónica de renombre. En el impresionante Auditorio Nacional, serás testigo de una actuación que combina la precisión técnica con la profunda emoción de la música clásica. Este evento es perfecto para amantes de la música de todas las edades, ofreciendo una experiencia que deleitará tus sentidos. Desde los movimientos más serenos hasta los crescendos más poderosos, la sinfonía te llevará en un viaje musical inolvidable. No te pierdas esta oportunidad de disfrutar de una noche de elegancia y cultura.', 'Accesible con silla de ruedas', 'limitado'),
(9, 'Travesía Fantástica', 'img/imgEventos/traveisafantastica.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2981.1907509225825!2d-4.730721424451958!3d41.65162047956455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd476d4d2c1f5957%3A0x639b38d0f337d8fc!2sTeatro%20Zorrilla!5e0!3m2!1ses!2ses!4v1717432211338!5m2!1ses!2ses', 'Teatro Zorrilla, Valladolid', 'Mayores de 12 años', '2 horas', 3, 'Embárcate en una Travesía Fantástica, una obra de teatro que desafía los límites de la realidad y la imaginación. En el Centro Cultural, esta producción te llevará a mundos maravillosos llenos de criaturas mágicas, héroes valientes y aventuras épicas. Con efectos especiales sorprendentes, una escenografía impresionante y un elenco de actores talentosos, esta obra es ideal para toda la familia. Déjate llevar por la historia y disfruta de una noche llena de magia y emoción. No te pierdas esta oportunidad de experimentar un espectáculo teatral único que te hará soñar despierto.', 'Accesible con silla de ruedas', 'limitado'),
(10, 'Reggae Roots', 'img/imgEventos/reggaeroots.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2997.849251404279!2d0.793861583367747!3d41.2903852280529!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a1334b809069eb%3A0xf00fae11f514640!2sParque%20Natural%20de%20la%20Sierra%20de%20Montsant!5e0!3m2!1ses!2ses!4v1717432338472!5m2!1ses!2ses', 'Parque Natural de la Sierra de Montsant, Tarragona', 'Mayores de 18 años', '7 horas', 2, 'Sumérgete en el ambiente relajado y los ritmos contagiosos del reggae con Reggae Roots, un evento que se celebra en el corazón del Bosque Nacional. Rodeado de naturaleza, podrás disfrutar de la música de los mejores artistas de reggae, que te harán vibrar con sus canciones llenas de positividad y buenas vibras. Con áreas para relajarte, puestos de comida y bebida, y actividades relacionadas con la cultura rastafari, este evento es perfecto para desconectar y disfrutar de un día en plena naturaleza. No te pierdas esta experiencia única que combina música, naturaleza y cultura en un solo lugar.', 'No accesible con silla de ruedas', 'ilimitado'),
(11, 'Festival de Verano', 'img/imgEventos/festivaldeverano.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3079.743552365506!2d-6.376235867298214!3d39.47512183921567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd15dfd67ae259a9%3A0x7b1b5915afe89a9!2sPlaza%20Mayor%2C%20Centro-Casco%20Antiguo%2C%2010003%20C%C3%A1ceres!5e0!3m2!1ses!2ses!4v1717432388214!5m2!1ses!2ses', 'Plaza Mayor, Cáceres', 'Todas las edades', '8 horas', 4, 'El Festival de Verano es el evento perfecto para disfrutar con toda la familia. En la Plaza Mayor, este festival ofrece una variedad de actividades que incluyen música en vivo, juegos, talleres y puestos de comida que deleitarán a todos los asistentes. Con actuaciones de bandas locales y artistas de diversos géneros, hay algo para todos los gustos. Además, habrá áreas de descanso, zonas para niños con actividades especiales y muchas sorpresas más. Ven y disfruta de un día lleno de diversión, música y entretenimiento para todas las edades. No te pierdas este evento que celebra el verano en su máximo esplendor.', 'Accesible con silla de ruedas', 'ilimitado'),
(12, 'Exposición de Arte Moderno', 'img/imgEventos/exposiciondeartemoderno.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3149.345172764009!2d-4.774264324645124!3d37.875609706345955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6d2086df257139%3A0x62272913ddcfeea!2sCentro%20de%20Creaci%C3%B3n%20Contempor%C3%A1nea%20de%20Andaluc%C3%ADa%20C3A!5e0!3m2!1ses!2ses!4v1717432420186!5m2!1ses!2ses', 'Museo de Arte Contemporáneo, Córdoba', 'Todas las edades', '5 horas', 5, 'Explora las obras de los artistas modernos más influyentes en la Exposición de Arte Moderno, ubicada en el prestigioso Museo de Arte Moderno. Esta exposición presenta una colección diversa y emocionante de pinturas, esculturas, y multimedia que reflejan las tendencias y movimientos más importantes del arte contemporáneo. Con galerías temáticas, charlas de expertos y actividades interactivas, esta exposición es ideal para todos los amantes del arte, desde entusiastas hasta críticos. No te pierdas la oportunidad de sumergirte en el mundo del arte moderno y descubrir nuevas perspectivas y emociones a través de estas obras innovadoras.', 'Accesible con silla de ruedas', 'limitado'),
(13, 'Conferencia sobre Tecnología', 'img/imgEventos/conferenciasobretecnologia.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3035.5874434872785!2d-3.618928624514618!3d40.46226725286739!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422e514edf02d3%3A0xe0971ba5c464c797!2sPalacio%20Municipal%20-%20IFEMA%20MADRID!5e0!3m2!1ses!2ses!4v1717432450677!5m2!1ses!2ses', 'Palacio Municipal de Congresos, Madrid', 'Mayores de 18 años', '4 horas', 8, 'Únete a nosotros en la Conferencia sobre Tecnología, un evento que reúne a líderes de la industria, innovadores y entusiastas para explorar las últimas tendencias y avances tecnológicos. Celebrada en el moderno Centro de Convenciones, esta conferencia ofrece una serie de charlas inspiradoras, talleres interactivos y exposiciones de productos de vanguardia. Es una oportunidad perfecta para aprender de expertos, hacer networking con profesionales del sector y descubrir cómo la tecnología está transformando el mundo. No te pierdas esta oportunidad de estar a la vanguardia del conocimiento tecnológico y de conectar con personas que comparten tu pasión por la innovación.', 'No accesible con silla de ruedas', 'limitado'),
(14, 'Noche de Magia', 'img/imgEventos/nochedemagia.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2892.2287066821236!2d-5.663849124349175!3d43.53927425979249!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd367c63d964a81b%3A0x1904453539f8b1db!2sTeatro%20Jovellanos!5e0!3m2!1ses!2ses!4v1717432479964!5m2!1ses!2ses', 'Teatro Jovellanos, Gijón', 'Todas las edades', '2.5 horas', 3, 'Déjate sorprender por la Noche de Magia, un espectáculo donde los mejores ilusionistas del país te llevarán a un mundo de asombro y fantasía. En el encantador Teatro Mágico, cada truco y actuación te dejará sin aliento, desde la desaparición de objetos hasta la levitación y la teletransportación. Este evento es perfecto para toda la familia y promete ser una velada llena de misterio y entretenimiento. Con una mezcla de magia clásica y moderna, y efectos especiales impresionantes, esta noche mágica es una experiencia que no querrás perderte. Acompáñanos y descubre el poder de la ilusión.', 'Accesible con silla de ruedas', 'limitado'),
(15, 'Danza Contemporánea', 'img/imgEventos/danzaconteporanea.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5802.753655638298!2d-4.054230707759125!3d43.348227732274836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd493e6d4d0fbae3%3A0x5e22dedece4c8d76!2sEscuela%20de%20Circo%20y%20Teatro%20F%C3%ADsico%20de%20Torrelavega%2C%20Cantabria!5e0!3m2!1ses!2ses!4v1717432530408!5m2!1ses!2ses', 'Centro de Artes Escénicas, Torrelavega', 'Todas las edades', '2 horas', 1, 'Sumérgete en el mundo de la Danza Contemporánea, una espectacular presentación que desafía los límites del movimiento y la expresión artística. En el elegante Centro de Artes Escénicas, bailarines talentosos ejecutarán coreografías innovadoras que combinan técnica, emoción y creatividad. Este espectáculo es una oportunidad única para experimentar la danza moderna en su forma más pura, con movimientos fluidos, interpretaciones poderosas y una escenografía minimalista que resalta la belleza del cuerpo en movimiento. No te pierdas esta oportunidad de ver a algunos de los mejores bailarines del país en una actuación que te dejará inspirado y maravillado.', 'Accesible con silla de ruedas', 'limitado'),
(16, 'Cine al Aire Libre', 'img/imgEventos/cinealairelibre.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3038.3114474914823!2d-3.882065074517754!3d40.40195075653954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd418f88b7035089%3A0xd6f7c4a278b31a50!2sParque%20Juan%20Pablo%20II!5e0!3m2!1ses!2ses!4v1717432595853!5m2!1ses!2ses', 'Parque Juan Pablo II, Boadilla del Monte', 'Todas las edades', '3 horas', 6, 'Disfruta de tus películas favoritas bajo las estrellas en nuestro evento de Cine al Aire Libre. Ubicado en el acogedor Parque Cine, este evento es perfecto para una noche relajada en compañía de amigos o familia. Trae tu manta o silla plegable y acomódate para disfrutar de una selección de clásicos del cine y éxitos modernos en una pantalla gigante. Con puestos de comida y bebida, y un ambiente tranquilo y seguro, este evento ofrece una experiencia cinematográfica única. No te pierdas la oportunidad de ver grandes películas en un entorno natural y disfrutar de la magia del cine al aire libre.', 'Accesible con silla de ruedas', 'ilimitado'),
(17, 'Feria de Libros', 'img/imgEventos/feriadelibros.webp', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6075.919765525598!2d-3.698951306420896!3d40.40973950000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4227b5f2fe98af%3A0x476825e0ff9aa7e3!2sFeria%20fija%20del%20libro!5e0!3m2!1ses!2ses!4v1717432638764!5m2!1ses!2ses', 'Feria del Libro, Parque del Retiro, Madrid', 'Todas las edades', '6 horas', 9, 'Sumérgete en el fascinante mundo de la lectura en la Feria de Libros, un evento que reúne a amantes de los libros, autores y editoriales en un solo lugar. En la Feria del Libro, podrás explorar las últimas novedades literarias, asistir a charlas y presentaciones de autores, y participar en talleres interactivos. Este evento es ideal para todas las edades, con actividades especiales para niños, jóvenes y adultos. Descubre libros de todos los géneros, conoce a tus escritores favoritos y disfruta de un ambiente lleno de cultura y conocimiento. No te pierdas esta celebración de la literatura y la creatividad.', 'Accesible con silla de ruedas', 'ilimitado'),
(18, 'Cena Romántica en el Lago', 'img/imgEventos/cenaromanticaenellago.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6085.383856807988!2d-3.746886716996989!3d40.30479878886633!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd418a0abd4bebeb%3A0xb4665b04766083ed!2sLago%20de%20la%20Alh%C3%B3ndiga!5e0!3m2!1ses!2ses!4v1717432686324!5m2!1ses!2ses', 'Restaurante Lago Alhóndiga, Getafe', 'Mayores de 18 años', '3 horas', 7, 'Disfruta de una velada exclusiva con tu pareja en la Cena Romántica en el Lago. Ubicado en el encantador Restaurante Lago, este evento ofrece una experiencia gastronómica única con vistas impresionantes del lago al atardecer. Con un menú gourmet diseñado por chefs de renombre, cada plato es una obra de arte culinaria. La atmósfera íntima, decorada con luces suaves y música en vivo, crea el ambiente perfecto para una noche inolvidable. Además, habrá opciones de maridaje de vinos y postres exquisitos para completar la experiencia. No te pierdas esta oportunidad de celebrar el amor en un entorno mágico y romántico.', 'No accesible con silla de ruedas', 'limitado'),
(19, 'Paseo en Globo al Atardecer', 'img/imgEventos/paseoenglobo.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3034.450371567842!2d-4.054177624513347!3d40.48742295133459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd419f854c35f8f3%3A0x9a3d5a13c788e01a!2sCampo%20de%20Vuelo%20Valdemorillo!5e0!3m2!1ses!2ses!4v1717432716582!5m2!1ses!2ses', 'Campo de Vuelo, Valdemorillo', 'Todas las edades', '2 horas', 7, 'Vive una experiencia inolvidable con un Paseo en Globo al Atardecer. Desde el Campo Abierto, asciende a los cielos y disfruta de vistas panorámicas espectaculares mientras el sol se pone en el horizonte. Esta actividad es perfecta para parejas, familias y amigos que buscan una aventura única y emocionante. Con pilotos experimentados y globos de última generación, tu seguridad y disfrute están garantizados. Captura momentos increíbles y crea recuerdos duraderos mientras flotas suavemente sobre paisajes impresionantes. No te pierdas esta oportunidad de ver el mundo desde una perspectiva completamente nueva.', 'No accesible con silla de ruedas', 'limitado'),
(20, 'Spa y Relajación para Parejas', 'img/imgEventos/spayrelajacionparaprejas.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3036.329623362084!2d-3.8710874245154767!3d40.44584085386792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4185ab79bb04f9%3A0xa67d732278d297e3!2sForus%20Majadahonda%20Las%20Rejas!5e0!3m2!1ses!2ses!4v1717432780112!5m2!1ses!2ses', 'Forus Majadahonda Las Rejas, Majadahonda', 'Mayores de 18 años', '5 horas', 7, 'Regálate y regálale a tu pareja un día de relajación total en nuestro evento de Spa y Relajación para Parejas. En el lujoso Spa Centro, disfrutarás de una variedad de tratamientos diseñados para rejuvenecer el cuerpo y la mente. Desde masajes en pareja hasta baños de aromaterapia, este evento ofrece todo lo necesario para desconectar del estrés diario y reconectar con tu ser querido. Con acceso a saunas, jacuzzis y áreas de descanso privadas, podrás disfrutar de un ambiente de paz y tranquilidad. Además, habrá opciones de tratamientos faciales y corporales personalizados para una experiencia completa de bienestar. No te pierdas esta oportunidad de relajarte y revitalizarte en compañía de tu pareja.', 'No accesible con silla de ruedas', 'ilimitado')";


// Sentencia INSERT - Tabla [relacionCatEven]
$sql_ins_relacionCatEven = "INSERT INTO relacionCatEven (id,id_categoriaEvento,id_evento) VALUES
( 1, 5, 1), 
( 2, 4, 1), 
( 3, 5, 2), 
( 4, 5, 3), 
( 5, 1, 4),
( 6, 4, 4), 
( 7, 5, 4), 
( 8, 5, 5), 
( 9, 2, 5), 
(10, 5, 6), 
(11, 1, 6), 
(12, 2, 7), 
(13, 4, 7), 
(14, 5, 8), 
(15, 3, 8), 
(16, 3, 9), 
(17, 5, 10), 
(18, 1, 10), 
(19, 2, 11), 
(20, 5, 12), 
(21, 3, 12), 
(22, 3, 13), 
(23, 3, 14), 
(24, 1, 14), 
(25, 5, 15), 
(26, 3, 15),
(27, 1, 16), 
(28, 4, 16), 
(29, 1, 17), 
(30, 4, 17), 
(31, 6, 18), 
(32, 6, 19), 
(33, 6, 20)  
";
// Sentencia INSERT - Tabla [calendarioEvento]
$sql_ins_calendarioEvento = "INSERT INTO calendarioEvento (id,id_evento,fecha,hora,totalPlazas,plazasOcupadas,precio) VALUES
( 1, 1, '2024-03-11', '18:00', 100, 80, '20.00' ),
( 2, 1, '2024-08-01', '20:00', 100, 90, '20.00' ),
( 3, 1, '2024-04-21', '18:00', 100, 70, '20.00' ),
( 4, 1, '2023-05-08', '20:00', 100, 60, '20.00' ),
( 5, 1, '2024-05-15', '18:00', 100, 90, '20.00' ),
( 6, 1, '2024-12-20', '20:00', 100, 85, '20.00' ),

( 7, 2, '2024-05-05', '19:00', 150, 120, '25.00' ),
( 8, 2, '2024-10-05', '21:00', 150, 130, '25.00' ),
( 9, 2, '2023-04-25', '19:00', 150, 130, '25.00' ),
( 10, 2, '2024-04-15', '21:00', 150, 140, '25.00' ),

( 11, 3, '2024-06-13', '19:30', 80, 60, '15.00' ),
( 12, 3, '2024-08-12', '21:30', 80, 50, '15.00' ),
( 13, 3, '2023-06-15', '19:30', 80, 70, '15.00' ),
( 14, 3, '2024-10-12', '21:30', 80, 60, '15.00' ),

( 15, 4, '2034-06-04', '19:00', 120, 100, '18.00' ),
( 16, 4, '2024-06-15', '21:00', 120, 95, '18.00' ),
( 17, 4, '2024-09-07', '19:00', 120, 110, '18.00' ),
( 18, 4, '2023-10-09', '21:00', 120, 105, '18.00' ),

( 19, 5, '2024-06-26', '20:00', 200, 180, '30.00' ),
( 20, 5, '2024-08-15', '22:00', 200, 190, '30.00' ),
( 21, 5, '2024-09-26', '20:00', 200, 190, '30.00' ),
( 22, 5, '2024-10-26', '22:00', 200, 195, '30.00' ),

( 23, 6, '2024-06-30', '20:30', 80, 70, '22.00' ),
( 24, 6, '2024-08-30', '22:30', 80, 60, '22.00' ),
( 25, 6, '2024-09-30', '20:30', 80, 60, '22.00' ),
( 26, 6, '2023-10-30', '22:30', 80, 55, '22.00' ),

( 27, 7, '2024-06-14', '18:30', 150, 140, '35.00' ),
( 28, 7, '2023-08-14', '20:30', 150, 135, '35.00' ),
( 29, 7, '2024-09-14', '18:30', 150, 130, '35.00' ),
( 30, 7, '2024-10-14', '20:30', 150, 125, '35.00' ),

( 31, 8, '2024-06-21', '19:00', 100, 90, '28.00' ),
( 32, 8, '2024-08-21', '21:00', 100, 85, '28.00' ),
( 33, 8, '2023-09-21', '19:00', 100, 80, '28.00' ),
( 34, 8, '2024-10-21', '21:00', 100, 75, '28.00' ),

( 35, 9, '2024-06-28', '20:00', 90, 80, '20.00' ),
( 36, 9, '2023-08-28', '22:00', 90, 70, '20.00' ),
( 37, 9, '2024-09-28', '20:00', 90, 70, '20.00' ),
( 38, 9, '2024-10-28', '22:00', 90, 65, '20.00' ),

( 39, 10, '2024-06-25', '22:00', 150, 130, '25.00' ),
( 40, 10, '2023-08-25', '00:00', 150, 135, '25.00' ),
( 41, 10, '2024-09-25', '22:00', 150, 140, '25.00' ),
( 42, 10, '2024-10-25', '00:00', 150, 145, '25.00' ),

( 43, 11, '2024-06-29', '10:00', 300, 250, '50.00' ),
( 44, 11, '2024-08-29', '12:00', 300, 260, '50.00' ),
( 45, 12, '2024-09-02', '10:00', 200, 180, '15.00' ),
( 46, 12, '2024-10-02', '12:00', 200, 170, '15.00' ),
( 47, 13, '2024-06-23', '09:00', 100, 80, '45.00' ),
( 48, 13, '2024-08-23', '11:00', 100, 85, '45.00' ),
( 49, 14, '2024-09-06', '18:00', 120, 100, '20.00' ),
( 50, 14, '2024-10-06', '20:00', 120, 105, '20.00' ),
( 51, 14, '2024-11-06', '18:00', 120, 110, '20.00' ),
( 52, 14, '2024-12-06', '20:00', 120, 115, '20.00' ),
( 53, 15, '2024-06-20', '19:00', 150, 140, '25.00' ),
( 54, 15, '2024-08-20', '21:00', 150, 135, '25.00' ),
( 55, 15, '2024-09-20', '19:00', 150, 130, '25.00' ),
( 56, 15, '2024-10-20', '21:00', 150, 125, '25.00' ),
( 57, 16, '2024-06-27', '20:00', 200, 180, '15.00' ),
( 58, 16, '2024-08-27', '22:00', 200, 170, '15.00' ),
( 59, 16, '2024-09-27', '20:00', 200, 160, '15.00' ),
( 60, 16, '2024-10-27', '22:00', 200, 150, '15.00' ),
( 61, 17, '2024-06-15', '10:00', 500, 450, '10.00' ),
( 62, 17, '2024-08-15', '12:00', 500, 460, '10.00' ),
( 63, 17, '2024-09-15', '10:00', 500, 470, '10.00' ),
( 64, 17, '2024-10-15', '12:00', 500, 480, '10.00' ),
( 65, 18, '2024-06-22', '19:00', 50, 40, '100.00'),
( 66, 18, '2024-08-22', '21:00', 50, 35, '100.00'),
( 67, 19, '2024-09-29', '18:00', 30, 25, '200.00'),
( 68, 19, '2024-10-29', '20:00', 30, 20, '200.00'),
( 69, 20, '2024-06-30', '09:00', 40, 35, '150.00'),
( 70, 20, '2024-08-31', '13:00', 40, 30, '150.00')";

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
$sql_ins_reservaUsuario = "INSERT INTO reservaUsuario (id_evento,id_calendarioEvento,usuario_id, numero_entradas) VALUES
( 1, 4, 1, 2 ),
( 2, 9, 1, 1 ),
( 4, 16, 1, 3 ),
( 1, 2, 3, 1 ),
( 1, 2, 4, 1 ),
( 4, 16, 5, 1 ),
( 1, 2, 6, 1 ),
( 2, 8, 6, 1 ),
( 2, 8, 2, 1 ),
( 2, 8, 1, 1 ),
( 2, 8, 3, 1 ),
( 3, 11, 1, 3 ),
( 3, 11, 2, 1 ),
( 3, 11, 3, 1 ),
( 5, 19, 3, 1 ),
( 5, 19, 2, 1 ),
( 5, 19, 1, 1 ),
( 5, 19, 4, 1 ),
( 5, 19, 5, 1 ),
( 9, 35, 6, 1 ),
( 9, 35, 1, 1 )";

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