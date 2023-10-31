<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $conn->query("delete from users where id=$id");
    if ($sql == 1) {
        echo '<div>Dato eliminado</div>';
    } else {
        echo '<div>Dato no eliminado</div>';
    }
}
