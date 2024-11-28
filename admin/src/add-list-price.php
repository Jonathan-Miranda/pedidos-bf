<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../../connection/conexion.php');
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agregar productos | Brudifarma</title>
        <?php
        require('../../src/component/bootstrap.php');
        ?>
    </head>

    <body class="bg-dark">

        <div class="container mt-3">
            <div class="row mb-3">
                <div class="col-md-4 text-center">
                    <a href="../products.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Regresar</a>
                </div>
                <div class="col-md-4 text-center">
                    <h2 class="text-white">Agregar precio</h2>
                </div>
                <div class="col-md-4 text-center border border-warning">

                    <form id="excel" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                        <label class="col-form-label focus text-white" for="file"><i class="bi bi-boxes"></i> Subir lista de precios</label>
                        <input type="file" class="form-control mb-3" id="file" name="file"
                            accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            required>
                        <div class="d-grid">
                            <input type="submit" id="btn-excel" value="SUBIR" class="btn btn-success">
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <?php
        require('../../src/component/jquery-bootstrap.php');
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // add-product-more
            $('#excel').submit(function (e) {
                e.preventDefault();
                var btn2 = $('#btn-excel');
                var formData = new FormData(this); // Crea un nuevo objeto FormData con los datos del formulario
                for (var pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                btn2.val('Subiendo lista espera...');
                btn2.prop('disabled', true);
                $.ajax({
                    url: "up-list-price.php",
                    type: "POST",
                    data: formData,
                    processData: false, // Importante para que jQuery no intente procesar el FormData
                    contentType: false,  // Importante para que jQuery no configure un tipo de contenido automático
                    dataType: "json",
                    success: function (response) {
                        if (response.status) {
                            btn2.val('SUBIR');
                            btn2.prop('disabled', false);
                            Swal.fire({
                                icon: response.icon,
                                title: response.msj,
                            }).then(() => {
                                window.location.href = "add-list-price.php";
                            });

                        } else {
                            btn2.val('SUBIR');
                            btn2.prop('disabled', false);
                            Swal.fire({
                                icon: response.icon,
                                title: response.msj,
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        // Función que se ejecuta si ocurre un error
                        btn2.val('SUBIR');
                        btn2.prop('disabled', false);
                        Swal.fire({
                            icon: 'error', // Tipo de alerta (error)
                            title: 'Error',
                            text: 'Ocurrió un error',
                            footer: 'Detalles del error: ' + xhr.responseText, // Aquí mostramos los detalles del error
                            confirmButtonText: 'Cerrar'
                        });
                    }
                });
            });
            // FIN add-product-more
        </script>

    </body>

    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
?>