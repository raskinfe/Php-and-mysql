<?php

namespace src\services;

use PDO;

class Connection
{
    private static PDO $pdo;
    private static ?Connection $instance = null;

    private function __construct()
    {
        $dsn = 'mysql:host=mysql;port=3306;dbname=test';
        $user = 'test';
        $password = 'test';

        self::$pdo = new PDO($dsn, $user, $password);
    }

    public static function getPdo()
    {
        if (self::$instance == null)
        {
            self::$instance = new Connection();
        }

        return self::$instance::$pdo;
    }

}
