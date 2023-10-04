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
            <!--Validacion para el formulario-->
            <h2>Sign in</h2>
            <?php
            include "controlador/controller_login.php";
            ?>
            <div class="inputBox">
                <input type="text" name="UserName" required="required">
                <span>User name</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="Password" name="Password" required="required">
                <span>Password</span>
                <i></i>
            </div>
            <div class="Links">
                <a href="#">Forgot Password</a>
                <a href="#">Sing</a>
            </div>
            <input type="submit" name="login" value="login">
        </form>
</body>

</html>