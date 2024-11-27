<?php
session_start();
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
if (isset($_SESSION['admin-us'])) {
    
    
    // Conexión a la base de datos
    require('../../connection/conexion.php');

    Configuration::instance([
        'cloud' => [
            'cloud_name' => $_ENV['CLOUDINARY_CLOUD'],
            'api_key' => $_ENV['CLOUDINARY_API_KEY'],
            'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
        ],
        'url' => [
            'secure' => true // Usa HTTPS
        ]
    ]);

    // Obtener los valores del formulario
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $sustancia = $_POST['sustancia'];
    $presentacion = $_POST['presentacion'];
    $reg = $_POST['reg'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];
    $codigo = $_POST['codigo'];

    // Verificar si se enviaron categorías seleccionadas
    if (isset($_POST['categorias']) && is_array($_POST['categorias'])) {
        $categorias = $_POST['categorias'];
    } else {
        $categorias = []; // Array vacío si no se seleccionaron categorías
    }

// Funcion subir img cloudinary
function subirImg($fileName, $tempFilePath){
    try {
        // Definir el public_id de la marca de agua
        $publicIdWatermark = 'logotipo-brudifarma'; // Asegúrate de tener esta imagen en Cloudinary

        // Sube la imagen a Cloudinary con la marca de agua
        $uploader = new UploadApi();
        $result = $uploader->upload($tempFilePath, [
            'folder' => 'productos', // Carpeta en Cloudinary
            'public_id' => pathinfo($fileName, PATHINFO_FILENAME), // Nombre base del archivo
            'format' => 'webp', // Convertir la imagen a .webp
            'transformation' => [
                [
                    'overlay' => $publicIdWatermark,  // Aplicar la marca de agua
                    'gravity' => 'south_east',         // Posicionar la marca de agua en la esquina inferior derecha
                    'opacity' => 60,                   // Opacidad de la marca de agua
                    'width' => 0.2,                    // Escala de la marca de agua (20% del tamaño original)
                    'crop' => 'scale'                  // Escalar la marca de agua
                ]
            ]
        ]);
        $url= $result['secure_url'];
        $publicId= $result['public_id'];
        $status = true;
        
    } catch (Exception $e) {
        // echo "Error al subir la imagen: " . $e->getMessage();
        $url= null;
        $publicId= null;
        $status = false;
    }

    return [
        'url' => $url,
        'publicId' => $publicId,
        'status' => $status
    ];
}
// end funcion subir img cloudinary

    // Función para insertar un producto
    function insertarProducto($con, $sku, $name, $sustancia, $presentacion, $reg, $stock, $descripcion, $url, $publicId, $codigo)
    {
        // Consulta SQL con placeholders
        $sql = "INSERT INTO product (SKU,NOMBRE,SUSTANCIA,PRESENTACION,REGISTRO_SANITARIO,STOCK,DESCRIPCION,IMAGEN_URL,PUBLIC_ID,CODIGO_BARRAS) 
            VALUES (:sku, :name, :sustancia, :presentacion, :reg, :stock, :descripcion, :img, :publicid, :codigo)";

        // Preparar la consulta
        $stmt = $con->prepare($sql);

        // Bind de parámetros
        $stmt->bindParam(':sku', $sku, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':sustancia', $sustancia, PDO::PARAM_STR);
        $stmt->bindParam(':presentacion', $presentacion, PDO::PARAM_STR);
        $stmt->bindParam(':reg', $reg, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':img', $url, PDO::PARAM_STR);
        $stmt->bindParam(':publicid', $publicId, PDO::PARAM_STR);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            $icon = "success";
            $msj = "Se añadio correctamente";
            $id = $con->lastInsertId();
            $status = true;
        } else {
            $icon = "error";
            $msj = "Error al guardar";
            $id = null;
            $status = false;
        }
        return [
            'icon' => $icon,
            'msj' => $msj,
            'id' => $id,
            'status' => $status
        ];
    }

    // Función para insertar en la tabla PRODUCTO_CATEGORIA
    function insertarCategorias($con, $productoId, $categorias)
    {
        $sql = "INSERT INTO product_category (ID_PRODUCT, ID_CATEGORY) VALUES (:productoId, :categoriaId)";
        $stmt = $con->prepare($sql);

        $exitos = 0; // Contador de inserciones exitosas

        foreach ($categorias as $categoriaId) {
            $stmt->bindParam(':productoId', $productoId, PDO::PARAM_INT);
            $stmt->bindParam(':categoriaId', $categoriaId, PDO::PARAM_INT);

            // Verificar si la ejecución fue exitosa
            if ($stmt->execute()) {
                $exitos++;
            } else {
                // Si una inserción falla, terminamos y retornamos error
                return [
                    'status' => false,
                    'msj' => "Error al insertar categoría con ID $categoriaId"
                ];
            }
        }

        // Si todas las categorías se insertaron correctamente
        return [
            'status' => true,
            'msj' => "categorías insertadas correctamente"
        ];
    }

    // ------------- main funct ----------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['img'])) {
    // Verificar que se subió un archivo
    if ($_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $_FILES['img']['tmp_name'];
        $fileName = $_FILES['img']['name'];

        $res_subirImg = subirImg($fileName, $tempFilePath);

        if ($res_subirImg['status']) {
            // main func
            $res_inser_prod = insertarProducto($con, $sku, $name, $sustancia, $presentacion, $reg, $stock, $descripcion, $res_subirImg['url'], $res_subirImg['publicId'], $codigo);

            if ($res_inser_prod['status']) {
                $productoId = $res_inser_prod['id'];

                // Si hay categorías seleccionadas, inserta en la tabla de categorías
                if (!empty($categorias)) {
                    $res_inser_cat = insertarCategorias($con, $productoId, $categorias);

                    if ($res_inser_cat['status']) {
                        $response = [
                            'icon' => 'success',
                            'msj' => 'Producto y categorías añadidos correctamente.',
                            'status' => true,
                        ];
                    } else {
                        $response = [
                            'icon' => 'error',
                            'msj' => $res_inser_cat['msj'],
                            'status' => false,
                        ];
                    }
                } else {
                    // Caso en que no hay categorías seleccionadas
                    $response = [
                        'icon' => 'success',
                        'msj' => 'Producto añadido correctamente, sin categorías seleccionadas.',
                        'status' => true,
                    ];
                }
            } else {
                // Error al insertar el producto
                $response = [
                    'icon' => 'error',
                    'msj' => $res_inser_prod['msj'],
                    'status' => false,
                ];
            }

        } else {
            $response = [
                'icon' => 'error',
                'msj' => $res_inser_prod['msj'],
                'status' => false,
            ];
        }

        // end main func

    } else {
        $response = [
            'icon' => 'error',
            'msj' => 'error al subir imagen',
            'status' => false,
        ];
    }
} else {
    $response = [
        'icon' => 'error',
        'msj' => 'No se recibió ninguna imagen.',
        'status' => false,
    ];
}

    // ---------------------------------- END main funct -------------------------

    print json_encode($response);
    $con = null;

} else {
    header("Location: index.php");
    exit();
}
