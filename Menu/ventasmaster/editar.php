<?php

//Verifica si no se ha proporcionado un parámetro "id" en la URL mediante el método GET
if(!isset($_GET["id"])) exit();

//Obtiene el valor del parámetro "id" de la URL y lo almacena en la variable id
$id = $_GET["id"];
include_once "base_de_datos.php";

//Prepara una consulta SQL para seleccionar todos los campos de la tabla "medicamentos" donde el campo "id" coincide con el valor proporcionado en la URL
$sentencia = $base_de_datos->prepare("SELECT * FROM medicamentos WHERE id = ?;");
$sentencia->execute([$id]);

//Obtiene el resultado de la consulta y lo almacena en la variable producto
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
if($producto === FALSE){
	echo "¡No existe algún producto con ese ID!";
	exit();
}

?>
<?php include_once "encabezado.php" ?>
	<div class="col-xs-12">

	                
		<h1>Editar producto con el ID <?php echo $producto->id; ?></h1>
		<form method="post" action="guardarDatosEditados.php">
			<input type="hidden" name="id" value="<?php echo $producto->id; ?>">
	
			<label for="Codigo">Código :</label>
			<input value="<?php echo $producto->Codigo ?>" class="form-control" name="Codigo" required type="text" id="Codigo" placeholder="Escribe el código">

			<label for="Descripcion">Descripción:</label>
			<textarea required id="Descripcion" name="Descripcion" cols="30" rows="5" class="form-control"><?php echo $producto->Descripcion ?></textarea>

			<label for="Lote">Lote:</label>
			<input value="<?php echo $producto->Lote ?>" class="form-control" name="Lote" required type="text" id="Lote" placeholder="Lote">

			<label for="Existencia">Existencia:</label>
			<input value="<?php echo $producto->Existencia ?>" class="form-control" name="Existencia" required type="number" id="Existencia" placeholder="Existencia">

			<label for="Precio_compra">Precio de compra:</label>
			<input value="<?php echo $producto->Precio_compra ?>" class="form-control" name="Precio_compra" required type="number" id="Precio_compra" placeholder="Precio de compra">

			<label for="Precio_venta">Precio de venta:</label>
			<input value="<?php echo $producto->Precio_venta ?>" class="form-control" name="Precio_venta" required type="number" id="Precio_venta" placeholder="Precio de Venta">

			<label for="Estado">Estado:</label>
			<textarea required id="Estado" name="Estado" cols="30" rows="5" class="form-control"><?php echo $producto->Estado ?></textarea>

			<label for="Codigo_categoria">Codigo Categoria:</label>
			<input value="<?php echo $producto->Codigo_categoria ?>" class="form-control" name="Codigo_categoria" required type="number" id="Codigo_categoria" placeholder="Codigo de Categoria">

			<label for="Codigo_proveedor">Codigo Proveedor:</label>
			<input value="<?php echo $producto->Codigo_proveedor ?>" class="form-control" name="Codigo_proveedor" required type="number" id="Codigo_proveedor" placeholder="Codigo de Proveedor">

			<label for="Fecha_entrada">Fecha de Entrada:</label>
			<input value="<?php echo $producto->Fecha_entrada ?>" class="form-control" name="Fecha_entrada" required type="date" id="Fecha_entrada" placeholder="Fecha de Entrada">
			
			<label for="Fecha_salida">Fecha de Salida:</label>
			<input value="<?php echo $producto->Fecha_salida ?>" class="form-control" name="Fecha_salida" required type="date" id="Fecha_salida" placeholder="Fecha de Salida">

			<label for="Unidad_medida">Descripción:</label>
			<textarea required id="Unidad_medida" name="Unidad_medida" cols="30" rows="5" class="form-control"><?php echo $producto->Unidad_medida ?></textarea>

			<label for="Numero_estante">Numero de Estante:</label>
			<input value="<?php echo $producto->Numero_estante ?>" class="form-control" name="Numero_estante" required type="id" id="Numero_estante" placeholder="Numero de Estante">

			<label for="Nivel_estante">Nivel de Estante:</label>
			<input value="<?php echo $producto->Nivel_estante ?>" class="form-control" name="Nivel_estante" required type="id" id="Nivel_estante" placeholder="Nivel de Estante">

			<label for="Posicion">Posicion:</label>
			<input value="<?php echo $producto->Posicion ?>" class="form-control" name="Posicion" required type="id" id="Posicion" placeholder="Posicion">

			<br><br><input class="btn btn-info" type="submit" value="Guardar">
			<a class="btn btn-warning" href="./listar.php">Cancelar</a>
		</form>
	</div>
<?php include_once "pie.php" ?>

<footer class="container bg-dark text-light py-3">
    <p class="text-center m-0">Derechos de autor &copy; 2023 Anthony Efrain Estrada Barrera - ventasmaster</p>
</footer>
