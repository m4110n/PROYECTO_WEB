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
    <title>Agregar Nuevo Cliente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Agregar Nuevo Cliente</h1>

        <?php
        // Inicializa las variables para los campos del formulario
        $name = $status = $address = $nit = $phone = $entry_date = $exit_date = $customer_type = "";
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtiene los datos del formulario cuando se envía
            $name = $_POST["name"];
            $status = $_POST["status"];
            $address = $_POST["address"];
            $nit = $_POST["nit"];
            $phone = $_POST["phone"];
            $entry_date = $_POST["entry_date"];
            $exit_date = $_POST["exit_date"];
            $customer_type = $_POST["customer_type"];

            // Valida y limpia los datos de entrada (ejemplo: evitar inyección SQL)
            $name = htmlspecialchars($name);
            $status = htmlspecialchars($status);
            $address = htmlspecialchars($address);
            $nit = htmlspecialchars($nit);
            $phone = htmlspecialchars($phone);
            $entry_date = htmlspecialchars($entry_date);
            $exit_date = htmlspecialchars($exit_date);
            $customer_type = htmlspecialchars($customer_type);

            // Luego, puedes guardar los datos en tu base de datos de manera segura
            // Establecer la conexión a la base de datos
            $servername = "localhost"; // Cambia esto al servidor de tu base de datos
            $username = "DrawdeDonis"; // Cambia esto a tu nombre de usuario de la base de datos
            $password = "Drawde1995"; // Cambia esto a tu contraseña de la base de datos
            $dbname = "botiquin_sa"; // Cambia esto al nombre de tu base de datos (sin espacios)

            // Crear una conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Insertar los datos del nuevo cliente en la base de datos sin especificar Code
            $sql = "INSERT INTO customers (Name, Status, Address, Nit, Phone, entry_date, exit_date, customer_type)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            // Utilizar una sentencia preparada para evitar la inyección SQL
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $name, $status, $address, $nit, $phone, $entry_date, $exit_date, $customer_type);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Nuevo cliente agregado correctamente.</div>";
                // Redirige al usuario a la página de clientes después de agregar un cliente
                echo "<script>window.location.href = 'clientes.php';</script>";
                exit();
            } else {
                $error = "Error al agregar el cliente: " . $conn->error;
            }

            // Cierra la conexión
            $stmt->close();
            $conn->close();
        }
        ?>

        <!-- Formulario para agregar un nuevo cliente -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <!-- No incluir el campo Code en el formulario -->
            <input type="hidden" name="code" value="auto_increment"> <!-- Campo Code se establece automáticamente -->
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" name="status" required>
                    <?php
                    // Obtén valores únicos de Status desde la base de datos
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

                    $sqlStatus = "SELECT DISTINCT Status FROM customers";
                    $resultStatus = $conn->query($sqlStatus);

                    if ($resultStatus->num_rows > 0) {
                        while ($rowStatus = $resultStatus->fetch_assoc()) {
                            echo "<option value='" . $rowStatus["Status"] . "'>" . $rowStatus["Status"] . "</option>";
                        }
                    }

                    // Cierra la conexión
                    $conn->close();
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" name="address" required>
            </div>

            <div class="form-group">
                <label for="nit">Nit:</label>
                <input type="text" class="form-control" name="nit" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" name="phone" required>
            </div>

            <div class="form-group">
                <label for="entry_date">Entry Date:</label>
                <input type="date" class="form-control" name="entry_date" required>
            </div>

            <div class="form-group">
                <label for="exit_date">Exit Date:</label>
                <input type="date" class="form-control" name="exit_date" required>
            </div>

            <div class="form-group">
                <label for="customer_type">Customer Type:</label>
                <select class="form-control" name="customer_type" required>
                    <?php
                    // Obtén valores únicos de Customer Type desde la base de datos
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

                    $sqlCustomerType = "SELECT DISTINCT customer_type FROM customers";
                    $resultCustomerType = $conn->query($sqlCustomerType);

                    if ($resultCustomerType->num_rows > 0) {
                        while ($rowCustomerType = $resultCustomerType->fetch_assoc()) {
                            echo "<option value='" . $rowCustomerType["customer_type"] . "'>" . $rowCustomerType["customer_type"] . "</option>";
                        }
                    }

                    // Cierra la conexión
                    $conn->close();
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Agregar Cliente</button>
        </form>

        <!-- Mostrar errores -->
        <?php
        if (!empty($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
    </div>
</body>
<footer>
    <div class="container">
        <p>Derechos de autor &copy; 2023 Carlos Edward Rafael Donis Alvarado - BOTIQUIN S.A</p>
    </div>
</footer>

</html>