<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login|Admin</title>
    <?php
    require('../src/component/bootstrap.php');
    ?>
</head>

<body class="bg-dark">

    <div class="container mt-5">
        <div class="row">
            <form id="frm-login" name="frm-login" method="POST">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text h1 text-center">Administrador</p>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                <img class="img-fluid d-block m-auto logo-login" src="https://brudifarma.com.mx/wp-content/uploads/2022/06/logoBrudi.png" alt="Brudifarma">
                                </div>
                                <div class="col-md-12 mt-5">
                                    <div class="input-group mb-3">
                                        <span class="btn btn-primary">@</span>
                                        <input type="email" class="form-control" placeholder="Correo" id="user">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="btn btn-primary"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" class="form-control" placeholder="Contraseña" id="pw">
                                    </div>
                                </div>
                                <div class="col-md-12 mt2">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" type="submit">Ingresar
                                            <span class=" spinner-border-sm " role="status" aria-hidden="true"
                                                id="spinsio"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    require('../src/component/jquery-bootstrap.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    require('js/login.php');
    ?>

</body>

</html>