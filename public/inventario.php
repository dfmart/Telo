<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../style/styleinventario.css"> <!-- Enlace al archivo CSS -->
    <title>Inventario</title>
 
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

// Redirigir a la página de inicio de sesión si el usuario no ha iniciado sesión
if (!isset($_SESSION["usuarios"])) {
    header("location:login.php");
    exit(); // Asegurarse de que el script se detenga después de redirigir
}
?>

<main>
    <h1>Bienvenido</h1>
    <p>User: <?php echo htmlspecialchars($_SESSION["usuarios"]); ?></p>

    <?php
    // Mensajes adicionales
    if (isset($_SESSION["mensaje"])) {
        echo '<div class="mensaje">' . htmlspecialchars($_SESSION["mensaje"]) . '</div>';
        unset($_SESSION["mensaje"]); // Limpiar el mensaje después de mostrarlo
    }
    ?>
</main>



</body>
</html>
