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
    <title>Reporte 3</title>
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
        <h1 class="mt-4 text-center">REPORTE DE VENTA DIARIA</h1>

        <!-- Botón desplegable en la parte superior derecha -->
        <div class="btn-group float-right">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
            </button>
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


        <!-- Selección de día, mes y año -->
        <div class="form-group">
            <label for="dia">Día:</label>
            <select class="form-control" id="dia" name="dia">
                <?php
                // Generar opciones para los días
                for ($i = 1; $i <= 31; $i++) {
                    printf("<option value='%02d'>%02d</option>", $i, $i);
                }
                ?>
            </select>
        </div>

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
            </select>
        </div>
        <div class="form-group">
            <label for="anio">Año:</label>
            <input type="number" class="form-control" id="anio" name="anio" min="2000" max="9999" value="<?php echo date('Y'); ?>">
        </div>

        <!-- Botón para buscar ventas diarias -->
        <button class="btn btn-primary" id="buscarVentasDiarias">Buscar Ventas Diarias</button>
        <button class="btn btn-danger" id="exportToPDF">Exportar a PDF</button>

        <!-- Tabla de Ventas Diarias -->
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
                <!-- Aquí se mostrarán los resultados -->
            </tbody>
        </table>

        <div id="resultadoVentasDiarias"></div>
    </div>

    <!-- Agrega los scripts necesarios -->
</body>
<footer>
    <div class="container">
        <p>Derechos de autor &copy; 2023 Ana Maria Cordero Aguilar - BOTIQUIN S.A</p>
    </div>
</footer>

</html>

<script>
    $(document).ready(function() {

        function exportToPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            const table = document.getElementById('table-to-export');
            const header = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
            const body = Array.from(table.querySelectorAll('tbody tr')).map(tr => Array.from(tr.children).map(td => td.innerText));
            doc.autoTable({
                head: [header],
                body: body,
            });
            doc.save('ventas_diarias.pdf');
        }

        $('#buscarVentasDiarias').click(function() {
            var dia = $('#dia').val();
            var mes = $('#mes').val();
            var anio = $('#anio').val();

            // Realizar una solicitud AJAX para obtener las ventas diarias
            $.ajax({
                url: 'consulta_venta_diaria.php',
                type: 'GET',
                data: {
                    dia: dia,
                    mes: mes,
                    anio: anio
                },
                success: function(data) {
                    // Reemplaza el contenido de la tbody con los resultados de la consulta
                    $('#table-to-export tbody').html(data);
                }
            });
        });

        // Agregar eventos a los botones de exportación
        document.getElementById('exportToPDF').addEventListener('click', exportToPDF);
    });
</script>
</body>


</html>