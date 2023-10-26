<?php
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

// Calcular la fecha actual
$currentDate = date("Y-m-d");

// Calcular la fecha en un mes (30 días)
$oneMonthLater = date("Y-m-d", strtotime("+30 days"));

// Consulta SQL para buscar productos próximos a vencer en un mes
$sql = "SELECT * FROM medications WHERE Expiry_Date BETWEEN '$currentDate' AND '$oneMonthLater'";

// Realizar la consulta SQL
$result = $conn->query($sql);

// Generar el resultado en formato HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Code"] . "</td>";
        echo "<td>" . $row["Description"] . "</td>";
        echo "<td>" . $row["Category_Code"] . "</td>";
        echo "<td>" . $row["Supplier_Code"] . "</td>";
        echo "<td>" . $row["Quantity"] . "</td>";
        echo "<td>" . $row["Unit_of_Measure"] . "</td>";
        echo "<td>" . $row["Shelf_Number"] . "</td>";
        echo "<td>" . $row["Shelf_Level"] . "</td>";
        echo "<td>" . $row["shelf_position_number"] . "</td>";
        echo "<td>" . $row["Entry_Date"] . "</td>";
        echo "<td>" . $row["Expiry_Date"] . "</td>";
        
    }
} else {
    echo "<tr><td colspan='10'>No se encontraron productos próximos a vencer en un mes.</td></tr>";
}

// Cerrar la conexión
$conn->close();
?>