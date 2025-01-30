<?php
session_start();
$_GET['id_product'] = 3945;
if (isset($_SESSION['s_usuario']) && isset($_GET['id_product'])) {
    require('connection/conexion.php');

    // Inicializar la variable de búsqueda de manera predeterminada
    $busqueda = '';

    // Verificar si el parámetro de búsqueda está presente en la URL
    if (isset($_GET['buscar'])) {
        $busqueda = $_GET['buscar'];
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Producto | Brudifarma</title>
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

        $q_product = "SELECT 
        p.ID AS product_id, 
        p.SKU, 
        p.NOMBRE, 
        p.SUSTANCIA, 
        p.PRESENTACION, 
        p.REGISTRO_SANITARIO, 
        p.STOCK, 
        p.DESCRIPCION, 
        p.IMAGEN_URL, 
        p.PUBLIC_ID, 
        p.CODIGO_BARRAS, 
        c.ID AS category_id, 
        c.NOMBRE AS category_name, 
        pr.PRECIO, 
        pr.OFERTA
    FROM 
        product p
    JOIN 
        product_category pc ON p.ID = pc.ID_PRODUCT
    JOIN 
        category c ON pc.ID_CATEGORY = c.ID
    JOIN 
        precio_product pr ON p.ID = pr.ID_PRODUCT
    WHERE 
        p.ID =:id_prod";
        $res_prod = $con->prepare($q_product);

        // Establecer parámetros de búsqueda y paginación
        $res_prod->bindValue(':id_prod', $_GET['id_product'], PDO::PARAM_INT);
        $res_prod->execute();
        if ($res_prod->rowCount() >= 1) {
            while ($row_p = $res_prod->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <div class="container mt-3">
                    <div class="row">
                        <div class="col-md-5">
                            <img class="img-fluid d-block m-auto" src="images/<?php echo $row_p['IMAGEN_URL']; ?>" alt="Producto"
                                loading="lazy">
                        </div>
                        <div class="col-md-7">
                            <p class="fs-2 focus"><?php echo $row_p['NOMBRE']; ?></p>
                            <p><span class="focus">Categoria:</span> <?php echo $row_p['category_name']; ?></p>
                            <hr>

                            <?php
                            if ($row_p['OFERTA'] > 0) {

                                ?>
                                <p class="focus fs-1 purp">$<?php echo $row_p['OFERTA']; ?> <span class="fs-4 text-danger">$<span
                                            class="text-decoration-line-through"><?php echo $row_p['PRECIO']; ?></span></span></p>
                                <?php
                            } else {
                                ?>
                                <p class="focus fs-1 purp">$<?php echo $row_p['PRECIO']; ?></p>
                                <?php
                            }
                            ?>
                            <p class="fs-4"><span class="focus">Disponibles:</span> <?php echo $row_p['STOCK']; ?></p>
                            <p class="focus fs-5">Sobre este producto</p>
                            <ul>
                                <li><span class="focus">SKU:</span> <?php echo $row_p['SKU']; ?></li>
                                <li><span class="focus">Reg.San:</span> <?php echo $row_p['REGISTRO_SANITARIO']; ?></li>
                                <li><span class="focus">Cod.Bar:</span> <?php echo $row_p['CODIGO_BARRAS']; ?></li>
                                <li><span class="focus">Sustancia:</span> <?php echo $row_p['SUSTANCIA']; ?></li>
                                <li><span class="focus">Presentación:</span> <?php echo $row_p['PRESENTACION']; ?></li>
                                <li><span class="focus">Descripción:</span> <?php echo $row_p['DESCRIPCION']; ?></li>
                            </ul>

                            <div class="input-group">
                                <button class="btn bk" type="button" id="menos"><i class="bi bi-dash"></i></button>
                                <input type="number" class="form-control" id="agregar" max="<?php echo $row_p['STOCK']; ?>" min="1">
                                <button class="btn bk" type="button" id="mas"><i class="bi bi-plus"></i></button>
                            </div>

                            <div class="d-grid  mt-3 gap-2">
                                <button class="btn btn-purple" type="button" id="btn-add">Agregar</button>
                            </div>

                        </div>
                    </div>

                    <?php
            }
        }
        ?>

            <?php
            $query_related = "SELECT 
        p.ID, 
        p.SKU,
        p.NOMBRE, 
        p.DESCRIPCION,
        p.IMAGEN_URL 
    FROM 
        product p
    JOIN 
        product_category pc ON p.ID = pc.ID_PRODUCT
    WHERE 
        pc.ID_CATEGORY = (
            SELECT 
                pc_sub.ID_CATEGORY 
            FROM 
                product_category pc_sub 
            WHERE 
                pc_sub.ID_PRODUCT = :id_product
            LIMIT 1
        )
    ORDER BY 
        p.ID DESC
    LIMIT 6";

            $res_related = $con->prepare($query_related);

            // Establecer parámetros de búsqueda y paginación
            $res_related->bindParam(':id_product', $_GET['id_product'], PDO::PARAM_INT);

            $res_related->execute();
            ?>

            <div class="row">
                <p class="fs-2 focus mt-3">Productos relacionados ⭐</p>

                <div class="col-md-12 my-3">
                    <!-- Swiper -->
                    <div class="swiper mySwiper2">
                        <div class="drag-indicator2 fs-3"><i class="bi bi-arrows"></i></div>
                        <div class="swiper-wrapper">

                            <?php
                            while ($row_related = $res_related->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <div class="swiper-slide position-relative">

                                    <div class="card">

                                        <img src="images/<?php echo $row_related['IMAGEN_URL']; ?>" class="card-img-top"
                                            alt="..." loading="lazy">
                                        <div class="card-body">
                                            <p class="fs-5 focus"><?php echo $row_related['NOMBRE']; ?></p>
                                            <p><?php echo $row_related['DESCRIPCION']; ?></p>
                                            <span class="fw-light">SKU: <?php echo $row_related['SKU']; ?></span>
                                        </div>

                                    </div>

                                    <div class="z-3 position-absolute top-0 start-0 m-3">
                                        <a class="btn rounded-circle btn-danger text-center" href="#">
                                            <i class="bi bi-heart"></i>
                                        </a>
                                    </div>

                                </div>
                                <?php
                            } ?>

                        </div>

                    </div>

                    <!-- End Swiper -->

                </div>
            </div>

        </div>


        <?php
        require('src/component/jquery-bootstrap.php');
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <?php
        require('js/swiper-carrousel-related.php');
        ?>

        <?php
        require('js/like.php');
        ?>

        <?php
        require('js/product-info.php');
        ?>

    </body>

    </html>
    <?php
} else {
    header("Location: catalogo.php");
    exit();
}
?>