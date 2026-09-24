<?php
    session_start();
    // conectar a mysql

    $host = 'localhost';
    $usuario = 'root';
    $contraseña = 'usuario';
    $base_de_datos = 'blog';

    try {
        $conn = new mysqli($host, $usuario, $contraseña, $base_de_datos);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

    } catch (Exception $e) {
        die("Error de conexión: " . $e->getMessage());
    }

    // BIEVENIDA
    if (isset($_SESSION['username'])) {
        echo "Bienvenido, " . $_SESSION['username'] . "<br>";
    } else {
        echo "No has iniciado sesión<br>";
    }

    // INICIO DE SESION
    if (isset($_POST["login"])) {
        $q = "SELECT * FROM usuarios WHERE nombre='" . $_POST['username'] . "'";
        $result = $conn->query($q);

        if ($row = $result->fetch_assoc()) {
            if ($row['contrasena'] == md5($_POST['password'])) {
                // GUARDAR EL USUARIO EN LA SESION AL INICIAR CORRECTAMENTE
                $_SESSION['username'] = $row['nombre'];
                echo "login correcto <br>";
                header("Location: index.php");
                exit();
            } else {
                echo "Contraseña incorrecta <br>";
            }
        } else {
            echo "Usuario no encontrado <br>";
        }
    }

    // REGISTRO DE USUARIOS
    if(isset($_POST['register'])) {
        $p = md5($_POST['password']);
        $q = "INSERT INTO usuarios (nombre, email, contrasena) VALUES ('" . $_POST['username'] . "', '" . $_POST['email'] . "', '" . $p . "')";
        $result = $conn->query($q);
        if ($result) {
            echo "Usuario registrado correctamente <br>";
        } else {
            echo "Error al registrar usuario: " . $conn->error . "<br>";
        }
    }

    // CERRAR SESION (Destruye la sesión y recarga la página obligatoriamente)
    if (isset($_GET['accion']) && $_GET['accion'] == 'logout') {
        session_unset();    
        session_destroy();   
        header("Location: index.php"); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG PERSONAL</title>
</head>

<body>
    <a href="index.php">Inicio</a>
    <a href="index.php?accion=articulos">Articulos</a>
    <a href="index.php?accion=login">Login</a>
    <a href="index.php?accion=registro">Registro</a>
    <a href="index.php?accion=logout">Cerrar Sesión</a>

    <hr>

    <?php
    // MOSTRAR ARTÍCULOS EN LA PÁGINA DE INICIO
    $sql_articulos = "SELECT * FROM articulos ORDER BY id DESC";
    $resultado_articulos = $conn->query($sql_articulos);

    if ($resultado_articulos && $resultado_articulos->num_rows > 0) {
        while ($articulo = $resultado_articulos->fetch_assoc()) {
            echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
            echo "<h3>" . htmlspecialchars($articulo['titulo']) . "</h3>";
            echo "<p>" . nl2br(htmlspecialchars($articulo['contenido'])) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay artículos publicados todavía o la tabla está vacía.</p>";
    }

    // GESTIÓN DE ACCIONES (LOGIN, REGISTRO, FORMULARIO DE ARTÍCULOS)
    if (isset($_GET['accion'])) {
        if ($_GET['accion'] == 'articulos') {
            if (isset($_SESSION['username'])) {
                echo "<h3>Hola " . $_SESSION['username'] . ", escribe tu artículo:</h3>";
            } else {
                echo "<p><b>Aviso:</b> No has iniciado sesión, pero puedes escribir el artículo igual.</p>";
            }
            ?>
            
            <form action="index.php" method="POST">
                <br>
                <input type="text" name="title" placeholder="Titulo del articulo"><br><br>
                <textarea name="contenido" placeholder="Contenido del articulo" style="width: 400px; height: 400px;"></textarea><br><br>
                <input type="submit" value="Enviar" name="enviar_articulo">
            </form>

            <?php
        } elseif ($_GET['accion'] == 'login') {
            ?>
            <form action="index.php" method="POST">
                <br>
                <input type="text" name="username" placeholder="Usuario"><br><br>
                <input type="password" name="password" placeholder="password"><br><br>
                <input type="submit" value="Enviar" name="login">
            </form>
            <?php
        } elseif ($_GET['accion'] == 'registro') {
            ?>
            <form action="index.php" method="POST">
                <br>
                <input type="text" name="username" placeholder="Usuario"><br><br>
                <input type="email" name="email" placeholder="Email"><br><br>
                <input type="password" name="password" placeholder="password"><br><br>
                <input type="submit" value="Registrar" name="register">
            </form>
            <?php
        }
    }
    ?>
</body>

</html>