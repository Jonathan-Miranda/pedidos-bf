<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../connection/conexion.php');
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tipos-Clientes | Brudifarma</title>
        <?php
        require('../src/component/bootstrap.php');
        ?>
    </head>

    <body>
        <?php
        require('src/navbar.php');
        ?>

        <?php
        require('../src/component/jquery-bootstrap.php');
        ?>

    </body>

    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
?>