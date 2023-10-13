<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["customer_id"])) {
    // Obtener los datos del formulario
    $customer_id = $_POST["customer_id"];
    $name = $_POST["name"];
    $status = $_POST["status"];
    // Agrega más campos según tus necesidades

    // Establecer la conexión a la base de datos
    $servername = "localhost"; // Cambia esto al servidor de tu base de datos
    $username = "root"; // Cambia esto a tu nombre de usuario de la base de datos
    $password = ""; // Cambia esto a tu contraseña de la base de datos
    $dbname = "botiquin_sa"; // Cambia esto al nombre de tu base de datos

    // Crear una conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Actualizar los datos del cliente en la base de datos
    $sql = "UPDATE customers SET Name='$name', Status='$status' WHERE Code=$customer_id";
    if ($conn->query($sql) === TRUE) {
        // Los cambios se han guardado correctamente, redirige al usuario a clientes.php
        header("Location: clientes.php");
        exit(); // Asegúrate de salir después de redirigir
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Error en la solicitud de actualización.";
}
