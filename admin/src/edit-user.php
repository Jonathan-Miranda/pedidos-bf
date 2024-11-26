<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../../connection/conexion.php');

    $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
    $id = (isset($_POST['id'])) ? $_POST['id'] : '';

    function actualizarTipoUser($nombre, $descripcion, $id, $con)
    {

        $consulta = "UPDATE tipo_user SET NOMBRE=:nombre, DESCRIPCION=:descripcion WHERE ID=:id";
        $resultado = $con->prepare($consulta);

        // Asignamos los valores de los parámetros
        $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $resultado->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutamos la consulta
        if ($resultado->execute()) {

            $icon = "success";
            $msj = "Se actualizo correctamente";
            $status = true;
        } else {
            // Acción si la actualización falló
            $icon = "error";
            $msj = "Error al actualizar";
            $status = false;
        }
        return [
            'icon' => $icon,
            'msj' => $msj,
            'status' => $status
        ];
    }

    $response = actualizarTipoUser($nombre, $descripcion, $id,   $con);
    print json_encode($response);
    $con=null;

} else {
    header("Location: ../index.php");
    exit();
}
?>