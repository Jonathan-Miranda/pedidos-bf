<?php
session_start();
if (isset($_SESSION['s_usuario'])) {
    require('../connection/conexion.php');

    $user_id = $_SESSION['id']; // Obtén el ID del usuario de la sesión
    $product_id = $_POST['product_id'];
    $cantidad = $_POST['cantidad'];

    // funcion Verificar user tiene car activo
    function exist_car($user_id, $con)
    {
        $consulta = "SELECT ID FROM cesta WHERE ID_USER = :user_id AND ESTADO = :state";
        $pdo = $con->prepare($consulta);
        $state = 0;

        $pdo->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $pdo->bindParam(':state', $state, PDO::PARAM_INT);

        $pdo->execute();

        if ($pdo->rowCount() > 0) {
            $row = $pdo->fetch(PDO::FETCH_ASSOC);
            $status = $row['ID'];
        } else {
            $status = false;
        }

        return $status;
    }
    // END funcion Verificar user tiene car activo

    // funcion actualizar si existe
    function add_to_car($res_car_active, $product_id, $cantidad, $con)
    {
        $consulta = "SELECT CANTIDAD FROM car WHERE ID_CESTA = :id_cesta AND ID_PRODUCT = :product_id";
        $pdo = $con->prepare($consulta);

        $pdo->bindParam(':id_cesta', $res_car_active, PDO::PARAM_INT);
        $pdo->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $pdo->execute();

        if ($pdo->rowCount() > 0) {
            $row = $pdo->fetch(PDO::FETCH_ASSOC);
            $cantidad_actual = $row['CANTIDAD'];
            $nueva_cantidad = $cantidad_actual + $cantidad;

            // Actualizar la cantidad en la base de datos
            $consulta_update = "UPDATE car SET CANTIDAD = :nueva_cantidad WHERE ID_CESTA = :id_cesta AND ID_PRODUCT = :product_id";
            $pdo = $con->prepare($consulta_update);
            $pdo->bindParam(':nueva_cantidad', $nueva_cantidad, PDO::PARAM_INT);
            $pdo->bindParam(':id_cesta', $res_car_active, PDO::PARAM_INT);
            $pdo->bindParam(':product_id', $product_id, PDO::PARAM_INT);

            if ($pdo->execute()) {
                $icon = "success";
                $msj = "Se actualizo el producto ⏫";
                $status = true;
            } else {

                $icon = "error";
                $msj = "No se pudo actualizar el producto 🚨";
                $status = false;
            }

        } else {
            //se agrega el prod if not exist
            $consulta = "INSERT INTO car (ID_CESTA, ID_PRODUCT, CANTIDAD) VALUES (:id_cesta, :product_id, :cantidad)";
            $pdo = $con->prepare($consulta);

            $pdo->bindParam(':id_cesta', $res_car_active, PDO::PARAM_INT);
            $pdo->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $pdo->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);

            if ($pdo->execute()) {
                $icon = "success";
                $msj = "Se agrego el producto 🛒";
                $status = true;
            } else {
                $icon = "error";
                $msj = "No se pudo agregar el producto";
                $status = false;
            }
        }

        return [
            'icon' => $icon,
            'msj' => $msj,
            'status' => $status
        ];
    }
    // END funcion actualizar si existe

    // funcion crear cesta
    function create_car($user_id, $con)
    {
        $consulta = "INSERT INTO cesta (ID_USER, ESTADO) VALUES (:user_id, :state)";
        $pdo = $con->prepare($consulta);

        $pdo->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $state = 0;
        $pdo->bindParam(':state', $state, PDO::PARAM_INT);

        if ($pdo->execute()) {
            $id_car = $con->lastInsertId();
            $status = $id_car;
        } else {
            $status = false;
        }

        return $status;
    }
    // END funcion crear cesta

    //Funcion modificar stock

    function stock($product_id, $cantidad, $con)
    {

        $consulta = "SELECT STOCK FROM product WHERE ID = :product_id";
        $pdo = $con->prepare($consulta);
        $pdo->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $pdo->execute();

        if ($pdo->rowCount() > 0) {
            $row = $pdo->fetch(PDO::FETCH_ASSOC);
            $cantidad_actual = $row['STOCK'];

            if ($cantidad > $cantidad_actual) {
                $status = false;
            } else {

                $nueva_cantidad = $cantidad_actual - $cantidad;

                // Actualizar la cantidad en la base de datos
                $consulta_update = "UPDATE product SET STOCK = :nueva_cantidad WHERE ID = :product_id";
                $pdo = $con->prepare($consulta_update);
                $pdo->bindParam(':nueva_cantidad', $nueva_cantidad, PDO::PARAM_INT);
                $pdo->bindParam(':product_id', $product_id, PDO::PARAM_INT);

                if ($pdo->execute()) {
                    $status = true;
                } else {
                    $status = false;
                }
            }


        } else {
            $status = false;
        }

        return $status;
    }

    //END funcion modificar stock


    // -------------- Main function --------------
    if ($user_id || $product_id) {

        $res_car_active = exist_car($user_id, $con);

        if ($res_car_active) {
            $res_stock = stock($product_id, $cantidad, $con);
            if ($res_stock) {
                $response = add_to_car($res_car_active, $product_id, $cantidad, $con);
            } else {
                $response = [
                    'icon' => 'error',
                    'msj' => 'Problemas con el stock',
                    'status' => false,
                ];
            }
        } else {
            $res_car_active = create_car($user_id, $con);  // Aquí actualizas $res_car_active con el nuevo ID de la cesta

            if ($res_car_active) {

                $res_stock = stock($product_id, $cantidad, $con);
                if ($res_stock) {
                    $response = add_to_car($res_car_active, $product_id, $cantidad, $con);
                } else {
                    $response = [
                        'icon' => 'error',
                        'msj' => 'Problemas con el stock',
                        'status' => false,
                    ];
                }

            } else {
                // Si no se pudo crear la cesta, retorna un error
                $response = [
                    'icon' => 'error',
                    'msj' => 'No se pudo crear la cesta.',
                    'status' => false,
                ];
            }
        }
    } else {

        $response = [
            'icon' => 'error',
            'msj' => 'No se pudo añadir el producto.',
            'status' => false,
        ];
    }
    // -------------- END Main function --------------

    print json_encode($response);
    $con = null;
} else {
    header("Location: index.php");
    exit();
}
