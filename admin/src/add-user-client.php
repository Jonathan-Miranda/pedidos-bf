<?php
session_start();
if (isset($_SESSION['admin-us'])) {
    require('../../connection/conexion.php');

    $nombre = (isset($_POST['name'])) ? $_POST['name'] : '';
    $apellido = (isset($_POST['apellido'])) ? $_POST['apellido'] : '';
    $correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
    $telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
    $numero_cliente = (isset($_POST['numero-cliente'])) ? $_POST['numero-cliente'] : '';
    $tipo_usuario = (isset($_POST['tipo-usuario'])) ? $_POST['tipo-usuario'] : '';
    

    function insertarUser($nombre, $apellido, $correo, $telefono, $numero_cliente, $tipo_usuario, $con)
    {

        $consulta = "INSERT INTO user (NOMBRE, APELLIDO, CORREO, TELEFONO, NUMERO_CLIENTE, ID_TIPO_USER) VALUES (:nombre, :apellido, :correo, :telefono, :numeroc, :itu)";
        $resultado = $con->prepare($consulta);

        // Asignamos los valores de los parámetros
        $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $resultado->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $resultado->bindParam(':correo', $correo, PDO::PARAM_STR);
        $resultado->bindParam(':telefono', $telefono, PDO::PARAM_INT);
        $resultado->bindParam(':numeroc', $numero_cliente, PDO::PARAM_INT);
        $resultado->bindParam(':itu', $tipo_usuario, PDO::PARAM_INT);

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

    $response = insertarUser($nombre, $apellido, $correo, $telefono, $numero_cliente, $tipo_usuario, $con);
    print json_encode($response);
    $con=null;

} else {
    header("Location: ../index.php");
    exit();
}
?>