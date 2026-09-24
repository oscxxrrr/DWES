<?php

// conectar a mysql
$host = 'localhost';
$usuario = 'root';
$contraseña = 'usuario';
$base_de_datos = 'test';

// Prueba de conexion a la base de datos
session_start();
try {
    $conn = new mysqli($host, $usuario, $contraseña, $base_de_datos);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    echo "Conexión correcta<br>";

} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

// INICIO DE SESION
if (isset($_POST["login"])) {

    $q = "SELECT * FROM users WHERE username='" . $_POST['username'] . "'";
    echo $q;

    $result = $conn->query($q);

    if ($row = $result->fetch_assoc()) {

        if ($row['password'] == md5($_POST['password'])) {
            echo "login correcto <br>";
        } else {
            echo "Contraseña incorrecta <br>";
        }

    } else {
        echo "Usuario no encontrado <br>";
    }
}



// REGISTRO DE USUARIO

if(isset($_POST['register'])) {
    $p = md5($_POST['password']);
    echo $p;
    $q = "INSERT INTO users (username, password) VALUES ('" . $_POST['usuario'] . "', '" . $p . "')";
    $result = $conn->query($q);
    if ($result) {
        echo "Usuario registrado correctamente <br>";
    } else {
        echo "Error al registrar usuario: " . $conn->error . "<br>";
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>INDICE: <br></h1>

    <hr>

    <a href="index.php">INICIO</a>
    <a href="index.php?opcion=galeria">GALERIA</a>
    <a href="index.php?opcion=contacto">CONTACTO</a>
    <a href="index.php?opcion=youtube">YOUTUBE</a>

    <br>

    

    <?php
    if(isset($_SESSION['usuario'])) {
        echo "Bienvenido, " . $_SESSION['usuario'] . "<br>";
        echo '<a href="logout.php">Cerrar sesión</a>';
    } else {
        echo '<a href="login.php?opcion=contacto">Iniciar sesión</a>';
    }

    if (isset($_GET['opcion'])) {

        if ($_GET['opcion'] == 'galeria') {

            echo '<img src="img/image1.jpg" width="400px"/>';
            echo '<img src="img/image2.jpg" width="400px"/>';
            echo '<img src="img/image3.jpg" width="400px"/>';

        } elseif ($_GET['opcion'] == 'contacto') {
            ?>

            <form CONTACTO action="index.php" method="POST">

                <input type="text" name="usuario" placeholder="Usuario">
                <input type="password" name="password" placeholder="password">
                <input type="submit" value="Enviar" name="login">

                <br><br><form REGISRO action="index.php" method="POST">
                    
                    <input type="text" name="usuario" placeholder="Usuario">
                    <input type="password" name="password" placeholder="password">
                    <input type="submit" value="Registrar" name="register">

                </form>

            </form>

            <?php

        } elseif ($_GET['opcion'] == 'youtube') {
            ?>

            <iframe
                width="560"
                height="315"
                src="https://www.youtube.com/embed/iXCFpkEwrLc?si=x7F2__DGGKTcb4J7"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen>
            </iframe>

            <?php
        }

    } else {
        echo "Bienvenido a mi pagina web";
    }

    ?>

</body>

</html>
