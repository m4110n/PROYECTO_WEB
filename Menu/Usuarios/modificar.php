<?php
include "../../conexion_dba/conexion.php";
$id = $_GET["id"];
$sql = $conn->query("select * from users where id=$id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <form class="col-4 p-3 m-auto" method="post">
        <h3 class="text-center text-secondary">Editar</h3>
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <?php
        include "../Usuarios/controlador_modificacion/modificar.php";
        while ($datos = $sql->fetch_object()) { ?>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= $datos->name ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Correo</label>
                <input type="email" class="form-control" name="Correo" value="<?= $datos->email ?>">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Permisos</label>
                <select class="form-select" name="Permisos" value="<?= $datos->permissions ?>">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="editor">Editor</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="Contraseña" value="<?= $datos->password ?>">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estatus</label>
                <select class="form-select" name="Estatus" value="<?= $datos->status ?>">
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                </select>
            </div>

        <?php   }
        ?>



        <button type="submit" class="btn btn-primary" name="Registrar">Modificar</button>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>