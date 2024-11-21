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
        <title>Usuarios | Brudifarma</title>
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
                    <h2 class="text-white text-center">Usuarios</h2>
                </div>

                <!-- Button trigger modal -->
                <div class="col-md-4 offset-md-4">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#add"><i
                                class="bi bi-plus-circle"></i> Crear nuevo</button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addlabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title fs-3 focus text-center" id="addlabel">Nuevo usuario</p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="add-client" method="POST" enctype="multipart/form-data" accept-charset="utf-8">

                                    <div class="mb-3">
                                        <label for="name" class="form-label focus">Nombre</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Nombre"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label focus">Apellido</label>
                                        <input type="text" id="apellido" name="apellido" class="form-control"
                                            placeholder="Apellido" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label focus">Correo</label>
                                        <input type="email" id="correo" name="correo" class="form-control"
                                            placeholder="ejemplo@ejemplo.com" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label focus">Telefono</label>
                                        <input type="number" id="telefono" name="telefono" class="form-control"
                                            placeholder="5563975841" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label focus">Numero cliente (SAP)</label>
                                        <input type="number" id="numero-cliente" name="numero-cliente" class="form-control"
                                            placeholder="Es el mismo numero que tiene el usuario en SAP" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tipo-usuario" class="form-label focus">Tipo de usuario</label>
                                        <select class="form-select" id="tipo-usuario" name="tipo-usuario" aria-label="Default select example">
                                            <?php
                                            $query_type = "SELECT ID,NOMBRE FROM tipo_user";

                                            $resultado_type = $con->prepare($query_type);
                                            $resultado_type->execute();
                                            if ($resultado_type->rowCount() >= 1) {
                                                while ($row_type = $resultado_type->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>

                                                    <option value="<?php echo $row_type['ID']; ?>">
                                                        <?php echo $row_type['NOMBRE']; ?></option>

                                                    <?php
                                                }
                                            } else {
                                                echo '<option>Antes de crear usuarios debes crear los tipos de usuarios</option>';
                                            }
                                            ?>
                                        </select>
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
                                <th scope="col">APELLIDO</th>
                                <th scope="col">CORREO</th>
                                <th scope="col">TELEFONO</th>
                                <th scope="col"># CLIENTE (SAP)</th>
                                <th scope="col">TIPO USUARIO</th>
                                <th scope="col">MODIFICAR</th>
                                <th scope="col">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Preview -->
                            <?php
                            //al no usar elementos dinamicos (where, order by) esta consulta es segura y no es vulnerable a inyecciones sql
                            $query = "SELECT u.ID, u.NOMBRE, u.APELLIDO, u.CORREO, u.TELEFONO, u.NUMERO_CLIENTE, t.NOMBRE AS TIPO_CLIENTE FROM user u JOIN tipo_user t ON u.ID_TIPO_USER = t.ID";

                            $resultado = $con->prepare($query);
                            $resultado->execute();
                            if ($resultado->rowCount() >= 1) {
                                while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr class="text-center">
                                        <td><?php echo $row['NOMBRE']; ?></td>
                                        <td><?php echo $row['APELLIDO']; ?></td>
                                        <td><?php echo $row['CORREO']; ?></td>
                                        <td><?php echo $row['TELEFONO']; ?></td>
                                        <td><?php echo $row['NUMERO_CLIENTE']; ?></td>
                                        <td><?php echo $row['TIPO_CLIENTE']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#edit-user" data-bs-nombre="<?php echo $row['NOMBRE']; ?>"
                                                data-bs-apellido="<?php echo $row['APELLIDO']; ?>"
                                                data-bs-correo="<?php echo $row['CORREO']; ?>"
                                                data-bs-telefono="<?php echo $row['TELEFONO']; ?>"
                                                data-bs-numero-cliente="<?php echo $row['NUMERO_CLIENTE']; ?>"
                                                data-bs-tipo-cliente="<?php echo $row['TIPO_CLIENTE']; ?>"
                                                data-bs-id="<?php echo $row['ID']; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <form class="delete-user" method="POST" enctype="multipart/form-data"
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
                                echo '<td colspan="8"><div class="alert alert-danger" role="alert">Aún no tienes ningun usuario creado</div></td>';
                            }
                            ?>
                            <!-- End preview -->

                            <!-- Modal-edit -->
                            <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="edit-user"
                                tabindex="-1" aria-labelledby="edit-userLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <p class="modal-title fs-3 focus" id="edit-userLabel">Editar</p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="edit-client" method="POST" enctype="multipart/form-data"
                                                accept-charset="utf-8">
                                                <div class="mb-3">
                                                    <label for="edit-name" class="col-form-label focus">Nombre:</label>
                                                    <input type="text" class="form-control" id="edit-name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit-descripcion"
                                                        class="col-form-label focus">Descripción:</label>
                                                    <input type="text" class="form-control" id="edit-descripcion">
                                                </div>
                                                <input type="hidden" id="edit-id">
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
        require('js/add-user-client.php');
        ?>


    </body>

    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
?>