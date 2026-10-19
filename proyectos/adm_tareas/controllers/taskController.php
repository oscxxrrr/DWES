<?php
    if(isset($_GET['delete'])){
        $db = DB::connect();
        $query = "DELETE FROM task WHERE id='" . $_GET['delete'] . "'";
        $result = $db->query($query);
        header("Location: index.php");
        exit;   
    }
    if(isset($_GET['edit'])){
        $tarea = TaskRepository::getTaskById($_GET['edit']);
        require_once("views/editTask.phtml");
        exit;
    }
    if(isset($_GET['update'])){

        $db = DB::connect();
        $query = "UPDATE task SET titulo='" . $_POST['titulo'] . "', contenido='" . $_POST['contenido'] . "', fecha_inicio='" . $_POST['fecha_inicio'] 
        . "', fecha_limite='" . $_POST['fecha_limite'] . "'";
        $result = $db->query($query);
        header("Location: index.php");
        exit;
    }

    if(isset($_GET['add'])){
        if(isset($_POST['titulo']) && isset($_POST['contenido']) && isset($_POST['fecha_inicio']) && isset($_POST['fecha_limite'])){
            $db = DB::connect();
            $query = "INSERT INTO task (titulo, contenido, fecha_inicio, fecha_limite, estado, user_id) VALUES ('" . $_POST['titulo'] . "',
             '" . $_POST['contenido'] . "', '" . $_POST['fecha_inicio'] . "', '" . $_POST['fecha_limite'] . "', 'pendiente', '" . $_SESSION['user']->getId() . "')";
            $result = $db->query($query);
            header("Location: index.php");
            exit;
        } else {
            require_once("views/addTask.phtml");
            exit;
        }
    }

    if(isset($_GET['finished'])){
        $newEstado=TaskRepository::getTaskById($_GET['finished']) -> getEstado() =='pendiente' ? 'realizada' : 'pendiente';
        $db=DB::connect();
        $query="UPDATE task SET estado='$newEstado' WHERE id= " . $_GET['finished'];  
        $result=$db->query($query); 
        header("Location: index.php");
        exit;
    }

    if(isset($_GET['share'])){
        TaskRepository::shareTask($_GET['share'], $_SESSION['user']->getId());
        header("Location: index.php");
        exit;
    }
?>