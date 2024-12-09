<nav class="navbar sticky-top navbar-expand-md bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="catalogo.php">
            <img class="img-fluid d-block m-auto logo-menu"
                src="https://brudifarma.com.mx/wp-content/uploads/2022/06/logoBrudi.png" alt="Brudifarma">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <p class="focus my-2">¡Hola👋! <?php echo $_SESSION['s_usuario']; ?></p>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <form method="get" class="d-flex">
                                <input type="search" class="form-control" placeholder="Buscar..." id="buscar"
                                    name="buscar" value="<?php echo htmlspecialchars($busqueda); ?>">
                                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex justify-content-evenly">

                            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#shop"
                                aria-controls="offcanvasRight"><i class="bi bi-cart2"></i></button>
                            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#like"
                                aria-controls="offcanvasRight"><i class="bi bi-heart-fill"></i></button>

                            <div class="dropdown dropstart">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    <i class="bi bi-person-fill"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-bag"></i> Mis pedidos</a></li>
                                    <li><a class="dropdown-item link-danger" href="src/destroy.php"><i
                                                class="bi bi-x-circle"></i> Cerrar sesión</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</nav>