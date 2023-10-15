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
    <title>Generar Factura de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

        function updateMedicationPrice() {
            var medicationSelect = document.getElementById("medication_code");
            var salePriceField = document.getElementById("medication_sale_price");

            var selectedOption = medicationSelect.options[medicationSelect.selectedIndex];

            var salePriceValue = selectedOption.getAttribute("data-sale-price");

            salePriceField.value = salePriceValue;
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

        function updateMedicationDetails() {
            var medicationSelect = document.getElementById("medication_code");
            var medicationExpireDateField = document.getElementById("medication_expire_date");
            var medicationSalePriceField = document.getElementById("medication_sale_price");

            var selectedOption = medicationSelect.options[medicationSelect.selectedIndex];
            var expireDate = selectedOption.getAttribute("data-expiry-date");
            var salePrice = selectedOption.getAttribute("data-sale-price");

            medicationExpireDateField.value = expireDate;
            medicationSalePriceField.value = salePrice;
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

        function generatePDF() {
            const doc = new jsPDF();

            doc.text("Factura de Cliente", 10, 10);

            const clientCode = document.getElementById("client_code").value;
            const purchaseDate = document.getElementById("purchase_date").value;
            const totalAmount = document.getElementById("total_amount").value;
            const nit = document.getElementById("nit").value;
            const address = document.getElementById("address").value;
            const phone = document.getElementById("phone").value;

            doc.text(`Código de Cliente: ${clientCode}`, 10, 20);
            doc.text(`Fecha de Compra: ${purchaseDate}`, 10, 30);
            doc.text(`Total de la Factura: $${totalAmount}`, 10, 40);
            doc.text(`NIT: ${nit}`, 10, 50);
            doc.text(`Dirección: ${address}`, 10, 60);
            doc.text(`Teléfono: ${phone}`, 10, 70);

            doc.save("factura.pdf");
        }
    </script>
</head>

<body onload="fillCurrentDate()">
    <div class="container mt-5">
        <h1 class="mb-4">Generar Factura de Cliente</h1>
        <form method="post">
            <div class="mb-3">
                <label for="client_code" class="form-label">Selecciona un Cliente:</label>
                <select name="client_code" id="client_code" required class="form-select" onchange="updateClientInfo()">
                    <option value="" disabled selected>Selecciona un cliente</option>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "botiquin_sa";
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    $query = "SELECT Code, Name, NIT, Address, Phone FROM customers";
                    $result = $conn->query($query);

                    while ($row = $result->fetch_assoc()) {
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
                <input type="text" name="total_amount" required class="form-control" readonly>
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

                    $query = "SELECT Code, Description, Sale_Price, Expiry_Date FROM medications";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
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
                <label for="medication_expire_date" class="form-label">Fecha de Vencimiento del Medicamento:</label>
                <input type="text" name="medication_expire_date" id="medication_expire_date" required class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="medication_sale_price" class="form-label">Precio de Venta del Medicamento:</label>
                <input type="text" name="medication_sale_price" id="medication_sale_price" required class="form-control" readonly>
            </div>

            <button type="button" class="btn btn-primary" onclick="addMedicationRow()">Agregar Medicamento</button>

            <div id="medications-container" class="mt-3">
                <!-- Aquí se agregarán las filas de medicamentos seleccionados -->
            </div>

            <div class="mb-3">
                <label for="total_amount" class="form-label">Total General:</label>
                <input type="text" id="total_amount" class="form-control" readonly>
            </div>

            <button type="button" class="btn btn-success" onclick="generatePDF()">Generar PDF</button>
        </form>
    </div>
    <script type="text/javascript">
        window.onload = function() {
            generatePDF();
        };
    </script>
</body>

</html>