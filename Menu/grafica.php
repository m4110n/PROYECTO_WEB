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
    <title>Gráfico de Ventas</title>
    <!-- Incluir la biblioteca de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1>Gráfico de Ventas</h1>

    <!-- Crear un elemento canvas para el gráfico -->
    <canvas id="graficoVentas" width="400" height="200"></canvas>

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
    $consulta = "SELECT Sale_Date, Total_Price FROM sales";

    // Ejecutar la consulta
    $resultado = $conexion->query($consulta);

    // Crear arrays para almacenar los datos
    $fechas = [];
    $totalPrecios = [];

    // Obtener los resultados y llenar los arrays
    while ($fila = $resultado->fetch_assoc()) {
        $fechas[] = $fila['Sale_Date'];
        $totalPrecios[] = $fila['Total_Price'];
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
    ?>

    <script>
        // Obtener los datos de PHP y convertirlos a JavaScript
        var fechas = <?php echo json_encode($fechas); ?>;
        var totalPrecios = <?php echo json_encode($totalPrecios); ?>;

        // Obtener el elemento canvas para el gráfico
        var ctx = document.getElementById('graficoVentas').getContext('2d');

        // Crear el gráfico de línea
        var grafico = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: 'Total de Ventas',
                    data: totalPrecios,
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
    </script>
</body>

</html>