<?php
session_start();

require('../../connection/conexion.php');
//recepción de datos enviados mediante POST desde ajax

$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$password = (isset($_POST['password'])) ? $_POST['password'] : '';

$consulta = "SELECT * FROM admin WHERE CORREO= :nombre";

$resultado = $con->prepare($consulta);

// Asignamos los valores de los parámetros
$resultado->bindParam(':nombre', $usuario, PDO::PARAM_STR);

$resultado->execute();

if ($resultado->rowCount() >= 1) {
    $data = $resultado->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $data['PW'])) {
        $_SESSION["admin-us"] = $data['NOMBRE'];  // Asignamos el nombre de usuario a la sesión
        $_SESSION["admin-id"] = $data['ID'];
    } else {

        $_SESSION["admin-us"] = null;  // Si no se encuentra el usuario, limpiamos la sesión
        $_SESSION["admin-id"] = null;  // Limpiamos el ID de sesión
        $data = null;
    }

} else {
    $_SESSION["admin-us"] = null;  // Si no se encuentra el usuario, limpiamos la sesión
    $_SESSION["admin-id"] = null;  // Limpiamos el ID de sesión
    $data = null;
}

print json_encode($data);
$con = null;

?>