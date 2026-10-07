<?php
class DB {
    public static function connect() {
        $conexion = new mysqli("localhost", "root", "usuario", "shop1");
        $conexion->set_charset("utf8");
        return $conexion;
    }
}
?>