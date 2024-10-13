<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../style/stylelogin.css"> <!-- Enlace al archivo CSS -->
    <title>Login Page</title>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>INGRESA TUS DATOS</h1>
        
        <?php

        
        session_start(); // Iniciar sesión al principio

        // Mostrar mensaje de sesión si existe
        if (isset($_SESSION["mensaje"])) {
            echo '<div class="mensaje">' . htmlspecialchars($_SESSION["mensaje"]) . '</div>';
            unset($_SESSION["mensaje"]); // Limpiar el mensaje después de mostrarlo
        }
        ?>

        <form action="comprueba_login.php" method="post">
            <table>
                <tr>
                    <td class="izq">Login:</td>
                    <td class="der"><input type="text" name="login" placeholder="Ingresa tu usuario" required></td>
                </tr>
                <tr>
                    <td class="izq">Password:</td>
                    <td class="der"><input type="password" name="password" placeholder="Ingresa tu contraseña" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="enviar" value="LOGIN"></td>
                </tr>
            </table>
        </form>
    </main>
</body>
</html>
