<?php
session_start();
if (isset($_SESSION['s_usuario'])) {
    require('connection/conexion.php');

    // Inicializar la variable de búsqueda de manera predeterminada
    $busqueda = '';

    // Verificar si el parámetro de búsqueda está presente en la URL
    if (isset($_GET['buscar'])) {
        $busqueda = trim($_GET['buscar']);
    }

    // Número de productos por página
    $productos_por_pagina = 20;

    // Obtener el número de página actual
    $pagina_actual = isset($_GET['pagina']) ? max((int)$_GET['pagina'], 1) : 1; // Asegurarse de que sea un número válido
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
        <div class="container">
            <div class="row">
                <div class="col-md-12 my-3">
                    <p class="focus fs-1">Mis Favoritos ❤️</p>
                </div>
            </div>
        </div>
        <?php
        require('src/component/products-like.php');
        ?>

        <?php
        require('src/component/jquery-bootstrap.php');
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php
        require('js/like.php');
        ?>

    </body>

    </html>
    <?php
} else {
    header("Location: index.php");
    exit();
}
?>