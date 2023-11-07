<?php
namespace touiteur\DataBase;
use PDO ;
class ConnectionFactory{
    public static ?PDO $db = null;
    private static array $config = [];

    public static function setConfig($file){
        self::$config = parse_ini_file($file);
    }

    public static function makeConnection(){
        if (self::$db ==null) {
            $dsn = self::$config['driver'].
                ':host='.self::$config['host'].
                ';dbname='.self::$config['database'];
            self::$db = new PDO($dsn, self::$config['username'], self::$config['password'], [
                PDO::ATTR_PERSISTENT=>true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

        }
        return self::$db;
    }
}