<?php

declare(strict_types = 1 );

namespace App\Services;

/**
 * FlashMessenger is responsible for managing flash messages
 * like in Symfony framework. Data rae stored in sessions.
 */
class FlashMessenger
{
    public function add(string $text): void
    {
       $this->messages[] = $text;
       $_SESSION['flashes'] = [$text];
    }
    public function get(): array
    {
        if (isset($_SESSION['flashes'])) {
            $flashes = $_SESSION['flashes'];
            unset($_SESSION['flashes']);
            return $flashes;
        }
        return [];
    }
}