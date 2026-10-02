<?php
class UserRepository {
    
    public static function getById($conn, $idUser) {
        $query = "SELECT * FROM usuarios WHERE id = " . $idUser;
        $resultado = $conn->query($query);
        
        if($resultado && $row = $resultado->fetch_assoc()){
            return new User($row['id'], $row['nombre'], $row['contrasena'], $row['email']);
        }
        return null;
    }
}
?>