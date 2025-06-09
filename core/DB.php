<?php

namespace Roomracoon\Core;

use PDO;

/**
 * Class DB
 * 
 * Database connection class
 * 
 * @package Roomracoon\Core
 */

abstract class DB
{

    /**
     * Create a new connection
     * 
     * @return PDO
     */
    public static function instance(): PDO
    {
        $dbconfig = getConfig("database");
        extract($dbconfig);
        $connectionDSN = "mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4";

        try {
            $connection = new PDO($connectionDSN, $dbuser, $dbpassword);
            return $connection;
        }catch(Exception $e) {
            exitApp(code: 500, message: $e->getMessage());
        }
    }

}