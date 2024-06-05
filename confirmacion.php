<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Contacto</title>
    <link rel="icon" href="./img/Eventium.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/contacto.css">
    <style>
    .confirmacion {
        background-color: #11446e;
    }

    .confirmacion-container {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 500px;
        margin: 50px auto;

    }

    .confirmacion-container h1 {
        color: #333;
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .confirmacion-container p {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    .confirmacion-container a {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background-color: #5b89c3;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .confirmacion-container a:hover {
        background-color: #9adede;
        color: black;
    }
    </style>
</head>
<header>
    <?php
    // Inicia o continua una sesión existente
    if (session_status() == PHP_SESSION_NONE) {
        // Si no hay sesión activa, iniciar una nueva sesión
        session_start();
    }

    // Verifica si la sesión está iniciada y si $id_usuario está definido
    if (isset($_SESSION['id_usuario'])) {
        include('menu_sesion_iniciada.php');
    } else {
        include('menu.php');
    }
    ?>
</header>

<body class="confirmacion">
    <div class="confirmacion-container">
        <h1>¡Mensaje enviado con éxito!</h1>
        <p>Gracias por contactarnos. Hemos recibido tu mensaje y nos pondremos en contacto contigo lo antes posible.</p>
        <a href="contacto.php">Volver al formulario</a>
    </div>
</body>
<footer>
    <?php include('footer.php'); ?>
</footer>

</html>