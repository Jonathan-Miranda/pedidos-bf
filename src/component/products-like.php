<div class="container">
  <div class="row">
    <div class="col-lg-10 offset-lg-1">
      <div class="row card-group">

        <?php
        $query_prod = "SELECT 
        p.ID, 
        p.SKU, 
        p.NOMBRE, 
        p.IMAGEN_URL, 
        p.DESCRIPCION
    FROM 
        wish_list w
    JOIN 
        product p 
    ON 
        w.ID_PRODUCT = p.ID
    WHERE 
        w.ID_USER = :idUser 
        AND (p.NOMBRE LIKE :busqueda OR p.SKU LIKE :busqueda)
    ORDER BY 
        w.ID DESC
    LIMIT 
        :limit OFFSET :offset";
        $resultado_fav = $con->prepare($query_prod);

        // Establecer parámetros de búsqueda y paginación
        $resultado_fav->bindValue(':idUser', $_SESSION['id'], PDO::PARAM_INT);
        $resultado_fav->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
        $resultado_fav->bindValue(':limit', $productos_por_pagina, PDO::PARAM_INT);
        $resultado_fav->bindValue(':offset', $offset, PDO::PARAM_INT);

        $resultado_fav->execute();

        // Contar total de productos para generar las páginas
        $query_total = "SELECT 
        COUNT(*) AS total 
    FROM 
        wish_list w
    JOIN 
        product p 
    ON 
        w.ID_PRODUCT = p.ID
    WHERE 
        w.ID_USER = :idUser 
        AND (p.NOMBRE LIKE :busqueda OR p.SKU LIKE :busqueda)";
        $stmt_total = $con->prepare($query_total);
        $stmt_total->bindValue(':idUser', $_SESSION['id'], PDO::PARAM_INT);
        $stmt_total->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
        $stmt_total->execute();
        $total_productos = $stmt_total->fetchColumn();
        $total_paginas = ceil($total_productos / $productos_por_pagina);

        if ($resultado_fav->rowCount() >= 1) {
          while ($row_prod = $resultado_fav->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <div class="col-lg-3 col-md-4 col-6 mb-3 position-relative">
              <div class="card">
                <img src="images/<?php echo $row_prod['IMAGEN_URL']; ?>" class="card-img-top" alt="..." loading="lazy" />
                <div class="card-body">
                  <p class="fs-5 focus"><?php echo $row_prod['NOMBRE']; ?></p>
                  <p><?php echo $row_prod['DESCRIPCION']; ?></p>
                  <span class="fw-light">SKU: <?php echo $row_prod['SKU']; ?></span>
                </div>


                <div class="z-3 position-absolute top-0 start-0 m-4">

                  <a class="btn rounded-circle btn-danger text-center toggle-wishlist" href="#"
                    data-product-id="<?php echo $row_prod['ID']; ?>">
                    <i class="bi bi-heart-fill"></i>
                  </a>

                </div>
              </div>

            </div>

            <?php
          }
        } else {
          echo 'Aún no tienes productos';
        }
        ?>

        <!-- Paginación -->
        <div class="col-md-12">
          <div class="col-md-12">
            <?php
            // Parámetros para la paginación
            echo generarPaginacion($pagina_actual, $total_paginas);
            ?>
          </div>

        </div>


        <?php

        function generarPaginacion($pagina_actual, $total_paginas)
        {
          $html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';

          // Botón "Anterior"
          if ($pagina_actual > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="?pagina=' . ($pagina_actual - 1) . '">Anterior</a></li>';
          } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Anterior</span></li>';
          }

          // Siempre mostrar las primeras 2 páginas
          for ($i = 1; $i <= 2; $i++) {
            if ($i > $total_paginas)
              break; // Si no hay suficientes páginas, detener
            $active = ($i == $pagina_actual) ? ' active' : '';
            $html .= '<li class="page-item' . $active . '"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
          }

          // Mostrar "..." si el rango siguiente no es adyacente
          if ($pagina_actual > 4) {
            $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
          }

          // Mostrar rango dinámico alrededor de la página actual
          $inicio = max(3, $pagina_actual - 2); // Inicio del rango
          $fin = min($total_paginas - 2, $pagina_actual + 2); // Fin del rango
        
          for ($i = $inicio; $i <= $fin; $i++) {
            if ($i > $total_paginas)
              break;
            $active = ($i == $pagina_actual) ? ' active' : '';
            $html .= '<li class="page-item' . $active . '"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
          }

          // Mostrar "..." si el rango anterior no es adyacente
          if ($pagina_actual < $total_paginas - 3) {
            $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
          }

          // Siempre mostrar las últimas 2 páginas
          for ($i = $total_paginas - 1; $i <= $total_paginas; $i++) {
            if ($i < 3)
              continue; // Si estamos en las primeras páginas, no repetir
            $active = ($i == $pagina_actual) ? ' active' : '';
            $html .= '<li class="page-item' . $active . '"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
          }

          // Botón "Siguiente"
          if ($pagina_actual < $total_paginas) {
            $html .= '<li class="page-item"><a class="page-link" href="?pagina=' . ($pagina_actual + 1) . '">Siguiente</a></li>';
          } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Siguiente</span></li>';
          }

          $html .= '</ul></nav>';
          return $html;
        }
        ?>


      </div>
    </div>
  </div>
</div>