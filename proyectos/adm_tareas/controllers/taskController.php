<?php
    if(isset($_GET['delete'])){
        $db = DB::connect();
        MarkRepository::deleteMarksByTaskId($_GET['delete']);
        $query = "DELETE FROM task WHERE id='" . $_GET['delete'] . "'";
        $result = $db->query($query);
        header("Location: index.php");
        exit;   
    }
    if(isset($_GET['edit'])){
        $tarea = TaskRepository::getTaskById($_GET['edit']);
        $etiquetas = MarkRepository::getAllMarks();
        require_once("views/editTask.phtml");
        exit;
    }
    if(isset($_GET['update'])){

        $db = DB::connect();
        $query = "UPDATE task SET titulo='" . $_POST['titulo'] . "', contenido='" . $_POST['contenido'] . "', fecha_inicio='" . $_POST['fecha_inicio'] 
        . "', fecha_limite='" . $_POST['fecha_limite'] . "' WHERE id='" . $_POST['id'] . "'";
        $result = $db->query($query);
        
        MarkRepository::deleteMarksByTaskId($_POST['id']);
        if(isset($_POST['etiquetas'])){
            $etiquetasPost = is_array($_POST['etiquetas']) ? $_POST['etiquetas'] : [$_POST['etiquetas']];
            foreach($etiquetasPost as $etiquetaId){
                MarkRepository::addMarkToTask($_POST['id'], $etiquetaId);
            }
        }

        header("Location: index.php");
        exit;
    }

    if(isset($_GET['add'])){
        $etiquetas = MarkRepository::getAllMarks();
        require_once("views/addTask.phtml");
        exit;
    }

    if(isset($_GET['insert'])){
        $db = DB::connect();
        $query = "INSERT INTO task (titulo, contenido, fecha_inicio, fecha_limite, estado, user_id) VALUES ('" . $_POST['titulo'] . "',
         '" . $_POST['contenido'] . "', '" . $_POST['fecha_inicio'] . "', '" . $_POST['fecha_limite'] . "', 'pendiente', '" . $_SESSION['user']->getId() . "')";
        $result = $db->query($query);
        $taskId = $db->insert_id;

        if(isset($_POST['etiquetas'])){
            $etiquetasPost = is_array($_POST['etiquetas']) ? $_POST['etiquetas'] : [$_POST['etiquetas']];
            foreach($etiquetasPost as $etiquetaId){
                MarkRepository::addMarkToTask($taskId, $etiquetaId);
            }
        }

        header("Location: index.php");
        exit;
    }

    if(isset($_GET['finished'])){
        $newEstado=TaskRepository::getTaskById($_GET['finished']) -> getEstado() =='pendiente' ? 'realizada' : 'pendiente';
        $db=DB::connect();
        $query="UPDATE task SET estado='$newEstado' WHERE id= " . $_GET['finished'];  
        $result=$db->query($query); 
        header("Location: index.php");
        exit;
    }

    if(isset($_GET['view'])){
        $etiquetas = MarkRepository::getAllMarks();
        $tarea = TaskRepository::getTaskById($_GET['view']);
        require_once("views/viewTask.phtml");
        exit;
    }

?>