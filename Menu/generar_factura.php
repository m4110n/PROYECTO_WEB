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
    <meta charset="utf-8">
    <title>Generar Factura de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.0.0/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <script type="text/javascript">
        function updateClientInfo() {
            var clientSelect = document.getElementById("client_code");
            var nitField = document.getElementById("nit");
            var addressField = document.getElementById("address");
            var phoneField = document.getElementById("phone");

            var selectedOption = clientSelect.options[clientSelect.selectedIndex];

            var nitValue = selectedOption.getAttribute("data-nit");
            var addressValue = selectedOption.getAttribute("data-address");
            var phoneValue = selectedOption.getAttribute("data-phone");

            nitField.value = nitValue;
            addressField.value = addressValue;
            phoneField.value = phoneValue;
        }

        function updateMedicationDetails() {
            var medicationSelect = document.getElementById("medication_code");
            var medicationDescriptionField = document.getElementById("medication_description");
            var medicationExpireDateField = document.getElementById("medication_expire_date");
            var medicationSalePriceField = document.getElementById("medication_sale_price");

            var selectedOption = medicationSelect.options[medicationSelect.selectedIndex];
            var expireDate = selectedOption.getAttribute("data-expiry-date");
            var salePrice = selectedOption.getAttribute("data-sale-price");
            var description = selectedOption.text;

            medicationExpireDateField.value = expireDate;
            medicationSalePriceField.value = salePrice;
            medicationDescriptionField.value = description;
        }

        function fillCurrentDate() {
            var currentDate = new Date();
            var day = String(currentDate.getDate()).padStart(2, '0');
            var month = String(currentDate.getMonth() + 1).padStart(2, '0');
            var year = currentDate.getFullYear();
            var formattedDate = `${year}-${month}-${day}`;
            document.getElementById("purchase_date").value = formattedDate;
        }

        function calculateTotal() {
            var medicationQuantity = parseFloat(document.getElementById("medication_quantity").value) || 0;
            var medicationPrice = parseFloat(document.getElementById("medication_sale_price").value) || 0;
            var totalAmount = medicationQuantity * medicationPrice;
            document.getElementById("total_amount").value = totalAmount.toFixed(2);
        }

        function addMedicationRow() {
            var medicationSelect = document.getElementById("medication_code");
            var selectedOption = medicationSelect.options[medicationSelect.selectedIndex];

            var medicationCode = selectedOption.value;
            var medicationDescription = selectedOption.text;
            var medicationQuantity = parseFloat(document.getElementById("medication_quantity").value) || 0;
            var medicationPrice = parseFloat(document.getElementById("medication_sale_price").value) || 0;

            if (medicationQuantity > 0 && medicationPrice > 0) {
                var newRow = document.createElement("div");
                newRow.classList.add("medication-row");

                newRow.innerHTML = `
                    <label>${medicationDescription}</label>
                    <input class="medication-quantity form-control" type="number" value="${medicationQuantity}" readonly>
                    <input class="medication-price form-control" type="number" value="${medicationPrice}" readonly>
                `;

                document.getElementById("medications-container").appendChild(newRow);
            }

            updateTotalAmount();
            calculateTotal();
        }

        function updateTotalAmount() {
            var totalAmount = 0;
            var medicationRows = document.querySelectorAll(".medication-row");

            medicationRows.forEach(function(row) {
                var quantity = parseFloat(row.querySelector(".medication-quantity").value);
                var price = parseFloat(row.querySelector(".medication-price").value);
                totalAmount += quantity * price;
            });

            document.getElementById("total_amount").value = totalAmount.toFixed(2);
        }
    </script>
</head>
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

<body onload="fillCurrentDate()">
    <div class="container mt-5">
        <h1 class="mb-4">Generar Factura de Cliente</h1>
        <form method="post" action="generar_factura_pdf.php">
            <div class="mb-3">
                <label for="client_code" class="form-label">Selecciona un Cliente:</label>
                <select name="client_code" id="client_code" required class="form-select" onchange="updateClientInfo()">
                    <option value="" disabled selected>Selecciona un cliente</option>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = ""; // Tu contraseña si la tienes
                    $dbname = "botiquin_sa";
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    $queryClientes = "SELECT Code, Name, NIT, Address, Phone FROM customers";
                    $resultClientes = $conn->query($queryClientes);

                    while ($row = $resultClientes->fetch_assoc()) {
                        echo "<option value='" . $row['Code'] . "' data-nit='" . $row['NIT'] . "' data-address='" . $row['Address'] . "' data-phone='" . $row['Phone'] . "'>" . $row['Code'] . " - " . $row['Name'] . "</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="purchase_date" class="form-label">Fecha de Compra:</label>
                <input type="date" name="purchase_date" id="purchase_date" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="total_amount" class="form-label">Total de la Factura:</label>
                <input type="text" id="total_amount" name="total_amount" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="nit" class="form-label">NIT:</label>
                <input type="text" name="nit" id="nit" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Dirección:</label>
                <input type="text" name="address" id="address" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono:</label>
                <input type="text" name="phone" id="phone" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="medication_code" class="form-label">Selecciona un Medicamento:</label>
                <select name="medication_code" id="medication_code" required class="form-select" onchange="updateMedicationDetails()">
                    <option value="" disabled selected>Selecciona un medicamento</option>
                    <?php
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    $queryMedicamentos = "SELECT Code, Description, Sale_Price, Expiry_Date FROM medications";
                    $resultMedicamentos = $conn->query($queryMedicamentos);

                    if ($resultMedicamentos->num_rows > 0) {
                        while ($row = $resultMedicamentos->fetch_assoc()) {
                            echo "<option value='" . $row['Code'] . "' data-sale-price='" . $row['Sale_Price'] . "' data-expiry-date='" . $row['Expiry_Date'] . "'>" . $row['Description'] . " (Vence el " . $row['Expiry_Date'] . ")</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No hay medicamentos disponibles</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="medication_quantity" class="form-label">Cantidad de Medicamentos:</label>
                <input type="number" name="medication_quantity" id="medication_quantity" required class="form-control" oninput="calculateTotal()">
            </div>

            <div class="mb-3">
                <label for="medication_description" class="form-label">Descripción del Medicamento:</label>
                <input type="text" name="medication_description" id="medication_description" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="medication_expire_date" class="form-label">Fecha de Vencimiento del Medicamento:</label>
                <input type="text" name="medication_expire_date" id="medication_expire_date" required class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="medication_sale_price" class="form-label">Precio de Venta del Medicamento:</label>
                <input type="text" name "medication_sale_price" id="medication_sale_price" required class="form-control" readonly>
            </div>

            <button type="button" class="btn btn-primary" onclick="addMedicationRow()">Agregar Medicamento</button>

            <div id="medications-container" class="mt-3">
                <!-- Aquí se agregarán las filas de medicamentos seleccionados -->
            </div>

            <div class="mb-3">
                <label for="total_amount" class="form-label">Total General:</label>
                <input type="text" id="total_amount" name="total_amount" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-success" name="generate_pdf">Generar PDF</button>
        </form>
    </div>
</body>

</html>