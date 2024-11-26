<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../../connection/conexion.php');

    $id = (isset($_POST['id'])) ? $_POST['id'] : '';

    function deleteCategory($id, $con)
    {

        $consulta = "DELETE FROM category WHERE ID=:id";
        $resultado = $con->prepare($consulta);

        // Asignamos los valores de los parámetros
        $resultado->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutamos la consulta
        if ($resultado->execute()) {

            $icon = "success";
            $msj = "Se elimino correctamente";
            $status = true;
        } else {
            // Acción si la actualización falló
            $icon = "error";
            $msj = "Error al eliminar";
            $status = false;
        }
        return [
            'icon' => $icon,
            'msj' => $msj,
            'status' => $status
        ];
    }

    $response = deleteCategory($id, $con);
    print json_encode($response);
    $con=null;

} else {
    header("Location: ../index.php");
    exit();
}
?>