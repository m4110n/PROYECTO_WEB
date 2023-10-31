<?php

#erifica si la variable $_GET["id"] está definida en la URL, si no hay muestra un mensaje de error 
if (!isset($_GET["id"])) {
    exit("No hay id");
}

#Asigna el valor de "id" pasado en la URL a la variable $id
$id = $_GET["id"];

include_once "base_de_datos.php";

#Prepara una sentencia SQL para seleccionar información sobre la venta con un ID específico
$sentencia = $base_de_datos->prepare("SELECT id, fecha, total FROM ventas WHERE id = ?");

#Ejecuta la sentencia SQL preparada, pasando el valor de $id como un parámetro
$sentencia->execute([$id]);

#Recupera la primera fila del resultado de la consulta y la almacena en la variable $venta
$venta = $sentencia->fetchObject();

#Verifica si la consulta no devolvió ningún resultado, lo que significa que no se encontró una venta con el ID proporcionado en la base de datos. Si no se encuentra, muestra un mensaje de error 
if (!$venta) {
    exit("No existe venta con el id proporcionado");
}

#Esta línea prepara una consulta SQL para seleccionar información sobre los medicamentos vendidos en una venta específica. La consulta utiliza una combinación de tablas utilizando INNER JOIN, 
#donde se relaciona la tabla "medicamentos" (alias "p") con la tabla "productos_vendidos" (alias "pv") en función de la igualdad entre los campos "id" de "medicamentos" y "id_producto" de "productos_vendidos"
#El signo de interrogación en la consulta es un marcador de posición que se reemplazará con el valor de $id cuando se ejecute la consulta
$sentenciamedicamentos = $base_de_datos->prepare("SELECT p.codigo, p.Descripcion,p.Precio_venta, pv.Cantidad
FROM medicamentos p
INNER JOIN 
productos_vendidos pv
ON p.id = pv.id_producto
WHERE pv.id_venta = ?");


#Esta línea ejecuta la consulta SQL preparada con el valor de $id como un parámetro. Esto recuperará los medicamentos vendidos en la venta con el ID correspondiente
$sentenciamedicamentos->execute([$id]);

#Después de ejecutar la consulta, se utilizan fetchAll() para obtener todos los resultados de la consulta y se almacenan en el arreglo $medicamentos
$medicamentos = $sentenciamedicamentos->fetchAll();
if (!$medicamentos) {
    exit("No hay productos");
}

?>
<style>

    /* Establece el tamaño de fuente y la fuente para todos los elementos en la página. */
    * {
        font-size: 12px;
        font-family: 'Times New Roman';
    }


    /* Define reglas de borde para las celdas, filas y tablas, creando un aspecto de tabla con bordes sólidos */
    td,
    th,
    tr,
    table {
        border-top: 1px solid black;
        border-collapse: collapse;
    }


    /* Establece el ancho máximo de las celdas con la clase "producto" en 90 píxeles */
    td.producto,
    th.producto {
        width: 90px;
        max-width: 90px;
    }

    /* Establece el ancho máximo de las celdas con la clase "Cantidad" en 50 píxeles y permite la división de palabras */
    td.Cantidad,
    th.Cantidad {
        width: 50px;
        max-width: 50px;
        word-break: break-all;
    }

    /* Establece el ancho máximo de las celdas con la clase "precio" en 50 píxeles, permite la división de palabras y alinea el texto a la derecha */
    td.precio,
    th.precio {
        width: 50px;
        max-width: 50px;
        word-break: break-all;
        text-align: right;
    }

    /* Define una clase llamada "centrado" que alinea el texto y el contenido al centro */
    .centrado {
        text-align: center;
        align-content: center;
    }

    /* Establece el ancho máximo de elementos con la clase "ticket" en 175 píxeles */
    .ticket {
        width: 175px;
        max-width: 175px;
    }

    /* Define reglas para imágenes, permitiendo que conserven su tamaño original */
    img {
        max-width: inherit;
        width: inherit;
    }


    /* Define reglas de estilo específicas para cuando se imprime la página. En este caso, la clase "oculto-impresion" y sus elementos secundarios se ocultan 
    durante la impresión, lo que puede ser útil para ocultar elementos no deseados en el ticket impreso */
    @media print {

        .oculto-impresion,
        .oculto-impresion * {
            display: none !important;
        }
    }
</style>

<body>

<!-- Crea un contenedor con una clase CSS "ticket" para el contenido del ticket de venta. -->
    <div class="ticket">

    <!-- Muestra una imagen del logotipo -->
        <img src="logo2.png" alt="Logotipo">

        <p class="centrado">TICKET DE VENTA
            <br><?php echo $venta->fecha; ?>
        </p>
        <table>
            <thead>
                <tr>

                <!-- define las celdas del encabezado de la tabla con los nombres de las columnas -->
                    <th class="Cantidad">CANT</th>
                    <th class="producto">PRODUCTO</th>
                    <th class="precio">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php

// Se inicializa la variable $total con un valor de cero. Esta variable se utilizará para llevar un registro del monto total de la venta
                $total = 0;

                // Inicia un bucle foreach que recorre el arreglo $medicamentos. Cada elemento del arreglo representa un medicamento vendido en la venta, y se almacena en la variable $producto
                foreach ($medicamentos as $producto) {

                    // Calcula el subtotal para el medicamento actual multiplicando el precio de venta ($producto->Precio_venta) por la cantidad vendida ($producto->Cantidad). El resultado se almacena en la variable $subtotal
                    $subtotal = $producto->Precio_venta * $producto->Cantidad;

                    // Agrega el subtotal al monto total de la venta, acumulando así el costo total de todos los medicamentos vendidos en la variable $total
                    $total += $subtotal;
                ?>
                    <tr>

                    <!-- se muestra la cantidad del medicamento vendido  -->
                        <td class="Cantidad"><?php echo $producto->Cantidad;  ?></td>

                        <!-- muestra la descripcion del medicamento junto con su precio de venta formateado con dos decimales y precedido por el símbolo Q -->
                        <td class="producto"><?php echo $producto->Descripcion;  ?> <strong>Q<?php echo number_format($producto->Precio_venta, 2) ?></strong></td>

                        <!-- se muestra el subtotal del medicamento vendido con formato precio, precedido por el simbolo Q -->
                        <td class="precio">Q<?php echo number_format($subtotal, 2)  ?></td>
                    </tr>
                <?php } ?>
                <tr>

                <!-- se coloca el texto, y el colspan lo que significa que esta celda abarca dos columnas en lugar de una  -->
                    <td colspan="2" style="text-align: right;">TOTAL</td>

                    <!-- se muestra el monto total de la venta, seguido del monto total con formato especifico que incluye dos decimales  -->
                    <td class="precio">
                        <strong>Q<?php echo number_format($total, 2) ?></strong>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="centrado">¡GRACIAS POR SU COMPRA!
        </p>
    </div>
</body>


<script>

// Este bloque de código se ejecuta cuando el evento "DOMContentLoaded" se dispara, lo que ocurre cuando la página se ha cargado completamente
    document.addEventListener("DOMContentLoaded", () => {

        //se utiliza para abrir la ventana de impresión del navegador y permitir al 
        //usuario imprimir la página actual, que en este caso es el ticket de venta
        window.print();

        //para retrasar una acción. En este caso, después de un retraso de 1000 milisegundos (1 segundo), se ejecuta una función anónima. 
        //Dentro de esta función anónima, se cambia la ubicación (URL) de la página a "ventas.php" utilizando window.location.href. 
        //Esto redirige al usuario automáticamente a la página de ventas después de que haya realizado la impresión del ticket.
        setTimeout(() => {
            window.location.href = "ventas.php";
        }, 1000);
    });
</script>