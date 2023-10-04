<?php
    $db_server = "localhost";
    $db_database = "botiquin_sa";
    $db_user = "root";
    $db_password = "";

    // Crear conexión
    $conn = mysqli_connect($db_server, $db_user, $db_password, $db_database);
    if (!$conn) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }
    // No cerrar conexión aquí
