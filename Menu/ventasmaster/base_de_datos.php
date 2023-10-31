<?php

$servername = "localhost"; 
$usuario = "root";
$contraseña = "";
$nombre_base_de_datos = "botiquin_sa1";

 //el Try para manejar excepciones, errores que puedan ocurrir durante la ejecucion -->

try{
    // //se crea un contrustructor llamado PDO para conectarse a la base de datos 
	$base_de_datos = new PDO('mysql:host=localhost;dbname=' . $nombre_base_de_datos, $usuario, $contraseña);
    
    // Esto es comúnmente utilizado para asegurarse de que la base de datos maneje caracteres especiales 
	$base_de_datos->query("set names utf8;");

    // //Esto desactiva la emulación de sentencias preparadas,
    // //que las sentencias preparadas serán manejadas directamente por el controlador MySQL en lugar de ser emuladas por PDO.
    $base_de_datos->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

    // //lanzará excepciones en caso de errores de base de datos en lugar de simplemente devolver valores falsos o nulos
    $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // //lo que significa que las filas se recuperarán como objetos anónimos en lugar de matrices asociativas.
    $base_de_datos->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}catch(Exception $e){
	echo "Ocurrió algo con la base de datos: " . $e->getMessage();
}
