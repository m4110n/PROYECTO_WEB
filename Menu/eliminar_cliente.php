<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre'])) {
    // Redirigir a la página de inicio de sesión si no está logueado
    header("Location: ../login/login.php");
    exit();
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $customer_id = $_GET["id"];

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

    // Eliminar el cliente de la base de datos
    $sql = "DELETE FROM customers WHERE Code = $customer_id";
    if ($conn->query($sql) === TRUE) {
        // Redirige a la página de clientes después de eliminar el cliente con éxito
        header("Location: clientes.php");
        exit; // Detiene la ejecución del script después de la redirección
    } else {
        echo "Error al eliminar el cliente: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "ID de cliente no especificado.";
}
