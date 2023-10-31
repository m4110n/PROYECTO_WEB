<?php

//Verifica si no se ha proporcionado un parámetro id en la URL mediante el método GET
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];

include_once "base_de_datos.php";

//repara una consulta SQL para eliminar un registro de la tabla medicamentos donde el campo id coincide con el valor proporcionado en la URL
$sentencia = $base_de_datos->prepare("DELETE FROM medicamentos WHERE id = ?;");
$resultado = $sentencia->execute([$id]);

if($resultado === TRUE){
	header("Location:listar.php");
	exit;
}
else echo "Algo salió mal";
?>