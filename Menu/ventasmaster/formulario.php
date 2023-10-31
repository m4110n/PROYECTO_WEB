<?php include_once "encabezado.php" ?>

<div class="col-xs-12">
	<h1>Nuevo producto</h1>
	<form method="post" action="nuevo.php">
		<label for="Codigo">Código:</label>
		<input class="form-control" name="Codigo" required type="number" id="Codigo" placeholder="Escribe el código">

		<label for="Descripcion">Descripción:</label>
		<textarea required id="Descripcion" name="Descripcion" cols="30" rows="5" class="form-control"></textarea>

		<label for="Lote">Lote:</label>
		<input class="form-control" name="Lote" required type="text" id="Lote">

		<label for="Existencia">Existencia:</label>
		<input class="form-control" name="Existencia" required type="number" id="Existencia" placeholder="Existencia">

		<label for="Precio_compra">Precio de Compra:</label>
		<input class="form-control" name="Precio_compra" required type="number" step="0.01" id="Precio_compra" placeholder="Precio de Compra">

		<label for="Precio_venta">Precio de venta:</label>
		<input class="form-control" name="Precio_venta" required type="number" step="0.01" id="Precio_venta" placeholder="Precio de venta">

		<label for="Estado">Estado:</label>
		<input class="form-control" name="Estado" required type="text" id="Estado" placeholder="Estado">

		<label for="Codigo_categoria">Codigo de Categoria:</label>
		<input class="form-control" name="Codigo_categoria" required type="number" id="Codigo_categoria" placeholder="Codigo de Categoria">

		<label for="Codigo_proveedor">Codigo de Proveedor:</label>
		<input class="form-control" name="Codigo_proveedor" required type="number" id="Codigo_proveedor" placeholder="Codigo de Proveedor">

		<label for="Fecha_entrada">Fecha de Entrada:</label>
		<input class="form-control" name="Fecha_entrada" required type="date" id="Fecha_entrada">

		<label for="Fecha_salida">Fecha de Salida:</label>
		<input class="form-control" name="Fecha_salida" required type="date" id="Fecha_salida">

		<label for="Unidad_medida">Unidad de Medida:</label>
		<input class="form-control" name="Unidad_medida" required type="text" id="Unidad_medida" placeholder="Unidad de Medida">

		<label for="Numero_estante">Numero de Estante:</label>
		<input class="form-control" name="Numero_estante" required type="number" id="Numero_estante" placeholder="Numero de Estante">

		<label for="Nivel_estante">Nivel de Estante:</label>
		<input class="form-control" name="Nivel_estante" required type="number" id="Nivel_estante" placeholder="Nivel de Estante">

		<label for="Posicion">Posicion:</label>
		<input class="form-control" name="Posicion" required type="number" id="Posicion" placeholder="Posicion">


		<br><br><input class="btn btn-info" type="submit" value="Guardar">
	</form>
</div>
<?php include_once "pie.php" ?>

<footer class="container bg-dark text-light py-3">
	<p class="text-center m-0">Derechos de autor &copy; 2023 Anthony Efrain Estrada Barrera - ventasmaster</p>
</footer>