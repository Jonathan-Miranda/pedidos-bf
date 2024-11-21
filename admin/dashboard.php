<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../connection/conexion.php');
    echo $_SESSION["admin-us"] . "-" . $_SESSION["admin-id"];
    ?>

    <br>
    <a href="src/destroy.php">Cerrar sesión</a>
    <?php
} else {
    header("Location: index.php");
    exit();
}
?>