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
    <title>Buscar Medicamento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Buscar Medicamento</h1>



        <!-- Formulario de búsqueda -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="mb-3">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="searchField">Buscar medicamento por:</label>
                    <select class="form-control" id="searchField" name="searchField">
                        <option value="Description">Description</option>
                        <option value="Lot">Lot</option>
                        <option value="Unit_of_Measure">Unit of Measure</option>
                        <option value="Shelf_Number">Shelf Number</option>
                        <option value="Shelf_Level">Shelf Level</option>
                        <option value="Shelf_Position_Number">Shelf Position Number</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="query">Ingrese su consulta:</label>
                    <input type="text" class="form-control" name="query">
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                </div>
            </div>
        </form>

        <h2>Resultados de la búsqueda:</h2>

        <?php
        // Establece la conexión a la base de datos
        $servername = "localhost"; // Cambia esto al servidor de tu base de datos
        $username = "root"; // Cambia esto a tu nombre de usuario de la base de datos
        $password = ""; // Cambia esto a tu contraseña de la base de datos
        $dbname = "botiquin_sa"; // Cambia esto al nombre de tu base de datos (sin espacios)

        // Crea una conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Paginación
        $results_per_page = 10;
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $offset = ($page - 1) * $results_per_page;

        $search_query = "";
        $search_field = "Description"; // Campo predeterminado

        // Verifica si se ha enviado una consulta de búsqueda
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["query"]) && isset($_GET["searchField"])) {
            $search_query = $_GET["query"];
            $search_field = $_GET["searchField"];
        }

        // Consulta la base de datos para buscar medicamentos con paginación
        $sql = "SELECT * FROM medications WHERE $search_field LIKE '%" . $search_query . "%' LIMIT $offset, $results_per_page";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'><tr><th>Description</th><th>Lot</th><th>Quantity</th><th>Purchase Price</th><th>Sale Price</th><th>Status</th><th>Category Code</th><th>Supplier Code</th><th>Entry Date</th><th>Expiry Date</th><th>Unit of Measure</th><th>Shelf Number</th><th>Shelf Level</th><th>Shelf Position Number</th></tr></thead>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
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
                echo "<td>" . $row["Unit_of_Measure"] . "</td>";
                echo "<td>" . $row["Shelf_Number"] . "</td>";
                echo "<td>" . $row["Shelf_Level"] . "</td>";
                echo "<td>" . $row["shelf_position_number"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";

            // Paginación
            $sql = "SELECT COUNT(*) AS total FROM medications WHERE $search_field LIKE '%" . $search_query . "%'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_pages = ceil($row["total"] / $results_per_page);

            echo "<nav aria-label='Page navigation'>";
            echo "<ul class='pagination'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='?query=$search_query&searchField=$search_field&page=$i'>$i</a></li>";
                }
            }
            echo "</ul>";
            echo "</nav>";
        } else {
            echo "<p>No se encontraron resultados para la búsqueda: " . $search_query . "</p>";
        }

        // Cierra la conexión
        $conn->close();
        ?>
    </div>
</body>
<footer>
    <div class="container">
        <p>Derechos de autor &copy; 2023 Carlos Edward Rafael Donis Alvarado - BOTIQUIN S.A</p>
    </div>
</footer>

</html>