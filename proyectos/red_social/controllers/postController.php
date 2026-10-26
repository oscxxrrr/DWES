<?php

require_once("helpers/fileHelper.php");

if(isset($_GET['myProfile'])){
    if(!isset($_SESSION['user'])){
        header("Location: index.php?login");
        exit;
    }
    $myPosts = Post::getPostByUser($_SESSION['user']->getId());
    require_once("views/myProfileView.phtml");
    exit;
}

if(isset($_GET['add'])){
    if(!isset($_SESSION['user'])){
        header("Location: index.php?login");
        exit;
    }
    require_once("views/addPostView.phtml");
    exit;
}

if(isset($_POST['addPost']) || isset($_POST['add'])){
    if(!isset($_SESSION['user'])){
        header("Location: index.php?login");
        exit;
    }

    $image = "";
    if(isset($_FILES['image']) && isset($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        FileHelper::uploadFile($_FILES['image'], "public/uploads/" . $image);
    }

    $newPost = new Post($_SESSION['user']->getId(), $_SESSION['user']->getUsername(), $_POST['content'], $image);
    $newPost->save();

    header("Location: index.php");
    exit;
}

if(isset($_GET['delete'])){
    Post::deleteById($_GET['post_id']);
    header("Location: index.php?c=post&myProfile");
    exit;
}


?>