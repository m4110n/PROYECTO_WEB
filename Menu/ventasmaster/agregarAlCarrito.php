<?php
#erifica si existe una variable $_POST llamada "Codigo". Si no existe, se ejecuta la declaración return, que termina la ejecución del script en ese punto.
if (!isset($_POST["Codigo"])) {
    return;
}

#Asigna el valor de "Codigo" recibido a la variable $Codigo
$Codigo = $_POST["Codigo"];

include_once "base_de_datos.php";

#Prepara una sentencia SQL para buscar un medicamento en una tabla llamada "medicamentos" donde el campo "Codigo" coincida con un valor específico
$sentencia = $base_de_datos->prepare("SELECT * FROM medicamentos WHERE Codigo = ? LIMIT 1;");

#Ejecuta la sentencia SQL preparada, pasando el valor de $Codigo como un parámetro.
$sentencia->execute([$Codigo]);

#Recupera la primera fila del resultado de la consulta y la almacena en la variable $producto como un objeto. Esto se hace utilizando la función fetch
$producto = $sentencia->fetch(PDO::FETCH_OBJ);

# Si no existe, salimos y lo indicamos
if (!$producto) {
    header("Location: vender.php?status=4");
    exit;
}

# Si no hay existencia...
if ($producto->Existencia < 1) {
    header("Location: vender.php?status=5");
    exit;
}

#inicia la sesion SESSION
session_start();

# Buscar producto dentro del carrito
$indice = false;

#Inicia un bucle for que recorre los elementos de un array almacenado en $_SESSION["carrito"]
for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {

    #Verifica si el código del producto actual en el carrito coincide con el código que se está buscando almacenado en la variable $Codigo
    if ($_SESSION["carrito"][$i]->Codigo === $Codigo) {
        $indice = $i;
        break;
    }
}
# Si no existe, lo agregamos como nuevo
if ($indice === false) {

    #establece la cantidad de productos actual en 1
    $producto->Cantidad = 1;

    #Calcula el total del producto actual multiplicando su precio de venta por la cantidad
    $producto->total = $producto->Precio_venta;

    #Agrega el producto al carrito de compras almacenado en la sesión del usuario.
    array_push($_SESSION["carrito"], $producto);
} else {
    # Si ya existe, se agrega la cantidad
    #Obtiene la cantidad existente del producto que ya está en el carrito.
    $cantidadExistente = $_SESSION["carrito"][$indice]->Cantidad;
    # si al sumarle uno supera lo que existe, no se agrega
    if ($cantidadExistente + 1 > $producto->Existencia) {
        header("Location:vender.php?status=5");
        exit;
    }

    #Aumenta la cantidad del producto existente en el carrito
    $_SESSION["carrito"][$indice]->Cantidad++;

    #Actualiza el total del producto existente en el carrito multiplicando su cantidad por su precio de venta
    $_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->Cantidad * $_SESSION["carrito"][$indice]->Precio_venta;
}
header("Location:vender.php");

?>