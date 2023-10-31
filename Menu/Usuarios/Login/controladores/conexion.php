<?php
$servername = "localhost"; // Cambia esto al servidor de tu base de datos
$username = "root"; // Cambia esto a tu nombre de usuario de la base de datos
$password = ""; // Cambia esto a tu contraseña de la base de datos
$dbname = "botiquin_sa"; // Cambia esto al nombre de tu base de datos


// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
$conn->set_charset("utf8");
    // No cerrar conexión aquí
