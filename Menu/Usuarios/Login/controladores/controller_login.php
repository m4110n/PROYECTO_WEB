<?php
session_start();
include "conexion.php";
if (isset($_POST["iniciosesion"])) {
    if (isset($_POST["UserName"]) && isset($_POST["Password"])) {
        $usuario = $_POST["UserName"];
        $contraseña = $_POST["Password"];

        $sql = $conn->query("SELECT * FROM users WHERE name ='$usuario' AND password='$contraseña' AND permissions='admin'");
        if ($dato = $sql->fetch_object()) {
            $_SESSION["id"] = $dato->id;
            $_SESSION["name"] = $dato->name;

            header("Location: ../../usuarios.php"); // Corregí el encabezado de redirección
            exit(); // Añadí exit para asegurarme de que el script se detenga después de redirigir
        } else {
            echo "Nombre de usuario o contraseña incorrectos";
        }
    }
}
