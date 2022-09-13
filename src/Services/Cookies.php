<?php

declare(strict_types = 1);

namespace App\Services;

class Cookies
{
  public static function storeCurrency(int $currencyIndex)
  {
    // cookie must be set directly, otherwise is not refreshed in the form
    $_COOKIE["currency"] = (string)$currencyIndex;
  }
}