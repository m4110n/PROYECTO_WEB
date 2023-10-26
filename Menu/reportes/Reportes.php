<?php
session_start();

// Verificar si el usuario está logueado
//if (!isset($_SESSION['nombre'])) {
    // Redirigir a la página de inicio de sesión si no está logueado
    //header("Location: ../login/login.php");
    //exit();
//}

// Definir la variable $inicio
$inicio = 0;

// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "botiquin_sa";

// Crear una conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Definir la cantidad de medicamentos por página
$medicamentosPorPagina = 10;


// Obtener la página actual
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;


// Inicializar variables para fechas
$start_date = '';
$end_date = '';

// Verificar si se enviaron fechas para la búsqueda
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    // Consulta SQL con rango de fechas
    $sql = "SELECT * FROM medications WHERE Entry_Date BETWEEN '$start_date' AND '$end_date' LIMIT $inicio, $medicamentosPorPagina";
} else {
    // Consulta SQL sin rango de fechas (por defecto)
    $sql = "SELECT * FROM medications LIMIT $inicio, $medicamentosPorPagina";
}

// Realizar la consulta SQL
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Reportes</title>
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
        <h1 class="mt-4 text-center">REPORTE DE RENTABILIDAD</h1>

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

        <!-- Botón para exportar a Excel -->
        <button class="btn btn-success" id="exportToExcel">Exportar a Excel</button>

        <!-- Botón para exportar a PDF -->
        <button class="btn btn-danger" id="exportToPDF">Exportar a PDF</button>

        <!-- Formulario de búsqueda por rango de fecha -->
        <form method="GET" action="Reportes.php">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="start_date">Fecha de inicio:</label>
                    <input type="date" class="form-control" name="start_date" id="start_date" value="<?= $start_date ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="end_date">Fecha de fin:</label>
                    <input type="date" class="form-control" name="end_date" id="end_date" value="<?= $end_date ?>">
                </div>
                <div class="form-group col-md-2">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                </div>
            </div>
        </form>

        <table id="table-to-export" class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Proveedor</th>
                    <th>Existencia</th>
                    <th>Medica</th>
                    <th>Estanteria</th>
                    <th>Nivel estanteria</th>
                    <th>Posicion estanteria</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
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
                       
                    }
                } else {
                    echo "<tr><td colspan='10'>No se encontraron registros.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                // Tu código PHP para generar la paginación aquí
                ?>
            </ul>
        </nav>
    </div>

    <script>
        // Función para exportar la tabla a Excel
        function exportToExcel() {
            const table = XLSX.utils.table_to_book(document.querySelector('table'), {
                sheet: "Medicamentos"
            });
            XLSX.writeFile(table, 'medicamentos.xlsx');
        }

        // Función para exportar la tabla a PDF
        function exportToPDF() {
            const table = document.getElementById('table-to-export');
            html2canvas(table).then(function (canvas) {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const width = pdf.internal.pageSize.getWidth();
                const height = pdf.internal.pageSize.getHeight();
                pdf.addImage(imgData, 'PNG', 0, 0, width, height);
                pdf.save('medicamentos.pdf');
            });
        }

        // Agregar eventos a los botones de exportación
        document.getElementById('exportToExcel').addEventListener('click', exportToExcel);
        document.getElementById('exportToPDF').addEventListener('click', exportToPDF);
    </script>
</body>
<footer>
    <div class="container">
    <p>Derechos de autor &copy; 2023 Ana Maria Cordero Aguilar - BOTIQUIN S.A</p>
    </div>
</footer>

</html>