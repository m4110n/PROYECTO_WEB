<?php
// Verificar si el usuario está logueado
//if (!isset($_SESSION['nombre'])) {
// Redirigir a la página de inicio de sesión si no está logueado
//  header("Location: ../login/login.php");
//exit();
//}
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre'])) {
    // Redirigir a la página de inicio de sesión si no está logueado
    header("Location: /PROYECTO_WEB/login/login.php");
    exit();
}
// Configura la zona horaria (ajusta según tu necesidad)
date_default_timezone_set('America/Mexico_City');
$hoy = date("Y-m-d");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reporte 4</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
</head>



<body>
    <div class="container">
        <h1 class="mt-4 text-center">REPORTE DE VENTAS MENSUALES</h1>

        <!-- Selección de mes y año -->
        <div class="form-group">
            <label for="mes">Mes:</label>
            <select class="form-control" id="mes" name="mes">
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
                <!-- Agrega las opciones para los otros meses -->
            </select>
        </div>
        <div class="form-group">
            <label for="anio">Año:</label>
            <input type="number" class="form-control" id="anio" name="anio" min="2000" max="9999" value="<?php echo date('Y'); ?>">
        </div>

        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="../index.php">
                <i class="fas fa-home"></i> Inicio
            </a>
            <a class="dropdown-item" href="../generar_factura.php">
                <i class="fas fa-users"></i> Reporte Venta
            </a>
            <a class="dropdown-item" href="../compras.php">
                <i class="fas fa-shopping-cart"></i> Compras
            </a>
            <a class="dropdown-item" href="../empleados.php">
                <i class="fas fa-user"></i> Empleados
            </a>
            <a class="dropdown-item" href="../../Menu/medicamento.php">
                <i class="fas fa-box"></i> Productos
            </a>
            <a class="dropdown-item" href="../proveedores.php">
                <i class="fas fa-truck"></i> Proveedores
            </a>
            <a class="dropdown-item" href="../ventasmaster/listar.php">
                <i class="fas fa-dollar-sign"></i> Ventas
            </a>
            <a class="dropdown-item" href="../categorias.php">
                <i class="fas fa-tags"></i> Categorías
            </a>
        </div>
    </div>

    <div class="container">


        <!-- Botón desplegable en la parte superior derecha -->
        <div class="btn-group float-right">
            <!-- ... (resto del código del menú desplegable) -->
        </div>

        <!-- Botón para exportar a Excel -->
        <button class="btn btn-success mr-2 mt-2 mb-2" id="exportToExcel">Exportar a Excel</button>

        <!-- Botón para exportar a PDF -->
        <button class="btn btn-danger mr-2 mt-2 mb-2" id="exportToPDF">Exportar a PDF</button>

        <!-- Botón de Venta Diaria -->
        <button class="btn btn-primary" id="buscarVentas">Buscar Ventas</button>



        <script>
            $(document).ready(function() {
                $('#buscarVentas').click(function() {
                    var mes = $('#mes').val();
                    var anio = $('#anio').val();

                    // Realizar una solicitud AJAX para obtener las ventas del mes y año seleccionados
                    $.ajax({
                        url: 'consulta_venta_mensual.php',
                        type: 'GET',
                        data: {
                            mes: mes,
                            anio: anio
                        }, // Incluye mes y año como parámetros
                        success: function(data) {
                            // Reemplaza el contenido de la tbody con los resultados de la consulta
                            $('#table-to-export tbody').html(data);
                        }
                    });
                });
            });
        </script>



        <table id="table-to-export" class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Numero de orden</th>
                    <th>Numero de factura</th>
                    <th>Cliente</th>
                    <th>Nit</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total descuentos</th>
                    <th>Total venta</th>
                    <th>Fecha venta</th>
                    <th>Tipo de pago</th>
                </tr>
            </thead>
            <tbody>



                <?php
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

                // Definir la cantidad de clientes por página
                $ventasPorPagina = 10;

                // Obtener la página actual
                $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                // Calcular el inicio y fin de la consulta

                ?>
            </tbody>
        </table>
        <div id="resultadoVentasMensuales"></div>


        ?>
        </ul>
        </nav>
        <?php
        // Cerrar la conexión
        $conn->close();
        ?>
    </div>

    <script>
        $(document).ready(function() {
            // Función para exportar la tabla a Excel
            function exportToExcel() {
                const table = XLSX.utils.table_to_book(document.querySelector('table'), {
                    sheet: "Ventas"
                });
                XLSX.writeFile(table, 'ventas.xlsx');
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
                    pdf.save('ventas.pdf');
                });
            }

            // Agregar eventos a los botones de exportación
            document.getElementById('exportToExcel').addEventListener('click', exportToExcel);
            document.getElementById('exportToPDF').addEventListener('click', exportToPDF);

            $('#buscarVentas').click(function() {
                var mes = $('#mes').val();
                var anio = $('#anio').val();

                // Realizar una solicitud AJAX para obtener las ventas del mes y año seleccionados
                $.ajax({
                    url: 'consulta_venta_mensual.php',
                    type: 'GET',
                    data: {
                        mes: mes,
                        anio: anio
                    }, // Incluye mes y año como parámetros
                    success: function(data) {
                        // Reemplaza el contenido de la tbody con los resultados de la consulta
                        $('#table-to-export tbody').html(data);
                    }
                });
            });
        });
    </script>
</body>
<footer>
    <div class="container">
        <p>Derechos de autor &copy; 2023 Ana Maria Cordero Aguilar - BOTIQUIN S.A</p>
    </div>
</footer>

</html>