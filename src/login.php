<?php
session_start();

//Variables de entorno{

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../connection');
$dotenv->load();

//}Fin variables de entorno

$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$password = (isset($_POST['pw'])) ? $_POST['pw'] : '';
$pwl_2 = (isset($_POST['pwl'])) ? $_POST['pwl'] : '';
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

    $consulta = "SELECT CREATE_PW FROM user WHERE CORREO = :correo";
    $resultado = $con->prepare($consulta);
    $resultado->bindParam(':correo', $email, PDO::PARAM_STR);
    $resultado->execute();

    if ($resultado->rowCount() >= 1) {
        // Usamos fetch() para obtener la fila de resultados
        $row = $resultado->fetch(PDO::FETCH_ASSOC); // Devuelve un array asociativo

        // Accedemos al valor de CREATE_PW
        if ($row['CREATE_PW'] == 0) {
            $icon = "warning";
            $msj = "El usuario existe pero no ha creado pw";
            $status = true;
            $process = 2;
        } else {
            $icon = "warning";
            $msj = "El usuario ya tiene creada la pw";
            $status = true;
            $process = 3;
        }

    } else {
        $icon = "error";
        $msj = "EL usuario no existe :(";
        $status = false;
        $process = 0;
    }
    return [
        'icon' => $icon,
        'msj' => $msj,
        'status' => $status,
        'process' => $process
    ];
}

// ==========================================================

function usuarioCreaPw($email, $pwl_2, $con)
{
    $pwhas = password_hash($pwl_2, PASSWORD_DEFAULT);

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
    $consulta = "SELECT ID,NOMBRE,PW FROM user WHERE CORREO = :correo ";
    $resultado = $con->prepare($consulta);
    $resultado->bindParam(':correo', $email, PDO::PARAM_STR);
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

switch ($dt) {
    case 1:
        if (verificarCorreo($email)) {

            $response = verUsuarioPwOK($email, $con);

        } else {

            $response = [
                'icon' => 'warning',
                'msj' => 'Coloque una direccion de correo valida',
                'status' => false,
            ];
        }
        break;

    case 2:
        $response = usuarioCreaPw($email, $pwl_2, $con);
        break;

    case 3:
        $response = loginUsuario($email, $password, $con);
        break;

    default:
        $response = [
            'icon' => 'error',
            'msj' => 'Ocurrio un error, vuelva a intentarlo más tarde',
            'status' => false,
        ];
        break;
}

//end funcion pricipal



print json_encode($response);
$con = null;
