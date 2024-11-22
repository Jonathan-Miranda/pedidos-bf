<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../../connection/conexion.php');

    $nombre = (isset($_POST['edit-name'])) ? $_POST['edit-name'] : '';
    $apellido = (isset($_POST['edit-apellido'])) ? $_POST['edit-apellido'] : '';
    $correo = (isset($_POST['edit-correo'])) ? $_POST['edit-correo'] : '';
    $telefono = (isset($_POST['edit-telefono'])) ? $_POST['edit-telefono'] : '';
    $numcliente = (isset($_POST['edit-numcliente'])) ? $_POST['edit-numcliente'] : '';
    $tipo_user = (isset($_POST['edit-tipo-user'])) ? $_POST['edit-tipo-user'] : '';
    $id = (isset($_POST['edit-id'])) ? $_POST['edit-id'] : '';

    function actualizarUser($nombre, $apellido, $correo, $telefono, $numcliente, $tipo_user, $id, $con)
    {

        $consulta = "UPDATE user SET NOMBRE=:nombre, APELLIDO=:apellido, CORREO=:correo, TELEFONO=:telefono, NUMERO_CLIENTE=:numcliente, ID_TIPO_USER=:tipouser WHERE ID=:id";
        $resultado = $con->prepare($consulta);

        // Asignamos los valores de los parámetros
        $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $resultado->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $resultado->bindParam(':correo', $correo, PDO::PARAM_STR);
        $resultado->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $resultado->bindParam(':numcliente', $numcliente, PDO::PARAM_INT);
        $resultado->bindParam(':tipouser', $tipo_user, PDO::PARAM_INT);
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

    $response = actualizarUser($nombre, $apellido, $correo, $telefono, $numcliente, $tipo_user, $id, $con);
    print json_encode($response);
    $con=null;

} else {
    header("Location: ../index.php");
    exit();
}
?>