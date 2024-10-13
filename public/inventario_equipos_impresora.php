<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Link to main CSS file -->
    <link rel="stylesheet" href="../style/styleinventario_equipos_portatil.css"> <!-- Link to specific CSS file -->
    <title>Registro de Equipos</title>
</head>
<body>


    <nav>
        <li><a href="inventario_equipos.php">Atras</a></li>
    </nav>

    <?php

session_start();
if (!isset($_SESSION["usuarios"])) {
    header("location:login.php");
    exit();
}
include("../conexion/conexion.php");

// Obtener datos de las tablas para los selects
$resultadotipo = $base->query("SELECT nombre FROM tipo")->fetchAll(PDO::FETCH_OBJ);
$proveed = $base->query("SELECT nombre FROM proveedores")->fetchAll(PDO::FETCH_OBJ);
$estad = $base->query("SELECT nombre FROM estado")->fetchAll(PDO::FETCH_OBJ);
$client = $base->query("SELECT nombre FROM clientes")->fetchAll(PDO::FETCH_OBJ);
$tecn = $base->query("SELECT nombre FROM tecnico")->fetchAll(PDO::FETCH_OBJ);

// Guardar datos en base de datos
if (isset($_POST["ins"])) {
    $placa = $_POST["pla"];
    $serial = $_POST["ser"];
    $proveedor = $_POST["pro"];
    $marca = $_POST["mar"];
    $modelo = $_POST["mod"];
    $nota = $_POST["not"];
    $estado = $_POST["est"];
    $cliente = $_POST["cli"];    
    $tecnico = $_POST["tec"];
    $fecha_ingreso = $_POST["fecing"];
    $fecha_salida = $_POST["fecsal"];

    $sql = "INSERT INTO registro_impresora (placa, serial, proveedor, marca, modelo,  nota, estado, cliente, tecnico, fecha_ingreso, fecha_salida) 
            VALUES (:pla, :ser, :pro, :mar, :mod, :not, :est, :cli, :tec, :fecing, :fecsal)";
    $resultados = $base->prepare($sql);
    $resultados->execute(array(
        ":pla" => $placa,
        ":ser" => $serial,
        ":pro" => $proveedor,
        ":mar" => $marca,
        ":mod" => $modelo,
        ":not"=> $nota ,
        ":est" => $estado,
        ":cli" => $cliente,        
        ":tec" => $tecnico,
        ":fecing" => $fecha_ingreso,
        ":fecsal" => $fecha_salida
    ));

    header("Location: inventario_equipos_impresora.php");
    exit();
}

?>

    <main>
        <h1>REGISTRO PORTATIL</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <table>
                <tr>
                    <td>
                        <label for="pla">Placa:</label><br>
                        <input type='text' name='pla' id='pla' size='20' required>
                    </td>
                    <td>
                        <label for="ser">Serial:</label><br>
                        <input type='text' name='ser' id='ser' size='20' required>
                    </td>
                    <td>
                        <label for="pro">Proveedor:</label><br>
                        <select name='pro' id='pro' required>
                            <option value="">Seleccione un proveedor</option>
                            <?php foreach ($proveed as $proveedores): ?>
                                <option value="<?php echo htmlspecialchars($proveedores->nombre); ?>">
                                    <?php echo htmlspecialchars($proveedores->nombre); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <label for="mar">Marca:</label><br>
                        <input type='text' name='mar' id='mar' size='20' required>
                    </td>
                   
                </tr>
                <tr>
                <td>
                        <label for="mod">Modelo:</label><br>
                        <input type='text' name='mod' id='mod' size='10' required>
                    </td>
                  
                    <td>
                        <label for="not">Nota:</label><br>
                        <input type='text' name='not' id='not' size='10'>
                    </td>
                    <td>
                        <label for="est">Estado:</label><br>
                        <select name='est' id='est' required>
                            <option value="">Seleccione un estado</option>
                            <?php foreach ($estad as $estado): ?>
                                <option value="<?php echo htmlspecialchars($estado->nombre); ?>">
                                    <?php echo htmlspecialchars($estado->nombre); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <label for="cli">Cliente:</label><br>
                        <select name='cli' id='cli' required>
                            <option value="">Seleccione un cliente</option>
                            <?php foreach ($client as $clientes): ?>
                                <option value="<?php echo htmlspecialchars($clientes->nombre); ?>">
                                    <?php echo htmlspecialchars($clientes->nombre); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                   
                </tr>
                <tr>
                <td>
                        <label for="tec">Técnico:</label><br>
                        <select name='tec' id='tec' >
                            <option value="">Seleccione un técnico</option>
                            <?php foreach ($tecn as $tecnico): ?>
                                <option value="<?php echo htmlspecialchars($tecnico->nombre); ?>">
                                    <?php echo htmlspecialchars($tecnico->nombre); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                  
                    <td><label>Fecha Ingreso:</label><br>
            <input type='date' name='fecing' id='fecing' value="<?php echo isset($persona->fecha_ingreso) ? htmlspecialchars($persona->fecha_ingreso) : ''; ?>"></td>
            <td><label>Fecha Salida:</label><br>
            <input type='date' name='fecsal' id='fecsal' value="<?php echo isset($persona->fecha_salida) ? htmlspecialchars($persona->fecha_salida) : ''; ?>"></td>
                </tr>
                <tr>
            <td class="bot"><input type='submit' name='ins' id='ins' value='Insertar'></td>
        </tr>
            </table>
        </form>
    </main>
    
</body>
</html>