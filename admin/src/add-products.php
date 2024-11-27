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
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="../products.php"><i class="bi bi-arrow-left"></i> Regresar</a>
                    <h2 class="text-white">Agregar producto</h2>
                </div>
            </div>

            <!-- form add one product -->
            <form id="frm-add-prod" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="row">

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="sku" class="col-form-label focus text-white">SKU:</label>
                            <input type="number" class="form-control" id="sku" name="sku" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="col-form-label focus text-white">NOMBRE:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="sustancia" class="col-form-label focus text-white">SUSTANCIA:</label>
                            <input type="text" class="form-control" id="sustancia" name="sustancia" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="presentacion" class="col-form-label focus text-white">PRESENTACIÓN:</label>
                            <input type="text" class="form-control" id="presentacion" name="presentacion" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="reg" class="col-form-label focus text-white">REGISTRO SANITARIO:</label>
                            <input type="text" class="form-control" id="reg" name="reg" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="stock" class="col-form-label focus text-white">STOCK:</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Descripción" name="descripcion" id="descripcion"
                                style="height: 100px" required></textarea>
                            <label for="descripcion">DESCRIPCÍON</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="col-form-label focus text-white" for="img">IMAGEN</label>
                            <input type="file" class="form-control" id="img" name="img" accept="image/*" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="codigo" class="col-form-label focus text-white">CODIGO BARRAS:</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Dropdown con checkboxes -->
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Categorías
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php
                                $query_cat = "SELECT * FROM category";
                                $resultado_cat = $con->prepare($query_cat);
                                $resultado_cat->execute();
                                if ($resultado_cat->rowCount() >= 1) {
                                    while ($row_cat = $resultado_cat->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <li>
                                            <label class="dropdown-item">
                                                <input type="checkbox" name="categorias[]"
                                                    value="<?php echo $row_cat['ID']; ?>"><?php echo $row_cat['NOMBRE']; ?>
                                            </label>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    echo 'Aún no tienes categorias creadas';
                                }
                                ?>
                            </ul>
                        </div>
                        <!-- END Dropdown con checkboxes -->
                    </div>

                    <div class="col-12"></div>

                    <div class="col-md-6 offset-md-3">
                        <div class="d-grid">
                            <input type="submit" id="btn" value="AGREGAR" class="btn btn-success">
                        </div>
                    </div>

                </div>
            </form>
            <!-- End form add one product -->

        </div>

        <?php
        require('../../src/component/jquery-bootstrap.php');
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // add-user
            $('#frm-add-prod').submit(function (e) {
                e.preventDefault();
                var btn = $('#btn');
                var formData = new FormData(this); // Crea un nuevo objeto FormData con los datos del formulario
                for (var pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                btn.val('Subiendo producto...');
                btn.prop('disabled', true);
                $.ajax({
                    url: "add-one-product.php",
                    type: "POST",
                    data: formData,
                    processData: false, // Importante para que jQuery no intente procesar el FormData
                    contentType: false,  // Importante para que jQuery no configure un tipo de contenido automático
                    dataType: "json",
                    success: function (response) {
                        if (response.status) {
                            btn.val('AGREGAR');
                            btn.prop('disabled', false);
                            Swal.fire({
                                icon: response.icon,
                                title: response.msj,
                            }).then(() => {
                                window.location.href = "../products.php";
                            });

                        } else {
                            btn.val('AGREGAR');
                            btn.prop('disabled', false);
                            Swal.fire({
                                icon: response.icon,
                                title: response.msj,
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        // Función que se ejecuta si ocurre un error
                        btn.val('AGREGAR');
                        btn.prop('disabled', false);
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
            // FIN add user
        </script>

    </body>

    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
?>