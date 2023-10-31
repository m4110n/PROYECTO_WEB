<!-- //incluye el contendido del archivo encabezado.php -->
<?php include_once "encabezado.php" ?>
<?php

//imporar el contenido del archivo 
include_once "base_de_datos.php";

//aqui se ejecuta la consulta a la base de datos, los registros de la tabla los almacena en la variable llamada sentencia 
$sentencia = $base_de_datos->query("SELECT * FROM medicamentos;");

//obtiene todas las filas de la sentencia y las almacena en una array
$medicamentos = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

<!-- //incluyendo un contenedor  -->
<div class="col-xs-12">
	<h1>Productos</h1>

	<div>
		<!-- //los siguinte son los botones  -->
		<a class="btn btn-success" href="formulario.php">Nuevo <i class="fa fa-plus"></i></a>
		<a class="btn btn-warning" href="consultar.php">Consultar</a>
		<a class="btn btn-primary" href="../index.php">Regresar al Menu Principal <i class="fa fa-arrow-left"></i></a></a>
		<br><br>
	</div>
</div>

<!-- //se crea la tabla  -->
<table class="table table-bordered">
	<thead>
		<tr>
			<!-- //con todos los datos que contiene la tabla medicamentos -->
			<th>ID</th>
			<th>Codigo</th>
			<th>Descripcion</th>
			<th>Lote</th>
			<th>Existencia</th>
			<th>Precio Compra</th>
			<th>Precio Venta</th>
			<th>Estado</th>
			<th>Codigo Categoria</th>
			<th>Codigo Proveedor</th>
			<th>Fecha_Entrada</th>
			<th>Fecha_Salida</th>
			<th>Unidad Medida</th>
			<th>Numero Estante</th>
			<th>Nivel Estante</th>
			<th>Posicion</th>
			<th>Editar</th>
			<th>Eliminar</th>
		</tr>
	</thead>
	<tbody>

		<!-- //con el bucle foreach se recorre el array medicamentos que contiene los registros, se imprimen los resgistros del objeto producto  -->
		<?php foreach ($medicamentos as $producto) { ?>
			<tr>

				<td><?php echo $producto->id ?></td>
				<td><?php echo $producto->Codigo ?></td>
				<td><?php echo $producto->Descripcion ?></td>
				<td><?php echo $producto->Lote ?></td>
				<td><?php echo $producto->Existencia ?></td>
				<td><?php echo $producto->Precio_compra ?></td>
				<td><?php echo $producto->Precio_venta ?></td>
				<td><?php echo $producto->Estado ?></td>
				<td><?php echo $producto->Codigo_categoria ?></td>
				<td><?php echo $producto->Codigo_proveedor ?></td>
				<td><?php echo $producto->Fecha_entrada ?></td>
				<td><?php echo $producto->Fecha_salida ?></td>
				<td><?php echo $producto->Unidad_medida ?></td>
				<td><?php echo $producto->Numero_estante ?></td>
				<td><?php echo $producto->Nivel_estante ?></td>
				<td><?php echo $producto->Posicion ?></td>

				<!-- se crean las dos opciones para editar y eliminar a traves del id  -->
				<td><a class="btn btn-warning" href="<?php echo "editar.php?id=" . $producto->id ?>"><i class="fa fa-edit"></i></a></td>
				<td><a class="btn btn-danger" href="<?php echo "eliminar.php?id=" . $producto->id ?>"><i class="fa fa-trash"></i></a></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
</div>

<!-- //se incluje lo que esta en el archivo pie -->
<?php include_once "pie.php" ?>

<footer class="container bg-dark text-light py-3">
	<p class="text-center m-0">Derechos de autor &copy; 2023 Anthony Efrain Estrada Barrera - VentasMaster</p>
</footer>