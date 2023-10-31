<?php include_once "encabezado.php" ?>
<?php

include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM medicamentos;");
$medicamentos = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

	<div class="col-xs-12">
	<h1>Lista de Productos</h1>

<!-- //boton para exportar a excel -->
<a class="btn btn-success" href="crear_excel.php">Exporatar a Excel</a>
    </div></div>
	<br>
   


		<table class="table table-bordered">
			<thead>
				<tr>

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
					<!-- <th>Editar</th>
					<th>Eliminar</th> -->
				</tr>
			</thead>
			<tbody>
				<?php foreach($medicamentos as $producto){ ?>
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

       
					<!-- <td><a class="btn btn-warning" href="<?php echo "editar.php?id=" . $producto->id?>"><i class="fa fa-edit"></i></a></td>
					<td><a class="btn btn-danger" href="<?php echo "eliminar.php?id=" . $producto->id?>"><i class="fa fa-trash"></i></a></td> -->
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	
<?php include_once "pie.php" ?>

<footer class="container bg-dark text-light py-3">
    <p class="text-center m-0">Derechos de autor &copy; 2023 Anthony Efrain Estrada Barrera - VentasMaster</p>
</footer>

 
 