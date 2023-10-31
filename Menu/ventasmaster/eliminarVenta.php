<?php

#Verifica si la variable $_GET["id"] está definida en la URL
if(!isset($_GET["id"])) exit();

#Asigna el valor de "id" pasado en la URL a la variable $id
$id = $_GET["id"];

include_once "base_de_datos.php";

#Prepara una sentencia SQL para eliminar una fila de la tabla "ventas" donde el campo "id" sea igual al valor proporcionado. La sentencia se prepara para su posterior ejecución.
$sentencia = $base_de_datos->prepare("DELETE FROM ventas WHERE id = ?;");

#El resultado de la ejecución se almacena en la variable $resultado.
$resultado = $sentencia->execute([$id]);

if($resultado === TRUE){
	header("Location: ventas.php");
	exit;
}
else echo "Algo salió mal";
?>