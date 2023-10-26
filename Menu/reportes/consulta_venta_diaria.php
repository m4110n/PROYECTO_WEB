<?php
date_default_timezone_set('America/Mexico_City');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "botiquin_sa";

$conn = new mysqli($servername, $username, $password, $dbname);


$dia = isset($_GET['dia']) ? $_GET['dia'] : date('d');
$mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
$anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');



echo "Día: $dia, Mes: $mes, Año: $anio";

$dia = str_pad($dia, 2, '0', STR_PAD_LEFT);
$mes = str_pad($mes, 2, '0', STR_PAD_LEFT);

$sql = "SELECT * FROM sales WHERE DATE(Sale_Date) = '$anio-$mes-$dia'";
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