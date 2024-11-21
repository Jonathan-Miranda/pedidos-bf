<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../connection/conexion.php');
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tipos-Clientes | Brudifarma</title>
        <?php
        require('../src/component/bootstrap.php');
        ?>
    </head>

    <body class="bg-dark">
        <?php
        require('src/navbar.php');
        ?>

        <!-- Registros -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-white text-center">Tipos de clientes registrados x </h2>
                </div>

                <div class="col-md-12 table-responsive ">

                    <table class="table table-dark table-striped align-middle">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">NOMBRE</th>
                                <th scope="col">IMAGEN</th>
                                <th scope="col">FECHA</th>
                                <th scope="col">PDF</th>
                                <th scope="col">MOSTRAR/OCULTAR</th>
                                <th scope="col">CATEGORIA</th>
                                <th scope="col">EDITAR</th>
                                <th scope="col">BORRAR</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Preview -->
                            <tr class="text-center">
                                <td>Nombre</td>
                                <td>imagen</td>
                                <td>fehca</td>
                                <td>pdf</td>
                                <td>btn</td>
                                <td>categoria</td>
                                <td>modificar</td>
                                <td>eliminar</td>
                            </tr>
                            <!-- End preview -->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin registros -->

        <?php
        require('../src/component/jquery-bootstrap.php');
        ?>

    </body>

    </html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>