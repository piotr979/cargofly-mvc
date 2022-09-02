<?php

declare(strict_types = 1);

namespace App\Exceptions;

use App\App;

class ExceptionHandler
{
    public function handle(\Throwable $exception): void
    {
        if (App::$app->isDebugMode()) {
            dump($exception);
        } else {
            echo "Something went wrong. Please try again (connection error)?";
        }
    }
}