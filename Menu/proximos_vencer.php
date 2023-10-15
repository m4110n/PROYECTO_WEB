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
    <title>Productos Próximos a Vencer</title>
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
    <div class="container">
        <h1 class="mt-4">Productos Próximos a Vencer</h1>

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

        // Calcular la fecha actual
        $current_date = date("Y-m-d");

        $search_term = "";
        $search_column = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchProducts"])) {
            $search_term = $_POST["search_term"];
            $search_column = $_POST["search_column"];
        }

        // Realizar una consulta SQL para obtener productos próximos a vencer
        $sql = "SELECT Code, Description, Lot, Quantity, Purchase_Price, Sale_Price, Status, Category_Code, Supplier_Code, Entry_Date, Expiry_Date
                FROM medications
                WHERE Expiry_Date >= '$current_date'";

        if (!empty($search_term) && !empty($search_column)) {
            $sql .= " AND $search_column LIKE '%$search_term%'";
        }

        $sql .= " ORDER BY Expiry_Date";

        $result = $conn->query($sql);

        if ($result) {
            echo "<h2>Productos Próximos a Vencer:</h2>";

            // Formulario para buscar en cada columna
            echo "<form method='POST' class='mb-4'>";
            echo "<div class='form-row'>";
            echo "<div class='col-8'>";
            echo "<input type='text' class='form-control' name='search_term' value='$search_term' placeholder='Buscar...'>";
            echo "</div>";
            echo "<div class='col-3'>";
            echo "<select name='search_column' class='form-control'>";
            echo "<option value='Code' " . ($search_column == 'Code' ? 'selected' : '') . ">Code</option>";
            echo "<option value='Description' " . ($search_column == 'Description' ? 'selected' : '') . ">Description</option>";
            echo "<option value='Lot' " . ($search_column == 'Lot' ? 'selected' : '') . ">Lot</option>";
            echo "<option value='Quantity' " . ($search_column == 'Quantity' ? 'selected' : '') . ">Quantity</option>";
            echo "<option value='Purchase_Price' " . ($search_column == 'Purchase_Price' ? 'selected' : '') . ">Purchase_Price</option>";
            echo "<option value='Sale_Price' " . ($search_column == 'Sale_Price' ? 'selected' : '') . ">Sale_Price</option>";
            echo "<option value='Status' " . ($search_column == 'Status' ? 'selected' : '') . ">Status</option>";
            echo "<option value='Category_Code' " . ($search_column == 'Category_Code' ? 'selected' : '') . ">Category_Code</option>";
            echo "<option value='Supplier_Code' " . ($search_column == 'Supplier_Code' ? 'selected' : '') . ">Supplier_Code</option>";
            echo "<option value='Entry_Date' " . ($search_column == 'Entry_Date' ? 'selected' : '') . ">Entry_Date</option>";
            echo "<option value='Expiry_Date' " . ($search_column == 'Expiry_Date' ? 'selected' : '') . ">Expiry_Date</option>";
            echo "</select>";
            echo "</div>";
            echo "<div class='col-1'>";
            echo "<button type='submit' name='searchProducts' class='btn btn-primary'>Buscar</button>";
            echo "</div>";
            echo "</div>";
            echo "</form>";

            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'><tr>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Code'>Code</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Description'>Description</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Lot'>Lot</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Quantity'>Quantity</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Purchase_Price'>Purchase_Price</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Sale_Price'>Sale_Price</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Status'>Status</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Category_Code'>Category_Code</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Supplier_Code'>Supplier_Code</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Entry_Date'>Entry_Date</a></th>";
            echo "<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=Expiry_Date'>Expiry_Date</a></th>";
            echo "</tr></thead>";

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
        } else {
            echo "<p>No se encontraron productos próximos a vencer.</p>";
        }

        // Cierra la conexión
        $conn->close();
        ?>
    </div>
</body>

</html>