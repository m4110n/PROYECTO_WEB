<?php

#si no se proporciona un índice válido en la URL, el script se detendrá aquí
if(!isset($_GET["indice"])) return;

#Este valor representa la posición en el carrito de compras del producto que se eliminará
$indice = $_GET["indice"];

session_start();

#Utiliza la función array_splice para eliminar un elemento del arreglo $_SESSION["carrito"]
array_splice($_SESSION["carrito"], $indice, 1);

#el usuario es redirigido a la página de ventas con un mensaje de que el producto ha sido quitado del carrito
header("Location:vender.php?status=3");
?>