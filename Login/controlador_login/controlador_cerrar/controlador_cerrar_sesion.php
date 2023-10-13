<?php
session_start();
session_destroy();
header("Location: ../../../login/login.php");
//podemos usar a   header("Location: /PROYECTO_WEB/login/login.php");
