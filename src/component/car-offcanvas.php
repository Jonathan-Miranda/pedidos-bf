<?php
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/catalogo/";
?>
    <!-- shop car -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="shop" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Carrito</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="text-center">
                <img src="<?php echo $base_url; ?>images/carrito-vacio.svg" class="img-fluid d-block m-auto" alt="Carrito vacio">
                <p class="fs-2 focus">Carrito vacío</p>
                <p>Agrega productos</p>
            </div>
        </div>
    </div>
    <!-- end shop car -->