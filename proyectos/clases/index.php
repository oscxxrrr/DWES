<?php
    session_start();
    // conectar a mysql
    try {
        $conn = new mysqli("localhost", "root", "usuario", "blog");

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

    } catch (Exception $e) {
        die("Error de conexión: " . $e->getMessage());
    }
?>

<?php
    class User{
        private $id;
        public $username;
        public $password;
        protected $state = 0;

        public function __construct($id=0, string $username, string $password){
            $this->id = $id;
            $this->username = $username;
            $this->password = $password;
            $this->state = 1;
        }

        public function getId(){
            return $this->id;
        }
        public function getUsername(){
            return $this->username;
        }
        public function getPassword(){
            return $this->password;
        }
        public function getState(){
            return $this->state;
        }
        public function setId($id){
            $this->id = $id;
        }
        public function setUsername($username){
            $this->username = $username;
        }
        public function setPassword($password){
            $this->password = $password;
        }
        public function setState($state){
            $this->state = $state;
        }
    }   

    class Article{
        public $title;
        public $content;

        public function __construct(string $title, string $content){
            $this->title = $title;
            $this->content = $content;
        }
        //GETTERS
        public function getTititle(){
            return $this->title;
        }
        public function getContent(){
            return $this->content;
        }
        //SETTERS
        public function setUsername($content){
            $this->content = $content;
        }
        public function setTitle($title){
            $this->title = $title;
        }
    }
?>

    <!-- MOSTRAR ARTICULOS -->
    <?php
    $q = "SELECT * FROM articulos";
    $resultado = $conn->query($q);

    if($resultado && $resultado->num_rows > 0){
        while($row = $resultado->fetch_assoc()){
            $articuloArray[] = new Article($row['titulo'], $row['contenido']);
        }
    } else {
        echo "No hay artículos guardados todavía.";
    }
?>

<?php
    // CERRAR SESION
    if(isset($_GET['accion']) && $_GET['accion'] == 'logout'){
        session_unset();
        header("Location: index.php");
        exit();
    }

    //LOGIN 
    if(isset($_POST['username']) && isset($_POST['password'])){
        $q = "SELECT * FROM usuarios WHERE nombre='" . $_POST['username'] . "'";
        $result = $conn->query($q);
        
        if($result && $row = $result->fetch_assoc()){
            if(md5($_POST['password']) == $row['contrasena']){
                $_SESSION['user'] = new User($row['id'], $row['nombre'], $row['contrasena']);
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
    if(isset($_POST['title']) && isset($_POST['contenido'])){
        $art = "INSERT INTO articulos (titulo, contenido) VALUES ('" . $_POST['title'] . "', '" . $_POST['contenido'] . "')";  
        $result = $conn->query($art);

        if ($result) {
            $info = "Articulos cargados";
        } else {
            $info = "Sin articulos";
        }
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
    <?php
    // SESION Y FORMULARIOS (ARRIBA)
    if(isset($_SESSION['user'])){
        echo " Bienvenido " . $_SESSION['user']->getUsername() . "<br>";
        ?>
        <form action="" method="POST">
            <br>
            <input type="text" name="title" placeholder="Titulo del articulo"><br><br>
            <textarea name="contenido" placeholder="Empieza a escribir tu articulo..." style="width: 400px; height: 400px;"></textarea><br><br>
            <input type="datetime-local" name="data" id=""><br><br>
            <input type="submit" value="Publicar" name="enviar_articulo">
        </form>
        <?php
        echo "<br><a href='index.php?accion=logout'>Cerrar sesión</a><br>";
    } else {
        ?>
        <form action="" method="POST">
            <br>
            <input type="text" name="username" placeholder="Usuario"><br><br>
            <input type="password" name="password" placeholder="password"><br><br>
            <input type="submit" value="Enviar">
        </form>
        <?php
    }

    if(isset($info)){
        echo $info;
    }
    ?>

    <hr>

    <!-- LISTA DE ARTÍCULOS ABAJO DEL TODO -->
    <h2>Lista de Artículos</h2>
    <?php
    $cont = 0;

    if($articuloArray){
        foreach($articuloArray as $articulos){
            $cont++;
            echo 'Articulo numero ' . $cont . ': <br>';
            echo "TITULO: " . $articulos->getTititle() . "<br>";
            echo "CONTENIDO: " . $articulos->getContent() . "<br>";
            echo '<br><hr>';
        }
    } else {
        echo "No hay artículos guardados todavía.";
    }
    ?>
</body>

</html>