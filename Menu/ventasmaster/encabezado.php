<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre'])) {
	// Redirigir a la página de inicio de sesión si no está logueado
	header("Location: ../../../../login/login.phpa");
	exit();
}
?>

<!-- //lineas que indian que es un documento html5 y esta en español con el lang es -->
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title>Ventas</title>

	<!-- //se inclyen hojas de estilo que se encuentran en la carpeta css -->
	<link rel="stylesheet" href="./css/fontawesome-all.min.css">
	<link rel="stylesheet" href="./css/2.css">
	<link rel="stylesheet" href="./css/estilo.css">
</head>

<body>

	<!-- //Crea una barra de navegación con un fondo oscuro y la fija en la parte superior de la página -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">ThonnyMaster</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="listar.php">Productos</a></li>
					<li><a href="vender.php">Vender</a></li>
					<li><a href="ventas.php">Ventas</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- //se utilizan para crear un contenedor principal y una fila para organizar el contenido principal de la página -->
	<div class="container">
		<div class="row">