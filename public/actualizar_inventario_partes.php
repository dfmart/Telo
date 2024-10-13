<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../style/styleinventario_partes.css"> <!-- Enlace al archivo CSS -->
    <title>Actualizar Registro</title>
    
</head>
<body><header>
    <div class="container">
        <nav>
            <ul>
              
                <li><a href="clientes.php">Clientes</a></li>
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

    $estad = $base->query("SELECT nombre FROM estado")->fetchAll(PDO::FETCH_OBJ);
    $client = $base->query("SELECT nombre FROM clientes")->fetchAll(PDO::FETCH_OBJ);

    if (isset($_POST["bot_actualizar"])) {
        $id = $_POST["id"];
        $tip = $_POST["tip"];
        $pla = $_POST["pla"];
        $ser = $_POST["ser"];
        $pro = $_POST["pro"];
        $mar = $_POST["mar"];
        $mod = $_POST["mod"];
        $esp = $_POST["esp"];
        $est = $_POST["est"];
        $cli = $_POST["cli"];
        $des = $_POST["des"];
        $tec = $_POST["tec"];
        $fecing = $_POST["fecing"];
        $fecsal = $_POST["fecsal"];

        $sql = "UPDATE registro_partes SET tipo=:mitip, placa=:mipla, serial=:miser, proveedor=:mipro, marca=:mimar, modelo=:mimod, especificacion=:miesp, estado=:miest, cliente=:micli, descripcion=:mides, tecnico=:mitec, fecha_ingreso=:mifecing, fecha_salida=:mifecsal WHERE id=:miid";
        
        $resultados = $base->prepare($sql);
        $resultados->execute([
            ":miid" => $id,
            ":mitip" => $tip,
            ":mipla" => $pla,
            ":miser" => $ser,
            ":mipro" => $pro,
            ":mimar" => $mar,
            ":mimod" => $mod,
            ":miesp" => $esp,
            ":miest" => $est,
            ":micli" => $cli,
            ":mides" => $des,
            ":mitec" => $tec,
            ":mifecing" => $fecing,
            ":mifecsal" => $fecsal
        ]);

        header("location:inventario_partes.php");
        exit;
    } else {
        $id = $_GET["id"];
        $tip = $_GET["tip"];
        $pla = $_GET["pla"];
        $ser = $_GET["ser"];
        $pro = $_GET["pro"];
        $mar = $_GET["mar"];
        $mod = $_GET["mod"];
        $esp = $_GET["esp"];
        $est = $_GET["est"];
        $cli = $_GET["cli"];
        $des = $_GET["des"];
        $tec = $_GET["tec"];
        $fecing = $_GET["fecing"];
        $fecsal = $_GET["fecsal"];
    }
    ?>
     <li><a href="inventario_partes.php">Atras</a></li>
    <main>
   
 <h1 style text-align: center;>Actualizar Registro</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <table>
            <tr>
                <td><input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"></td>
            </tr>
            <tr>
                <td><label>Tipo:</label><input type="text" name="tip" value="<?php echo htmlspecialchars($tip); ?>"></td>
                <td><label>Placa:</label><input type='text' name='pla' value="<?php echo htmlspecialchars($pla); ?>"></td>
                <td><label>Serial:</label><input type='text' name='ser' value="<?php echo htmlspecialchars($ser); ?>"></td>
                <td><label>Proveedor:</label><input type='text' name='pro' value="<?php echo htmlspecialchars($pro); ?>"></td>
                <td><label>Marca:</label><input type='text' name='mar' value="<?php echo htmlspecialchars($mar); ?>"></td>
            </tr>
            <tr>
                <td><label>Modelo:</label><input type='text' name='mod' value="<?php echo htmlspecialchars($mod); ?>"></td>
                <td><label>Especificación:</label><input type='text' name='esp' value="<?php echo htmlspecialchars($esp); ?>"></td>
                <td><label>Estado:</label><br>
                <select name='est' id='est'>
                    <option value="">Seleccione un estado</option>
                    <?php foreach ($estad as $estado): ?>
                        <option value="<?php echo $estado->nombre; ?>"><?php echo $estado->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
                <td><label>Cliente:</label><br>
                <select name='cli' id='cli'>
                    <option value="">Seleccione un cliente</option>
                    <?php foreach ($client as $clientes): ?>
                        <option value="<?php echo $clientes->nombre; ?>"><?php echo $clientes->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
                <td><label>Descripción:</label><input type='text' name='des' value="<?php echo htmlspecialchars($des); ?>"></td>
            </tr>
            <tr>
                <td><label>Técnico:</label><input type='text' name='tec' value="<?php echo htmlspecialchars($tec); ?>"></td>
                <td><label>Fecha Ingreso:</label><input type='date' name='fecing' value="<?php echo htmlspecialchars($fecing); ?>"></td>
                <td><label>Fecha Salida:</label><input type='date' name='fecsal' value="<?php echo htmlspecialchars($fecsal); ?>"></td>
            </tr>
            <tr class="bot">
                <td colspan="5"><input type="submit" name="bot_actualizar" value="Actualizar"></td>
            </tr>
        </table>
    </form>
    </main>
</body>
</html>
