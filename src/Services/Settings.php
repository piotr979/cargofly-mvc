<?php

declare(strict_types = 1);

namespace App\Services;

use App\Services\Cookies;

class Settings
{
    private static int $currency = 0;
    private static array $currencies = ["&#36;", "&#8364;", "&#163;"];

    /**
     * Returns currency
     * @return currency symbol (html code from $currencies array)
     */
    public static function getCurrencySymbol(): string
    {
        if (isset($_COOKIE['currency'])) {
            return self::$currencies[(int)$_COOKIE['currency']];
        }
        return self::$currencies[self::$currency];
    }

    /**
     * Returns index of the currency from array
     * @return int index 
     */
    public static function getCurrencyIndex(): int
    {
        if (isset($_COOKIE['currency'])) {
            return (int)$_COOKIE['currency'];
        }
        return self::$currency;
    }

    /**
     * Set currency index
     * @param int $currencyIndex index
     */
    public static function setCurrencyIndex(int $currencyIndex): void
    {
        Cookies::storeCurrency($currencyIndex);
    }
}