<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="importar_inventario_partes.php" method="post" enctype="multipart/form-data">
    <label for="file">Selecciona un archivo Excel:</label>
    <input type="file" name="file" id="file" accept=".xlsx, .xls">
    <input type="submit" value="Importar">
</form>
    
</body>
</html>