<?php
    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: index.php");
        exit;
    }
    if(isset($_POST['login'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $db=DB::connect();
            $q = "SELECT * FROM user WHERE usuario = '".$_POST['username']."' AND contraseña = '".md5($_POST['password'])."'";
            $result=$db->query($q);
            if($row= $result -> fetch_assoc()){
                if($row['contraseña']==md5($_POST['password'])){
                    $_SESSION['user']=new User($row['id'], $row['usuario'], $row['rol']);
                }
            }   
        }
        header("Location: index.php");
        exit;
    }
    if(isset($_POST['register'])){
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && $_POST['password']==$_POST['password2']){
            $db= DB::connect(); 
            $q="INSERT INTO user (usuario, contraseña, rol) VALUES ('".$_POST['username']."', md5('".$_POST['password']."'), 'user')";
            $db->query($q);
            if($db->insert_id){
                header('location:index.php?login');
                exit();
            }
        header('location:index.php');
        exit();
      
    }
}
?>