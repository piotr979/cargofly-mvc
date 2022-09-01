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

enum FormRules
{
    case Required;
    case Email;
    case MinLength;
    case MaxLength;
    case RuleMatch;
    case InvalidCharacters;
}

return [
    'environment' => Environment::Dev,
    'databaseDriver' => DatabaseDriver::MySQL,
    'logging' => true
];
