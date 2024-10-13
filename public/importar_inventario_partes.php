<?php

require '../vendor/autoload.php';

 // Asegúrate de que la ruta a autoload.php sea correcta


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (isset($_FILES['file'])) {
    // Verificar si se ha subido un archivo
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Conectar a la base de datos
        include("../conexion/conexion.php");

        // Preparar la consulta
        $sql = "INSERT INTO registro_partes (tipo, placa, serial, proveedor, marca, modelo, especificacion, estado, cliente, descripcion, tecnico, fecha_ingreso, fecha_salida) 
                VALUES (:tipo, :placa, :serial, :proveedor, :marca, :modelo, :especificacion, :estado, :cliente, :descripcion, :tecnico, :fecha_ingreso, :fecha_salida)";
        
        $stmt = $base->prepare($sql);

        // Recorrer las filas de datos y realizar la inserción
        foreach ($sheetData as $row) {
            // Asegúrate de que los índices de las columnas coincidan con tu archivo Excel
            $stmt->execute([
                ':tipo' => $row['tipo'], // Ajusta según la columna de tu archivo
                ':placa' => $row['placa'],
                ':serial' => $row['serial'],
                ':proveedor' => $row['proveedor'],
                ':marca' => $row['marca'],
                ':modelo' => $row['modelo'],
                ':especificacion' => $row['especificacion'],
                ':estado' => $row['estado'],
                ':cliente' => $row['cliente'],
                ':descripcion' => $row['descripcion'],
                ':tecnico' => $row['tecnico'],
                ':fecha_ingreso' => date('Y-m-d', strtotime($row['fecha_ingreso'])), // Asegúrate de que esté en el formato correcto
                ':fecha_salida' => date('Y-m-d', strtotime($row['fecha_salida'])),
            ]);
        }

        echo "Importación exitosa!";
    } else {
        echo "Error al cargar el archivo.";
    }
} else {
    echo "No se ha enviado ningún archivo.";
}
?>
