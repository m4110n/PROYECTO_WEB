<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel_de_control</title>
    <button class="btn btn-primary"><a href="../index.php" style="color: white; text-decoration: none;">Regresar</a></button>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/46a0b7b2cd.js" crossorigin="anonymous"></script>

</head>

<body>
    <h1 class="text-center p-3">Panel de control</h1>
    <div class="container-fluid row">
        <!--tabla de registo-->
        <form class="col-4 p-3" method="post">
            <h3 class="text-center text-secondary">Registro</h3>
            <?php
            include "../../conexion_dba/conexion.php";
            include "../Usuarios/controlador_registro/registro.php";
            include "./controlador_eliminar.php";
            ?>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Correo</label>
                <input type="email" class="form-control" name="Correo">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Permisos</label>
                <select class="form-select" name="Permisos">
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                    <option value="Editor">Editor</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="Contraseña">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estatus</label>
                <select class="form-select" name="Estatus">
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="Registrar">Registrar</button>
            <!--Mostrar datos-->
        </form>
        <div class="col-8 p-4">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Permisos</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Estatus</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "../../conexion_dba/conexion.php";
                    $sql = $conn->query("select * from users");
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id ?></td>
                            <td><?= $datos->name ?></td>
                            <td><?= $datos->email ?></td>
                            <td><?= $datos->permissions ?></td>
                            <td><?= $datos->password ?></td>
                            <td><?= $datos->status ?></td>
                            <td>
                                <a href="../Usuarios/modificar.php?id=<?= $datos->id ?>" class="btn btn-small btn-warning "><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="usuarios.php?id=<?= $datos->id ?>" class="btn btn-small btn-danger "><i class="fa-solid fa-delete-left"></i></a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>