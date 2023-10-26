<?php
require('fpdf/fpdf.php');

if (isset($_POST['generate_pdf'])) {
    // Obtener los datos del formulario
    $clientCode = $_POST['client_code'];
    $purchaseDate = $_POST['purchase_date'];
    $totalAmount = $_POST['total_amount'];
    $nit = $_POST['nit'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Crear un nuevo objeto PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Establecer fuente y color personalizado
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);

    // Título de la factura
    $pdf->Cell(0, 10, 'Factura de Cliente', 0, 1, 'C');
    $pdf->Ln(10);

    // Datos del cliente
    $pdf->Cell(0, 10, 'Código de Cliente: ' . $clientCode, 0, 1);
    $pdf->Cell(0, 10, 'Fecha de Compra: ' . $purchaseDate, 0, 1);
    $pdf->Cell(0, 10, 'NIT: ' . $nit, 0, 1);
    $pdf->Cell(0, 10, 'Dirección: ' . $address, 0, 1);
    $pdf->Cell(0, 10, 'Teléfono: ' . $phone, 0, 1);

    // Línea divisoria
    $pdf->Ln(10);
    $pdf->Cell(0, 0, '', 'T');
    $pdf->Ln(10);

    // Encabezado de la tabla de medicamentos
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'Código', 1);
    $pdf->Cell(80, 10, 'Descripción', 1);
    $pdf->Cell(40, 10, 'Cantidad', 1);
    $pdf->Cell(40, 10, 'Precio', 1);
    $pdf->Ln();

    // Detalles de medicamentos (esto es solo un ejemplo)
    $pdf->SetFont('Arial', '', 12);
    for ($i = 1; $i <= 10; $i++) {
        $pdf->Cell(30, 10, 'Med' . $i, 1);
        $pdf->Cell(80, 10, 'Medicamento de prueba', 1);
        $pdf->Cell(40, 10, '2', 1);
        $pdf->Cell(40, 10, '$25.00', 1);
        $pdf->Ln();
    }

    // Total de la factura
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(150, 10, 'Total:', 1);
    $pdf->Cell(40, 10, '$' . $totalAmount, 1);

    // Nombre del archivo PDF
    $pdfFileName = 'factura_' . $clientCode . '.pdf';

    // Generar el archivo PDF
    $pdf->Output($pdfFileName, 'D');
}
