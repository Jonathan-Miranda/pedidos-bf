<?php
session_start();
require('../connection/conexion.php');

//recepción de datos enviados mediante POST desde ajax
$email = (isset($_POST['correo'])) ? $_POST['correo'] : '';

$consulta = "SELECT ID,CORREO FROM user WHERE CORREO='$email' ";
$resultado = $con->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() >= 1) {
    $data = $resultado->fetch();
    $sql = "UPDATE user SET RESET_PW = 1 WHERE ID='$data[0]'";
    $result = $con->prepare($sql);
    $result->execute();
    $data2 = 2;
} else {
    $data2 = 0;
}

print $data2;
$con = null;

?>