<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../style/styleproveedores.css"> <!-- Enlace al archivo CSS -->
    <title>Actualizar Proveedores</title>
    
</head>
<body>
<header>
    <div class="container">
        <nav>
            <ul>
              
                <li><a href="proveedores.php">Proveedor</a></li>
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

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        
        // Obtener datos del proveedor
        $stmt = $base->prepare("SELECT * FROM proveedores WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$proveedor) {
            echo "<p>Proveedor no encontrado.</p>";
            exit;
        }
    }

    if (isset($_POST["bot_actualizar"])) {
        $id = $_POST["id"];
        $nom = $_POST["nom"];
        $dir = $_POST["dir"];
        $tel = $_POST["tel"];
        $corr = $_POST["corr"];

        // Actualizar datos del proveedor
        $sql = "UPDATE proveedores SET nombre = :minom, direccion = :midir, telefono = :mitel, correo = :micorr WHERE id = :miid";
        $resultados = $base->prepare($sql);
        $resultados->execute([
            ":miid" => $id,
            ":minom" => $nom,
            ":midir" => $dir,
            ":mitel" => $tel,
            ":micorr" => $corr
        ]);

        header("Location: proveedores.php");
        exit;
    }
    ?>
    <li><a href="proveedores.php">Atras</a></li>
<main>
<h1 text-aling="center">Actualizar Proveedor</h1>

    <form name="act_proveedor" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $id); ?>">
        <table>
            <tr>
                <td><input type="hidden" name="id" value="<?php echo htmlspecialchars($proveedor['id']); ?>"></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input type="text" name="nom" value="<?php echo htmlspecialchars($proveedor['nombre']); ?>"></td>
            </tr>
            <tr>
                <td>Dirección:</td>
                <td><input type="text" name="dir" value="<?php echo htmlspecialchars($proveedor['direccion']); ?>"></td>
            </tr>
            <tr>
                <td>Teléfono:</td>
                <td><input type="text" name="tel" value="<?php echo htmlspecialchars($proveedor['telefono']); ?>"></td>
            </tr>
            <tr>
                <td>Correo:</td>
                <td><input type="text" name="corr" value="<?php echo htmlspecialchars($proveedor['correo']); ?>"></td>
            </tr>
            <tr class="bot">
                <td colspan="2"><input type="submit" name="bot_actualizar" value="Actualizar"></td>
            </tr>
        </table>
    </form>
    </main>

    
</body>
</html>
