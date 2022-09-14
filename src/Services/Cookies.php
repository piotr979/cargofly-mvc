<?php

declare(strict_types = 1);

namespace App\Services;

class Cookies
{
  /**
   * Stores currency in cookie.
   * @param int $currency Index
   */
  public static function storeCurrency(string $currencyIndex): void
  {
    // setcookie is repeated because it wasn't available straight away
    // also it disappared when page changed
    setcookie("currency", $currencyIndex, time() + 60*60*24*30,'/');
    $_COOKIE['currency'] = $currencyIndex;
  }
}