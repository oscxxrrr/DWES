<?php

class Post {
    private $id;
    private $user_id;
    private $username;
    private $content;
    private $image;
    private $likes;

    public function __construct($user_id, $username, $content, $image = "", $id = null, $likes = 0) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->content = $content;
        $this->image = $image;
        $this->id = $id;
        $this->likes = $likes;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getContent() {
        return $this->content;
    }

    public function getLikes() {
        return $this->likes;
    }

    public function getImage() {
        if($this->image){
            return "<br><img src='public/uploads/" . $this->image . "' width='200'><br>";
        }
        return "";
    }

    public function save() {
        $db = DB::connect();
        $descripcion = $db->real_escape_string($this->content);
        $imagen = $db->real_escape_string($this->image);
        $q = "INSERT INTO publicaciones (usuario_id, imagen_url, descripcion) VALUES ($this->user_id, '$imagen', '$descripcion')";
        $db->query($q);
    }

    public static function getAllPosts($id){
        $db = DB::connect();
        // para poder consultar el username y sacar aquellos que no son del propio usuario
        $q = "SELECT publicaciones.*, usuarios.nombre_usuario FROM publicaciones JOIN usuarios ON publicaciones.usuario_id = usuarios.id WHERE publicaciones.usuario_id <> $id";
        $result = $db->query($q);
        $posts = [];
        while($row = $result->fetch_assoc()){
            $posts[] = new Post($row['usuario_id'], $row['nombre_usuario'], $row['descripcion'], $row['imagen_url'], $row['id']);
        }
        return $posts;
    }

    public static function getPostByUser($id){
        $db = DB::connect();
        $q = "SELECT * FROM publicaciones WHERE usuario_id = $id";
        $result = $db->query($q);
        $posts = [];
        while($row = $result->fetch_assoc()){
            $posts[] = new Post($row['usuario_id'], $row['nombre_usuario'], $row['descripcion'], $row['imagen_url'], $row['id']);
        }
        return $posts;
    }

    public static function getPostById($id){
        $db = DB::connect();
        $q = "SELECT publicaciones.*, usuarios.nombre_usuario FROM publicaciones JOIN usuarios ON publicaciones.usuario_id = usuarios.id WHERE publicaciones.id = $id";
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            return new Post($row['usuario_id'], $row['nombre_usuario'], $row['descripcion'], $row['imagen_url'], $row['id']);
        }
        return null;
    }


    public static function deleteById($id){
        $db = DB::connect();
        $db->query("DELETE FROM comentarios WHERE publicacion_id = $id");
        $db->query("DELETE FROM publicaciones WHERE id = $id");
    }
}

?>