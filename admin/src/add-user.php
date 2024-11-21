<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../../connection/conexion.php');

    $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';

    function insertarTipoUser($nombre, $descripcion, $con)
    {

        $consulta = "INSERT INTO tipo_user (NOMBRE, DESCRIPCION) VALUES (:nombre, :descripcion)";
        $resultado = $con->prepare($consulta);

        // Asignamos los valores de los parámetros
        $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $resultado->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);

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

    $response = insertarTipoUser($nombre, $descripcion, $con);
    print json_encode($response);
    $con=null;

} else {
    header("Location: ../index.php");
    exit();
}
?>