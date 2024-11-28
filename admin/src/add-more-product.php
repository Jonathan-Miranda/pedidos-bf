<?php
session_start();
use PhpOffice\PhpSpreadsheet\IOFactory;
if (isset($_SESSION['admin-us'])) {


    // Conexión a la base de datos
    require('../../connection/conexion.php');

    // Obtener los valores del formulario

    $archivo = (isset($_FILES['file'])) ? $_FILES['file'] : '';

    //funcion para validar la extencion del archivo

    function val($archivo)
    {
        if ($archivo && isset($archivo['tmp_name']) && $archivo['error'] === UPLOAD_ERR_OK) {
            try {
                // Cargar el archivo usando PhpSpreadsheet
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($archivo['tmp_name']);

                $icon = "success";
                $msj = "El archivo es un archivo válido de Excel.";
                $status = true;
            } catch (\Exception $e) {
                $icon = "error";
                $msj = "El archivo no es un archivo válido de Excel.";
                $status = false;
            }
        } else {
            $icon = "error";
            $msj = "No se subió ningún archivo o hubo un error en la subida.";
            $status = false;
        }
        return [
            'icon' => $icon,
            'msj' => $msj,
            'status' => $status
        ];
    }

    //END funcion para validar la extencion del archivo

    //funcion cargar datos
    function cargarDatos($archivo, $con)
    {
        $document = IOFactory::load($archivo['tmp_name']);
        $hojaExcel = $document->getSheet(0);
        $filasHojaExcel = $hojaExcel->getHighestDataRow();

        $sql = "INSERT INTO product (SKU, NOMBRE, SUSTANCIA, PRESENTACION, REGISTRO_SANITARIO, STOCK, DESCRIPCION, CODIGO_BARRAS) 
                VALUES (:sku, :nombre, :sustancia, :presentacion, :registro, :stock, :descripcion, :codbarras)";

        $pdo = $con->prepare($sql);

        for ($i = 2; $i <= $filasHojaExcel; $i++) {
            $sku = $hojaExcel->getCell('A' . $i)->getValue(); // Primera columna (A)
            $nombre = $hojaExcel->getCell('B' . $i)->getValue(); // Segunda columna (B)
            $sustancia = $hojaExcel->getCell('C' . $i)->getValue(); // Tercera columna (C)
            $presentacion = $hojaExcel->getCell('D' . $i)->getValue(); // Cuarta columna (D)
            $registro = $hojaExcel->getCell('E' . $i)->getValue(); // Quinta columna (E)
            $stock = $hojaExcel->getCell('F' . $i)->getValue(); // Sexta columna (F)
            $descripcion = $hojaExcel->getCell('G' . $i)->getValue(); // Séptima columna (G)
            $codbarras = $hojaExcel->getCell('H' . $i)->getValue(); // Octava columna (H)

            // Validar valores vacíos y asignar un valor predeterminado
            $nombre = empty($nombre) ? 'Sin nombre' : $nombre;  // Asigna 'Desconocido' si está vacío
            $sustancia = empty($sustancia) ? 'Sin sustancia' : $sustancia;
            $presentacion = empty($presentacion) ? 'Sin presentación' : $presentacion;
            $registro = empty($registro) ? 'Sin registro' : $registro;  // Asigna 'Desconocido' si está vacío
            $stock = empty($stock) ? 0 : $stock;  // Asigna 0 si el stock está vacío
            $descripcion = empty($descripcion) ? 'Sin descripción' : $descripcion;  // Asigna un valor predeterminado si está vacío
            $codbarras = empty($codbarras) ? 000 : $codbarras;  // Asigna 'Sin código' si está vacío

            // Ejecutar la inserción en la base de datos
            $pdo->execute([
                ':sku' => $sku,
                ':nombre' => $nombre,
                ':sustancia' => $sustancia,
                ':presentacion' => $presentacion,
                ':registro' => $registro,
                ':stock' => $stock,
                ':descripcion' => $descripcion,
                ':codbarras' => $codbarras
            ]);
        }
        return true;
    }
    //end funcion cargar datos

    // ------------- main funct ----------------------

    // Validación del archivo
    $response = val($archivo);

    if ($response['status']) {
        // Si el archivo es válido, proceder con la carga de datos
        if (cargarDatos($archivo, $con)) {
            $response = [
                'icon' => 'success',
                'msj' => 'Los datos se cargaron correctamente en la base de datos.',
                'status' => true
            ];
        } else {
            $response = [
                'icon' => 'error',
                'msj' => 'Hubo un error al guardar los datos en la base de datos.',
                'status' => false
            ];
        }
    }

    // ---------------------------------- END main funct -------------------------

    print json_encode($response);
    $con = null;

} else {
    header("Location: index.php");
    exit();
}
