<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../style/styleclientes.css"> <!-- Enlace al archivo CSS -->
    <title>Actualizar Cliente</title>
  
</head>
<body>
<header>
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
    
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $stmt = $base->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$cliente) {
            echo "<p>Cliente no encontrado.</p>";
            exit;
        }
    }

    if (isset($_POST["bot_actualizar"])) {
        $id = $_POST["id"];
        $nom = $_POST["nom"];
        $dir = $_POST["dir"];
        $tel = $_POST["tel"];
        $corr = $_POST["corr"];

        $sql = "UPDATE clientes SET nombre = :minom, direccion = :midir, telefono = :mitel, correo = :micorr WHERE id = :miid";
        $resultados = $base->prepare($sql);
        $resultados->execute([
            ":miid" => $id,
            ":minom" => $nom,
            ":midir" => $dir,
            ":mitel" => $tel,
            ":micorr" => $corr
        ]);

        header("Location: clientes.php");
        exit;
    }
    ?>
     <li><a href="clientes.php">Atras</a></li>
     <main>
     <h1>Actualizar Cliente</h1>
    <form name="act_clientes" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $id); ?>">
        <table>
       
            <tr>
                <td><input type="hidden" name="id" value="<?php echo htmlspecialchars($cliente['id']); ?>"></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input type="text" name="nom" value="<?php echo htmlspecialchars($cliente['nombre']); ?>"></td>
            </tr>
            <tr>
                <td>Dirección:</td>
                <td><input type="text" name="dir" value="<?php echo htmlspecialchars($cliente['direccion']); ?>"></td>
            </tr>
            <tr>
                <td>Teléfono:</td>
                <td><input type="text" name="tel" value="<?php echo htmlspecialchars($cliente['telefono']); ?>"></td>
            </tr>
            <tr>
                <td>Correo:</td>
                <td><input type="text" name="corr" value="<?php echo htmlspecialchars($cliente['correo']); ?>"></td>
            </tr>
            <tr class="bot">
                <td colspan="2"><input type="submit" name="bot_actualizar" value="Actualizar"></td>
            </tr>
        </table>
    </form>

    </main>
</body>
</html>
