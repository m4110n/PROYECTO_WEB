<?php

if (!empty($_POST["login"])) {
    if (!empty($_POST["UserName"]) and ($_POST["Password"])) {
        //almacenando valores de usuario
        $usuario = $_POST["UserName"];
        $contraseña = $_POST["Password"];
    } else {
        echo "Campos vacios";
    }
}
