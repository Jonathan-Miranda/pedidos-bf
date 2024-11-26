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
        <title>Categorias | Brudifarma</title>
        <?php
        require('../src/component/bootstrap.php');
        ?>
    </head>

    <body class="bg-dark">
        <?php
        require('src/navbar.php');
        ?>

        <!-- Registros -->
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-white text-center">Categorias</h2>
                </div>

                <!-- Button trigger modal -->
                <div class="col-md-4 offset-md-4">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#add"><i
                                class="bi bi-plus-circle"></i> Crear nueva</button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addlabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title fs-3 focus text-center" id="addlabel">Nueva categoria</p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="add-category" method="POST" enctype="multipart/form-data" accept-charset="utf-8">

                                    <div class="mb-3">
                                        <label for="name" class="form-label focus">Nombre</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Nombre-de-la-categoria"
                                            required>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success">Crear</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->

                <div class="col-md-12 table-responsive ">

                    <table class="table table-dark table-striped align-middle">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">NOMBRE</th>
                                <th scope="col">PRODUCTOS</th>
                                <th scope="col">EDITAR</th>
                                <th scope="col">BORRAR</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Preview -->
                            <?php
                            //al no usar elementos dinamicos (where, order by) esta consulta es segura y no es vulnerable a inyecciones sql
                            $query = "SELECT * FROM category";

                            $resultado = $con->prepare($query);
                            $resultado->execute();
                            if ($resultado->rowCount() >= 1) {
                                while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr class="text-center">
                                        <td><?php echo $row['NOMBRE']; ?></td>
                                        <td>xx</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#edit-category" 
                                                data-bs-nombre="<?php echo $row['NOMBRE']; ?>"
                                                data-bs-id="<?php echo $row['ID']; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <form class="delete-category" method="POST" enctype="multipart/form-data"
                                                accept-charset="utf-8">
                                                <input type="hidden" class="delete-id" value="<?php echo $row['ID']; ?>">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>

                                            </form>

                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<td colspan="4"><div class="alert alert-danger" role="alert">Aún no tienes ninguna categoria</div></td>';
                            }
                            ?>
                            <!-- End preview -->

                            <!-- Modal-edit -->
                            <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="edit-category"
                                tabindex="-1" aria-labelledby="edit-categoryLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <p class="modal-title fs-3 focus" id="edit-categoryLabel">Editar</p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="frm-edit-category" method="POST" enctype="multipart/form-data"
                                                accept-charset="utf-8">
                                                <div class="mb-3">
                                                    <label for="edit-name" class="col-form-label focus">Nombre:</label>
                                                    <input type="text" class="form-control" id="edit-name" name="edit-name">
                                                </div>
                                                
                                                <input type="hidden" id="edit-id" name="edit-id">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-success">Modificar</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END Modal-edit -->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin registros -->

        <?php
        require('../src/component/jquery-bootstrap.php');
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php
        require('js/category.php');
        ?>


    </body>

    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
?>