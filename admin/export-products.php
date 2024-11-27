<?php
session_start();
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_SESSION['admin-us'])) {
    require('../connection/conexion.php');

    // Consulta para obtener los productos
    $query = "SELECT * FROM product";
    $resultado = $con->prepare($query);
    $resultado->execute();

    // Verificamos si hay productos en la base de datos
    if ($resultado->rowCount() >= 1) {
        // Crear un objeto de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Obtener los nombres de las columnas
        $row = $resultado->fetch(PDO::FETCH_ASSOC); // Tomamos una fila para obtener las claves de las columnas
        $titles = array_keys($row); // Títulos de las columnas

        // Escribir los títulos de las columnas en la primera fila
        $sheet->fromArray($titles, NULL, 'A1');

        // Volver a la primera fila para leer todas las filas
        $resultado->execute();

        // Agregar los datos de la tabla
        $row = 2; // Comenzamos en la fila 2 porque la 1 ya tiene los títulos
        while ($product = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $sheet->fromArray($product, NULL, 'A' . $row);
            $row++;
        }

        // Obtener la fecha actual en formato "dd-mm-yy"
        $date = date("d-m-y");

        // Especificar el nombre del archivo con la fecha dinámica
        $fileName = "productos-catalogo-$date.xlsx";
        // Especificar el nombre del archivo
        
        // Enviar las cabeceras necesarias para la descarga del archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
        
        // Escribir el archivo y enviarlo al navegador para que se descargue directamente
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    } else {
        echo "No hay productos para exportar.";
    }

} else {
    header("Location: index.php");
    exit();
}
?>