<!DOCTYPE html>
<html>

<head>
    <title>Editar Cliente</title>
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h1 class="text-center">Editar Cliente</h1>

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
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type='text' class="form-control" name='name' value='<?php echo $row["Name"]; ?>'>
                </div>
                <div class="form-group">
                    <label for="status">Estado:</label>
                    <input type='text' class="form-control" name='status' value='<?php echo $row["Status"]; ?>'>
                </div>
                <!-- Agrega más campos según tus necesidades -->
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
