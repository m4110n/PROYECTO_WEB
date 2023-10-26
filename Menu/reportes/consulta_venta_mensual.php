<?php
date_default_timezone_set('America/Mexico_City');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "botiquin_sa";

$conn = new mysqli($servername, $username, $password, $dbname);

$mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
$anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');

$mes = str_pad($mes, 2, '0', STR_PAD_LEFT);

$sql = "SELECT * FROM sales WHERE MONTH(Sale_Date) = '$mes' AND YEAR(Sale_Date) = '$anio'";
$result = $conn->query($sql);

$html = '0'; // Inicializa la variable de cadena HTML



if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Construye una fila de la tabla
        $html .= "<tr>";
        $html .= "<td>" . $row["Order_Number"] . "</td>";
        $html .= "<td>" . $row["Invoice_Number"] . "</td>";
        $html .= "<td>" . $row["Client_Name"] . "</td>";
        $html .= "<td>" . $row["Nit"] . "</td>";
        $html .= "<td>" . $row["Product"] . "</td>";
        $html .= "<td>" . $row["Quantity"] . "</td>";
        $html .= "<td>" . $row["Discount"] . "</td>";
        $html .= "<td>" . $row["Total_Price"] . "</td>";
        $html .= "<td>" . $row["Sale_Date"] . "</td>";
        $html .= "<td>" . $row["Payment_Type"] . "</td>";
        $html .= "</tr>";
    }
} else {
    $html .= "<tr><td colspan='10'>No se encontraron registros.</td></tr>";
}

echo $html; // Devuelve la cadena HTML como respuesta AJAX

$conn->close();
?>