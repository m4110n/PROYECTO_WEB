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
    <title>Mostrar Ventas</title>
    <!-- Agrega los enlaces a los estilos de Bootstrap y DataTables -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

</head>

<body>
    <!-- Botón desplegable en la parte superior derecha -->
    <div class="btn-group float-right">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="index.php">
                <i class="fas fa-home"></i> Inicio
            </a>
            <a class="dropdown-item" href="clientes.php">
                <i class="fas fa-users"></i> Clientes
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
    <div class="container mt-5">
        <h1>Listado de Ventas</h1>

        <!-- Formulario para mostrar las ventas -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button type="submit" class="btn btn-primary" name="mostrar_ventas">Mostrar Ventas</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "botiquin_sa";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            // Consulta para seleccionar todas las ventas
            $sql = "SELECT Code, Nit, Client_Code, Client_Name, Sale_Date FROM sales";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Mostrar los datos de las ventas en una tabla con estilos de Bootstrap y DataTables
                echo '<table id="ventasTable" class="table table-bordered table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Nit</th>
                                <th>Client Code</th>
                                <th>Client Name</th>
                                <th>Sale Date</th>
                            </tr>
                        </thead>
                        <tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row["Code"] . '</td>
                            <td>' . $row["Nit"] . '</td>
                            <td>' . $row["Client_Code"] . '</td>
                            <td>' . $row["Client_Name"] . '</td>
                            <td>' . $row["Sale_Date"] . '</td>
                          </tr>';
                }
                echo '</tbody></table>';
            } else {
                echo "No se encontraron ventas.";
            }

            // Cerrar la conexión a la base de datos
            $conn->close();
        }
        ?>

    </div>

    <!-- Agrega los enlaces a los scripts de jQuery, DataTables y Bootstrap al final del body -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script>
        // Inicializa DataTables en la tabla de ventas
        $(document).ready(function() {
            $('#ventasTable').DataTable();
        });
    </script>
</body>

</html>