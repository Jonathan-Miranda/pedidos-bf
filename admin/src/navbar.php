<nav class="navbar sticky-top navbar-expand-md bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
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
                        <p class="focus my-2"><?php echo $_SESSION["admin-us"] . "-" . $_SESSION["admin-id"]; ?></p>
                    </div>

                    <div class="col-md-9">
                        <div class="d-grid gap-2 d-md-block">

                            <a class="btn btn-primary" href="tipo-cliente.php">
                                <i class="bi bi-people-fill"></i> Tipos clientes
                            </a>

                            <a class="btn btn-primary" href="#">
                                <i class="bi bi-person-fill"></i> Usuarios
                            </a>
                            <a class="btn btn-primary" href="#">
                                <i class="bi bi-tag-fill"></i> Categorias
                            </a>
                            <a class="btn btn-primary" href="#">
                                <i class="bi bi-box-fill"></i> Productos
                            </a>

                            <a class="btn btn-danger" href="src/destroy.php"><i class="bi bi-x-circle"></i>
                                Cerrar sesión</a>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</nav>