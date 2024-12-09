<?php
session_start();
if (isset($_SESSION['s_usuario'])) {
    require('connection/conexion.php');

    // Inicializar la variable de búsqueda de manera predeterminada
    $busqueda = '';

    // Verificar si el parámetro de búsqueda está presente en la URL
    if (isset($_GET['buscar'])) {
        $busqueda = $_GET['buscar'];
    }

    // Número de productos por página
    $productos_por_pagina = 20;

    // Obtener el número de página actual
    $pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
    $offset = ($pagina_actual - 1) * $productos_por_pagina;
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Favoritos | Brudifarma</title>
        <?php
        require('src/component/bootstrap.php');
        ?>
    </head>

    <body>
        <?php
        require('src/component/navbar.php');
        ?>

        <?php
        require('src/component/car-offcanvas.php');
        ?>

        <?php
        require('src/component/like-offcanvas.php');
        ?>

        <?php
        require('src/component/products.php');
        ?>

        <?php
        require('src/component/jquery-bootstrap.php');
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php
        require('js/swiper-carrousel-home.php');
        ?>

    </body>

    </html>
    <?php
} else {
    header("Location: index.php");
    exit();
}
?>