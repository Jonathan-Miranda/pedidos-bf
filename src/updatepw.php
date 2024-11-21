<?php
require('../connection/conexion.php');

$id = $_POST['id'];
$pw = $_POST['pw1'];

$pwnew = password_hash($pw, PASSWORD_DEFAULT);


if (updatepw($con, $id, $pwnew) == 1) {
    echo 1;
} else {
    echo 2;
}

function updatepw($con, $id, $pwnew)
{

    $consulta = "UPDATE user SET PW ='$pwnew', RESET_PW = 0 WHERE ID=$id";
    $resultado = $con->prepare($consulta);
    $resultado->execute();

    if ($resultado->execute()) {
        return 1;
    } else {
        return 0;
    }
}
