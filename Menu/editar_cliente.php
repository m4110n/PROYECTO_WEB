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
    <title>Editar Cliente</title>
</head>

<body>
    <h1>Editar Cliente</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $customer_id = $_GET["id"];

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

        // Consultar la base de datos para obtener los datos del cliente
        $sql = "SELECT * FROM customers WHERE Code = $customer_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Aquí puedes mostrar un formulario para editar los datos del cliente
            // Por ejemplo:
    ?>
            <form action='guardar_edicion_cliente.php' method='POST'>
                <input type='hidden' name='customer_id' value='<?php echo $row["Code"]; ?>'>
                Nombre: <input type='text' name='name' value='<?php echo $row["Name"]; ?>'><br>
                Estado: <input type='text' name='status' value='<?php echo $row["Status"]; ?>'><br>
                <!-- Agrega más campos según tus necesidades -->
                <input type='submit' value='Guardar Cambios'>
            </form>
    <?php
        } else {
            echo "No se encontró el cliente.";
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        echo "ID de cliente no especificado.";
    }
    ?>

</body>

</html>