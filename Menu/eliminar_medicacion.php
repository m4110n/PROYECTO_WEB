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

    // Eliminar el medicamento de la base de datos
    $sql = "DELETE FROM medications WHERE Code = $medication_id";
    if ($conn->query($sql) === TRUE) {
        // Redirige a la página de medicamentos después de eliminar el medicamento con éxito
        header("Location: medications.php");
        exit; // Detiene la ejecución del script después de la redirección
    } else {
        echo "Error al eliminar el medicamento: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "ID de medicamento no especificado.";
}
