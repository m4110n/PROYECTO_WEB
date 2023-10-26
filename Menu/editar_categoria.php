<!DOCTYPE html>
<html>

<head>
    <title>Editar Categoría</title>
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h1 class="text-center">Editar Categoría</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $category_id = $_GET["id"];

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

        // Consultar la base de datos para obtener los datos de la categoría
        $sql = "SELECT * FROM categories WHERE Code = $category_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Aquí puedes mostrar un formulario para editar los datos de la categoría
            // Por ejemplo:
    ?>
           <form action="guardar_edicion_categoria.php" method="POST">
    <input type="hidden" name="categoria_id" value="<?php echo $row["Code"]; ?>">
    <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" class="form-control" name="name" value="<?php echo $row["Name"]; ?>">
    </div>
    <div class="form-group">
        <label for="status">Estado:</label>
        <input type="text" class="form-control" name="status" value="<?php echo $row["Status"]; ?>">
    </div>
    <div class="form-group">
        <label for="entry_date">Fecha de entrada:</label>
        <input type="text" class="form-control" name="entry_date" value="<?php echo $row["Entry_Date"]; ?>">
    </div>
    <div class="form-group">
        <label for="exit_date">Fecha de salida:</label>
        <input type="text" class="form-control" name="exit_date" value="<?php echo $row["Exit_Date"]; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
</form>

    <?php
        } else {
            echo "No se encontró la categoría.";
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        echo "ID de categoría no especificado.";
    }
    ?>

</body>

</html>
