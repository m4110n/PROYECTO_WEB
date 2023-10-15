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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <!-- Incluir primero el archivo CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Luego, tu archivo CSS personalizado -->
    <link rel="stylesheet" type="text/css" href="contacto.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Lista de Usuarios</h2>
        <table class="table table-striped table-custom">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conectarse a la base de datos
                $conexion = new mysqli("localhost", "root", "", "botiquin_sa");

                // Verificar la conexión
                if ($conexion->connect_error) {
                    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
                }

                // Consulta SQL para obtener los datos de usuarios
                $consulta = "SELECT name, email FROM users";

                // Ejecutar la consulta
                $resultado = $conexion->query($consulta);

                // Mostrar los datos en la tabla
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila['name'] . "</td>";
                    echo "<td>" . $fila['email'] . "</td>";
                    echo "</tr>";
                }

                // Cerrar la conexión a la base de datos
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>