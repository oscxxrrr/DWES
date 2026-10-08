<?php
class DB {
    public static function connect() {
        $conexion = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));
        $conexion->set_charset("utf8");
        return $conexion;
    }
}
?>