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
enum DeliveryStatus: int
{
    case awaiting = 0;
    case onDelivery = 1;
    case Delivered = 2;
}
return [
    'environment' => Environment::Dev,
    'databaseDriver' => DatabaseDriver::MySQL,
    'logging' => true
];
