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
    <title>Editar Proveedor</title>
</head>

<body>
    <h1>Editar Proveedor</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $proveedor_id = $_GET["id"];

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

        // Consultar la base de datos para obtener los datos del proveedor
        $sql = "SELECT * FROM Suppliers WHERE Code = $proveedor_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
    ?>
            <form action='guardar_edicion_proveedor.php' method='POST'>
                <input type='hidden' name='proveedor_id' value='<?php echo $row["Code"]; ?>'>
                Nombre: <input type='text' name='name' value='<?php echo $row["Name"]; ?>'><br>
                Estado:
                <select name='status'>
                    <?php
                    // Consulta para obtener los estados disponibles desde la base de datos
                    $statusQuery = "SELECT DISTINCT Status FROM Suppliers";
                    $statusResult = $conn->query($statusQuery);
                    while ($statusRow = $statusResult->fetch_assoc()) {
                        $selected = ($statusRow['Status'] == $row['Status']) ? 'selected' : '';
                        echo "<option value='" . $statusRow['Status'] . "' $selected>" . $statusRow['Status'] . "</option>";
                    }
                    ?>
                </select><br>
                Dirección: <input type='text' name='address' value='<?php echo $row["Address"]; ?>'><br>
                Nit: <input type='text' name='nit' value='<?php echo $row["Nit"]; ?>'><br>
                Teléfono: <input type='text' name='phone' value='<?php echo $row["Phone"]; ?>'><br>
                Fecha de Entrada: <input type='text' name='entry_date' value='<?php echo $row["Entry_Date"]; ?>'><br>
                Fecha de Salida: <input type='text' name='exit_date' value='<?php echo $row["Exit_Date"]; ?>'><br>
                Tipo de Proveedor:
                <select name='supplier_type'>
                    <?php
                    // Consulta para obtener los tipos de proveedores disponibles desde la base de datos
                    $supplierTypeQuery = "SELECT DISTINCT Supplier_Type FROM Suppliers";
                    $supplierTypeResult = $conn->query($supplierTypeQuery);
                    while ($supplierTypeRow = $supplierTypeResult->fetch_assoc()) {
                        $selected = ($supplierTypeRow['Supplier_Type'] == $row['Supplier_Type']) ? 'selected' : '';
                        echo "<option value='" . $supplierTypeRow['Supplier_Type'] . "' $selected>" . $supplierTypeRow['Supplier_Type'] . "</option>";
                    }
                    ?>
                </select><br>
                <input type='submit' value='Guardar Cambios'>
            </form>
    <?php
        } else {
            echo "No se encontró el proveedor.";
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        echo "ID de proveedor no especificado.";
    }
    ?>

</body>

</html>