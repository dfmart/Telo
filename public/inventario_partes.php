<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../style/styleinventario_partes.css"> <!-- Enlace al archivo CSS -->
    <title>Registro de Partes</title>
    
</head>
<body>
<header>
    <div class="container">
        <nav>
            <ul>
                <li><a href="clientes.php">Clientes</a></li>
                <li><a href="proveedores.php">Proveedor</a></li>
                <li><a href="inventario_partes.php">Inventario Partes</a></li>
                <li><a href="inventario_equipos.php">Inventario Equipos</a></li>
                <li><a href="cierre.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </div>
</header>


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

// Manejo de la búsqueda
$search = "";
$registros = [];
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $base->prepare("SELECT * FROM registro_partes WHERE 
        placa LIKE :search OR 
        serial LIKE :search OR 
        modelo LIKE :search OR 
        especificacion LIKE :search OR 
        estado LIKE :search OR 
        cliente LIKE :search OR 
        tecnico LIKE :search OR 
        proveedor LIKE :search");
    $stmt->execute([':search' => '%' . $search . '%']);
    $registros = $stmt->fetchAll(PDO::FETCH_OBJ);
} else {
    $registros = $base->query("SELECT * FROM registro_partes")->fetchAll(PDO::FETCH_OBJ);
}

// Guardar datos en base de datos
if (isset($_POST["ins"])) {
    $tipo = $_POST["tip"];
    $placa = $_POST["pla"];
    $serial = $_POST["ser"];
    $proveedor = $_POST["pro"];
    $marca = $_POST["mar"];
    $modelo = $_POST["mod"];
    $especificacion = $_POST["esp"];
    $estado = $_POST["est"];
    $cliente = $_POST["cli"];
    $descripcion = $_POST["des"];
    $tecnico = $_POST["tec"];
    $fecha_ingreso = $_POST["fecing"];
    $fecha_salida = $_POST["fecsal"];

    $sql = "INSERT INTO registro_partes (tipo, placa, serial, proveedor, marca, modelo, especificacion, estado, cliente, descripcion, tecnico, fecha_ingreso, fecha_salida) 
            VALUES (:tip, :pla, :ser, :pro, :mar, :mod, :esp, :est, :cli, :des, :tec, :fecing, :fecsal)";
    $resultados = $base->prepare($sql);
    $resultados->execute(array(
        ":tip" => $tipo,
        ":pla" => $placa,
        ":ser" => $serial,
        ":pro" => $proveedor,
        ":mar" => $marca,
        ":mod" => $modelo,
        ":esp" => $especificacion,
        ":est" => $estado,
        ":cli" => $cliente,
        ":des" => $descripcion,
        ":tec" => $tecnico,
        ":fecing" => $fecha_ingreso,
        ":fecsal" => $fecha_salida
    ));

    header("Location: inventario_partes.php");
    exit();
}
?>
<div class="excel">
<a href="exportar_partes.php" class="bot">Exportar excel</a><br>
<a href="importar_partes.php" class="bot">Importar excel</a><br>
</div>

<main>
<h1>REGISTRO DE PARTES</h1>
<?php
if (isset($_SESSION["mensaje"])) {
    $tipo = isset($_SESSION["tipo_mensaje"]) ? $_SESSION["tipo_mensaje"] : 'error';
    echo '<div class="mensaje ' . $tipo . '">' . htmlspecialchars($_SESSION["mensaje"]) . '</div>';
    unset($_SESSION["mensaje"]);
    unset($_SESSION["tipo_mensaje"]);
}
?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <table>
        <tr>
            <td><label>Tipo:</label><br>
                <select name='tip' id='tip'>
                    <option value="">Seleccione un tipo</option>
                    <?php foreach ($resultadotipo as $tipo): ?>
                        <option value="<?php echo htmlspecialchars($tipo->nombre); ?>"><?php echo htmlspecialchars($tipo->nombre); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><label>Placa:</label><br>
                <input type='text' name='pla' id='pla' size='20'></td>
            <td><label>Serial:</label><br>
                <input type='text' name='ser' id='ser' size='20'></td>
            <td><label>Proveedor:</label><br>
                <select name='pro' id='pro'>
                    <option value="">Seleccione un proveedor</option>
                    <?php foreach ($proveed as $proveedores): ?>
                        <option value="<?php echo htmlspecialchars($proveedores->nombre); ?>"><?php echo htmlspecialchars($proveedores->nombre); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><label>Marca:</label><br>
            <input type='text' name='mar' id='mar' size='20' value="<?php echo isset($persona->marca) ? htmlspecialchars($persona->marca) : ''; ?>"></td>

        </tr>
        
        <tr>
              <td><label>Modelo:</label><br>
              <input type='text' name='mod' id='mod' size='10' value="<?php echo htmlspecialchars(isset($persona->modelo) ? $persona->modelo : ''); ?>"></td>
              <td><label>Especificación:</label><br>
              <input type='text' name='esp' id='esp' size='10' value="<?php echo htmlspecialchars(isset($persona->especificacion) ? $persona->especificacion : ''); ?>"></td>
             

            <td><label>Estado:</label><br>
                <select name='est' id='est'>
                    <option value="">Seleccione un estado</option>
                    <?php foreach ($estad as $estado): ?>
                        <option value="<?php echo htmlspecialchars($estado->nombre); ?>"><?php echo htmlspecialchars($estado->nombre); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><label>Cliente:</label><br>
                <select name='cli' id='cli'>
                    <option value="">Seleccione un cliente</option>
                    <?php foreach ($client as $clientes): ?>
                        <option value="<?php echo htmlspecialchars($clientes->nombre); ?>"><?php echo htmlspecialchars($clientes->nombre); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><label>Descripción:</label><br>
            <input type='text' name='des' id='des' size='10' value="<?php echo htmlspecialchars(isset($persona->descripcion) ? $persona->descripcion : ''); ?>"></td>

        </tr>
        <tr>
            <td><label>Técnico:</label><br>
                <select name='tec' id='tec'>
                    <option value="">Seleccione un técnico</option>
                    <?php foreach ($tecn as $tecnico): ?>
                        <option value="<?php echo htmlspecialchars($tecnico->nombre); ?>"><?php echo htmlspecialchars($tecnico->nombre); ?></option>
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

                    <!-- Formulario de búsqueda -->
