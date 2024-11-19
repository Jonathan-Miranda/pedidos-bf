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
// 1) crear pw 1era ves
// 2) inicio sesion
// 3) guarda que es usuario creo pw
$dt = (isset($_POST['dt'])) ? $_POST['dt'] : '';

if ($dt == 1) {

    $email = (isset($_POST['email'])) ? $_POST['email'] : '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $consulta = "SELECT NOMBRE FROM user WHERE CORREO='$email' AND CREATE_PW = '0' ";
        $resultado = $con->prepare($consulta);
        $resultado->execute();


        if ($resultado->rowCount() >= 1) {
            $data2 = 3;
        } else {

            $consulta2 = "SELECT NOMBRE FROM user WHERE CORREO='$email' AND CREATE_PW = '1' ";
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
    $password = (isset($_POST['pwl'])) ? $_POST['pwl'] : '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        //$consulta = "SELECT ID,NOMBRE FROM user WHERE CORREO='$email' AND PW= '$password' ";
        $consulta = "SELECT ID,NOMBRE,PW FROM user WHERE CORREO = ? ";
        $resultado = $con->prepare($consulta);
        $resultado-> bind_param("s",$email);
        $resultado->execute();


        if ($resultado->rowCount() >= 1) {
            $data = $resultado->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $data[PW])) {
                $_SESSION["id"] = $data[ID];
                $_SESSION["s_usuario"] = $data[NOMBRE];
    
                $data2 = 2;//agregar alerta de pw incorrecta
            } else{
                $_SESSION["s_usuario"] = null;
                $data2 = null;
            }

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
    $password = (isset($_POST['pwl'])) ? password_hash($_POST['pwl'], PASSWORD_DEFAULT) : '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $consulta = "UPDATE user SET PW ='$password', C_PW = 1 WHERE CORREO='$email'";
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
