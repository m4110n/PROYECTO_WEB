<?php
//tomamos los datos del formulario y comprobamos que esten en los campos
if (isset($_POST["Register"]) && isset($_POST["usuario_registro"]) && isset($_POST["correo_registro"]) && isset($_POST["password_register"])) {
    $nombre = $_POST["usuario_registro"];
    $email = $_POST["correo_registro"];
    $contraseña = $_POST["password_register"];

    // Insertar datos en la base de datos por default
    $sql = $conn->query("INSERT INTO users(name, email, permissions, password, status) VALUES ('$nombre', '$email', 'user', '$contraseña', 'active')");
}