<form class="buscar" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <input type="text" name="search" placeholder="Buscar por placa, serial, modelo, etc." value="<?php echo htmlspecialchars($search); ?>">
    <input type="submit" value="Buscar">
</form>


    <table class="info">
    <tr>
        <th>Id</th>
        <th>Tipo</th>
        <th>Placa</th>
        <th>Serial</th>
        <th>Proveedor</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Especificación</th>
        <th>Estado</th>
        <th>Cliente</th>
        <th>Descripción</th>
        <th>Técnico</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Salida</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($registros as $persona): ?>
        <tr>
            <td><?php echo htmlspecialchars($persona->id); ?></td>
            <td><?php echo htmlspecialchars($persona->tipo); ?></td>
            <td><?php echo htmlspecialchars($persona->placa); ?></td>
            <td><?php echo htmlspecialchars($persona->serial); ?></td>
            <td><?php echo htmlspecialchars($persona->proveedor); ?></td>
            <td><?php echo htmlspecialchars($persona->marca); ?></td>
            <td><?php echo htmlspecialchars($persona->modelo); ?></td>
            <td><?php echo htmlspecialchars($persona->especificacion); ?></td>
            <td><?php echo htmlspecialchars($persona->estado); ?></td>
            <td><?php echo htmlspecialchars($persona->cliente); ?></td>
            <td><?php echo htmlspecialchars($persona->descripcion); ?></td>
            <td><?php echo htmlspecialchars($persona->tecnico); ?></td>
            <td><?php echo htmlspecialchars(date("d-m-Y", strtotime($persona->fecha_ingreso))); ?></td>
            <td><?php echo htmlspecialchars(date("d-m-Y", strtotime($persona->fecha_salida))); ?></td>
            <td  class="bot">
            <a href="borrar_inventario_partes.php?id=<?php echo htmlspecialchars($persona->id); ?>"><input type='button' value='Borrar'></a>
            <a href="actualizar_inventario_partes.php?id=<?php echo htmlspecialchars($persona->id); ?>&tip=<?php echo htmlspecialchars($persona->tipo); ?>&pla=<?php echo htmlspecialchars($persona->placa); ?>&ser=<?php echo htmlspecialchars($persona->serial); ?>&pro=<?php echo htmlspecialchars($persona->proveedor); ?>&mar=<?php echo htmlspecialchars($persona->marca); ?>&mod=<?php echo htmlspecialchars($persona->modelo); ?>&esp=<?php echo htmlspecialchars($persona->especificacion); ?>&est=<?php echo htmlspecialchars($persona->estado); ?>&cli=<?php echo htmlspecialchars($persona->cliente); ?>&des=<?php echo htmlspecialchars($persona->descripcion); ?>&tec=<?php echo htmlspecialchars($persona->tecnico); ?>&fecing=<?php echo htmlspecialchars($persona->fecha_ingreso); ?>&fecsal=<?php echo htmlspecialchars($persona->fecha_salida); ?>"><input type='button' value='Actualizar'></a></td>
        </tr>
    <?php endforeach; ?>
</table>

<p>&nbsp;</p>
</body>
</html>
