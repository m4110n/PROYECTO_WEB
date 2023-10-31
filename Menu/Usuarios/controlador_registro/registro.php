<?php
if (isset($_POST["Registrar"]) && !empty($_POST["nombre"]) && !empty($_POST["Correo"]) && isset($_POST["Permisos"]) && !empty($_POST["Contraseña"]) && isset($_POST["Estatus"])) {

    $nombre = $_POST["nombre"];
    $email = $_POST["Correo"];
    $permisos = $_POST["Permisos"];
    $contraseña = $_POST["Contraseña"];
    $status = $_POST["Estatus"];

    $sql = $conn->query("INSERT INTO users (name, email, permissions, password, status) VALUES ('$nombre', '$email', '$permisos', '$contraseña', '$status')");

    if ($sql == TRUE) {
        echo '<div class="alert alert-success">Persona registrada correctamente</div>';
    } else {
        echo '<div class="alert alert-danger">Error de registro</div>';
    }
}
