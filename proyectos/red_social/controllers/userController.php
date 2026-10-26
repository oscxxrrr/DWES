<?php
    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: index.php");
        exit;
    }
    if(isset($_POST['login'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $db=DB::connect();
            $q = "SELECT * FROM usuarios WHERE nombre_usuario = '".$_POST['username']."' AND password = '".md5($_POST['password'])."'";
            $result=$db->query($q);
            if($row= $result -> fetch_assoc()){
                if($row['password']==md5($_POST['password'])){
                    $_SESSION['user']=new User($row['id'], $row['nombre_usuario'], $row['password']);
                }
            }   
        }
        header("Location: index.php");
        exit;
    }
    if(isset($_POST['register'])){
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && $_POST['password']==$_POST['password2']){
            $db= DB::connect(); 
            $q="INSERT INTO usuarios (nombre_usuario, password, email) VALUES ('".$_POST['username']."', md5('".$_POST['password']."'), '".$_POST['email']."')";
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
