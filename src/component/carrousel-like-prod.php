<!-- like -->
<div class="container">
    <div class="row">
        <p class="fs-1 focus mt-3">Mis favoritos ❤️
            <a class="btn rounded-pill bk icon-link icon-link-hover" href="favoritos.php">
                Ver todos
                <svg fill="currentColor" class="bi bi-arrow-right-short fs-4" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                </svg>
            </a>
        </p>

        <div class="col-md-12 mt-3">
            <!-- Swiper -->
            <div class="swiper mySwiper2">
                <div class="drag-indicator2 fs-3"><i class="bi bi-arrows"></i></div>
                <div class="swiper-wrapper">
                    <?php
                    if (count($wishListItems) > 0) {
                        foreach ($wishListItems as $row_wish) {
                            ?>

                            <div class="swiper-slide">
                                <div class="card">
                                    <img src="https://placehold.co/600" class="card-img-top" alt="..." loading="lazy" />
                                    <div class="card-body">
                                        <p class="fs-5 focus"><?php echo $row_wish['NOMBRE']; ?></p>
                                        <p><?php echo $row_wish['DESCRIPCION']; ?></p>
                                        <span class="fw-light">SKU: <?php echo $row_wish['SKU']; ?></span>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    } else {
                        ?>
                        <div class="alert alert-warning" role="alert">
                            🥺 Aun no tienes productos favoritos
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>

            <!-- End Swiper -->

        </div>
    </div>

</div>

<!-- end like -->