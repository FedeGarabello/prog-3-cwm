<?php

namespace GoNetwork\DBConnection;

use GoNetwork\Core\App;
use Exception;
use PDO;

class DBConnection
{
    private static $db;

    private function __construct()
    {}

    /**
     * Start Db Connection.
    **/
    protected static function openConnection()
    {
        $host = App::getEnv('DATABASE_HOST');
        $user = App::getEnv('DATABASE_USER');
        $pass = App::getEnv('DATABASE_PASS');
        $base = App::getEnv('DATABASE_NAME');
        $dsn = "mysql:host=" . $host . ";dbname=" . $base . ";charset=utf8mb4";

        try {
            self::$db = new PDO($dsn, $user, $pass);
        } catch(Exception $e) {
            echo "Could not connect to db";
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
