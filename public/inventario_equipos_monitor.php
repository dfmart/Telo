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
$registros  = $base->query("SELECT * FROM registro_monitor")->fetchAll(PDO::FETCH_OBJ);

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

    $sql = "INSERT INTO registro_monitor (placa, serial, proveedor, marca, modelo,  nota, estado, cliente, tecnico, fecha_ingreso, fecha_salida) 
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

    header("Location: inventario_equipos_monitor.php");
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
                    <td><label>Marca:</label><br>
                    <input type='text' name='mar' id='mar' size='20' value="<?php echo isset($persona->marca) ? htmlspecialchars($persona->marca) : ''; ?>"></td>
                   
                </tr>
                <tr>
                <td><label>Modelo:</label><br>
                <input type='text' name='mod' id='mod' size='10' value="<?php echo htmlspecialchars(isset($persona->modelo) ? $persona->modelo : ''); ?>"></td>
                  
                <td><label>Nota:</label><br>
                <input type='text' name='not' id='not' size='10' value="<?php echo htmlspecialchars(isset($persona->nota) ? $persona->nota : ''); ?>"></td>
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

    <table class="info">
    <tr>
        <th>Id</th>
        
        <th>Placa</th>
        <th>Serial</th>
        <th>Proveedor</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Nota</th>
        <th>Estado</th>
        <th>Cliente</th>
        <th>Técnico</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Salida</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($registros as $persona): ?>
        <tr>
            <td><?php echo htmlspecialchars($persona->id); ?></td>
            <td><?php echo htmlspecialchars($persona->placa); ?></td>
            <td><?php echo htmlspecialchars($persona->serial); ?></td>
            <td><?php echo htmlspecialchars($persona->proveedor); ?></td>
            <td><?php echo htmlspecialchars($persona->marca); ?></td>
            <td><?php echo htmlspecialchars($persona->modelo); ?></td>
            <td><?php echo htmlspecialchars($persona->nota); ?></td>
            <td><?php echo htmlspecialchars($persona->estado); ?></td>
            <td><?php echo htmlspecialchars($persona->cliente); ?></td>
            <td><?php echo htmlspecialchars($persona->tecnico); ?></td>
            <td><?php echo htmlspecialchars(date("d-m-Y", strtotime($persona->fecha_ingreso))); ?></td>
            <td><?php echo htmlspecialchars(date("d-m-Y", strtotime($persona->fecha_salida))); ?></td>
            <td  class="bot">
            <a href="borrar_equipos_monitor.php?id=<?php echo htmlspecialchars($persona->id); ?>"><input type='button' value='Borrar'></a>
            <a href="actualizar_inventario_partes.php?id=<?php echo htmlspecialchars($persona->id); ?>&tip=<?php echo htmlspecialchars($persona->tipo); ?>&pla=<?php echo htmlspecialchars($persona->placa); ?>&ser=<?php echo htmlspecialchars($persona->serial); ?>&pro=<?php echo htmlspecialchars($persona->proveedor); ?>&mar=<?php echo htmlspecialchars($persona->marca); ?>&mod=<?php echo htmlspecialchars($persona->modelo); ?>&esp=<?php echo htmlspecialchars($persona->especificacion); ?>&est=<?php echo htmlspecialchars($persona->estado); ?>&cli=<?php echo htmlspecialchars($persona->cliente); ?>&des=<?php echo htmlspecialchars($persona->descripcion); ?>&tec=<?php echo htmlspecialchars($persona->tecnico); ?>&fecing=<?php echo htmlspecialchars($persona->fecha_ingreso); ?>&fecsal=<?php echo htmlspecialchars($persona->fecha_salida); ?>"><input type='button' value='Actualizar'></a></td>
        </tr>
    <?php endforeach; ?>
</table>

<p>&nbsp;</p>
    
</body>
</html>