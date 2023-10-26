<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre'])) {
    // Redirigir a la página de inicio de sesión si no está logueado
    header("Location: /PROYECTO_WEB/login/login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "botiquin_sa";

$meses = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener registros ordenados por fecha
$sql = "SELECT * FROM medications ORDER BY Entry_Date ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reporte 1</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-4 text-center">REPORTE POR RANGO DE FECHA PARA CUADRE DE INVENTARIO FÍSICO DE MEDICAMENTOS</h1>
        <h1 class="mt-4"></h1>

        <!-- Botón desplegable en la parte superior derecha -->
        <div class="btn-group float-right">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="index.php">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <a class="dropdown-item" href="ventas.php">
                    <i class="fas fa-users"></i> Reporte Venta
                </a>
                <a class="dropdown-item" href="compras.php">
                    <i class="fas fa-shopping-cart"></i> Compras
                </a>
                <a class="dropdown-item" href="empleados.php">
                    <i class="fas fa-user"></i> Empleados
                </a>
                <a class="dropdown-item" href="productos.php">
                    <i class="fas fa-box"></i> Productos
                </a>
                <a class="dropdown-item" href="proveedores.php">
                    <i class="fas fa-truck"></i> Proveedores
                </a>
                <a class="dropdown-item" href="usuarios.php">
                    <i class="fas fa-user-circle"></i> Usuarios
                </a>
                <a class="dropdown-item" href="ventas.php">
                    <i class="fas fa-dollar-sign"></i> Ventas
                </a>
                <a class="dropdown-item" href="categorias.php">
                    <i class="fas fa-tags"></i> Categorías
                </a>
            </div>
        </div>




        <table id="table-to-export" class="table table-bordered">

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $currentMonth = null;
                    $hasRecordsForCurrentMonth = false;

                    while ($row = $result->fetch_assoc()) {
                        $entryDate = date_create($row["Entry_Date"]);
                        $month = date_format($entryDate, "m");

                        if ($month !== $currentMonth) {
                            if ($currentMonth !== null && $hasRecordsForCurrentMonth) {
                                echo "</tbody></table></td></tr>";
                            }

                            $hasRecordsForCurrentMonth = false;

                            $currentMonth = $month;

                            if ($result->num_rows > 0) {
                                $entryDate = date_create($row["Entry_Date"]);
                                echo "<tr><td colspan='11' style='font-size: 12px;'><h2>Mes: " . $meses[intval(date_format($entryDate, 'm'))] . " " . date_format($entryDate, 'Y') . "</h2></td></tr>";
                                echo "<tr><td><table class='table table-bordered'>
                                    <thead class='thead-dark'>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Categoria</th>
                                            <th>Proveedor</th>
                                            <th>Existencia</th>
                                            <th>Unidad Medida</th>
                                            <th>Estanteria</th>
                                            <th>Nivel estanteria</th>
                                            <th>Posicion estanteria</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                            }
                        }
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
                        echo "</tr>";

                        $hasRecordsForCurrentMonth = true;
                    }

                    if ($currentMonth !== null && !$hasRecordsForCurrentMonth) {
                        echo "</tbody></table></td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No se encontraron registros.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- ... -->
</body>
<footer>
    <div class="container">
        <p>Derechos de autor &copy; 2023 Ana Maria Cordero Aguilar - BOTIQUIN S.A</p>
    </div