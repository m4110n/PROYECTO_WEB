<?php

include_once("../conexion/conexion.php");

if (!empty($_POST["login"])) {
    if (!empty($_POST["UserName"]) and ($_POST["Password"])) {
        //almacenando valores de usuario
        $Usuario = $_POST["UserName"];
        $Contraseña = $_POST["Password"];
        //verificacion de datos ingresados con la base de datos
        $sql = $conn->query("select * from users where name ='$Usuario' and password ='$Contraseña'");
        //validacion 1
        if ($datos = $sql->fetch_object()) {
            //insertar el menu de inicio en url.php
            header("location: ../Menu/index.php");
        } else {
            echo "<div class='alert-danger' >Acceso denegado</div>";
        }
    } else {
        echo "Campos vacios";
    }
}
