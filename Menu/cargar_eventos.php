<?php
// Configura la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // Reemplaza con la contraseña de tu usuario root
$dbname = "botiquin_sa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtiene las fechas de inicio y fin de la solicitud POST
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Consulta SQL para obtener los eventos
$sql = "SELECT Code, Entry_Date, Exit_Date FROM suppliers WHERE Entry_Date IS NOT NULL AND Exit_Date IS NOT NULL";

if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND Entry_Date >= '$start_date' AND Exit_Date <= '$end_date'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $events = array();
    while ($row = $result->fetch_assoc()) {
        $events[] = array(
            'title' => "Proveedor: " . $row["Code"],
            'start' => $row["Entry_Date"],
            'end' => $row["Exit_Date"],
        );
    }
    echo json_encode($events); // Devuelve los eventos en formato JSON
} else {
    echo json_encode(array()); // Si no hay eventos, devuelve un arreglo vacío en formato JSON
}

$conn->close();
?>
