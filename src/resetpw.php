<?php
if (isset($_GET["mail"]) && $_GET["mail"] != "" && filter_var($_GET["mail"], FILTER_VALIDATE_EMAIL)) {
    require('../connection/conexion.php');

    $query = "SELECT ID FROM user WHERE CORREO='" . $_GET["mail"] . "' AND RESET_PW='1'";
    $resultado = $con->prepare($query);
    $resultado->execute();

    if ($resultado->rowCount() >= 1) {
        $data = $resultado->fetch();
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Restablecer contraseña</title>
            <?php
            require('component/bootstrap.php');
            ?>
        </head>

        <body>

            <div class="container overflow-hidden">
                <div class="row my-5">
                    <div class="col-md-6 offset-md-3 bg-light p-3 rounded-4">

                        <h1 class="text-center">Restablecer contraseña</h1>

                        <form id="pw-form" method="POST" name="pw-form" enctype="multipart/form-data" accept-charset="utf-8">
                            <input type="hidden" value="<?php echo $data[0]; ?>" name="id" id="id">

                            <div class="form-floating my-3">
                                <input type="password" class="form-control" id="pw1" name="pw1" placeholder="Nueva contraseña"
                                    required>
                                <label for="pw1" class="form-label">Nueva contraseña</label>
                            </div>

                            <div class="form-floating my-3">
                                <input type="password" class="form-control" id="pw2" name="pw2"
                                    placeholder="Confirmar contraseña nueva" required>
                                <label for="pw2" class="form-label">Confirmar contraseña nueva</label>
                            </div>

                            <div class="d-grid gap-2 mb-3 text-center">
                                <input type="submit" class="btn btn-primary btn-lg" id="btnpw" value="Restablecer">
                            </div>

                            <div class="my-3">
                                <a href="../index.php">Iniciar sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $('#pw-form').submit(function (e) {
                    e.preventDefault();
                    var datos = new FormData(document.getElementById("pw-form"));
                    var pw1 = $("#pw1").val();
                    var pw2 = $("#pw2").val();

                    if (pw1 != pw2) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Las contraseñas no coinciden',
                        });
                    } else {
                        $("#btnpw").attr("disabled", true);
                        $("#btnpw").attr("value", "Verificando Información");
                        $.ajax({
                            url: "updatepw.php",
                            type: "POST",
                            dataType: "HTML",
                            data: datos,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if (data == 0) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'No se pudo cambiar la contraseña, intente nuevamente',
                                    });
                                    $("#btnpw").attr("disabled", false);
                                    $("#btnpw").attr("value", "Restablecer");
                                } else {
                                    Swal.fire("Listo", "Se ha cambiado la contraseña", "success");
                                    $("#btnpw").attr("disabled", false);
                                    $("#pw-form")[0].reset();
                                    $("#btnpw").attr("value", "Restablecer");
                                }
                            }
                        });

                    }
                });
            </script>
        </body>

        </html>
        <?php

    } else {
        header('Location: ../index.php');
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}
?>