<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . "/../system/constant/global.php";
require __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = new Dotenv\Dotenv(PATH_ROOT);
$dotenv->load();

// Instantiate the app
$settings = require APPPATH . 'system/config/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require  PATH_ROOT . 'system/dependencies.php';

// Register middleware
require  PATH_ROOT . 'system/middleware.php';

// Auto Inject Semua Module ke slim Dependency Injection
require PATH_ROOT . 'system/bootstrap/Autoload.php';
new \Rian\HMVC\Autoload($app);

// Register routes
require  PATH_ROOT . 'system/routes.php';

// Run app
$app->run();