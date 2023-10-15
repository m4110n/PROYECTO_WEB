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
    <title>BOTIQUIN S.A</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Enlaza el archivo CSS -->

</head>

<body>
    <header>
        <h1 class="text-center display-4">BIENVENIDOS A BOTIQUIN S.A</h1>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home"></i> INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cogs"></i> Configuración</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/controlador_login/controlador_cerrar/controlador_cerrar_sesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php"><i class="fas fa-envelope"></i> CONTACTO</a>
                        <!-- Div de usuario logueado -->
                        <div class="text-white bg-custom-purple p-2 ml-2">
                            <?php echo "Usuario  " . $_SESSION["nombre"]; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <!-- Barra izquierda -->
            <div class="col-md-3">
                <div class="menu-izquierdo">
                    <div class="logo">
                        <a href="#">Botiquín S.A</a>
                    </div>
                    <ul class="menu-list">
                        <li><a href="ultimas_ventas_realizadas.php">Últimas ventas realizadas <i class="fas fa-chart-line"></i></a></li>
                        <li><a href="productos_mas_vendidos.php">Productos más vendidos <i class="fas fa-shopping-bag"></i></a></li>
                        <li><a href="proximos_vencer.php">Productos próximos a vencer <i class="fas fa-exclamation-circle"></i></a></li>
                        <li><a href="#">Reportes <i class="fas fa-file-alt"></i></a></li>
                        <li><a href="generar_factura.php">Generar Factura <i class="fas fa-file-alt"></i></a></li>

                    </ul>
                </div>
            </div>
            <!-- Contenido principal -->
            <div class="col-md-9">
                <div class="container mt-4 mb-4">
                    <h2>
                        <i class="fas fa-tachometer-alt"></i> Tablero
                    </h2>
                </div>
                <div class="row">
                    <!-- Iconos de acceso rápido -->
                    <div class="col-md-3">
                        <a href="clientes.php" class="icon-link">
                            <i class="fas fa-users fa-3x"></i>
                            <p>Clientes</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="enlace2.php" class="icon-link">
                            <i class="fas fa-shopping-cart fa-3x"></i>
                            <p>Compras</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="enlace3.php" class="icon-link">
                            <i class="fas fa-user-tie fa-3x"></i>
                            <p>Empleados</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="enlace4.php" class="icon-link">
                            <i class="fas fa-box fa-3x"></i>
                            <p>Productos</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="proveedores.php" class="icon-link">
                            <i class="fas fa-truck fa-3x"></i>
                            <p>Proveedores</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="enlace6.php" class="icon-link">
                            <i class="fas fa-user fa-3x"></i>
                            <p>Usuarios</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="ventas.php" class="icon-link">
                            <i class="fas fa-chart-line fa-3x"></i>
                            <p>Ventas</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="enlace8.php" class="icon-link">
                            <i class="fas fa-folder fa-3x"></i>
                            <p>Categorías</p>
                        </a>
                    </div>
                    <!-- Agrega más iconos aquí -->
                    <div class="col-md-3">
                        <a href="grafica.php" class="icon-link">
                            <i class="fas fa-chart-pie fa-3x"></i>
                            <p>Estadísticas</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="icon-link">
                            <i class="fas fa-wrench fa-3x"></i>
                            <p>Herramientas</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="icon-link">
                            <i class="fas fa-briefcase fa-3x"></i>
                            <p>Proyectos</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="icon-link">
                            <i class="fas fa-calendar-alt fa-3x"></i>
                            <p>Calendario</p>
                        </a>
                    </div>
                    <!-- Fin de los iconos -->
                </div>
            </div>
        </div>
    </div>

    <!-- Botón para mostrar/ocultar el menú -->
    <div class="menu-toggle">
        <button id="mostrarMenu">
            <i class="fas fa-bars"></i> Mostrar Menú
        </button>
    </div>

    <!-- Menú desplegable desde la derecha -->
    <div class="menu-derecho">
        <ul class="list-group">
            <li class="list-group-item"><a href="galeria.php"><i class="fas fa-images"></i> Galería</a></li>
            <ul class="list-group">
                <li class="list-group-item"><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                <li class="list-group-item"><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                <li class="list-group-item"><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
            </ul>

    </div>

    <script>
        // Función para mostrar/ocultar el menú al hacer clic en el botón
        document.getElementById('mostrarMenu').addEventListener('click', function() {
            document.querySelector('.menu-derecho').classList.toggle('mostrar-menu');
        });

        // Función para desplegar el menú de reportes
        document.getElementById('reportesDropdown').addEventListener('click', function(event) {
            event.preventDefault();
            document.querySelector('.submenu').classList.toggle('mostrar-menu'); // Corregido el nombre del evento
        });
    </script>
</body>
<footer class="container bg-dark text-light py-3">
    <p class="text-center m-0">Derechos de autor &copy; 2023 Carlos Edward Rafael Donis Alvarado - BOTIQUIN S.A</p>
</footer>

</html>