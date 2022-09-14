<?php

/**
 * Dump is a lobal command to print formmatted strings out
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
 * Finally some app definitions
 */
$config = require_once __DIR__ . '/../config/app.php';

/**
 * PSR-4 autoload
 */
require_once __DIR__ . '/../vendor/autoload.php';

use App\App;

/**
 * "use" required when migration is uncommented:
 */
use App\Fixtures\FixtureLauncher;
use App\Services\MigrationsManager;

// To migrate database simply run uncomment following lines:
//$migrations = new MigrationsManager();
//$migrations->dropAllTables();exit;
//$migrations->migrateDatabase();exit;

$app = new App($config, ...['public x= 1']);
$app->run();

/**
 * url defines the path from the browser when the page is open
 * it will be used for further processing of the route
 */
$url = $_SERVER['REQUEST_URI'];

/**
 * for now all request are maintained by POST router
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST' || 
    $_SERVER['REQUEST_METHOD'] == 'GET') 
    {
    $app->resolve($url);
}
