<?php

if(isset($_POST['login'])){
    $db = DB::connect();
    $q = "SELECT * FROM users WHERE username='".$_POST['username']."'";
    $result = $db->query($q);
    if($row = $result->fetch_assoc()){
        if($row['password'] == md5($_POST['password'])){
            $_SESSION['user'] = new User($row['id'], $row['username']);
        }
    }
    header('location:index.php');
    exit;
}

if(isset($_POST['register'])){
    if($_POST['password'] == $_POST['password2']){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $db = DB::connect();
        $q = "INSERT INTO users VALUES (NULL, '$username', '$password')";
        $db->query($q);
    }
    header('location:index.php?login=1');
    exit;
}