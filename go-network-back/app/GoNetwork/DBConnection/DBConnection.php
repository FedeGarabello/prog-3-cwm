<?php

namespace GoNetwork\DBConnection;

use Exception;
use PDO;

class DBConnection
{
    private static $db;

    const DB_HOST = "localhost";
    const DB_USER = "root";
    const DB_PASS = "";
    const DB_BASE = "goNetwork";

    private function __construct()
    {}

    /**
     * Start Db Connection.
    **/
    protected static function openConnection()
    {
        $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_BASE . ";charset=utf8mb4";

        try {
            self::$db = new PDO($dsn, self::DB_USER, self::DB_PASS);
        } catch(Exception $e) {
            echo "Cant connect to Database";
        }
    }

    /**
     * Returns the DBConnection connection
     * @return PDO
     */
    public static function getConnection()
    {
        if(self::$db === null) {
            self::openConnection();
        }

        return self::$db;
    }
}
