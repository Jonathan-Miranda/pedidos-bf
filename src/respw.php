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

                <h2 class="text-center fs-1">Restablecer contraseña</h2>
                <hr>

                <form id="pw-form" method="POST" name="pw-form" enctype="multipart/form-data" accept-charset="utf-8">

                    <div class="form-floating my-3">
                        <input type="email" class="form-control" id="correo" name="correo"
                            placeholder="Correo electronico con el que inicias sesión" required>
                        <label for="correo" class="form-label">Correo electronico con el que inicias sesión</label>
                    </div>

                    <div class="text-center">
                        <div class="d-grid gap-2">
                            <input type="submit" class="btn btn-primary btn-lg" id="btnpw" value="Restablecer">
                        </div>
                    </div>
                    <div class="my-3">
                        <a href="../index.php">Regresar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#pw-form').submit(function (e) {
            e.preventDefault();
            var datos = new FormData(document.getElementById("pw-form"));

            $("#btnpw").attr("disabled", true);
            $("#btnpw").attr("value", "Verificando Información");
            $.ajax({
                url: "reset.php",
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
                            title: 'El correo no existe',
                        });
                        $("#btnpw").attr("disabled", false);
                        $("#btnpw").attr("value", "Restablecer");
                    } else {
                        // =================
                        $.ajax({
                            url: "../mail/notipw.php",
                            type: "POST",
                            dataType: "HTML",
                            data: datos,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if (data == 2) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Hubo un error al tratar de enviar el correo para restablecer tu contraseña. Intentalo de nuevo y si el problema persiste manda un whatsapp al 55 5039 0170',
                                    });
                                    $("#btnpw").attr("disabled", false);
                                    $("#btnpw").attr("value", "Restablecer");
                                } else {

                                    Swal.fire("Te enviamos un correo", "Con instrucciones para restablecer tu contraseña revisa tu bandeja si no aparece intenta buscar en spam", "success");
                                    $("#btnpw").attr("disabled", false);
                                    $("#pw-form")[0].reset();
                                    $("#btnpw").attr("value", "Restablecer");
                                }
                            },
                            error: function (xhr, status, error) {
                                // Función que se ejecuta si ocurre un error
                                Swal.fire({
                                    icon: 'error', // Tipo de alerta (error)
                                    title: 'Error en la solicitud',
                                    text: 'Ocurrió un error al intentar obtener los datos.',
                                    footer: 'Detalles del error: ' + xhr.responseText, // Aquí mostramos los detalles del error
                                    confirmButtonText: 'Cerrar'
                                });
                            }

                        });
                    }
                }
            });


        });
    </script>
</body>

</html>