<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_SESSION['message']))
    {
        echo"<h4>".$_SESSION['message']."</h4>";
        unset($_SESSION['message']);
    }
    ?>
<form action="importar_cliente.php" method="post" enctype="multipart/form-data">
    <label for="file">Selecciona un archivo Excel:</label>
    <input type="file" name="import_file" class="form-control">
    <button type="submit"  name="save_excel_data" value="Importar">Importar</button>
</form>
    
</body>
</html>