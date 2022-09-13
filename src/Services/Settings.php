<?php

declare(strict_types = 1);

namespace App\Services;

use App\Services\Cookies;

class Settings
{
    private static int $currency = 0;
    private static array $currencies = ["&#36;", "&#8364;", "&#163;"];

    public static function getCurrencySymbol(): string
    {
        if (isset($_COOKIE['currency'])) {
            return self::$currencies[(int)$_COOKIE['currency']];
        }
        return self::$currencies[self::$currency];
    }
    public static function getCurrencyIndex(): int
    {
        if (isset($_COOKIE['currency'])) {
            return (int)$_COOKIE['currency'];
        }
        return self::$currency;
    }
    public static function setCurrencyIndex(int $currencyIndex): void
    {
        Cookies::storeCurrency($currencyIndex);
    }
}