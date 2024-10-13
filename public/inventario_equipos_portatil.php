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
    $procesador = $_POST["proc"];
    $tipmemoria = $_POST["tipmem"];
    $tammemoria = $_POST["tammem"];
    $nummodulo = $_POST["nummod"];
    $tipdisco = $_POST["tipdis"];
    $tamano = $_POST["tam"];
    $bateria = $_POST["bat"];
    $nota = $_POST["not"];
    $estado = $_POST["est"];
    $cliente = $_POST["cli"];    
    $tecnico = $_POST["tec"];
    $fecha_ingreso = $_POST["fecing"];
    $fecha_salida = $_POST["fecsal"];

    $sql = "INSERT INTO registro_portatil (placa, serial, proveedor, marca, modelo, procesador, tipmemoria, tammemoria,nummodulo, tipdisco,tamano, bateria, nota, estado, cliente, tecnico, fecha_ingreso, fecha_salida) 
            VALUES (:pla, :ser, :pro, :mar, :mod, :proc, :tipmem, :tammem, :nummod, :tipdis, :tam, :bat, :not, :est, :cli, :tec, :fecing, :fecsal)";
    $resultados = $base->prepare($sql);
    $resultados->execute(array(
        ":pla" => $placa,
        ":ser" => $serial,
        ":pro" => $proveedor,
        ":mar" => $marca,
        ":mod" => $modelo,
        ":proc"=> $procesador,
        ":tipmem"=> $tipmemoria,
        ":tammem"=> $tammemoria,
        ":nummod"=> $nummodulo ,
        ":tipdis"=>  $tipdisco,
        ":tam"=> $tamano,
        ":bat"=> $bateria ,
        ":not"=> $nota ,
        ":est" => $estado,
        ":cli" => $cliente,        
        ":tec" => $tecnico,
        ":fecing" => $fecha_ingreso,
        ":fecsal" => $fecha_salida
    ));

    header("Location: inventario_equipos_portatil.php");
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
                    <td>
                        <label for="mod">Modelo:</label><br>
                        <input type='text' name='mod' id='mod' size='10' required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="proc">Procesador:</label><br>
                        <input type='text' name='proc' id='proc' size='20' required>
                    </td>
                    <td>
                        <label for="tipmem">Tipo Memoria:</label><br>
                        <select name="tipmem" id="tipmem" required>
                            <option value="">Seleccione memoria</option>
                            <option value="ddr1">DDR1</option>
                            <option value="ddr2">DDR2</option>
                            <option value="ddr3">DDR3</option>
                            <option value="ddr4">DDR4</option>
                        </select>
                    </td>
                    <td>
                        <label for="tammem">Tamaño Memoria:</label><br>
                        <select name="tammem" id="tammem" required>
                            <option value="">Seleccione tamaño</option>
                            <option value="4GB">4 GB</option>
                            <option value="8GB">8 GB</option>
                            <option value="12GB">12 GB</option>
                            <option value="16GB">16 GB</option>
                            <option value="32GB">32 GB</option>
                        </select>
                    </td>
                    <td>
                        <label for="nummod"># Modulo:</label><br>
                        <select name="nummod" id="nummod" required>
                            <option value="">Seleccione # Modulo</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </td>
                    <td>
                        <label for="tipdis">Tipo de Disco:</label><br>
                        <select name="tipdis" id="tipdis" required>
                            <option value="">Seleccione tipo disco</option>
                            <option value="hdd">HDD</option>
                            <option value="ssd">SSD</option>
                            <option value="nvme">NVMe</option>
                            <option value="m2">M.2</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="tam">Tamaño:</label><br>
                        <input type='text' name='tam' id='tam' size='10' required>
                    </td>
                    <td>
                        <label for="bat">Batería:</label><br>
                        <input type='text' name='bat' id='bat' size='10' required>
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
