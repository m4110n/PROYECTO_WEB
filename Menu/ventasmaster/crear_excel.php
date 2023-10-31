<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=documento_exportado_" . date('Y-m-d-H-i-s') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

include_once("base_de_datos.php");

$output = "";

if (isset($_POST['export'])) {
    $output .= "
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th>Lote</th>
                    <th>Existencia</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
                    <th>Estado</th>
                    <th>Codigo Categoria</th>
                    <th>Codigo Proveedor</th>
                    <th>Fecha Entrada</th>
                    <th>Fecha Salida</th>
                    <th>Unidad Medida</th>
                    <th>Numero Estante</th>
                    <th>Nivel Estante</th>
                    <th>Posicion</th>
                </tr>
            </thead>
            <tbody>
    ";

    $query = mysqli_query($base_de_datos, "SELECT * FROM medicamentos") or die(mysqli_errno());
    while ($fetch = mysqli_fetch_array($query)) {
        $output .= "
            <tr>
                <td>" . $fetch['id'] . "</td>
                <td>" . $fetch['Codigo'] . "</td>
                <td>" . $fetch['Descripcion'] . "</td>
                <td>" . $fetch['Lote'] . "</td>
                <td>" . $fetch['Existencia'] . "</td>
                <td>" . $fetch['Precio_compra'] . "</td>
                <td>" . $fetch['Precio_venta'] . "</td>
                <td>" . $fetch['Estado'] . "</td>
                <td>" . $fetch['Codigo_categoria'] . "</td>
                <td>" . $fetch['Codigo_proveedor'] . "</td>
                <td>" . $fetch['Fecha_entrada'] . "</td>
                <td>" . $fetch['Fecha_salida'] . "</td>
                <td>" . $fetch['Unidad_medida'] . "</td>
                <td>" . $fetch['Numero_estante'] . "</td>
                <td>" . $fetch['Nivel_estante'] . "</td>
                <td>" . $fetch['Posicion'] . "</td>
            </tr>
        ";
    }

    $output .= "
            </tbody>
        </table>
    ";

    echo $output;
}
?>
