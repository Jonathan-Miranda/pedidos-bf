<?php
session_start();
if (isset($_SESSION['s_usuario'])) {
    require('../connection/conexion.php'); // Asegúrate de que esta conexión sea con PDO

    $user_id = $_SESSION['id']; // Obtén el ID del usuario de la sesión
    $product_id = $_POST['product_id'];

    // funcion Verifica si el producto ya está en la lista de deseos
    function view($user_id, $product_id, $con)
    {
        $consulta = "SELECT ID FROM wish_list WHERE ID_USER = :user_id AND ID_PRODUCT = :product_id";
        $pdo = $con->prepare($consulta);

        $pdo->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $pdo->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        $pdo->execute();

        if ($pdo->rowCount() > 0) {

            $msj = "el producto ya esta en lista deseo";
            $status = true;
        } else {

            $msj = "El producto no esta en lista deseo";
            $status = false;
        }

        return [
            'msj' => $msj,
            'status' => $status
        ];
    }
    // END funcion Verifica si el producto ya está en la lista de deseos

    // funcion elimiar si existe
    function del_prod($user_id, $product_id, $con)
    {
        $consulta = "DELETE FROM wish_list WHERE ID_USER = :user_id AND ID_PRODUCT = :product_id";
        $pdo = $con->prepare($consulta);

        $pdo->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $pdo->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if ($pdo->execute()) {
            $icon = "warning";
            $msj = "Se retiro el producto 💔";
            $status = true;
        } else {
            $icon = "error";
            $msj = "No se pudo retirar el producto";
            $status = false;
        }

        return [
            'icon' => $icon,
            'msj' => $msj,
            'status' => $status
        ];
    }
    // END funcion elimiar si existe

    // funcion elimiar si existe
    function add($user_id, $product_id, $con)
    {
        $consulta = "INSERT INTO wish_list (ID_USER, ID_PRODUCT) VALUES (:user_id, :product_id)";
        $pdo = $con->prepare($consulta);

        $pdo->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $pdo->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if ($pdo->execute()) {
            $icon = "success";
            $msj = "Producto añadido a favoritos 🎉";
            $status = true;
        } else {
            $icon = "warning";
            $msj = "Se retiro el producto 💔";
            $status = false;
        }

        return [
            'icon' => $icon,
            'msj' => $msj,
            'status' => $status
        ];
    }
    // END funcion elimiar si existe


    // -------------- Main function --------------
    if ($user_id || $product_id) {

        $res_view = view($user_id, $product_id, $con);
        if ($res_view['status']) {
            $response = del_prod($user_id, $product_id, $con);
        } else {
            $response = add($user_id, $product_id, $con);
        }
    } else {

        $response = [
            'icon' => 'error',
            'msj' => 'No se pudo añadir el producto.'.$user_id,
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
