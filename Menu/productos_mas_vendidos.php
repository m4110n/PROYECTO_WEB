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
    <title>Productos Más Vendidos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
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
    <div class="container">
        <h1 class="mt-4">Productos Más Vendidos</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="search_column">Buscar en la columna:</label>
                <select name="search_column" class="form-control">
                    <option value="Code">Code</option>
                    <option value="Description">Description</option>
                    <option value="Lot">Lot</option>
                    <option value="Quantity">Quantity</option>
                    <option value="Purchase_Price">Purchase_Price</option>
                    <option value="Sale_Price">Sale_Price</option>
                    <option value="Status">Status</option>
                    <option value="Category_Code">Category_Code</option>
                    <option value="Supplier_Code">Supplier_Code</option>
                    <option value="Entry_Date">Entry_Date</option>
                    <option value="Expiry_Date">Expiry_Date</option>
                </select>
            </div>

            <div class="form-group">
                <label for="search_term">Término de búsqueda:</label>
                <input type="text" class="form-control" name="search_term">
            </div>

            <button type="submit" name="searchProducts" class="btn btn-primary">Buscar Productos</button>
        </form>

        <?php
        // Establecer la conexión a la base de datos
        $servername = "localhost"; // Cambia esto al servidor de tu base de datos
        $username = "root"; // Cambia esto a tu nombre de usuario de la base de datos
        $password = ""; // Cambia esto a tu contraseña de la base de datos
        $dbname = "botiquin_sa"; // Cambia esto al nombre de tu base de datos (sin espacios)

        // Crear una conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $page = 1; // Número de página actual
        $records_per_page = 10; // Cantidad de registros por página

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchProducts"])) {
            $search_column = $_POST["search_column"];
            $search_term = $_POST["search_term"];

            // Realizar una consulta SQL para buscar productos por columna
            $sql = "SELECT Code, Description, Lot, Quantity, Purchase_Price, Sale_Price, Status, Category_Code, Supplier_Code, Entry_Date, Expiry_Date
                    FROM medications
                    WHERE $search_column LIKE '%$search_term%'
                    ORDER BY Quantity DESC
                    LIMIT $records_per_page OFFSET " . ($page - 1) * $records_per_page;
        } else {
            // Consulta para mostrar todos los productos
            $sql = "SELECT Code, Description, Lot, Quantity, Purchase_Price, Sale_Price, Status, Category_Code, Supplier_Code, Entry_Date, Expiry_Date
                    FROM medications
                    ORDER BY Quantity DESC
                    LIMIT $records_per_page OFFSET " . ($page - 1) * $records_per_page;
        }

        $result = $conn->query($sql);

        if ($result) {
            echo "<h2>Productos:</h2>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'><tr><th>Code</th><th>Description</th><th>Lot</th><th>Quantity</th><th>Purchase_Price</th><th>Sale_Price</th><th>Status</th><th>Category_Code</th><th>Supplier_Code</th><th>Entry_Date</th><th>Expiry_Date</th></tr></thead>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Code"] . "</td>";
                echo "<td>" . $row["Description"] . "</td>";
                echo "<td>" . $row["Lot"] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
                echo "<td>" . $row["Purchase_Price"] . "</td>";
                echo "<td>" . $row["Sale_Price"] . "</td>";
                echo "<td>" . $row["Status"] . "</td>";
                echo "<td>" . $row["Category_Code"] . "</td>";
                echo "<td>" . $row["Supplier_Code"] . "</td>";
                echo "<td>" . $row["Entry_Date"] . "</td>";
                echo "<td>" . $row["Expiry_Date"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";

            // Paginación
            $total_records = $conn->query("SELECT COUNT(*) as total FROM medications")->fetch_assoc()['total'];
            $total_pages = ceil($total_records / $records_per_page);

            echo "<ul class='pagination'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li class='page-item'><a class='page-link' href='" . $_SERVER['PHP_SELF'] . "?page=$i'>$i</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No se encontraron resultados en la búsqueda.</p>";
        }

        // Cierra la conexión
        $conn->close();
        ?>
    </div>
</body>

</html>