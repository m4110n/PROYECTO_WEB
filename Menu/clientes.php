<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Ingreso de Datos de Clientes</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlaza tu archivo CSS personalizado aquí -->
</head>
<body>
    <div class="container">
        <h1>Formulario de Ingreso de Datos de Clientes</h1>
        <form action="procesar.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <textarea id="direccion" name="direccion"></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Guardar Cliente</button>
            </div>
        </form>
    </div>
</body>
</html>
