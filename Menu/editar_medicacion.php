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
    <title>Editar Medicación</title>
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h1 class="text-center">Editar Medicación</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $medication_id = $_GET["id"];

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

        // Consultar la base de datos para obtener los datos de la medicación
        $sql = "SELECT * FROM medications WHERE Code = $medication_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Aquí puedes mostrar un formulario para editar los datos de la medicación
            // Por ejemplo:
    ?>
            <form action="guardar_edicion_medicacion.php" method="POST">
                <input type="hidden" name="medication_id" value="<?php echo $row["Code"]; ?>">
                <div class="form-group">
                    <label for="description">Descripción:</label>
                    <input type="text" class="form-control" name="description" value="<?php echo $row["Description"]; ?>">
                </div>
                <div class="form-group">
                    <label for="lot">Lote:</label>
                    <input type="text" class="form-control" name="lot" value="<?php echo $row["Lot"]; ?>">
                </div>
                <div class="form-group">
                    <label for="quantity">Cantidad:</label>
                    <input type="text" class="form-control" name="quantity" value="<?php echo $row["Quantity"]; ?>">
                </div>
                <div class="form-group">
                    <label for="purchase_price">Precio de Compra:</label>
                    <input type="text" class="form-control" name="purchase_price" value="<?php echo $row["Purchase_Price"]; ?>">
                </div>
                <div class="form-group">
                    <label for="sale_price">Precio de Venta:</label>
                    <input type="text" class="form-control" name="sale_price" value="<?php echo $row["Sale_Price"]; ?>">
                </div>
                <div class="form-group">
                    <label for="status">Estado:</label>
                    <input type="text" class="form-control" name="status" value="<?php echo $row["Status"]; ?>">
                </div>
                <div class="form-group">
                    <label for="category_code">Código de Categoría:</label>
                    <input type="text" class="form-control" name="category_code" value="<?php echo $row["Category_Code"]; ?>">
                </div>
                <div class="form-group">
                    <label for="supplier_code">Código de Proveedor:</label>
                    <input type="text" class="form-control" name="supplier_code" value="<?php echo $row["Supplier_Code"]; ?>">
                </div>
                <div class="form-group">
                    <label for="entry_date">Fecha de Entrada:</label>
                    <input type="text" class="form-control" name="entry_date" value="<?php echo $row["Entry_Date"]; ?>">
                </div>
                <div class="form-group">
                    <label for="expiry_date">Fecha de Vencimiento:</label>
                    <input type="text" class="form-control" name="expiry_date" value="<?php echo $row["Expiry_Date"]; ?>">
                </div>
                <div class="form-group">
                    <label for="unit_of_measure">Unidad de Medida:</label>
                    <input type="text" class="form-control" name="unit_of_measure" value="<?php echo $row["Unit_of_Measure"]; ?>">
                </div>
                <div class="form-group">
                    <label for="shelf_number">Número de Estante:</label>
                    <input type="text" class="form-control" name="shelf_number" value="<?php echo $row["Shelf_Number"]; ?>">
                </div>
                <div class="form-group">
                    <label for="shelf_level">Nivel de Estante:</label>
                    <input type="text" class="form-control" name="shelf_level" value="<?php echo $row["Shelf_Level"]; ?>">
                </div>
                <div class="form-group">
                    <label for="shelf_position_number">Número de Posición en Estante:</label>
                    <input type="text" class="form-control" name="Shelf_Position_Number" value="<?php echo $row["Shelf_Position_Number"]; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
    <?php
        } else {
            echo "No se encontró la medicación.";
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        echo "ID de medicación no especificado.";
    }
    ?>

</body>

</html>