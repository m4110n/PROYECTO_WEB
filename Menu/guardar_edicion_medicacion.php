<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["medication_id"])) {
    // Obtener los datos del formulario
    $medication_id = $_POST["medication_id"];
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

    // Actualizar los datos del medicamento en la base de datos
    $sql = "UPDATE medications SET Description='$description', Lot='$lot', Quantity='$quantity', Purchase_Price='$purchase_price', Sale_Price='$sale_price', Status='$status', Category_Code='$category_code', Supplier_Code='$supplier_code', Entry_Date='$entry_date', Expiry_Date='$expiry_date', Unit_of_Measure='$unit_of_measure', Shelf_Number='$shelf_number', Shelf_Level='$shelf_level', Shelf_Position_Number='$shelf_position_number' WHERE Code=$medication_id";
    
    if ($conn->query($sql) === TRUE) {
        // Los cambios se han guardado correctamente, redirige al usuario a medications.php
        header("Location: medications.php");
        exit(); // Asegúrate de salir después de redirigir
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Error en la solicitud de actualización.";
}
