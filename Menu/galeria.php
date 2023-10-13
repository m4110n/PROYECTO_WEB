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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Imágenes con Bootstrap</title>
    <!-- Agrega los enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">Galería de Imágenes</h1>

        <!-- Contenedor de las miniaturas de las imágenes -->
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <img src="img/Triprofen.png" alt="Imagen 1" class="img-thumbnail">
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <img src="img/medicamento2.png" alt="Imagen 2" class="img-thumbnail">
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <img src="img/medicamento3.jpeg" alt="Imagen 3" class="img-thumbnail">
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <img src="img/medicamento4.jpg" alt="Imagen 4" class="img-thumbnail">
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <img src="img/medicamento5.jpeg" alt="Imagen 5" class="img-thumbnail">
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <img src="img/medicamento6.jpg" alt="Imagen 6" class="img-thumbnail">
            </div>

            <!-- Puedes agregar más imágenes siguiendo la misma estructura -->
        </div>
    </div>

    <!-- Agrega los enlaces a los archivos JavaScript de Bootstrap y jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
<footer>
    <div class="container">
        <p>Derechos de autor &copy; 2023 Carlos Edward Rafael Donis Alvarado - BOTIQUIN S.A</p>
    </div>
</footer>

</html>