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
    <title>Tabla de Clientes</title>
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
        <h1 class="mt-4">Tabla de Clientes</h1>

        <!-- Botón desplegable en la parte superior derecha -->
        <div class="btn-group float-right">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="index.php">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <a class="dropdown-item" href="clientes.php">
                    <i class="fas fa-users"></i> Clientes
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

        <!-- Botón para agregar nuevo cliente -->
        <a class="btn btn-primary" href="agregar_cliente.php">
            <i class="fas fa-plus"></i> Agregar Cliente
        </a>

        <!-- Botón para exportar a Excel -->
        <button class="btn btn-success" id="exportToExcel">Exportar a Excel</button>

        <!-- Botón para exportar a PDF -->
        <button class="btn btn-danger" id="exportToPDF">Exportar a PDF</button>

        <!-- Formulario de búsqueda -->
        <form class="form-inline" action="buscar_cliente.php" method="GET">
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control" name="query" placeholder="Buscar cliente...">
            </div>
            <button type="submit" class="btn btn-primary mb-2">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>

        <table id="table-to-export" class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Nit</th>
                    <th>Phone</th>
                    <th>Entry Date</th>
                    <th>Exit Date</th>
                    <th>Customer Type</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
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

                // Definir la cantidad de clientes por página
                $clientesPorPagina = 10;

                // Obtener la página actual
                $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                // Calcular el inicio y fin de la consulta
                $inicio = ($paginaActual - 1) * $clientesPorPagina;

                // Consultar la base de datos con paginación
                $sql = "SELECT * FROM customers LIMIT $inicio, $clientesPorPagina";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Code"] . "</td>";
                        echo "<td>" . $row["Name"] . "</td>";
                        echo "<td>" . $row["Status"] . "</td>";
                        echo "<td>" . $row["Address"] . "</td>";
                        echo "<td>" . $row["Nit"] . "</td>";
                        echo "<td>" . $row["Phone"] . "</td>";
                        echo "<td>" . $row["entry_date"] . "</td>";
                        echo "<td>" . $row["exit_date"] . "</td>";
                        echo "<td>" . $row["customer_type"] . "</td>";
                        echo "<td>";
                        echo "<a class='btn btn-primary' href='editar_cliente.php?id=" . $row["Code"] . "'>Editar</a> ";
                        echo "<a class='btn btn-danger' href='eliminar_cliente.php?id=" . $row["Code"] . "'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
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
                // Consultar la cantidad total de clientes
                $sqlTotal = "SELECT COUNT(*) as total FROM customers";
                $resultTotal = $conn->query($sqlTotal);
                $filaTotal = $resultTotal->fetch_assoc();
                $totalClientes = $filaTotal["total"];

                // Calcular el número de páginas
                $totalPaginas = ceil($totalClientes / $clientesPorPagina);

                // Mostrar los enlaces de paginación
                for ($i = 1; $i <= $totalPaginas; $i++) {
                    echo "<li class='page-item ";
                    if ($i == $paginaActual) {
                        echo "active";
                    }
                    echo "'><a class='page-link' href='clientes.php?pagina=$i'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>

        <?php
        // Cerrar la conexión
        $conn->close();
        ?>
    </div>

    <script>
        // Función para exportar la tabla a Excel
        function exportToExcel() {
            const table = XLSX.utils.table_to_book(document.querySelector('table'), {
                sheet: "Clientes"
            });
            XLSX.writeFile(table, 'clientes.xlsx');
        }

        // Función para exportar la tabla a PDF
        function exportToPDF() {
            const table = document.getElementById('table-to-export');
            html2canvas(table).then(function(canvas) {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const width = pdf.internal.pageSize.getWidth();
                const height = pdf.internal.pageSize.getHeight();
                pdf.addImage(imgData, 'PNG', 0, 0, width, height);
                pdf.save('clientes.pdf');
            });
        }

        // Agregar eventos a los botones de exportación
        document.getElementById('exportToExcel').addEventListener('click', exportToExcel);
        document.getElementById('exportToPDF').addEventListener('click', exportToPDF);
    </script>
</body>
<footer>
    <div class="container">
        <p>Derechos de autor &copy; 2023 Carlos Edward Rafael Donis Alvarado - BOTIQUIN S.A</p>
    </div>
</footer>

</html>