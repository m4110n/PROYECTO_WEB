<?php
#Salir si alguno de los datos no está presente
if(
!isset($_POST["Codigo"]) || 
!isset($_POST["Descripcion"]) || 
!isset($_POST["Lote"]) || 
!isset($_POST["Existencia"]) || 
!isset($_POST["Precio_compra"]) || 
!isset($_POST["Precio_venta"]) || 
!isset($_POST["Estado"]) || 
!isset($_POST["Codigo_categoria"]) || 
!isset($_POST["Codigo_proveedor"]) || 
!isset($_POST["Fecha_entrada"]) || 
!isset($_POST["Fecha_salida"]) || 
!isset($_POST["Unidad_medida"]) || 
!isset($_POST["Numero_estante"]) || 
!isset($_POST["Nivel_estante"]) || 
!isset($_POST["Posicion"])) 
exit();

#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";


$Codigo = $_POST["Codigo"];
$Descripcion = $_POST["Descripcion"];
$Lote = $_POST["Lote"];
$Existencia= $_POST["Existencia"];
$Precio_compra = $_POST["Precio_compra"];
$Precio_venta= $_POST["Precio_venta"];
$Estado= $_POST["Estado"];
$Codigo_categoria = $_POST["Codigo_categoria"];
$Codigo_proveedor = $_POST["Codigo_proveedor"];
$Fecha_entrada = $_POST["Fecha_entrada"];
$Fecha_salida = $_POST["Fecha_salida"];
$Unidad_medida = $_POST["Unidad_medida"];
$Numero_estante = $_POST["Numero_estante"];
$Nivel_estante = $_POST["Nivel_estante"];
$Posicion = $_POST["Posicion"];


#Se prepara una consulta SQL para insertar un nuevo registro en la tabla "medicamentos". Se utilizan marcadores de posición "?" en la consulta para evitar la inyección SQL
$sentencia = $base_de_datos->prepare("INSERT INTO medicamentos(Codigo, Descripcion, Lote, Existencia, Precio_compra, Precio_venta, Estado, Codigo_categoria, Codigo_proveedor, Fecha_entrada, Fecha_salida, Unidad_medida, Numero_estante, Nivel_estante, Posicion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?);");

#Se ejecuta la consulta SQL preparada utilizando el método execute(), y se proporcionan los valores necesarios para los marcadores de posición en la consulta
$resultado = $sentencia->execute([$Codigo, $Descripcion, $Lote, $Existencia, $Precio_compra, $Precio_venta, $Estado, $Codigo_categoria, $Codigo_proveedor, $Fecha_entrada, $Fecha_salida, $Unidad_medida, $Numero_estante, $Nivel_estante, $Posicion]);

if($resultado === TRUE){
	header("Location:listar.php");
	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista";


?>
<?php include_once "pie.php" ?>

<footer class="container bg-dark text-light py-3">
    <p class="text-center m-0">Derechos de autor &copy; 2023 Anthony Efrain Estrada Barrera - ventasmaster</p>
</footer>