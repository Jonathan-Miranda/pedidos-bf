<?php
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/catalogo/";
?>
<!-- like -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="like" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Favoritos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <?php
        $query_wish = "SELECT 
            p.ID, 
            p.SKU, 
            p.NOMBRE, 
            p.IMAGEN_URL, 
            p.DESCRIPCION
        FROM 
            wish_list w
        JOIN 
            product p 
        ON 
            w.ID_PRODUCT = p.ID
        WHERE 
            w.ID_USER = :idUser
        ORDER BY 
            w.ID DESC
        LIMIT 6";
        $resultado_wish = $con->prepare($query_wish);

        // Establecer parámetros de búsqueda y paginación
        $resultado_wish->bindValue(':idUser', $_SESSION['id'], PDO::PARAM_INT);

        $resultado_wish->execute();

        $wishListItems = $resultado_wish->fetchAll(PDO::FETCH_ASSOC);

        if (count($wishListItems) > 0) {
            foreach ($wishListItems as $row_wish) {
                ?>

                <div class="alert alert-light alert-dismissible fade show" role="alert">
                    <a href="#" class="btn text-decoration-none">
                        <img src="https://placehold.co/50" alt="Imagen del producto">
                        <span class="focus"><?php echo $row_wish['NOMBRE']; ?></span>
                    </a>
                    <button type="button" class="btn-close toggle-wishlist" data-product-id="<?php echo $row_wish['ID']; ?>" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <?php
            }
            ?>
            <div class="d-grid">

                <a class="btn d-block rounded-pill bk icon-link icon-link-hover" href="favoritos.php">
                    Ver todos
                    <svg fill="currentColor" class="bi bi-arrow-right-short fs-4" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                    </svg>
                </a>
            </div>
            <?php
        } else {
            ?>
            <div class="text-center">
                <img src="<?php echo $base_url; ?>images/favorito-vacio.svg" width="80px" height="auto"
                    class="img-fluid d-block m-auto" alt="Sin favoritos">
                <p class="fs-2 focus">Aun no tienes favoritos</p>
                <p>-¡Pss! los mejores son los de casa.😉</p>
            </div>
            <?php
        }
        ?>

    </div>
</div>
<!-- end like -->