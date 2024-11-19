<?php
session_start();

//Variables de entorno{

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../connection');
$dotenv->load();

//}Fin variables de entorno

$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$password = (isset($_POST['pwl'])) ? $_POST['pwl'] : '';
$dt = (isset($_POST['dt'])) ? $_POST['dt'] : '';

//Establecer coneccion -> DB{
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

//}End establecer coneccion -> DB

//Funciones{

function verificarCorreo($email)
{

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $verificarCorreoResponse = true;
    } else {
        $verificarCorreoResponse = false;
    }

    return $verificarCorreoResponse;
}

// ==========================================================

function verUsuarioPwOK($email, $con)
{

    $consulta = "SELECT NOMBRE FROM user WHERE CORREO = :correo AND CREATE_PW = '0'";
    $resultado = $con->prepare($consulta);
    $resultado->bindParam(':correo', $email, PDO::PARAM_STR);
    $resultado->execute();

    if ($resultado->rowCount() >= 1) {
        $icon = "warning";
        $msj = "El usuario existe pero no ha creado pw";
        $status = true;
    } else {
        $icon = "error";
        $msj = "EL usuario no existe :(";
        $status = false;
    }
    return [
        'icon' => $icon,
        'msj' => $msj,
        'status' => $status
    ];
}

// ==========================================================

function usuarioCreaPw($email, $password, $con)
{
    $pwhas = password_hash($password, PASSWORD_DEFAULT);

    $consulta = "UPDATE user SET PW = :password, CREATE_PW = 1 WHERE CORREO = :correo";
    $resultado = $con->prepare($consulta);

    // Asignamos los valores de los parámetros
    $resultado->bindParam(':password', $pwhas, PDO::PARAM_STR);
    $resultado->bindParam(':correo', $email, PDO::PARAM_STR);

    // Ejecutamos la consulta
    if ($resultado->execute()) {

        $icon = "success";
        $msj = "Contraseña creada correctamente";
        $status = true;
    } else {
        // Acción si la actualización falló
        $icon = "error";
        $msj = "No se guardo su contraseña";
        $status = false;
    }
    return [
        'icon' => $icon,
        'msj' => $msj,
        'status' => $status
    ];
}

// ==========================================================

function loginUsuario($email, $password, $con)
{
    $consulta = "SELECT ID,NOMBRE,PW FROM user WHERE CORREO = ? ";
    $resultado = $con->prepare($consulta);
    $resultado->bind_param("s", $email);
    $resultado->execute();
    if ($resultado->rowCount() >= 1) {
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $data['PW'])) {

            $_SESSION["id"] = $data['ID'];
            $_SESSION["s_usuario"] = $data['NOMBRE'];

            $icon = "success";
            $msj = "Bienvenido";
            $status = true;
        } else {

            $_SESSION["s_usuario"] = null;
            $icon = "warning";
            $msj = "Contraseña incorrecta";
            $status = false;
        }
    } else {

        $_SESSION["s_usuario"] = null;
        $icon = "error";
        $msj = "No existe este usuario, verifique sus datos";
        $status = false;
    }

    return [
        'icon' => $icon,
        'msj' => $msj,
        'status' => $status
    ];
}

//}End funciones

// ================================================================

//funcion principal

function main($email, $password, $con) {
    
    if (verificarCorreo($email)) {
        $response = verUsuarioPwOK($email, $con);

        if ($response['status']) {
            $response_Crearpw = usuarioCreaPw($email, $password, $con);

            $icon = $response_Crearpw['icon'];
            $msj = $response_Crearpw['msj'];
            $status = $response_Crearpw['status'];
        } else {
            $response_login = loginUsuario($email, $password, $con);

            $icon = $response_login['icon'];
            $msj = $response_login['msj'];
            $status = $response_login['status'];
        }

    } else {
        $icon = "warning";
        $msj = "Coloque una direccion de correo valida";
        $status = false;
    }

    return [
        'icon' => $icon,
        'msj' => $msj,
        'status' => $status
    ];
}

//end funcion pricipal

$datos = main($email, $password, $con);

print json_encode($data2);
$con = null;
