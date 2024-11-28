<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../connection/conexion.php');

    // Inicializar la variable de búsqueda de manera predeterminada
    $busqueda = '';

    // Verificar si el parámetro de búsqueda está presente en la URL
    if (isset($_GET['buscar'])) {
        $busqueda = $_GET['buscar'];
    }

    // Número de productos por página
    $productos_por_pagina = 100;

    // Obtener el número de página actual
    $pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
    $offset = ($pagina_actual - 1) * $productos_por_pagina;
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Productos | Brudifarma</title>
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
                    <h2 class="text-white text-center">Productos</h2>
                </div>

                <div class="col-md-6 my-3">
                    <!-- buscador -->
                    <div class="input-group">
                        <form method="get" class="d-flex">
                            <input type="search" class="form-control" placeholder="Buscar..." id="buscar" name="buscar"
                                value="<?php echo htmlspecialchars($busqueda); ?>">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                    <!-- fin buscador -->
                </div>

                <!-- Button trigger modal -->
                <div class="col-md-3 my-3">
                    <div class="d-grid gap-2">
                        <a href="src/add-products.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Agregar</a>
                    </div>
                </div>

                <div class="col-md-3 my-3">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>Más acciones
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="export-products.php"><i
                                        class="bi bi-file-earmark-arrow-down"></i> Exportar
                                    productos</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil-square"></i> Multiples
                                    productos</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-trash-fill"></i> Multiples productos</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Preview -->
                <?php
                //al no usar elementos dinamicos (where, order by) esta consulta es segura y no es vulnerable a inyecciones sql
                $query = "SELECT * FROM product WHERE NOMBRE LIKE :busqueda OR SKU LIKE :busqueda LIMIT :limit OFFSET :offset";

                $resultado = $con->prepare($query);

                // Establecer parámetros de búsqueda y paginación
                $resultado->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
                $resultado->bindValue(':limit', $productos_por_pagina, PDO::PARAM_INT);
                $resultado->bindValue(':offset', $offset, PDO::PARAM_INT);

                $resultado->execute();

                // Contar total de productos para generar las páginas
                $query_total = "SELECT COUNT(*) FROM product WHERE NOMBRE LIKE :busqueda OR SKU LIKE :busqueda";
                $stmt_total = $con->prepare($query_total);
                $stmt_total->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
                $stmt_total->execute();
                $total_productos = $stmt_total->fetchColumn();
                $total_paginas = ceil($total_productos / $productos_por_pagina);

                ?>
                <div class="col-md-12 table-responsive ">

                    <table class="table table-dark table-striped align-middle">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">SKU</th>
                                <th scope="col">NOMBRE</th>
                                <th scope="col">SUSTANCIA</th>
                                <th scope="col">STOCK</th>
                                <th scope="col">IMG</th>
                                <th scope="col">VER</th>
                                <th scope="col">EDITAR</th>
                                <th scope="col">BORRAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($resultado->rowCount() >= 1) {
                                while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr class="text-center">
                                        <td><?php echo $row['SKU']; ?></td>
                                        <td><?php echo $row['NOMBRE']; ?></td>
                                        <td><?php echo $row['SUSTANCIA']; ?></td>
                                        <td><?php echo $row['STOCK']; ?></td>
                                        <td>
                                            <a href="<?php echo $row['IMAGEN_URL']; ?>" target="_blank" class="btn btn-primary"><i
                                                    class="bi bi-image"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#edit-category" data-bs-nombre="<?php echo $row['NOMBRE']; ?>"
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
                                echo '<td colspan="8"><div class="alert alert-danger" role="alert">No hay productos</div></td>';
                            }
                            ?>
                            <!-- End preview -->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin registros -->

        <!-- Paginación -->
        <div class="col-md-12">
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                            <a class="page-link"
                                href="?pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($busqueda); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
        <!-- END Paginación -->

        <?php
        require('../src/component/jquery-bootstrap.php');
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php
        require('js/product.php');
        ?>


    </body>

    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
?>