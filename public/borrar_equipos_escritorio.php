<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Inventario Equipos</title>
</head>
<body>
<?php
include("../conexion/conexion.php");
$id=$_GET["id"];
$base->query("DELETE FROM registro_escritorio WHERE id = $id ");
header("location:inventario_equipos_escritorio.php");
?>
    
</body>
</html>