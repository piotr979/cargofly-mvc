<?php

declare(strict_types = 1);

namespace App\Helpers;

/**
 * Url methods. Mainly redirecting
 */
class Url
{
    /**
     * Simply redirect to a given route. Redirecting is instant.
     * @param string $url Route to be redirected to
     */
    public static function redirect(string $url)
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

    header('Location: ' . $url);
    }
    
}