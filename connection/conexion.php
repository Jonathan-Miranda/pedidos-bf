<?php
//Variables de entorno{

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../connection');
$dotenv->load();

//}Fin variables de entorno

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
?>