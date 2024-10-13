<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../style/styleproveedores.css"> <!-- Enlace al archivo CSS -->
    <title>Proveedores</title>   
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
echo "User: " . htmlspecialchars($_SESSION["usuarios"]) . "<br><br>";

include("../conexion/conexion.php");

// Manejo de la búsqueda
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $base->prepare("SELECT * FROM proveedores WHERE nombre LIKE :search");
    $stmt->execute([':search' => '%' . $search . '%']);
    $registros = $stmt->fetchAll(PDO::FETCH_OBJ);
} else {
    $registros = $base->query("SELECT * FROM proveedores")->fetchAll(PDO::FETCH_OBJ);
}


// Manejo de la inserción
if (isset($_POST["ins"])) {
    $nombre = $_POST["nom"];
    $direccion = $_POST["dir"];
    $telefono = $_POST["tel"];
    $correo = $_POST["corr"];
    $sql = "INSERT INTO proveedores (nombre, direccion, telefono, correo) VALUES (:nom, :dir, :tel, :corr)";
    $resultados = $base->prepare($sql);
    $resultados->execute(array(":nom" => $nombre, ":dir" => $direccion, ":tel" => $telefono, ":corr" => $correo));
    header("location:proveedores.php");
    exit();
}

// Manejo de la actualización
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $base->prepare("SELECT * FROM proveedores WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="excel">
<a href="exportar_proveedores.php" class="bot">Exportar excel</a><br><br>
<a href="importar_proveedores.php" class="bot">Importar excel</a><br>
</div>


<main>
<h1>Registro de Proveedor</h1>

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
            <td><input type="text" name="nom" value="<?php echo isset($proveedor['nombre']) ? htmlspecialchars($proveedor['nombre']) : ''; ?>"></td>
        </tr>
        <tr>
            <td>Dirección:</td>
            <td><input type="text" name="dir" value="<?php echo isset($proveedor['direccion']) ? htmlspecialchars($proveedor['direccion']) : ''; ?>"></td>
        </tr>
        <tr>
            <td>Número Teléfono:</td>
            <td><input type="int" name="tel" value="<?php echo isset($proveedor['telefono']) ? htmlspecialchars($proveedor['telefono']) : ''; ?>"></td>
        </tr>
        <tr>
            <td>Correo:</td>
            <td><input type="email" name="corr" value="<?php echo isset($proveedor['correo']) ? htmlspecialchars($proveedor['correo']) : ''; ?>"></td>
        </tr>
        <tr class="bot">
            <td colspan="2"><input type="submit" name="ins" value="Insertar"></td>
        </tr>
    </table>
</form>
</main>



<!-- Formulario de búsqueda -->
<form class="buscar" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <input type="text" name="search" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($search); ?>">
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
            <a href="borrar_proveedores.php?id=<?php echo $persona->id; ?>"><input type="button" value="Borrar"></a>
            <a href="actualizar_proveedores.php?id=<?php echo $persona->id; ?>"><input type="button" value="Actualizar"></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>


</body>
</html>
