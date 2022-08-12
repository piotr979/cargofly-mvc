<?php

/**
 * Dump is global command to print out formmatted strings
 */
include_once __DIR__ . '/../src/Services/Dump.php';

/**
 * Database settings (constants like DB_HOST, etc.)
 */

require_once __DIR__ . '/../config/database.php';

/**
 * Others is a config file with secondary settings
 */
require_once __DIR__ . '/../config/others.php';

/**
 * PSR-4 autoload
 */
require_once __DIR__ . '/../vendor/autoload.php';

use App\App;

$app = new App;
$app->run();

/**
 * url defines the path from the browser when the page is open
 * it will be used for further processing of the route
 */
$url = $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $app->resolve($url);
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $app->resolve($url);
}