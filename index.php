<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php
    require('src/component/bootstrap.php');
    ?>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-7">
                <img class="img-fluid d-block m-auto logo-login" src="https://brudifarma.com.mx/wp-content/uploads/2022/06/logoBrudi.png" alt="Brudifarma">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <hr>
                        <h1 class="text-center focus">INICIA SESIÓN</h1>
                        <p class="text-center">Nos alegra tenerte de vuelta</p>

                        <form>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label focus g-text">Email</label>
                                <input type="email" class="form-control rounded-pill" placeholder="ejemplo@brudifarma.com.mx">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label focus g-text">Contraseña</label>
                                <input type="password" class="form-control rounded-pill" placeholder="Contraseña">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn rounded-pill btn-danger">Ingresar</button>
                            </div>
                        </form>
                        <p class="focus mt-3">-Olvidaste tu contraseña🥺? <a href="#" class="text-decoration-none">recuperala aqui 🥳</a></p>
                    </div>
                </div>
            </div>

            <div class="col-md-5 purple rounded-4 p-4">
                <div class="d-block my-5 text-center text-white">
                    <p class="fs-1"><i class="bi bi-boxes"></i></p>
                    <h2>Descubre una nueva forma<br>de crear tus pedidos</h2>
                    <p>Es muy sencillo, selecciona los productos, crea tu preorden y en unos instantes se comunicaran contigo para concretar tu pedido.</p>
                    <a class="btn btn-outline-light me-1 mb-3" role="button" href="#"><i class="bi bi-patch-check"></i> 100% Confiable</a>
                    <a class="btn btn-outline-light mb-3" role="button" href="#"><i class="bi bi-headset"></i> Seguimiento personalizado</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>