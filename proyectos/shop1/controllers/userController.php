<?php

if(isset($_GET['logout'])){
    session_destroy();
    header('location:index.php');
    exit;
}

if(isset($_POST['login'])){
    if(isset($_POST['username']) && isset($_POST['password'])){
        $q = "SELECT * FROM users WHERE username='".$_POST['username']."'";
        $db = DB::connect();
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            if($row['password'] == md5($_POST['password'])){
                $_SESSION['user'] = new User($row['id'], $row['username']);
            }
        }
    }
    header('location:index.php');
    exit;
}

if(isset($_POST['register'])){
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        
        $db = DB::connect();
        
        // Comprobar si el usuario ya existe para evitar errores de duplicidad
        $check = $db->query("SELECT id FROM users WHERE username = '$username'");
        if($check->num_rows > 0){
            // El usuario ya existe, redirigir al registro (puedes cambiarlo si prefieres mostrar un aviso)
            header('location:index.php?register=1');
            exit();
        }

        $q = "INSERT INTO users VALUES (NULL, '$username', '$password')";
        $db->query($q);
        
        if($db->insert_id){
            header('location:index.php?login=1');
            exit();
        }
    }
    header('location:index.php?register=1');
    exit();
}