<?php
    require_once 'models/article.php';
    require_once 'models/user.php';
    require_once 'models/comment.php';

    session_start();

    // CERRAR SESION
    if(isset($_GET['accion']) && $_GET['accion'] == 'logout'){
        session_unset();
        header("Location: index.php");
        exit();
    }

    // REGISTRO (debe ir antes que LOGIN para evitar conflicto de campos)
    if(isset($_POST['register']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){
        $nombre = $_POST['username'];
        $email = $_POST['email'];
        $contrasena = md5($_POST['password']);
        
        $q = "INSERT INTO usuarios (nombre, email, contrasena) VALUES ('$nombre', '$email', '$contrasena')";
        
        if($conn->query($q)){
            $info = "¡Registro exitoso! Ya puedes iniciar sesión.";
        } else {
            $info = "Error al registrar el usuario.";
        }
    }

    // LOGIN 
    if(!isset($_POST['register']) && isset($_POST['username']) && isset($_POST['password'])){
        $q = "SELECT * FROM usuarios WHERE nombre='" . $_POST['username'] . "'";
        $result = $conn->query($q);
        
        if($result && $row = $result->fetch_assoc()){
            if(md5($_POST['password']) == $row['contrasena']){
                $_SESSION['user'] = new User($row['id'], $row['nombre'], $row['contrasena'], $row['email']);
                header("Location: index.php");
                exit();
            } else {
                $info = "Contraseña incorrecta <br>";
            }
        } else {
            $info = "Usuario no encontrado <br>";
        }
    }

    // CREAR ARTICULOS
    if(isset($_POST['title']) && isset($_POST['contenido']) && isset($_SESSION['user'])){
        $idUser = $_SESSION['user']->getId();
        $art = "INSERT INTO articulos (titulo, contenido, idUser) VALUES ('" . $_POST['title'] . "', '" . $_POST['contenido'] . "', $idUser)";  
        $conn->query($art);
        header("Location: index.php");
        exit();
    }

    // CREAR COMENTARIOS
    if(isset($_POST['comentario']) && isset($_SESSION['user'])){
        $idUser = $_SESSION['user']->getId();
        $idArticulo = $_POST['idArticulo'];
        $textoComentario = $_POST['comentario'];
        
        $commQuery = "INSERT INTO comentarios (comentario, idUser, idArticulo) VALUES ('$textoComentario', $idUser, $idArticulo)";
        $conn->query($commQuery);
        header("Location: index.php");
        exit();
    }

    // ENSEÑAR ARTICULOS CON COMENTARIOS
    $articuloArray = [];
    $resultado = $conn->query("SELECT * FROM articulos");

    if($resultado && $resultado->num_rows){
        while($row = $resultado->fetch_assoc()){
            $article = new Article($row['id'], $row['titulo'], $row['contenido'], $row['idUser']);
            
            $qComm = $conn->query("SELECT c.*, u.nombre FROM comentarios c JOIN usuarios u ON c.idUser = u.id WHERE c.idArticulo = " . $row['id']);
            
            if($qComm){
                while($rowComment = $qComm->fetch_assoc()){
                    $article->addComment(new Comment($rowComment['id'], $rowComment['comentario'], $rowComment['idUser'], $rowComment['idArticulo'], $rowComment['nombre']));
                }
            }
            $articuloArray[] = $article;
        }
    }

    require_once 'views/mainView.phtml';
?>