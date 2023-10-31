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
    <title>Agregar Nuevo Medicamento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Agregar Nuevo Medicamento</h1>
        <!-- Botón desplegable en la parte superior derecha -->
        <div class="btn-group float-right">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="index.php">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <a class a dropdown-item" href="clientes.php">
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

        <?php
        // Inicializa las variables para los campos del formulario
        $description = $lot = $quantity = $purchase_price = $sale_price = $status = $category_code = $supplier_code = $entry_date = $expiry_date = $unit_of_measure = $shelf_number = $shelf_level = $shelf_position_number = "";
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtiene los datos del formulario cuando se envía
            $description = $_POST["description"];
            $lot = $_POST["lot"];
            $quantity = $_POST["quantity"];
            $purchase_price = $_POST["purchase_price"];
            $sale_price = $_POST["sale_price"];
            $status = $_POST["status"];
            $category_code = $_POST["category_code"];
            $supplier_code = $_POST["supplier_code"];
            $entry_date = $_POST["entry_date"];
            $expiry_date = $_POST["expiry_date"];
            $unit_of_measure = $_POST["unit_of_measure"];
            $shelf_number = $_POST["shelf_number"];
            $shelf_level = $_POST["shelf_level"];
            $shelf_position_number = $_POST["shelf_position_number"];

            // Valida y limpia los datos de entrada (ejemplo: evitar inyección SQL)
            $description = htmlspecialchars($description);
            $lot = htmlspecialchars($lot);
            $quantity = htmlspecialchars($quantity);
            $purchase_price = htmlspecialchars($purchase_price);
            $sale_price = htmlspecialchars($sale_price);
            $status = htmlspecialchars($status);
            $category_code = htmlspecialchars($category_code);
            $supplier_code = htmlspecialchars($supplier_code);
            $entry_date = htmlspecialchars($entry_date);
            $expiry_date = htmlspecialchars($expiry_date);
            $unit_of_measure = htmlspecialchars($unit_of_measure);
            $shelf_number = htmlspecialchars($shelf_number);
            $shelf_level = htmlspecialchars($shelf_level);
            $shelf_position_number = htmlspecialchars($shelf_position_number);

            // Luego, puedes guardar los datos en tu base de datos de manera segura
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

            // Insertar los datos del nuevo medicamento en la tabla medications
            $sql = "INSERT INTO medications (Description, Lot, Quantity, Purchase_Price, Sale_Price, Status, Category_Code, Supplier_Code, Entry_Date, Expiry_Date, Unit_of_Measure, Shelf_Number, Shelf_Level, Shelf_Position_Number)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Utilizar una sentencia preparada para evitar la inyección SQL
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssss", $description, $lot, $quantity, $purchase_price, $sale_price, $status, $category_code, $supplier_code, $entry_date, $expiry_date, $unit_of_measure, $shelf_number, $shelf_level, $shelf_position_number);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Nuevo medicamento agregado correctamente.</div>";
                // Redirige al usuario a la página de medicamentos después de agregar un medicamento
                echo "<script>window.location.href = 'medications.php';</script>";
                exit();
            } else {
                $error = "Error al agregar el medicamento: " . $conn->error;
            }

            // Cierra la conexión
            $stmt->close();
            $conn->close();
        }
        ?>

        <!-- Formulario para agregar un nuevo medicamento -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" name="description" required>
            </div>

            <div class="form-group">
                <label for="lot">Lot:</label>
                <input type="text" class="form-control" name="lot" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" class="form-control" name="quantity" required>
            </div>

            <div class="form-group">
                <label for="purchase_price">Purchase Price:</label>
                <input type="text" class="form-control" name="purchase_price" required>
            </div>

            <div class="form-group">
                <label for="sale_price">Sale Price:</label>
                <input type="text" class="form-control" name="sale_price" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" name="status" required>
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                    <!-- Agrega más opciones según tus necesidades -->
                </select>
            </div>

            <div class="form-group">
                <label for="category_code">Category Code:</label>
                <input type="text" class="form-control" name="category_code" required>
            </div>

            <div class="form-group">
                <label for="supplier_code">Supplier Code:</label>
                <input type="text" class="form-control" name="supplier_code" required>
            </div>

            <div class="form-group">
                <label for="entry_date">Entry Date:</label>
                <input type="date" class="form-control" name="entry_date" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" class="form-control" name="expiry_date" required>
            </div>

            <div class="form-group">
                <label for="unit_of_measure">Unit of Measure:</label>
                <input type="text" class="form-control" name="unit_of_measure" required>
            </div>

            <div class="form-group">
                <label for="shelf_number">Shelf Number:</label>
                <input type="text" class="form-control" name="shelf_number" required>
            </div>

            <div class="form-group">
                <label for="shelf_level">Shelf Level:</label>
                <input type="text" class="form-control" name="shelf_level" required>
            </div>

            <div class="form-group">
                <label for="shelf_position_number">Shelf Position Number:</label>
                <input type="text" class="form-control" name="shelf_position_number" required>
            </div>

            <button type="submit" class="btn btn-primary">Agregar Medicamento</button>
        </form>

        <!-- Mostrar errores -->
        <?php
        if (!empty($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
    </div>
</body>
<footer>
    <div class="container">
        <p>Derechos de autor &copy; 2023 Carlos Edward Rafael Donis Alvarado - BOTIQUIN S.A</p>
    </div>
</footer>

</html>