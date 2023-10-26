<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre'])) {
    // Redirigir a la página de inicio de sesión si no está logueado
    header("Location: ../login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reportes</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 40px;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        h1 {
            font-size: 32px;
        }

        p {
            font-size: 18px;
            line-height: 1.5;
        }


        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 10px;
        }

        ul li a {
            text-decoration: none;
        }

        ul li a button {
            background-color: #ddd;
            color: #333;
            padding: 20px 40px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 24px;
            display: block;
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <h1>REPORTES</h1>

    </header>

    <!-- Botón desplegable en la parte superior derecha -->
    <div class="btn-group float-right">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="index.php">
                <i class="fas fa-home"></i> Inicio
            </a>
            <a class="dropdown-item" href="ventas.php">
                <i class="fas fa-users"></i> Reporte Venta
            </a>
            <a class="dropdown-item" href="compras.php">
                <i class="fas fa-shopping-cart"></i> Compras
            </a>
            <a class="dropdown-item" href="empleados.php">
                <i class="fas fa-user"></i> Empleados
            </a>
            <a class="dropdown-item" href="productos.php">
                <i class="fas fa-box"></i> Productos
            </a>
            <a class="dropdown-item" href="proveedores.php">
                <i class="fas fa-truck"></i> Proveedores
            </a>
            <a class="dropdown-item" href="usuarios.php">
                <i class="fas fa-user-circle"></i> Usuarios
            </a>
            <a class="dropdown-item" href="ventas.php">
                <i class="fas fa-dollar-sign"></i> Ventas
            </a>
            <a class="dropdown-item" href="categorias.php">
                <i class="fas fa-tags"></i> Categorías
            </a>
        </div>
    </div>

    <ul>
        <li><a href="Reportes1.php"><button>Reporte por rango de fecha para cuadre de inventario físico de medicamentos</button></a></li>
        <li><a href="Reportes2.php"><button>Reporte de medicamentos próximos a vencer</button></a></li>
        <li><a href="Reportes3.php"><button>Reporte de ventas Diaria</button></a></li>
        <li><a href="Reportes4.php"><button>Reporte de ventas Mensual</button></a></li>
        <li><a href="Reportes.php"><button>Reporte de rentabilidad</button></a></li>
    </ul>


    <footer>
        <div class="container">
            <p>Derechos de autor &copy; 2023 Ana Maria Cordero Aguilar - BOTIQUIN S.A</p>
        </div>
    </footer>



</body>

</html>