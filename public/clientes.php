<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../style/styleclientes.css"> <!-- Enlace al archivo CSS -->
   
    <title>Clientes</title>
    
</head>
<body>
<p>&nbsp;</p>
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

// Manejo de la búsqueda
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $base->prepare("SELECT * FROM clientes WHERE nombre LIKE :search");
    $stmt->execute([':search' => '%' . $search . '%']);
    $registros = $stmt->fetchAll(PDO::FETCH_OBJ);
} else {
    $registros = $base->query("SELECT * FROM clientes")->fetchAll(PDO::FETCH_OBJ);
}

// Manejo de la inserción
if (isset($_POST["ins"])) {
    $nombre = $_POST["nom"];
    $direccion = $_POST["dir"];
    $telefono = $_POST["tel"];
    $correo = $_POST["corr"];
    
    if (empty($nombre) || empty($direccion) || empty($telefono) || empty($correo)) {
        $_SESSION["mensaje"] = "Todos los campos son obligatorios.";
        $_SESSION["tipo_mensaje"] = "error";
    } else {
        $sql = "INSERT INTO clientes (nombre, direccion, telefono, correo) VALUES (:nom, :dir, :tel, :corr)";
        $resultados = $base->prepare($sql);
        $resultados->execute(array(":nom" => $nombre, ":dir" => $direccion, ":tel" => $telefono, ":corr" => $correo));
        
        $_SESSION["mensaje"] = "Cliente guardado con éxito.";
        $_SESSION["tipo_mensaje"] = "exito";
        header("location:clientes.php");
        exit();
    }
}

// Manejo de la actualización
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $base->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $clientes = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="excel">
    <a href="exportar_clientes.php">Descargar Excel</a>
    <a href="importar_cliente.php">Subir Excel</a>
</div>


<main>
<h1>Registro de Clientes</h1>

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
            <td>Nombre de la empresa:</td>
            <td><input type="text" name="nom" value="<?php echo isset($clientes['nombre']) ? htmlspecialchars($clientes['nombre']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Dirección:</td>
            <td><input type="text" name="dir" value="<?php echo isset($clientes['direccion']) ? htmlspecialchars($clientes['direccion']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Número Teléfono:</td>
            <td><input type="int" name="tel" value="<?php echo isset($clientes['telefono']) ? htmlspecialchars($clientes['telefono']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Correo:</td>
            <td><input type="email" name="corr" value="<?php echo isset($clientes['correo']) ? htmlspecialchars($clientes['correo']) : ''; ?>" required></td>
        </tr>
        <tr class="bot">
            <td colspan="2"><input type="submit" name="ins" value="Insertar"></td>
        </tr>
    </table>
</form>
</main>

<!-- Formulario de búsqueda -->
<form class="buscar" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <input type="text" name="search" placeholder="Ingresa nombre cliente" value="<?php echo htmlspecialchars($search); ?>">
    <input type="submit" value="Buscar">
</form>


<table class="info">
    <tr>
        <th>Id</th>
        <th>Nombre de la empresa</th>
        <th>Dirección</th>
        <th>Número Teléfono</th>
        <th>Correo</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($registros as $persona) : ?>
    <tr>
        <td><?php echo htmlspecialchars($persona->id); ?></td>
        <td><?php echo htmlspecialchars($persona->nombre); ?></td>
        <td><?php echo htmlspecialchars($persona->direccion); ?></td>
        <td><?php echo htmlspecialchars($persona->telefono); ?></td>
        <td><?php echo htmlspecialchars($persona->correo); ?></td>
        <td class="bot">
            <a href="borrar_clientes.php?id=<?php echo $persona->id; ?>"><input type="button" value="Borrar"></a>
            <a href="actualizar_clientes.php?id=<?php echo $persona->id; ?>"><input type="button" value="Actualizar"></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<p>&nbsp;</p>
</body>
</html>
