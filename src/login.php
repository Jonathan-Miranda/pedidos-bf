<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../connection');
$dotenv->load();


class Conexion
{
    public static function Conectar()
    {
        define('servidor', $_ENV['DB_HOST']);
        define('nombre_bd', $_ENV['BD_NAME']);
        define('usuario', $_ENV['DB_USER']);
        define('password', $_ENV['DB_PASSWORD']);
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        try {
            $con = new PDO("mysql:host=" . servidor . "; dbname=" . nombre_bd, usuario, password, $opciones);
            return $con;
        } catch (Exception $e) {
            die("El error de Conexión es: " . $e->getMessage());
        }
    }
}

$objeto = new Conexion();
$con = $objeto->Conectar();

//recepción de datos enviados mediante POST desde ajax
$dt = (isset($_POST['dt'])) ? $_POST['dt'] : '';

if ($dt == 1) {

    $email = (isset($_POST['email'])) ? $_POST['email'] : '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $consulta = "SELECT NAME FROM user WHERE EMAIL='$email' AND C_PW = '0' ";
        $resultado = $con->prepare($consulta);
        $resultado->execute();


        if ($resultado->rowCount() >= 1) {

            $data2 = 3;
        } else {

            $consulta2 = "SELECT NAME FROM user WHERE EMAIL='$email' AND C_PW = '1' ";
            $resultado2 = $con->prepare($consulta2);
            $resultado2->execute();

            if ($resultado2->rowCount() >= 1) {
                $data2 = 4;
            }else {
                $data2 = null;
            }

        }

        print json_encode($data2);
        $con = null;
    } else {
        print json_encode(null);
        $con = null;
    }
} else if ($dt == 2) {

    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $password = (isset($_POST['pwl'])) ? md5($_POST['pwl']) : '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $consulta = "SELECT ID,NAME FROM user WHERE EMAIL='$email' AND PW= '$password' ";
        $resultado = $con->prepare($consulta);
        $resultado->execute();


        if ($resultado->rowCount() >= 1) {
            $data = $resultado->fetch();

            $_SESSION["id"] = $data[0];
            $_SESSION["s_usuario"] = $data[1];

            $data2 = 2;
        } else {
            $_SESSION["s_usuario"] = null;
            $data2 = null;
        }

        print json_encode($data2);
        $con = null;
    } else {
        print json_encode(null);
        $con = null;
    }
} else if ($dt == 3) {
    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $password = (isset($_POST['pwl'])) ? md5($_POST['pwl']) : '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $consulta = "UPDATE user SET PW ='$password', C_PW = 1 WHERE EMAIL='$email'";
        $resultado = $con->prepare($consulta);

        if ($resultado->execute()) {
            $data2 = 5;
        } else {
            $data2 = null;
        }
        print json_encode($data2);
        $con = null;
    } else {
        print json_encode(null);
        $con = null;
    }
}
