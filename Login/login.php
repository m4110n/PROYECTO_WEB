<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión y registrarse</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h2 class="logo">Sistema Botiquin SA</h2>
        <nav class="navigation">
            <a href="#">Inicio</a>
            <a href="#">Acerca de</a>
            <a href="#">Servicios</a>
            <a href="#">Contacto</a>
            <button class="bthLogin-popup">Iniciar sesión</button>
        </nav>
    </header>
    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close"></ion-icon>
        </span>
        <!--inicio de sesion-->
        <div class="form-box login">
            <h2>Iniciar sesión</h2>
            <?php
            //conectar a la dba
            include "../conexion_dba/conexion.php";
            //conectar con el controlador de login iniciar
            include "./controlador_login/controlador/controlador.php"
            ?>
            <form method="post" action="">
                <!--correo-->
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" required="" name="correo">
                    <label>Correo electrónico</label>
                </div>
                <!--contraseña-->
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" required="" name="contraseña">
                    <label>Contraseña</label>
                </div>
                <div class="remember-forgot">
                    <!--check-->
                    <label><input type="checkbox" required>Recordarme</label>
                    <a href="#">¿Olvidaste la contraseña?</a>
                </div>
                <button type="submit" class="bth" name="inicio_sesion">Iniciar sesión</button>
                <div class="login-register">
                    <p>¿No tienes una cuenta? <a href="#" class="register-link">Registrarse</a></p>
                </div>
            </form>
        </div>
        <!--registro de usuario-->
        <div class="form-box register">
            <h2>Registro</h2>
            <?php
            include "./conexion_dba/conexion.php";
            include "./controlador_register/REcontrolador.php";
            ?>
            <form action="#" method="post">
                <!--usuario-->
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <input type="text" required="" name="usuario_registro">
                    <label>Nombre de usuario</label>
                </div>
                <!--correo -->
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" name="correo_registro" required="">
                    <label>Correo electrónico</label>
                </div>
                <!--ingresar contraseña-->
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password_register" required="">
                    <label>Contraseña</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" required>Acepto los términos y condiciones</label>
                </div>
                <button type="submit" class="bth" name="Register">Registrarse</button>
                <div class="login-register">
                    <p>¿Ya tienes una cuenta? <a href="#" class="login-link">Iniciar sesión</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>