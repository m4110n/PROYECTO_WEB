<?php
if (isset($_POST["Registrar"])) {
    if (isset($_POST["nombre"]) && isset($_POST["Correo"]) && isset($_POST["Permisos"]) && isset($_POST["Contraseña"]) && isset($_POST["Estatus"])) {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $email = $_POST["Correo"];
        $permisos = $_POST["Permisos"];
        $contraseña = $_POST["Contraseña"];
        $status = $_POST["Estatus"];

        $sql = $conn->query("UPDATE users SET name='$nombre', email='$email', permissions='$permisos', password='$contraseña', status='$status' WHERE id=$id");

        if ($sql == 1) {
            header("location: ./usuarios.php");
        } else {
            # code...
        }
    } else {
        echo " <div class='alert alert-warning'>Campos vacios</div>";
    }
}
