<?php
    abstract class Connection
    {
        private static $conn;

        public static function getConn(){
            if(self::$conn == null){
                self::$conn = new PDO('mysql: host=localhost; port=3307; dbname=teste_manyminds;', 'root', '');
                
            }
            return self::$conn;
        }
    }