<?php
session_start();
// Dentro de controlador.php
if (isset($_POST['inicio_sesion'])) {
    if (isset($_POST["correo"]) and isset($_POST["contraseña"])) {
        $email = $_POST["correo"];
        $password = $_POST["contraseña"];
        //comparando datos
        $sql = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password' AND status='active'");
        if ($datos = $sql->fetch_object()) {
            //almacenando datos de la sesion
            $_SESSION["id"] = $datos->id;
            $_SESSION["nombre"] = $datos->name;
            $_SESSION["permissions"] = $datos->permissions;
            // Redirigir al usuario a otra página después del inicio de sesión exitoso
            header("Location: ../Menu/index.php");
            exit();  // Asegúrate de salir después de la redirección
        } else {
            //ridereccionar al login de nuevo
            header("Location: ./login.php");
        }
    } else {
        # code...
    }
}
