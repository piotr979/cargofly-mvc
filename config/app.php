<?php

/** 
 * This file connfigures some basic settings of the app
 * 
 */
enum Environment
{
    case Dev;
    case Prod;
}

enum DatabaseDriver
{
    case MySQL;
}

return [
    'environment' => Environment::Dev,
    'databaseDriver' => DatabaseDriver::MySQL,
    'logging' => true
];
