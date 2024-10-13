<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Enlace al archivo CSS -->
    <title>Document</title>
</head>
<body>
    <?php
    session_start(); // Iniciar sesión al principio

    // Comprobar si hay mensajes en la sesión y mostrarlos
    if (isset($_SESSION["mensaje"])) {
        echo '<div class="mensaje">' . htmlspecialchars($_SESSION["mensaje"]) . '</div>';
        unset($_SESSION["mensaje"]); // Limpiar el mensaje después de mostrarlo
    }

    try {
        $base = new PDO("mysql:host=localhost;dbname=inventario", "root", "");
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Comprobar si se han enviado datos por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar que los campos no estén vacíos
            if (empty($_POST["login"]) || empty($_POST["password"])) {
                $_SESSION["mensaje"] = "Por favor, ingresa tu usuario y contraseña.";
                header("Location: login.php");
                exit();
            }

            $sql = "SELECT * FROM usuarios_pass WHERE usuarios = :login AND password = :password";
            $resultado = $base->prepare($sql);

            // Obtener y sanitizar los datos de entrada
            $login = htmlentities(trim($_POST["login"])); // Usar trim para quitar espacios
            $password = htmlentities(trim($_POST["password"])); // Usar trim para quitar espacios

            $resultado->bindValue(":login", $login);
            $resultado->bindValue(":password", $password); // Considerar encriptar la contraseña

            $resultado->execute();

            $numero_registro = $resultado->rowCount();

            if ($numero_registro != 0) {
                $_SESSION["usuarios"] = $login; // Almacenar usuario en la sesión
                $_SESSION["mensaje"] = "Has iniciado sesión correctamente.";
                header("Location: inventario_equipos.php");
                exit(); // Terminar el script después de redirigir
            } else {
                $_SESSION["mensaje"] = "Credenciales incorrectas. Inténtalo de nuevo.";
                header("Location: login.php");
                exit();
            }
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
    ?>
</body>
</html>
