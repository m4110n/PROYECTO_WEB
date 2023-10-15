<?php
require('fpdf/fpdf.php');

// Crear una nueva instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Configuración de fuente y tamaño
$pdf->SetFont('Arial', 'B', 16);

// Título
$pdf->Cell(0, 10, 'Factura de Cliente', 0, 1, 'C');

// Obtener datos del formulario
$clientCode = $_POST['client_code'];
$purchaseDate = $_POST['purchase_date'];
$totalAmount = $_POST['total_amount'];
$nit = $_POST['nit'];
$address = $_POST['address'];
$phone = $_POST['phone'];

// Mostrar los datos en el PDF
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Código de Cliente: ' . $clientCode, 0, 1);
$pdf->Cell(0, 10, 'Fecha de Compra: ' . $purchaseDate, 0, 1);
$pdf->Cell(0, 10, 'Total de la Factura: $' . $totalAmount, 0, 1);
$pdf->Cell(0, 10, 'NIT: ' . $nit, 0, 1);
$pdf->Cell(0, 10, 'Dirección: ' . $address, 0, 1);
$pdf->Cell(0, 10, 'Teléfono: ' . $phone, 0, 1);

// Guardar el PDF en un archivo
$pdf->Output('factura.pdf', 'F');

echo 'Factura generada correctamente. Puedes descargar el PDF <a href="factura.pdf">aquí</a>.';
?>
