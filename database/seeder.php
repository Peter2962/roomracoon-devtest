<?php

use Roomracoon\Core\DB;

$baseDir = dirname(__DIR__);

include $baseDir . DIRECTORY_SEPARATOR . "helpers.php";
include $baseDir . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$db = DB::instance();

// Create users table
$usersTableCmd = "CREATE TABLE IF NOT EXISTS users (
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
)";

// Create items table
$cmd = "CREATE TABLE IF NOT EXISTS items (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    completed INT(1) DEFAULT 0,
    assignee INT(10) NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$db->exec($cmd);
$db->exec($usersTableCmd);