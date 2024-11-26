<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../../connection/conexion.php');

    $nombre = (isset($_POST['edit-name'])) ? $_POST['edit-name'] : '';
    $id = (isset($_POST['edit-id'])) ? $_POST['edit-id'] : '';

    function actualizarCategory($nombre, $id, $con)
    {

        $consulta = "UPDATE category SET NOMBRE=:nombre WHERE ID=:id";
        $resultado = $con->prepare($consulta);

        // Asignamos los valores de los parámetros
        $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);
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

    $response = actualizarCategory($nombre, $id, $con);
    print json_encode($response);
    $con=null;

} else {
    header("Location: ../index.php");
    exit();
}
?>