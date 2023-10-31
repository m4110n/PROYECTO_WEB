<?php include_once "encabezado.php" ?>
<?php
include_once "base_de_datos.php";

#Ejecuta una consulta SQL que busca información sobre las ventas. La consulta realiza una operación JOIN en varias tablas para obtener detalles de las ventas y productos vendidos, y los concatena en una sola cadena separada por '__'. Luego, la consulta agrupa los resultados por el ID de la venta y los ordena por ese mismo ID
$sentencia = $base_de_datos->query("SELECT ventas.total, ventas.fecha, ventas.id, GROUP_CONCAT(	medicamentos.Codigo, '..',  medicamentos.Descripcion, '..', productos_vendidos.Cantidad SEPARATOR '__') AS medicamentos FROM ventas INNER JOIN productos_vendidos ON productos_vendidos.id_venta = ventas.id INNER JOIN medicamentos ON medicamentos.id = productos_vendidos.id_producto GROUP BY ventas.id ORDER BY ventas.id;");

#Ejecuta la consulta y almacena los resultados en un array de objetos
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

	<div class="col-xs-12">
		<h1>Ventas</h1>
		<div>
			<a class="btn btn-success" href="vender.php">Nueva <i class="fa fa-plus"></i></a>
		</div>
		<br>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Número</th>
					<th>Fecha</th>
					<th>Productos vendidos</th>
					<th>Total</th>
					<th>Ticket</th>
					<th>Eliminar</th>
				</tr>
			</thead>
			<tbody>

			<!-- Inicia un bucle foreach que recorre cada venta en el array de ventas -->
				<?php foreach($ventas as $venta){ ?>
				<tr>

				<!-- Llena las celdas de la fila con información de la venta -->
					<td><?php echo $venta->id ?></td>
					<td><?php echo $venta->fecha ?></td>
					<td>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>Descripción</th>
									<th>Cantidad</th>
								</tr>
							</thead>
							<tbody>
							<!-- Inicia un bucle foreach que recorre un array generado a partir de la cadena de texto $venta->medicamentos. La cadena se divide en elementos usando el separador __, y cada elemento se almacena en la variable $productosConcatenados -->
								<?php foreach(explode("__", $venta->medicamentos) as $productosConcatenados){ 

                               // Divide la cadena $productosConcatenados en un nuevo array llamado $producto utilizando el separador ... Esto separa la información de cada producto en tres partes	
								$producto = explode("..", $productosConcatenados)
								?>
								<tr>
									<td><?php echo $producto[0] ?></td>
									<td><?php echo $producto[1] ?></td>
									<td><?php echo $producto[2] ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</td>

					<!-- Muestra el total de la venta en una celda de la tabla principal -->
					<td><?php echo $venta->total ?></td>

					<!-- los dos siguientes son para los botones  -->
					<td><a class="btn btn-info" href="<?php echo "imprimirTicket.php?id=" . $venta->id?>"><i class="fa fa-print"></i></a></td>
					<td><a class="btn btn-danger" href="<?php echo "eliminarVenta.php?id=" . $venta->id?>"><i class="fa fa-trash"></i></a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<a class="btn btn-primary" href="../Menu/index.php">Regresar al Menu Principal <i class="fa fa-arrow-left"></i></a>
	
<?php include_once "pie.php" ?>

<footer class="container bg-dark text-light py-3">
    <p class="text-center m-0">Derechos de autor &copy; 2023 Anthony Efrain Estrada Barrera - ventasmaster</p>
</footer>