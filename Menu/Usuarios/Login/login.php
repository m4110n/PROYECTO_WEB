<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated login form 02</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="box">
        <span class="borderLine"></span>
        <!--Formulario metodo de envio-->
        <form action="" method="post">
            <?php
            include "./controladores/controller_login.php";
            include "./controladores/conexion.php";
            ?>
            <!--Validacion para el formulario-->
            <h2>Super Usuario</h2>
            <div class="inputBox">
                <input type="text" name="UserName" required="required">
                <span>Usuario</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="Password" name="Password" required="required">
                <span>Contraseña</span>
                <i></i>
            </div>
            <input type="submit" name="iniciosesion" value="login">
        </form>
</body>

</html>