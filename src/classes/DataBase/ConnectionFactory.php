<?php
namespace touiteur\DataBase;
use PDO ;
class ConnectionFactory
{
    public static ?PDO $db = null;
    private static array $config = [];

    public static function setConfig($file)
    {
        self::$config = parse_ini_file($file);
    }

    public static function makeConnection(array $config):PDO
    {
        self::$config = $config;
        if (self::$db === null) {
            $dsn = self::$config['driver'].
            ':host='.self::$config['host'].
            ';dbname='.self::$config['dbname'];
            self::$db = new PDO($dsn, self::$config['user'], self::$config['password']);
        }
        return self::$db;
    }
}