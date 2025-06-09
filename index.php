<?php

// Load helper functions
require_once "helpers.php";

include "vendor/autoload.php";

// Load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Start the app
Roomracoon\Core\App::createApp();