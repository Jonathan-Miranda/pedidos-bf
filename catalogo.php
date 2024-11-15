<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo | Brudifarma</title>
    <?php
    require('src/component/bootstrap.php');
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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
    require('src/component/carrousel-main.php');
    ?>

    <?php
    require('src/component/carrousel-product-casa.php');
    ?>

    <?php
    require('src/component/carrousel-like-prod.php');
    ?>

    <?php
    require('src/component/products.php');
    ?>

    <?php
    require('src/component/jquery-bootstrap.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <?php
    require('js/swiper-carrousel-home.php');
    ?>

</body>

</html>