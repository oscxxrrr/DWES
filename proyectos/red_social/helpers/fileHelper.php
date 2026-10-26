<?php
    class FileHelper {
        private static $folder="public/uploads/";
        private $file;

        public static function uploadFile($origen, $destino){
            $name = basename($destino);
            $tmp = is_array($origen) ? $origen['tmp_name'] : $origen;
            if(!file_exists(self::$folder)){
                mkdir(self::$folder, 0777, true);
            }
            if(move_uploaded_file($tmp, self::$folder.$name)){
                return true;   
            }
            return false;   
        } 
        
    }   
?>