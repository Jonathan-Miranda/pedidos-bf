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
        <title>exportar | Brudifarma</title>
        <?php
        require('../src/component/bootstrap.php');
        ?>
    </head>

    <body class="bg-dark">
        <?php
        require('src/navbar.php');
        ?>
        HOLA
        <?php
        require('../src/component/jquery-bootstrap.php');
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    </body>

    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
?>