<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page | Living Code</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/b408879b64.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="box-info">
            <h1>CONTÁCTATE CON NOSOTROS</h1>
            <div class="data">
                <p><i class="fa-solid fa-phone"></i> +502 1234-5678</p>
                <p><i class="fa-solid fa-envelope"></i> sesmaikel@gmail.com</p>
                <p><i class="fa-solid fa-location-dot"></i> 18 Avenida, Vista Hermosa 3, Zona 15, GT</p>
            </div>
            <div class="links">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>
        <form method="post" action="">
            <?php
            include "../contacto/controlador/enviar.php"
            ?>
            <div class="input-box">
                <input type="text" placeholder="Nombre y apellido" name="name" required="">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="email" required placeholder="Correo electrónico" name="email" required="">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Asunto" name="asunto" required="">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div class="input-box">
                <textarea placeholder="Escribe tu mensaje..." name="mensaje" required=""></textarea>
            </div>
            <button type="submit" name="boton_enviar" required="">Enviar mensaje</button>
        </form>
    </div>
</body>

</html>