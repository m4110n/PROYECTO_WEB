<?php

#Esta línea verifica si la variable POST "total" está presente. Si no está presente, se utiliza la función
if(!isset($_POST["total"])) exit;


session_start();

#Obtiene el valor de la variable POST "total" y lo almacena en la variable $total
$total = $_POST["total"];

include_once "base_de_datos.php";

#btiene la fecha y hora actual y almacena este valor en la variable ahora
$ahora = date("Y-m-d H:i:s");

#Se prepara una consulta SQL para insertar un nuevo registro en la tabla "ventas" que registra la venta, incluyendo la fecha y el total.
$sentencia = $base_de_datos->prepare("INSERT INTO ventas(fecha, total) VALUES (?, ?);");
$sentencia->execute([$ahora, $total]);


#Se ejecuta la consulta preparada con la fecha y el total de la venta
#Se prepara una consulta SQL para obtener el ID de la última venta registrada en la tabla "ventas."
$sentencia = $base_de_datos->prepare("SELECT id FROM ventas ORDER BY id DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);


#Se almacena el ID de la venta en la variable idVenta, Si no se puede obtener un resultado se establece el valor predeterminado de idVenta en 1.
$idVenta = $resultado === false ? 1 : $resultado->id;


#Se inicia una transacción en la base de datos utilizando $base_de_datos->beginTransaction(). Esto es útil para garantizar que todas las operaciones de inserción y actualización se realicen correctamente antes de confirmar la transacción
$base_de_datos->beginTransaction();


#Se prepara una consulta SQL para insertar registros en la tabla "productos_vendidos" que registra los productos vendidos en la venta, incluyendo el ID del producto, el ID de la venta y la cantidad vendida.
$sentencia = $base_de_datos->prepare("INSERT INTO productos_vendidos(id_producto, id_venta, Cantidad) VALUES (?, ?, ?);");

#Se prepara otra consulta SQL para actualizar la existencia de los productos en la tabla medicamentos, Se reduce la cantidad de existencia de cada producto vendido
$sentenciaExistencia = $base_de_datos->prepare("UPDATE medicamentos SET Existencia = Existencia - ? WHERE id = ?;");

#recorre cada elemento del arreglo que ha sido agregado al carrito de comprar 
foreach ($_SESSION["carrito"] as $producto) {
	
	#esto se hace para calcular el costo total de la venta sumando el total de cada producto del carrito 
	$total += $producto->total;

	#inserta un registro en la tabla 
	$sentencia->execute([$producto->id, $idVenta, $producto->Cantidad]);
	
	#actualiza la existencia del producto en la tabla medicamentos
	$sentenciaExistencia->execute([$producto->Cantidad, $producto->id]);
}

#esto asegura que todas las operaciones se completen con exito antes de confirmar la transaccion
$base_de_datos->commit();

#se limpia y renicia la variable se sesion llamada carrito
unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];



header("Location:vender.php?status=1");
?>