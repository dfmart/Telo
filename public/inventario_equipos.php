<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/styleequipos.css">
  
    <title>Inventarios de Equipos</title>
   
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="clientes.php">Clientes</a></li>
                    <li><a href="proveedores.php">Proveedor</a></li>
                    <li><a href="inventario_partes.php">Inventario Partes</a></li>
                    <li><a href="inventario_equipos.php">Inventario Equipos</a>
                    <ul class="submenu">
                   <li><a href="inventario_equipos_portatil.php">Inventario Portátiles</a></li>
                   <li><a href="inventario_equipos_escritorio.php">Inventario escritorio</a></li>
                   <li><a href="inventario_equipos_servidor.php">Inventario servidor</a></li>
                   <li><a href="inventario_equipos_impresora.php">Inventario impresora</a></li>
                   <li><a href="inventario_equipos_monitor.php">Inventario monitor</a></li>
                   </ul>
                   </li>
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


    ?>

    
<h1>Inventarios de Equipos</h1>
    <div class="containerr">
   
        
        <a href="inventario_equipos_portatil.php">
            <p><img src="../../img/portatil.png" alt="Portátil"></p>
            <p>Inventario Portátil</p>
        </a>
        <a href="inventario_equipos_escritorio.php">
            <p><img src="../../img/pc.png" alt="PC"></p>
            <p>Inventario PC</p>
        </a>
        <a href="inventario_equipos_servidor.php">
            <p><img src="../../img/servidor.png" alt="Servidor"></p><br><br>
            <p>Inventario Servidor</p>
        </a>
        <a href="inventario_equipos_impresora.php">
            <p><img src="../../img/impresora.png" alt="Impresora"></p><br>
            <p>Inventario Impresora</p>
        </a>
        <a href="inventario_equipos_monitor.php">
            <p><img src="../../img/monitor.png" alt="Monitor"></p><br>
            <p>Inventario Monitor</p>
        </a>
    </div>
</body>
</html>
