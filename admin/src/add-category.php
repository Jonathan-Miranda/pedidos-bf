<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../../connection/conexion.php');

    $nombre = (isset($_POST['name'])) ? $_POST['name'] : '';

    function insertarCategory($nombre, $con)
    {

        $consulta = "INSERT INTO category (NOMBRE) VALUES (:nombre)";
        $resultado = $con->prepare($consulta);

        // Asignamos los valores de los parámetros
        $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);

        // Ejecutamos la consulta
        if ($resultado->execute()) {

            $icon = "success";
            $msj = "Se añadio correctamente";
            $status = true;
        } else {
            // Acción si la actualización falló
            $icon = "error";
            $msj = "Error al guardar";
            $status = false;
        }
        return [
            'icon' => $icon,
            'msj' => $msj,
            'status' => $status
        ];
    }

    $response = insertarCategory($nombre, $con);
    print json_encode($response);
    $con=null;

} else {
    header("Location: ../index.php");
    exit();
}
?>