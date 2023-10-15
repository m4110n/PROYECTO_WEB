<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["proveedor_id"])) {
    // Obtener los datos del formulario
    $proveedor_id = $_POST["proveedor_id"];
    $name = $_POST["name"];
    $status = $_POST["status"];
    $address = $_POST["address"];
    $nit = $_POST["nit"];
    $phone = $_POST["phone"];
    $entry_date = $_POST["entry_date"];
    $exit_date = $_POST["exit_date"];
    $supplier_type = $_POST["supplier_type"];

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

    // Actualizar los datos del proveedor en la base de datos
    $sql = "UPDATE Suppliers SET Name='$name', Status='$status', Address='$address', Nit='$nit', Phone='$phone', Entry_Date='$entry_date', Exit_Date='$exit_date', Supplier_Type='$supplier_type' WHERE Code=$proveedor_id";

    if ($conn->query($sql) === TRUE) {
        // Los cambios se han guardado correctamente, redirige al usuario a proveedores.php
        header("Location: proveedores.php");
        exit(); // Asegúrate de salir después de redirigir
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Error en la solicitud de actualización.";
}
?>
