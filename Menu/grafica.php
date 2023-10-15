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
    <title>Gráficos de Ventas y Productos</title>
    <!-- Incluir la biblioteca de Chart.js y Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Gráficos de Ventas y Productos</h1>

        <div class="row">
            <div class="col-md-6">
                <h2>Gráfico de Ventas</h2>
                <canvas id="graficoVentas" width="400" height="200"></canvas>
            </div>
            <div class="col-md-6">
                <h2>Gráfico de Productos</h2>
                <canvas id="graficoProductos" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <?php
    // Conexión a la base de datos
    $host = "localhost";
    $usuario = "root";
    $contraseña = "";
    $base_de_datos = "botiquin_sa";

    $conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Consulta SQL para obtener los datos de ventas
    $consultaVentas = "SELECT Sale_Date, Total_Price FROM sales";

    // Ejecutar la consulta de ventas
    $resultadoVentas = $conexion->query($consultaVentas);

    // Crear arrays para almacenar los datos de ventas
    $fechasVentas = [];
    $totalPreciosVentas = [];

    // Obtener los resultados de ventas y llenar los arrays
    while ($fila = $resultadoVentas->fetch_assoc()) {
        $fechasVentas[] = $fila['Sale_Date'];
        $totalPreciosVentas[] = $fila['Total_Price'];
    }

    // Consulta SQL para obtener los datos de productos
    $consultaProductos = "SELECT COUNT(*) as totalProductos FROM medications";

    // Ejecutar la consulta de productos
    $resultadoProductos = $conexion->query($consultaProductos);

    // Obtener el total de productos
    $totalProductos = $resultadoProductos->fetch_assoc()['totalProductos'];

    // Cerrar la conexión a la base de datos
    $conexion->close();
    ?>

    <script>
        // Obtener los datos de ventas y convertirlos a JavaScript
        var fechasVentas = <?php echo json_encode($fechasVentas); ?>;
        var totalPreciosVentas = <?php echo json_encode($totalPreciosVentas); ?>;

        // Obtener el total de productos
        var totalProductos = <?php echo $totalProductos; ?>;

        // Obtener el elemento canvas para el gráfico de ventas
        var ctxVentas = document.getElementById('graficoVentas').getContext('2d');

        // Crear el gráfico de línea para ventas
        var graficoVentas = new Chart(ctxVentas, {
            type: 'line',
            data: {
                labels: fechasVentas,
                datasets: [{
                    label: 'Total de Ventas',
                    data: totalPreciosVentas,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Obtener el elemento canvas para el gráfico de productos
        var ctxProductos = document.getElementById('graficoProductos').getContext('2d');

        // Crear el gráfico de barras para productos
        var graficoProductos = new Chart(ctxProductos, {
            type: 'bar',
            data: {
                labels: ['Total de Productos'],
                datasets: [{
                    label: 'Cantidad',
                    data: [totalProductos],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>