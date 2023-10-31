<?php

#inicia la sesion para manipular SESSION


include_once "encabezado.php";

#erifica si la variable de sesión "carrito" existe. Si no existe, se crea como un arreglo vacío. Esta variable de sesión se utiliza para almacenar los productos en el carrito de compras.
if (!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];

#variable que inicializa en 0, que se utiliza para llevar el costo total de los productos
$granTotal = 0;
?>
<div class="col-xs-12">
	<h1>Vender</h1>
	<?php

	#se utiliza el estatus para mostrar mensajes de exito 
	if (isset($_GET["status"])) {
		if ($_GET["status"] === "1") {
	?>
			<div class="alert alert-success">
				<strong>¡Correcto!</strong> Venta realizada correctamente
			</div>
		<?php
		} else if ($_GET["status"] === "2") {
		?>
			<div class="alert alert-info">
				<strong>Venta cancelada</strong>
			</div>
		<?php
		} else if ($_GET["status"] === "3") {
		?>
			<div class="alert alert-info">
				<strong>Ok</strong> Producto quitado de la lista
			</div>
		<?php
		} else if ($_GET["status"] === "4") {
		?>
			<div class="alert alert-warning">
				<strong>Error:</strong> El producto que buscas no existe
			</div>
		<?php
		} else if ($_GET["status"] === "5") {
		?>
			<div class="alert alert-danger">
				<strong>Error: </strong>El producto está agotado
			</div>
		<?php
		} else {
		?>
			<div class="alert alert-danger">
				<strong>Error:</strong> Algo salió mal mientras se realizaba la venta
			</div>
	<?php
		}
	}
	?>
	<br>
	<form method="post" action="agregarAlCarrito.php">
		<label for="Codigo">Código </label>
		<input autocomplete="off" autofocus class="form-control" name="Codigo" required type="text" id="Codigo" placeholder="Escribe el código">
	</form>
	<br><br>
	<table class="table table-bordered">
		<thead>
			<tr>

			        <th>ID</th>
			        <th>Codigo</th>
					<th>Descripcion</th>
					<th>Precio Compra</th>
					<th>Precio Venta</th>
					<th>Cantidad</th>
					<th>Total</th>
					
				    <th>Quitar</th>
							
			</tr>
		</thead>
		<tbody>
			
		<!-- para mostrar la informacion de cada producto  -->
			<?php foreach ($_SESSION["carrito"] as $indice => $producto) {
				$granTotal += $producto->total;
			?>
				<tr>

				    <td><?php echo $producto->id ?></td>
				    <td><?php echo $producto->Codigo ?></td>
					<td><?php echo $producto->Descripcion ?></td>
					<td><?php echo $producto->Precio_compra ?></td>
					<td><?php echo $producto->Precio_venta ?></td>
					<td><?php echo $producto->Cantidad ?></td>
					<td><?php echo $producto->total ?></td>
					
					
					<td><a class="btn btn-danger" href="<?php echo "quitarDelCarrito.php?indice=" . $indice ?>"><i class="fa fa-trash"></i></a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<!-- se calcula el grantotal -->
	<h3>Total: <?php echo $granTotal; ?></h3>
	<form action="terminarVenta.php" method="POST">

	<!-- para que se pueda utilizar en el proceso de finalización de la venta -->
		<input name="total" type="hidden" value="<?php echo $granTotal; ?>">

		<!-- se incluyen los botones  -->
		<button type="submit" class="btn btn-success">Terminar venta</button>
		<a href="cancelarVenta.php" class="btn btn-danger">Cancelar venta</a>
		<a class="btn btn-primary" href="../Menu/index.php">Regresar al Menu Principal <i class="fa fa-arrow-left"></i></a>
	</form>
</div>
<?php include_once "pie.php" ?>

<footer class="container bg-dark text-light py-3">
    <p class="text-center m-0">Derechos de autor &copy; 2023 Anthony Efrain Estrada Barrera - ventasmaster</p>
</footer>