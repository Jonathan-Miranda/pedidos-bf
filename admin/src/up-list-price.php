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

        $sql = "INSERT INTO precio_product (ID_PRODUCT, ID_TIPO_USER, PRECIO, OFERTA) 
                VALUES (:idprod, :iduser, :precio, :oferta)";

        $pdo = $con->prepare($sql);

        for ($i = 2; $i <= $filasHojaExcel; $i++) {
            $idprod = $hojaExcel->getCell('A' . $i)->getValue();
            $iduser = $hojaExcel->getCell('C' . $i)->getValue();
            $precio = $hojaExcel->getCell('D' . $i)->getValue();
            $oferta = $hojaExcel->getCell('E' . $i)->getValue();
            

            // Validar valores vacíos y asignar un valor predeterminado
            $idprod = empty($idprod) ? 0 : $idprod;
            $iduser = empty($iduser) ? 0 : $iduser;
            $precio = empty($precio) ? 0 : $precio;
            $oferta = empty($oferta) ? 0 : $oferta;

            // Ejecutar la inserción en la base de datos
            $pdo->execute([
                ':idprod' => $idprod,
                ':iduser' => $iduser,
                ':precio' => $precio,
                ':oferta' => $oferta
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
