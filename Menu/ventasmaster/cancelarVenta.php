<?php
#inicia la sesion para manipular SESSION
session_start();

#para eliminar el contenido de la variable de SESSION almacena los productos en el carrito de compras 
unset($_SESSION["carrito"]);

#crea un nuevo arreglo vacio 
$_SESSION["carrito"] = [];


#el usuario es redirigido a la página de ventas con un mensaje de que la venta ha sido cancelada
// header("Location:vender.php?status=2");
header("Location:vender.php?status=2");
?>